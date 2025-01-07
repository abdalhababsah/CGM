<?php

namespace App\Services;

use App\Models\Comming_soon;
use App\Models\HeaderSlider;

class HomeService
{
    /**
     * Retrieve the first Header Slider.
     *
     * @return \App\Models\HeaderSlider|null
     */
    public function getFirstSlider()
    {
        $slider = HeaderSlider::first();

        if (!$slider) {
            // Create a default slider if none exists
            $slider = HeaderSlider::create([
                'title_ar' => 'خصم 30٪ على جميع المنتجات',
                'title_en' => '30% OFF ON ALL PRODUCTS ENTER CODE: BESHOP2020',
                'title_he' => '30% הנחה על כל המוצרים קוד: BESHOP2020',
            ]);
        }

        return $slider;
    }
    public function getComingSoonItems()
    {
        return Comming_soon::orderBy("created_at", "desc")->paginate(10);
    }
}