<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin User
        User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@cgm.com',
            'phone' => '0782445888',
            'password' => Hash::make('password'), // Ensure to hash passwords
            'role' => 1, // Admin role
            'preferred_language' => 0, // English
            'email_verified_at' => now(),
        ]);

        // Create a Regular User
        User::create([
            'name' => 'Regular User',
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@cgm.com',
            'phone' => '0782445888',
            'password' => Hash::make('password'),
            'role' => 0, // User role
            'preferred_language' => 1, // Arabic
            'email_verified_at' => now(),
        ]);

        // Create Additional Users (Optional)
        User::factory()->count(10)->create();
    }
}
