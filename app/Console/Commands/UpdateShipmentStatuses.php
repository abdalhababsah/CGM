<?php

namespace App\Console\Commands;

use Arr;
use Illuminate\Console\Command;
use App\Services\DeliveryService;
use App\Models\Order;
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
     * @var \App\Services\DeliveryService
     */
    protected $deliveryService;

    /**
     * Create a new command instance.
     *
     * @param \App\Services\DeliveryService $deliveryService
     * @return void
     */
    public function __construct(DeliveryService $deliveryService)
    {
        parent::__construct();
        $this->deliveryService = $deliveryService;
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
                // $this->deliveryService->authenticate();
                try {
                    // Fetch the current shipment status using the delivery API
                    $response = Arr::last($this->deliveryService->getShipmentStatus($order->delivery_shipment_id) ?? []);//kant tracking_no

                    // Check if response is valid
                    if ($response && isset($response['NewStatusId'])) {
                        $deliveryStatus = $response['NewStatusId'];

                        // Map the delivery system status to your application's status
                        $mappedStatus = $this->mapDeliveryStatusToOrderStatus($deliveryStatus);

                        // Update the order status if it has changed
                        if ($order->status !== $mappedStatus) {
                            $order->status = $mappedStatus;
                            $order->save();

                            Log::info("Order #{$order->id} status updated to '{$mappedStatus}'.");
                        }
                    } else {
                        Log::warning("Invalid response for Order #{$order->id}: " . json_encode($response));
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to update status for Order #{$order->id}: " . $e->getMessage());
                    // Optionally, you can continue or stop the command based on the exception
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
