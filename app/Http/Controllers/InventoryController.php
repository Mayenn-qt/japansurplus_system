<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class InventoryController extends Controller
{
    public function inventoryReport(Request $request)
    {
        $filters = $this->validateInventoryReportFilters($request);
        $baseQuery = $this->inventoryReportQuery($filters, false);
        $inventory = $this->inventoryReportQuery($filters)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('owner.reports.inventory', [
            'totalProducts' => (clone $baseQuery)->distinct('product_id')->count('product_id'),
            'inStockItems' => (clone $baseQuery)->where('current_stock', '>', 0)->sum('current_stock'),
            'outOfStockItems' => (clone $baseQuery)->where('current_stock', 0)->count(),
            'totalInventoryRecords' => (clone $baseQuery)->count(),
            'inventory' => $inventory,
            'branches' => Branch::orderBy('branch_name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }

    public function exportInventoryReport(Request $request)
    {
        $filters = $this->validateInventoryReportFilters($request);

        return response()->streamDownload(function () use ($filters) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Product', 'SKU', 'Category', 'Branch', 'Current stock', 'Status']);

            $this->inventoryReportQuery($filters)
                ->chunkById(500, function ($inventories) use ($output) {
                    foreach ($inventories as $inventory) {
                        fputcsv($output, [
                            $inventory->product?->name ?? 'Product removed',
                            $inventory->product?->sku ?? '',
                            $inventory->product?->category?->name ?? 'Uncategorized',
                            $inventory->branch?->branch_name ?? 'Unassigned',
                            $inventory->current_stock,
                            $inventory->current_stock > 0 ? 'In stock' : 'Out of stock',
                        ]);
                    }
                });

            fclose($output);
        }, 'inventory-report-' . now()->format('Ymd-His') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validateInventoryReportFilters(Request $request): array
    {
        return $request->validate([
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'stock_level' => ['nullable', 'in:all,in_stock,out_of_stock'],
        ]);
    }

    private function inventoryReportQuery(array $filters, bool $applyStockLevel = true): Builder
    {
        $query = Inventory::with(['product.category', 'branch'])->whereHas('product');

        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }
        if (!empty($filters['category_id'])) {
            $query->whereHas('product', fn (Builder $productQuery) => $productQuery->where('category_id', $filters['category_id']));
        }
        if ($applyStockLevel) {
            match ($filters['stock_level'] ?? 'all') {
                'in_stock' => $query->where('current_stock', '>', 0),
                'out_of_stock' => $query->where('current_stock', 0),
                default => null,
            };
        }

        return $query;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $userBranchId = $user->branch_id;

        $query = Inventory::with(['product', 'branch'])
            ->whereHas('product');

        if ($userBranchId) {
            $query->where('branch_id', $userBranchId);
        }

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (!$userBranchId && $request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('stock_level')) {
            match ($request->stock_level) {
                'in_stock' => $query->where('current_stock', '>', 0),
                'out_of_stock' => $query->where('current_stock', 0),
                default => null,
            };
        }

        $sortDirection = $request->input('sort') === 'oldest' ? 'asc' : 'desc';
        $stocks = $query
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->select('inventories.*')
            ->orderBy('products.created_at', $sortDirection)
            ->orderBy('inventories.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $baseCountQuery = Inventory::whereHas('product');
        if ($userBranchId) {
            $baseCountQuery->where('branch_id', $userBranchId);
        }

        $unitsInStock = (clone $baseCountQuery)->sum('current_stock');
        $soldOutCount = (clone $baseCountQuery)->where('current_stock', 0)->count();
        $trackedProducts = (clone $baseCountQuery)->count();

        $branches = $userBranchId
            ? Branch::whereKey($userBranchId)->get()
            : Branch::orderBy('branch_name')->get();

        $productsQuery = Product::query()
            ->whereHas('inventories', function ($q) use ($userBranchId) {
                if ($userBranchId) {
                    $q->where('branch_id', $userBranchId);
                }
            })
            ->orderBy('name');
        $products = $productsQuery->get();
        $activities = collect();

        return view('staff.inventory.index', compact(
            'stocks',
            'activities',
            'unitsInStock',
            'soldOutCount',
            'trackedProducts',
            'branches',
            'products'
        ));
    }

    public function outOfStock(Request $request)
    {
        $request->merge(['stock_level' => 'out_of_stock']);

        return $this->index($request);
    }

    public function updateStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'current_stock' => 'required|integer|min:0',
        ]);

        $user = $request->user();
        if ($user->role === 'staff' && (int) $user->branch_id !== (int) $inventory->branch_id) {
            abort(403);
        }

        $inventory->update($validated);

        return back()->with('success', 'Stock quantity updated.');
    }
}