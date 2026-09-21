<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'price',
        'supplier_price',
        'sale_price',
        'image',
        'reorder_level',
        'condition',
        'location',
        'remarks',
        'date_last_sold',
    ];

    protected $casts = [
        'date_last_sold' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->oldest();
    }
}