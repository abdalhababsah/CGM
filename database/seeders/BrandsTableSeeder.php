<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example Brands
        Brand::create([
            'name_en' => 'Apple',
            'name_ar' => 'أبل',
            'name_he' => 'אפל',
            'description_en' => 'Leading brand in electronics.',
            'description_ar' => 'علامة تجارية رائدة في الإلكترونيات.',
            'description_he' => 'מותג מוביל באלקטרוניקה.',
            'logo_url' => 'https://example.com/logos/apple.png',
            'is_active' => true,
        ]);

        Brand::create([
            'name_en' => 'Samsung',
            'name_ar' => 'سامسونج',
            'name_he' => 'סמסונג',
            'description_en' => 'Innovative electronics brand.',
            'description_ar' => 'علامة تجارية مبتكرة في الإلكترونيات.',
            'description_he' => 'מותג אלקטרוניקה חדשני.',
            'logo_url' => 'https://example.com/logos/samsung.png',
            'is_active' => true,
        ]);

        // Add more brands as needed
    }
}
