<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'category_id',
        'brand_id',
        'sku',
        'price',
        'quantity',
        'name_en',
        'name_ar',
        'name_he',
        'description_en',
        'description_ar',
        'description_he',
        'is_active',
    ];

    // Relationships

    // A product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A product belongs to a brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // A product can have many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // A product can have many cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // A product can have many wish list items
    public function wishListItems()
    {
        return $this->hasMany(WishListItem::class);
    }

        /**
     * A product can have many images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}