<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
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

    public function test_sales_report_chart_groups_revenue_by_month(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $staff = User::factory()->create(['role' => 'staff']);
        $branch = $this->makeBranch('Main Branch');
        $this->makeSale($staff, $branch, 100, now()->setDate(2026, 1, 10));
        $this->makeSale($staff, $branch, 200, now()->setDate(2026, 2, 12));

        $this->actingAs($owner)
            ->get(route('owner.reports.sales', [
                'start_date' => '2026-01-01',
                'end_date' => '2026-03-31',
            ]))
            ->assertOk()
            ->assertViewHas('trendLabels', ['Jan 2026', 'Feb 2026', 'Mar 2026'])
            ->assertViewHas('trendData', [100.0, 200.0, 0.0]);
    }

    public function test_sales_report_chart_groups_revenue_by_week(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $staff = User::factory()->create(['role' => 'staff']);
        $branch = $this->makeBranch('Main Branch');
        $this->makeSale($staff, $branch, 50, now()->setDate(2026, 1, 6));
        $this->makeSale($staff, $branch, 70, now()->setDate(2026, 1, 12));
        $this->makeSale($staff, $branch, 20, now()->setDate(2026, 1, 18));

        $this->actingAs($owner)
            ->get(route('owner.reports.sales', [
                'start_date' => '2026-01-05',
                'end_date' => '2026-01-18',
                'trend_period' => 'weekly',
            ]))
            ->assertOk()
            ->assertViewHas('trendPeriod', 'weekly')
            ->assertViewHas('trendLabels', ['Jan 5 - Jan 11', 'Jan 12 - Jan 18'])
            ->assertViewHas('trendData', [50.0, 90.0]);
    }

    public function test_sales_report_best_sellers_exclude_free_items(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $staff = User::factory()->create(['role' => 'staff']);
        $branch = $this->makeBranch('Main Branch');
        $category = Category::forceCreate(['name' => 'Kitchen']);
        $paidProduct = $this->makeProduct($category, 'Paid kettle');
        $freeProduct = $this->makeProduct($category, 'Free kettle');
        $sale = $this->makeSale($staff, $branch, 200, now());
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $paidProduct->id,
            'quantity' => 2,
            'price' => 100,
            'total' => 200,
        ]);
        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $freeProduct->id,
            'quantity' => 1,
            'price' => 0,
            'total' => 0,
        ]);

        $this->actingAs($owner)
            ->get(route('owner.reports.sales'))
            ->assertOk()
            ->assertViewHas('bestSellingProducts', fn ($products) => $products->count() === 1
                && $products->sole()->product_id === $paidProduct->id
                && (int) $products->sole()->quantity_sold === 2
                && (float) $products->sole()->revenue === 200.0);
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