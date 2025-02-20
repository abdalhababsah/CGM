<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLocation extends Model
{ // address colum is used must improve
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'latitude',
        'longitude',
        'city',
        'address',
        'country',
    ];

    /**
     * Relationship to Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
