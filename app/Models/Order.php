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
}
