<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHairType extends Model
{
    // Disable timestamps if not needed
    public $timestamps = false;

    // Define the table name explicitly (optional if it follows Laravel's naming convention)
    protected $table = 'product_hair_type';

    // Allow mass assignment for the pivot table fields
    protected $fillable = [
        'product_id',
        'hair_type_id',
    ];
}