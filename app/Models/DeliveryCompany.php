<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'contact_info',
        'is_active',
    ];

    // Relationships

    // A delivery company can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
