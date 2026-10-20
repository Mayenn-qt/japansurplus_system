<?php

use Illuminate\Support\Facades\DB;

$projectRoot = dirname(__DIR__);
require $projectRoot . '/vendor/autoload.php';
$app = require $projectRoot . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$sourcePath = $projectRoot . '/database/database.sqlite';
$apply = in_array('--apply', $argv, true);
$replaceTarget = in_array('--replace-target', $argv, true);

if (!is_file($sourcePath)) {
    fwrite(STDERR, "SQLite source not found: {$sourcePath}" . PHP_EOL);
    exit(1);
}

try {
    $source = new PDO('sqlite:' . $sourcePath);
    $source->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $target = DB::connection('mysql');
    $targetDatabase = $target->selectOne('SELECT DATABASE() AS database_name')->database_name;

    if ($targetDatabase !== 'ohaiyo_japan_erp') {
        throw new RuntimeException("Refusing to import into unexpected MySQL database: {$targetDatabase}");
    }

    $sourceTables = $source->query(
        "SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY name"
    )->fetchAll(PDO::FETCH_COLUMN);
    $targetTables = array_map(
        static fn (object $table): string => $table->TABLE_NAME,
        $target->select('SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE()')
    );
    $missingTables = array_values(array_diff($sourceTables, $targetTables));

    if ($missingTables !== []) {
        throw new RuntimeException('Target is missing tables: ' . implode(', ', $missingTables));
    }

    $quotedTable = static fn (string $table): string => '"' . str_replace('"', '""', $table) . '"';
    $dependencies = [];
    $sourceRows = [];
    $primaryKeys = [];
    $numericColumns = [];

    foreach ($sourceTables as $table) {
        $quoted = $quotedTable($table);
        $columns = $source->query("PRAGMA table_info({$quoted})")->fetchAll(PDO::FETCH_ASSOC);
        $numericColumns[$table] = array_column(
            array_values(array_filter(
                $columns,
                static fn (array $column): bool => preg_match('/INT|REAL|FLOA|DOUB|NUMERIC|DECIMAL|BOOL/i', $column['type']) === 1
            )),
            'name'
        );
        $primaryKeys[$table] = array_column(
            array_values(array_filter($columns, static fn (array $column): bool => (int) $column['pk'] > 0)),
            'name'
        );

        if ($primaryKeys[$table] === []) {
            throw new RuntimeException("Cannot safely preserve rows in {$table}: no primary key found.");
        }

        $sourceColumnNames = array_column($columns, 'name');
        $targetColumnNames = $target->getSchemaBuilder()->getColumnListing($table);
        $missingColumns = array_values(array_diff($sourceColumnNames, $targetColumnNames));

        if ($missingColumns !== []) {
            throw new RuntimeException("Target table {$table} is missing columns: " . implode(', ', $missingColumns));
        }

        $sourceRows[$table] = $source->query("SELECT * FROM {$quoted}")->fetchAll(PDO::FETCH_ASSOC);
        $foreignKeys = $source->query("PRAGMA foreign_key_list({$quoted})")->fetchAll(PDO::FETCH_ASSOC);
        $dependencies[$table] = array_values(array_unique(array_filter(
            array_column($foreignKeys, 'table'),
            static fn (string $parent): bool => $parent !== $table && in_array($parent, $sourceTables, true)
        )));
    }

    $orderedTables = [];
    while (count($orderedTables) < count($sourceTables)) {
        $readyTables = array_values(array_filter(
            $sourceTables,
            static fn (string $table): bool => !in_array($table, $orderedTables, true)
                && array_diff($dependencies[$table], $orderedTables) === []
        ));

        if ($readyTables === []) {
            throw new RuntimeException('Foreign-key cycle detected; refusing to import in an unsafe order.');
        }

        $orderedTables = array_merge($orderedTables, $readyTables);
    }

    $plans = [];
    foreach ($orderedTables as $table) {
        $differences = 0;
        foreach ($sourceRows[$table] as $row) {
            $query = $target->table($table);
            foreach ($primaryKeys[$table] as $key) {
                $query->where($key, $row[$key]);
            }
            $existing = $query->first();

            if ($existing === null) {
                $differences++;
                continue;
            }

            $existing = (array) $existing;
            foreach ($row as $column => $value) {
                if (!valuesMatch($value, $existing[$column] ?? null, in_array($column, $numericColumns[$table], true))) {
                    $differences++;
                    break;
                }
            }
        }

        $plans[$table] = [
            'source' => count($sourceRows[$table]),
            'target' => $target->table($table)->count(),
            'differences' => $differences,
        ];
    }

    echo "Source: {$sourcePath}" . PHP_EOL;
    echo "Target: MySQL {$targetDatabase}" . PHP_EOL;
    echo 'Every SQLite table will replace the corresponding MySQL table inside one transaction.' . PHP_EOL;
    echo str_pad('Table', 22) . str_pad('SQLite rows', 14) . str_pad('MySQL rows', 14) . 'Row differences' . PHP_EOL;
    foreach ($plans as $table => $plan) {
        echo str_pad($table, 22)
            . str_pad((string) $plan['source'], 14)
            . str_pad((string) $plan['target'], 14)
            . $plan['differences'] . PHP_EOL;
    }

    if (!$apply || !$replaceTarget) {
        echo 'Dry run only. To replace all MySQL tables with SQLite data, pass --apply --replace-target.' . PHP_EOL;
        exit(0);
    }

    $target->transaction(function () use ($target, $orderedTables, $sourceRows): void {
        foreach (array_reverse($orderedTables) as $table) {
            $target->table($table)->delete();
        }

        foreach ($orderedTables as $table) {
            foreach ($sourceRows[$table] as $row) {
                $target->table($table)->insert($row);
            }
        }
    });

    echo 'Import completed. MySQL tables now contain the SQLite records with their original IDs.' . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}

function valuesMatch(mixed $left, mixed $right, bool $numeric): bool
{
    if ($left === null || $right === null) {
        return $left === $right;
    }

    $left = (string) $left;
    $right = (string) $right;

    return $numeric
        ? normalizeDecimal($left) === normalizeDecimal($right)
        : $left === $right;
}

function normalizeDecimal(string $value): string
{
    $negative = str_starts_with($value, '-');
    $value = ltrim($value, '-');
    [$whole, $fraction] = array_pad(explode('.', $value, 2), 2, '');
    $whole = ltrim($whole, '0') ?: '0';
    $fraction = rtrim($fraction, '0');
    $normalized = $whole . ($fraction === '' ? '' : '.' . $fraction);

    return $negative && $normalized !== '0' ? '-' . $normalized : $normalized;
}
