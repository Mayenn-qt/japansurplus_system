<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsFunctionalTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_report_filters_rows_and_csv_by_date_and_branch(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $staff = User::factory()->create(['role' => 'staff']);
        $mainBranch = $this->makeBranch('Main Branch');
        $otherBranch = $this->makeBranch('Juban Branch');
        $matchingSale = $this->makeSale($staff, $mainBranch, 300, now());
        $this->makeSale($staff, $otherBranch, 200, now());
        $excludedSale = $this->makeSale($staff, $mainBranch, 100, now()->subDay());
        $filters = [
            'branch_id' => $mainBranch->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
        ];

        $this->actingAs($owner)
            ->get(route('owner.reports.sales', $filters))
            ->assertOk()
            ->assertViewHas('totalSales', 300.0)
            ->assertViewHas('recentSales', fn ($sales) => $sales->total() === 1
                && $sales->getCollection()->sole()->id === $matchingSale->id);

        $response = $this->actingAs($owner)->get(route('owner.reports.sales.export', $filters));
        $csv = $response->streamedContent();

        $this->assertStringContainsString('Main Branch', $csv);
        $this->assertStringNotContainsString('Juban Branch', $csv);
        $this->assertStringNotContainsString($excludedSale->id . ',', $csv);
    }

    public function test_inventory_report_filters_by_branch_category_and_stock_level(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $mainBranch = $this->makeBranch('Main Branch');
        $otherBranch = $this->makeBranch('Juban Branch');
        $category = Category::forceCreate(['name' => 'Kitchen']);
        $otherCategory = Category::forceCreate(['name' => 'Furniture']);
        $inStock = $this->makeProduct($category, 'Stocked kettle');
        $outOfStock = $this->makeProduct($category, 'Empty kettle');
        $otherCategoryProduct = $this->makeProduct($otherCategory, 'Chair');
        Inventory::create(['branch_id' => $mainBranch->id, 'product_id' => $inStock->id, 'current_stock' => 4]);
        Inventory::create(['branch_id' => $mainBranch->id, 'product_id' => $outOfStock->id, 'current_stock' => 0]);
        Inventory::create(['branch_id' => $otherBranch->id, 'product_id' => $inStock->id, 'current_stock' => 8]);
        Inventory::create(['branch_id' => $mainBranch->id, 'product_id' => $otherCategoryProduct->id, 'current_stock' => 3]);
        $filters = [
            'branch_id' => $mainBranch->id,
            'category_id' => $category->id,
            'stock_level' => 'out_of_stock',
        ];

        $this->actingAs($owner)
            ->get(route('owner.reports.inventory', $filters))
            ->assertOk()
            ->assertViewHas('inventory', fn ($inventory) => $inventory->total() === 1
                && $inventory->getCollection()->sole()->product_id === $outOfStock->id)
            ->assertViewHas('inStockItems', 4);

        $csv = $this->actingAs($owner)
            ->get(route('owner.reports.inventory.export', $filters))
            ->streamedContent();

        $this->assertStringContainsString('Empty kettle', $csv);
        $this->assertStringNotContainsString('Stocked kettle', $csv);
        $this->assertStringNotContainsString('Chair', $csv);
    }

    public function test_branch_report_filters_aggregates_and_csv_by_date_and_branch(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $staff = User::factory()->create(['role' => 'staff']);
        $mainBranch = $this->makeBranch('Main Branch');
        $otherBranch = $this->makeBranch('Juban Branch');
        $this->makeSale($staff, $mainBranch, 150, now());
        $this->makeSale($staff, $otherBranch, 75, now());
        $this->makeSale($staff, $mainBranch, 125, now()->subDay());
        $filters = [
            'branch_id' => $mainBranch->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
        ];

        $this->actingAs($owner)
            ->get(route('owner.reports.branchreport', $filters))
            ->assertOk()
            ->assertViewHas('branches', fn ($branches) => $branches->count() === 1
                && $branches->sole()->sales_count === 1
                && (float) $branches->sole()->sales_sum_total_amount === 150.0);

        $csv = $this->actingAs($owner)
            ->get(route('owner.reports.branchreport.export', $filters))
            ->streamedContent();

        $this->assertStringContainsString('Main Branch', $csv);
        $this->assertStringNotContainsString('Juban Branch', $csv);
        $this->assertStringContainsString('150', $csv);
    }

    private function makeBranch(string $name): Branch
    {
        return Branch::forceCreate(['branch_name' => $name]);
    }

    private function makeProduct(Category $category, string $name): Product
    {
        return Product::forceCreate([
            'name' => $name,
            'sku' => strtoupper(str_replace(' ', '-', $name)) . '-' . uniqid(),
            'category_id' => $category->id,
            'price' => 100,
            'sale_price' => 100,
        ]);
    }

    private function makeSale(User $staff, Branch $branch, float $total, $createdAt): Sale
    {
        $sale = Sale::create([
            'user_id' => $staff->id,
            'branch_id' => $branch->id,
            'order_type' => 'walk-in',
            'subtotal' => $total,
            'discount' => 0,
            'total_amount' => $total,
            'money_received' => $total,
            'change' => 0,
            'is_suki' => false,
        ]);
        $sale->forceFill(['created_at' => $createdAt, 'updated_at' => $createdAt])->saveQuietly();

        return $sale;
    }
}