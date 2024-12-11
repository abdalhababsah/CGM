<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WishList;
use App\Models\Product;
use App\Models\WishListItem;

class WishListItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Wish Lists and Products
        $adminWishList = WishList::where('user_id', function($query){
            $query->select('id')->from('users')->where('email', 'admin@cgm.com')->limit(1);
        })->first();

        $userWishList = WishList::where('user_id', function($query){
            $query->select('id')->from('users')->where('email', 'user@cgm.com')->limit(1);
        })->first();

        $galaxy = Product::where('sku', 'SMS-GLAXY-001')->first();
        $harryPotter = Product::where('sku', 'BK-HARRY-001')->first();

        // Example Wish List Items for Admin's Wish List
        WishListItem::create([
            'wish_list_id' => $adminWishList->id,
            'product_id' => $galaxy->id,
        ]);

        // Example Wish List Items for User's Wish List
        WishListItem::create([
            'wish_list_id' => $userWishList->id,
            'product_id' => $harryPotter->id,
        ]);

        // Add more wish list items as needed
    }
}
