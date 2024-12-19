<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocationAndPrice extends Model
{
    use HasFactory;

    protected $table = 'delivery_location_and_prices'; 
    
    protected $fillable = [
        'city_ar',
        'city_en',
        'city_he',
        'country_ar',
        'country_en',
        'country_he',
        'price',
        'is_active',
    ];

    /**
     * Scope for active delivery locations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_location_id');
    }
}