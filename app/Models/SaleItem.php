<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price', 'total'];

    protected static function booted(): void
    {
        static::created(function (SaleItem $saleItem) {
            $saleItem->product?->updateQuietly(['date_last_sold' => now()]);
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}