<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'is_active',
    ];

    // Relationships

    // A category can have many products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}