<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairThickness extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'name_he',
    ];
    protected $appends = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_hair_thickness');
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
