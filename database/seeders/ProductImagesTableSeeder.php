<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Products
        $iphone = Product::where('sku', 'APL-IPHN-001')->first();
        $galaxy = Product::where('sku', 'SMS-GLAXY-001')->first();
        $harryPotter = Product::where('sku', 'BK-HARRY-001')->first();

        // Example Images for iPhone
        ProductImage::create([
            'product_id' => $iphone->id,
            'image_url' => 'https://example.com/images/iphone_front.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $iphone->id,
            'image_url' => 'https://example.com/images/iphone_back.jpg',
            'is_primary' => false,
            'sort_order' => 2,
        ]);

        // Example Images for Galaxy
        ProductImage::create([
            'product_id' => $galaxy->id,
            'image_url' => 'https://example.com/images/galaxy_front.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $galaxy->id,
            'image_url' => 'https://example.com/images/galaxy_back.jpg',
            'is_primary' => false,
            'sort_order' => 2,
        ]);

        // Example Images for Harry Potter Book
        ProductImage::create([
            'product_id' => $harryPotter->id,
            'image_url' => 'https://example.com/images/hp_cover.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        // Add more images as needed
    }
}
