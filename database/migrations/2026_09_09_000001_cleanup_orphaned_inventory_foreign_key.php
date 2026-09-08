<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('inventories')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('products.id', 'inventories.product_id');
            })
            ->delete();

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }
};
