<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairPore extends Model
{
    use HasFactory;

    // Table name (optional if it matches the class name in plural form)
    protected $table = 'hair_pores';

    // Mass assignable attributes
    protected $fillable = [
        'name_en',
        'name_ar',
        'name_he',
    ];
    protected $appends = [
        'name',
    ];

    /**
     * The products that belong to the hair pore.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_hair_pore');
    }

    //Localize
    public function getNameAttribute()
    {
        $local = config('app.locale');
        return $this->attributes['name_'.$local]
        ?? $this->attributes['name_en']
        ?? $this->attributes['name']
        ?? null;
    }
}
