<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WishList;
use App\Models\User;

class WishListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Users
        $admin = User::where('email', 'admin@cgm.com')->first();
        $user = User::where('email', 'user@cgm.com')->first();

        // Create Wish Lists for Users
        WishList::create([
            'user_id' => $admin->id,
        ]);

        WishList::create([
            'user_id' => $user->id,
        ]);

        // Optionally, create wish lists for other users
    }
}
