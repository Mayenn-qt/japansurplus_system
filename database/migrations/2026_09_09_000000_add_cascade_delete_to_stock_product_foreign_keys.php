<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('stocks')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('products.id', 'stocks.product_id');
            })
            ->delete();

        DB::table('stock_logs')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereColumn('products.id', 'stock_logs.product_id');
            })
            ->delete();

        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('stock_logs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });

        Schema::table('stock_logs', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('stock_logs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('stocks', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });

        Schema::table('stock_logs', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
        });
    }
};