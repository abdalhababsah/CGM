<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSlider extends Model
{
    protected $fillable = [
        'title_ar',
        'title_en',
        'title_he'
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"title_$locale"};
    }
}
