<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    // Relationships

    // A cart item belongs to a cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // A cart item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
