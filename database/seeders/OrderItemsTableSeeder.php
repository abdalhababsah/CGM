<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch Orders and Products
        $order1 = Order::first(); // Fetch the first order
        $order2 = Order::skip(1)->first(); // Fetch the second order

        // Ensure orders and products exist
        if (!$order1 || !$order2) {
            $this->command->error('Not enough orders found in the database.');
            return;
        }

        $iphone = Product::where('sku', 'APL-IPHN-001')->first();
        $harryPotter = Product::where('sku', 'BK-HARRY-001')->first();

        if (!$iphone || !$harryPotter) {
            $this->command->error('Required products not found in the database.');
            return;
        }

        // Example Order Items for Order 1
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $iphone->id,
            'quantity' => 1,
            'unit_price' => $iphone->price,
            'total_price' => $iphone->price * 1,
        ]);

        // Example Order Items for Order 2
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $harryPotter->id,
            'quantity' => 2,
            'unit_price' => $harryPotter->price,
            'total_price' => $harryPotter->price * 2,
        ]);

        $this->command->info('Order items seeded successfully.');
    }
}
