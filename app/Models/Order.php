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
        'discount',
        'finalPrice',
        'payment_method',
        'status',
        'preferred_language',
        'phone2',
        // It is the city ID FOCUS. The name was incorrectly identified, but it fits the delivery company because of major modifications in the locations tables.
        'delivery_location_id',
        'discount_code_id',
        'area_id',
        'note',
        'delivery_tracking_no',
        'delivery_shipment_id',
        'is_deleted',
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
    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class);
    }
    //meant for city
    public function deliveryLocation()
    {
        return $this->belongsTo(DeliveryLocationAndPrice::class, 'delivery_location_id');
    }
    public function areaLocation()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
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
