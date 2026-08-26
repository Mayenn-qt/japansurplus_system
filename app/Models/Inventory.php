<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Inventory extends Model
{
  use HasFactory;
  
  protected $fillable = [
    'branch_id',
    'product_id',
    'current_stock',
    'status',
  ];

  public function branch()
  {
    return $this->belongsTo(Branch::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
