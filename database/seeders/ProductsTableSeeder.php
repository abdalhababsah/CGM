<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Categories and Brands
        $electronics = Category::where('name_en', 'Electronics')->first();
        $books = Category::where('name_en', 'Books')->first();

        $apple = Brand::where('name_en', 'Apple')->first();
        $samsung = Brand::where('name_en', 'Samsung')->first();

        // Example Products
        Product::create([
            'category_id' => $electronics->id,
            'brand_id' => $apple->id,
            'sku' => 'APL-IPHN-001',
            'price' => 999.99,
            'quantity' => 50,
            'name_en' => 'iPhone 14 Pro',
            'name_ar' => 'آيفون 14 برو',
            'name_he' => 'אייפון 14 פרו',
            'description_en' => 'Latest Apple iPhone with advanced features.',
            'description_ar' => 'أحدث آيفون من أبل مع ميزات متقدمة.',
            'description_he' => 'אייפון האחרון של אפל עם תכונות מתקדמות.',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'brand_id' => $samsung->id,
            'sku' => 'SMS-GLAXY-001',
            'price' => 899.99,
            'quantity' => 30,
            'name_en' => 'Samsung Galaxy S22',
            'name_ar' => 'سامسونج جالاكسي S22',
            'name_he' => 'סמסונג גלקסי S22',
            'description_en' => 'High-performance Samsung smartphone.',
            'description_ar' => 'هاتف ذكي سامسونج عالي الأداء.',
            'description_he' => 'סמסונג סמארטפון עם ביצועים גבוהים.',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $books->id,
            'brand_id' => null, // Assuming books might not have a brand
            'sku' => 'BK-HARRY-001',
            'price' => 19.99,
            'quantity' => 100,
            'name_en' => 'Harry Potter and the Sorcerer\'s Stone',
            'name_ar' => 'هاري بوتر وحجر الفيلسوف',
            'name_he' => 'הארי פוטר ואבן החכמים',
            'description_en' => 'First book in the Harry Potter series.',
            'description_ar' => 'أول كتاب في سلسلة هاري بوتر.',
            'description_he' => 'הספר הראשון בסדרת הארי פוטר.',
            'is_active' => true,
        ]);

        // Add more products as needed
    }
}
