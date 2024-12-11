<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\DeliveryCompany;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Users
        $admin = User::where('email', 'admin@cgm.com')->first();
        $user = User::where('email', 'user@cgm.com')->first();

        // Fetch Delivery Companies
        $dhl = DeliveryCompany::where('name', 'DHL')->first();
        $fedex = DeliveryCompany::where('name', 'FedEx')->first();

        // Check if required data exists
        if (!$admin || !$user || !$dhl || !$fedex) {
            $this->command->error('Required data not found. Make sure Users and DeliveryCompanies tables are seeded first.');
            return;
        }

        // Example Orders
        Order::create([
            'user_id' => $admin->id,
            'delivery_company_id' => $dhl->id,
            'total_amount' => 999.99,
            'payment_method' => 'Credit Card',
            'status' => 'Processing',
            'preferred_language' => 'en',
        ]);

        Order::create([
            'user_id' => $user->id,
            'delivery_company_id' => $fedex->id,
            'total_amount' => 19.99,
            'payment_method' => 'Cash on Delivery',
            'status' => 'Pending',
            'preferred_language' => 'ar',
        ]);

        $this->command->info('Orders table seeded successfully.');
    }
}
