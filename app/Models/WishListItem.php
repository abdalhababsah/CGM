<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishListItem extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'wish_list_id',
        'product_id',
    ];

    // Relationships

    // A wish list item belongs to a wish list
    public function wishList()
    {
        return $this->belongsTo(WishList::class);
    }

    // A wish list item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
