<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('supplier_price', 10, 2)->default(0)->after('price');
            $table->decimal('sale_price', 10, 2)->default(0)->after('supplier_price');
            $table->string('condition')->nullable()->after('sale_price');
            $table->text('remarks')->nullable()->after('condition');
            $table->timestamp('date_last_sold')->nullable()->after('remarks');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'supplier_price',
                'sale_price',
                'condition',
                'remarks',
                'date_last_sold',
            ]);
        });
    }
};
