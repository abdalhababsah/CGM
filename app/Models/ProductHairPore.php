<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHairPore extends Model
{
    use HasFactory;

    // Disable timestamps if not required for the pivot table
    public $timestamps = false;

    // Explicitly define the table name (optional, only needed if not following Laravel conventions)
    protected $table = 'product_hair_pore';

    // Allow mass assignment for pivot fields
    protected $fillable = [
        'product_id',
        'hair_pore_id',
    ];

    /**
     * Define a relationship to the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Define a relationship to the HairPore model.
     */
    public function hairPore()
    {
        return $this->belongsTo(HairPore::class, 'hair_pore_id');
    }
}