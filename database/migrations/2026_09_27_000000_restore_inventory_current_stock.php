<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedInteger('current_stock')->default(0)->after('product_id');
        });

        DB::table('inventories')
            ->where('availability_status', 'available')
            ->update(['current_stock' => 1]);

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('availability_status');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('availability_status')->default('available')->after('product_id');
        });

        DB::table('inventories')
            ->where('current_stock', 0)
            ->update(['availability_status' => 'sold_out']);

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('current_stock');
        });
    }
};