<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniqueInventoryAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_decrements_inventory_by_sold_quantity(): void
    {
        [$user, $product, $inventory] = $this->makeAvailableProduct();

        $this->actingAs($user)->post(route('staff.sales.store'), [
            'cart_data' => json_encode([[
                'id' => $product->id,
                'quantity' => 1,
            ]]),
            'money_received' => 500,
        ])->assertRedirect(route('staff.sales.pos', ['clear_cart' => 'true']));

        $this->assertSame(4, $inventory->fresh()->current_stock);
        $this->assertSame(1, SaleItem::where('product_id', $product->id)->count());
    }

    public function test_checkout_accepts_multiple_quantity_of_the_same_item(): void
    {
        [$user, $product, $inventory] = $this->makeAvailableProduct();

        $this->actingAs($user)->post(route('staff.sales.store'), [
            'cart_data' => json_encode([[
                'id' => $product->id,
                'quantity' => 3,
            ]]),
            'money_received' => 1500,
        ])->assertRedirect(route('staff.sales.pos', ['clear_cart' => 'true']));

        $this->assertSame(2, $inventory->fresh()->current_stock);
        $this->assertSame(3, SaleItem::where('product_id', $product->id)->sole()->quantity);
    }

    public function test_checkout_rejects_quantity_above_stock(): void
    {
        [$user, $product, $inventory] = $this->makeAvailableProduct(1);

        $this->actingAs($user)->from('/staff/pos')->post(route('staff.sales.store'), [
            'cart_data' => json_encode([['id' => $product->id, 'quantity' => 2]]),
            'money_received' => 1000,
        ])->assertRedirect('/staff/pos')->assertSessionHasErrors('cart_data');

        $this->assertSame(1, $inventory->fresh()->current_stock);
        $this->assertSame(0, SaleItem::where('product_id', $product->id)->count());
    }

    public function test_checkout_accepts_multiple_free_items_alongside_paid_items(): void
    {
        [$user, $product, $inventory] = $this->makeAvailableProduct(5);

        $this->actingAs($user)->post(route('staff.sales.store'), [
            'cart_data' => json_encode([
                ['id' => $product->id, 'quantity' => 3],
                ['id' => $product->id, 'quantity' => 2, 'is_free' => true],
            ]),
            'money_received' => 1500,
        ])->assertRedirect(route('staff.sales.pos', ['clear_cart' => 'true']));

        $saleItems = SaleItem::where('product_id', $product->id)->orderBy('price', 'desc')->get();
        $this->assertCount(2, $saleItems);
        $this->assertSame(3, $saleItems[0]->quantity);
        $this->assertSame(500.0, (float) $saleItems[0]->price);
        $this->assertSame(2, $saleItems[1]->quantity);
        $this->assertSame(0.0, (float) $saleItems[1]->price);
        $this->assertSame(0, $inventory->fresh()->current_stock);
    }

    public function test_inventory_stock_can_be_manually_adjusted(): void
    {
        [$user, , $inventory] = $this->makeAvailableProduct();

        $this->actingAs($user)->put(route('owner.inventory.stock', $inventory), [
            'current_stock' => 12,
        ])->assertSessionHas('success', 'Stock quantity updated.');

        $this->assertSame(12, $inventory->fresh()->current_stock);
    }

    private function makeAvailableProduct(int $stock = 5): array
    {
        $branch = Branch::forceCreate(['branch_name' => 'Main Branch']);
        $user = User::factory()->create(['branch_id' => $branch->id]);
        $category = Category::forceCreate(['name' => 'Ceramics']);
        $product = Product::forceCreate([
            'name' => 'Japanese Ceramic Plate',
            'sku' => 'CERAMIC-' . uniqid(),
            'category_id' => $category->id,
            'price' => 500,
            'sale_price' => 500,
        ]);
        $inventory = Inventory::create([
            'branch_id' => $branch->id,
            'product_id' => $product->id,
            'current_stock' => $stock,
        ]);

        return [$user, $product, $inventory];
    }
}