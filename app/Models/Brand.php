<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Mass assignable attributes
    protected $fillable = [
        'name_en',
        'name_ar',
        'name_he',
        'description_en',
        'description_ar',
        'description_he',
        'logo_url',
        'is_active',
    ];

    // Relationships

    // A brand can have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}