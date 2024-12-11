<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example Categories
        Category::create([
            'name_en' => 'Electronics',
            'name_ar' => 'إلكترونيات',
            'name_he' => 'אלקטרוניקה',
            'description_en' => 'Devices and gadgets.',
            'description_ar' => 'أجهزة وأدوات.',
            'description_he' => 'מכשירים וגאדג\'טים.',
            'is_active' => true,
        ]);

        Category::create([
            'name_en' => 'Books',
            'name_ar' => 'كتب',
            'name_he' => 'ספרים',
            'description_en' => 'Various genres of books.',
            'description_ar' => 'أنواع مختلفة من الكتب.',
            'description_he' => 'זנים שונים של ספרים.',
            'is_active' => true,
        ]);

        // Add more categories as needed
    }
}
