<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $furniture = Category::where('name', 'Furniture')->first();
        $kitchenware = Category::where('name', 'Kitchenware')->first();
        $heavy = Category::where('name', 'Heavy Equipment & Machinery')->first();
        $bags = Category::where('name', 'Bags & Luggage')->first();
        $tools = Category::where('name', 'Tools & Equipment')->first();

        // List ng products
        $products = [
            [
                'image' => 'cabinet.jpg',
                'name' => 'Japanese Wooden Wardrobe Cabinet',
                'sku' => 'SKU-HS-001',
                'category_id' => $furniture->id ?? null,
                'price' => 10000.00,
                'stock_main' => 10, 'stock_juban' => 5, 'stock_magallanes' => 0,
            ], 
            [
                'name' => 'Ceramic Plate & Bowl Set',
                'sku' => 'SKU-HS-002',
                'category_id' => $kitchenware->id ?? null,
                'price' => 450.00,
                'stock_main' => 5, 'stock_juban' => 10, 'stock_magallanes' => 3,
            ],
            [
                'name' => 'Office Swivel Chair',
                'sku' => 'SKU-HS-003',
                'category_id' => $furniture->id ?? null,
                'price' => 1200.00,
                'stock_main' => 15, 'stock_juban' => 5, 'stock_magallanes' => 4,
            ],
            [
                'name' => 'Japanese Hard-Case Travel Luggage',
                'sku' => 'SKU-HS-004',
                'category_id' => $bags->id ?? null,
                'price' => 1450.00,
                'stock_main' => 0, 'stock_juban' => 2, 'stock_magallanes' => 1,
            ],
            [
                'name' => 'Shindaiwa Gasoline Engine Chainsaw',
                'sku' => 'SKU-HS-005',
                'category_id' => $tools->id ?? null,
                'price' => 4200.00,
                'stock_main' => 5, 'stock_juban' => 3, 'stock_magallanes' => 1,
            ],
            [
                'name' => 'Traditional Cast Iron Teapot Set',
                'sku' => 'SKU-HS-006',
                'category_id' => $kitchenware->id ?? null,
                'price' => 850.00,
                'stock_main' => 8, 'stock_juban' => 6, 'stock_magallanes' => 4    
            ],
            [
                'name' => 'Vintage Seiko Wooden Wall Clock',
                'sku' => 'SKU-HS-007',
                'category_id' => $furniture->id ?? null,
                'price' => 1500.00,
                'stock_main' => 10, 'stock_juban' => 3, 'stock_magallanes' => 7    
            ],
            [
                'name' => 'Hitachi Electric Wood Planer',
                'sku' => 'SKU-HS-008',
                'category_id' => $tools->id ?? null,
                'price' => 2800.00,
                'stock_main' => 5, 'stock_juban' => 3, 'stock_magallanes' => 1    
            ],
            [
                'name' => 'Outdoor Camping Backpack & Gear Set',
                'sku' => 'SKU-HS-009',
                'category_id' => $bags->id ?? null,
                'price' => 2100.00,
                'stock_main' => 7, 'stock_juban' => 3, 'stock_magallanes' => 5
            ],
            [
                'name' => 'Japanese Ceramic Ramen Bowl Set',
                'sku' => 'SKU-HS-010',
                'category_id' => $kitchenware->id ?? null,
                'price' => 650.00,
                'stock_main' => 12, 'stock_juban' => 8, 'stock_magallanes' => 5
            ]
        ];

        foreach ($products as $data) {
            $product = Product::create([
                'name' => $data['name'],
                'sku' => $data['sku'],
                'category_id' => $data['category_id'],
                'price' => $data['price'],
                'reorder_level' => 3,
            ]);

            // Branch 1 (Main)
            Inventory::create([
                'branch_id' => 1, 
                'product_id' => $product->id, 
                'current_stock' => $data['stock_main'], 
                'status' => $data['stock_main'] == 0 ? 'Out of Stock' : ($data['stock_main'] <= 5 ? 'Low Stock' : 'In Stock')
            ]);

            // Branch 2 (Juban)
            Inventory::create([
                'branch_id' => 2, 
                'product_id' => $product->id, 
                'current_stock' => $data['stock_juban'], 
                'status' => $data['stock_juban'] == 0 ? 'Out of Stock' : ($data['stock_juban'] <= 5 ? 'Low Stock' : 'In Stock')
            ]);

            // Branch 3 (Magallanes)
            Inventory::create([
                'branch_id' => 3, 
                'product_id' => $product->id, 
                'current_stock' => $data['stock_magallanes'], 
                'status' => $data['stock_magallanes'] == 0 ? 'Out of Stock' : ($data['stock_magallanes'] <= 5 ? 'Low Stock' : 'In Stock')
            ]);
        }
    }
}