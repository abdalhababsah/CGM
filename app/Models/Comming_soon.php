<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comming_soon extends Model
{
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_he",
        "image",
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_$locale"};
    }
}
