<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_location_id',
        'area_en',
        'area_ar',
        'area_he',
        'company_area_id',
    ];

    /**
     * Get the delivery location that owns the area.
     */
    public function deliveryLocation()
    {
        return $this->belongsTo(DeliveryLocationAndPrice::class, 'delivery_location_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'area_id');
    }
}