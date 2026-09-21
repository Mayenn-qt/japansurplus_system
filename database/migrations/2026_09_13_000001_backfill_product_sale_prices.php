<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('products')
            ->where('sale_price', 0)
            ->update(['sale_price' => DB::raw('price')]);
    }

    public function down(): void
    {
        // The legacy price column remains the compatibility source.
    }
};
