<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\DeliveryService;
use Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateShipmentStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shipments:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and update shipment statuses from the delivery system';

    /**
     * The DeliveryService instance.
     *
     * @var DeliveryService
     */
    protected $deliveryService;

    /**
     * The OrderService instance.
     *
     * @var OrderService
     */
    protected $orderService;

    /**
     * Create a new command instance.
     *
     * @param DeliveryService $deliveryService
     * @param OrderService $orderService
     * @return void
     */
    public function __construct(DeliveryService $deliveryService, OrderService $orderService)
    {
        parent::__construct();
        $this->deliveryService = $deliveryService;
        $this->orderService = $orderService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Fetch all orders that have been sent to the delivery system
        $orders = Order::whereNotNull('delivery_shipment_id')
                        ->where('is_deleted', false)
                        ->where('status', '!=', 'Delivered')
                        ->where('status', '!=', 'Cancelled')
                        ->get();

        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                
                try {
                    // Fetch the current shipment status using the delivery API
                    $response = Arr::last($this->deliveryService->getShipmentStatus($order->delivery_shipment_id) ?? []);

                    // Check if response is valid
                    if ($response && isset($response['NewStatusId'])) {
                        $deliveryStatus = $response['NewStatusId'];

                        // Map the delivery system status to your application's status
                        $mappedStatus = $this->mapDeliveryStatusToOrderStatus($deliveryStatus);
                        
                        // Update the order status if it has changed
                        if ($order->status !== $mappedStatus) {
                            $order->status = $mappedStatus;
                            $order->save();

                            // If the status is 'Cancelled', call the returnOrder method in the OrderService
                            if ($order->status == 'Cancelled') { 
                                Log::info("Processing cancellation for Order #{$order->id}...");
                                $this->orderService->returnOrder($order->load('orderItems.product'));
                                Log::info("Order #{$order->id} is cancelled and processed for return.");
                            }

                            Log::info("Order #{$order->id} status updated to '{$mappedStatus}'.");
                        }
                    } else {
                        Log::warning("Invalid response for Order #{$order->id}: " . json_encode($response));
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to update status for Order #{$order->id}: " . $e->getMessage());
                    continue;
                }
            }
        }

        Log::info('Shipment status updates completed.');
    }

    /**
     * Map delivery system status to application order status.
     *
     * @param string $deliveryStatus
     * @return string
     */
    protected function mapDeliveryStatusToOrderStatus(string $deliveryStatus): string
    {
        // Define your mapping based on the delivery system's status
        $mapping = [
            '2'    => 'Submitted',
            '11'    => 'Cancelled',
            '14'   => 'Shipped',
            '8'    => 'Delivered',
            'Returned'     => 'Returned',
            // Add more mappings as per delivery API documentation
        ];

        return $mapping[$deliveryStatus] ?? 'Pending';
    }
}
