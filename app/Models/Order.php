<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'user_id',
        'delivery_company_id',
        'total_amount',
        'payment_method',
        'status',
        'preferred_language',
        'delivery_location_id',
        'discount_code_id',
        'note',
    ];

    // Relationships

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order belongs to a delivery company
    public function deliveryCompany()
    {
        return $this->belongsTo(DeliveryCompany::class);
    }

    public function orderLocation()
    {
        return $this->hasOne(OrderLocation::class);
    }
    // An order can have many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // An order can have many order history records
    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class);
    }
    public function deliveryLocation()
    {
        return $this->belongsTo(DeliveryLocationAndPrice::class, 'delivery_location_id');
    }
    /**
     * An order belongs to a discount code.
     */
    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class, 'discount_code_id');
    }
    public function getAdjustedTotalAttribute()
    {
        $deliveryPrice = $this->orderLocation->price ?? 0;
        return $this->total_amount + $deliveryPrice;
    }
}
