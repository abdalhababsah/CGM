<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Users
        $admin = User::where('email', 'admin@cgm.com')->first();
        $user = User::where('email', 'user@cgm.com')->first();

        // Example Notifications for Admin
        Notification::create([
            'user_id' => $admin->id,
            'language' => 'en',
            'message' => 'Your order #1 has been shipped.',
            'is_read' => false,
        ]);

        // Example Notifications for User
        Notification::create([
            'user_id' => $user->id,
            'language' => 'ar',
            'message' => 'طلبك #2 قيد المعالجة.',
            'is_read' => false,
        ]);

        // Add more notifications as needed
    }
}
