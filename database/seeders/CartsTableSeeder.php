<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\User;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Users
        $admin = User::where('email', 'admin@cgm.com')->first();
        $user = User::where('email', 'user@cgm.com')->first();

        // Create Carts for Users
        Cart::create([
            'user_id' => $admin->id,
        ]);

        Cart::create([
            'user_id' => $user->id,
        ]);

        // Optionally, create carts for other users or guest users
    }
}
