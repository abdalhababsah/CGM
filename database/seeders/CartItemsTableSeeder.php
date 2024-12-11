<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

class CartItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Users
        $admin = User::where('email', 'admin@cgm.com')->first();
        $user = User::where('email', 'user@cgm.com')->first();

        // Fetch Products
        $iphone = Product::where('sku', 'APL-IPHN-001')->first();
        $harryPotter = Product::where('sku', 'BK-HARRY-001')->first();

        // Fetch Carts
        $adminCart = $admin ? Cart::where('user_id', $admin->id)->first() : null;
        $userCart = $user ? Cart::where('user_id', $user->id)->first() : null;

        // Check for missing data
        if (!$adminCart || !$userCart || !$iphone || !$harryPotter) {
            $this->command->error('Required data is missing. Ensure Users, Products, and Carts are seeded first.');
            return;
        }

        // Example Cart Items for Admin's Cart
        CartItem::create([
            'cart_id' => $adminCart->id,
            'product_id' => $iphone->id,
            'quantity' => 1,
        ]);

        // Example Cart Items for User's Cart
        CartItem::create([
            'cart_id' => $userCart->id,
            'product_id' => $harryPotter->id,
            'quantity' => 3,
        ]);

        $this->command->info('Cart items seeded successfully.');
    }
}
