<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    // Disable automatic timestamps
    public $timestamps = false;

    // Mass assignable attributes
    protected $fillable = [
        'order_id',
        'status',
        'changed_at',
    ];

    // Relationships

    // An order history belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
