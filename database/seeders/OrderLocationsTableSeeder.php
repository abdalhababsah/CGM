<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderLocation;

class OrderLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Orders
        $orders = Order::all();

        foreach ($orders as $order) {
            OrderLocation::create([
                'order_id' => $order->id,
                'status' => 'Shipped',
                'latitude' => '31.963158', // Example latitude (e.g., Amman, Jordan)
                'longitude' => '35.930359', // Example longitude
                'city' => 'Amman',
                'address' => 'Amman Governorate',
                'country' => 'Jordan',
            ]);

            // Add another location update (e.g., delivered)
            OrderLocation::create([
                'order_id' => $order->id,
                'status' => 'Delivered',
                'latitude' => '31.985410', // Example latitude (e.g., final destination)
                'longitude' => '35.905230',
                'city' => 'Zarqa',
                'address' => 'Zarqa Governorate',
                'country' => 'Jordan',
            ]);
        }

        $this->command->info('Order locations seeded successfully.');
    }
}
