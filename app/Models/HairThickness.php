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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_hair_thickness');
    }
}