<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderHistory;

class OrderHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Orders
        $order1 = Order::first(); // Fetch the first order
        $order2 = Order::skip(1)->first(); // Fetch the second order

        // Ensure orders exist
        if (!$order1 || !$order2) {
            $this->command->error('Not enough orders found in the database.');
            return;
        }

        // Example Order History for Order 1
        OrderHistory::create([
            'order_id' => $order1->id,
            'status' => 'Pending',
        ]);

        OrderHistory::create([
            'order_id' => $order1->id,
            'status' => 'Processing',
        ]);

        // Example Order History for Order 2
        OrderHistory::create([
            'order_id' => $order2->id,
            'status' => 'Shipped',
        ]);

        OrderHistory::create([
            'order_id' => $order2->id,
            'status' => 'Shipped',
        ]);

        $this->command->info('Order history seeded successfully.');
    }
}
