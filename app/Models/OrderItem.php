<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'order_id',
        'product_id',
        'hex',
        'quantity',
        'unit_price',
        'total_price',
    ];

    // Relationships

    // An order item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // An order item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
