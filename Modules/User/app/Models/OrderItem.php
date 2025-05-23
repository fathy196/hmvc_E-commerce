<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Models\Product;
// use Modules\User\Database\Factories\OrderItemsFactory;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
   protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'status'
    ];

    public function product() {
    return $this->belongsTo(Product::class);
}
}
