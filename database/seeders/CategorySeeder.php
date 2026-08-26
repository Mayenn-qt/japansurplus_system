<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Inventory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::firstOrCreate(['name' => 'Furniture']);
        Category::firstOrCreate(['name' => 'Kitchenware']);
        Category::firstOrCreate(['name' => 'Heavy Equipment & Machinery']);
        Category::firstOrCreate(['name' => 'Bags & Luggage']);
        Category::firstOrCreate(['name' => 'Tools & Equipment']);
    }
}
