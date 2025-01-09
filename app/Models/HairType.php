<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairType extends Model
{
    use HasFactory;

    // Table name (optional if it matches the class name in plural form)
    protected $table = 'hair_types';

    // Mass assignable attributes
    protected $fillable = [
        'name_en',
        'name_ar',
        'name_he',
    ];

    /**
     * The products that belong to the hair type.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_hair_type');
    }
}
