<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\DeliveryService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendOrderToDeliveryService implements ShouldQueue
{
    use InteractsWithQueue;

    protected $deliveryService;

    /**
     * Create the event listener.
     *
     * @param \App\Services\DeliveryService $deliveryService
     * @return void
     */
    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
    
        // Fetch the related area and city IDs for the delivery company
        $companyCityId = $order->deliveryLocation->company_city_id ?? null;
        $companyAreaId = $order->areaLocation->company_area_id ?? null;
    
        if (!$companyCityId || !$companyAreaId) {
            Log::error("Failed to send Order #{$order->id} to Delivery Service: Missing company_city_id or company_area_id.");
            return;
        }
    
        // Prepare shipment data based on the API documentation
        $shipmentData = [
            'ShipmentTrackingNo' => 'new', // Must be 'new' as per API documentation
            'qrAltId'           => '',    // Empty string as per API
            'ShipmentTypeID'    => $this->getShipmentTypeId($order->delivery_company_id),
            'ClientName'        => $order->user->first_name . ' ' . $order->user->last_name,
            'ClientCityID'      => $companyCityId, // Use the company_city_id from the delivery location
            'ClientAreaID'      => $companyAreaId, // Use the company_area_id from the area
            'ClientPhone'       => $order->user->phone,
            'ClientPhone2'      => $order->phone2 ?? '',
            'ClientAddress'     => $order->orderLocation->address ?? '',
            'Alert'             => $order->note ?? '',
            'ShipmentTotal'     => $order->total_amount,
            'Remarks'           => $order->note ?? '',
            'IsReturn'          => false,
            'ShipmentContains'  => $this->formatShipmentContents($order->orderItems),
            'lang'              => $order->preferred_language,
            'ShipmentQuantity'  => $this->getShipmentQuantity($order->orderItems),
            'IsForeign'         => false,
        ];
    
        // dd($shipmentData);
        try {
            // Send the shipment data to the delivery system
            $response = $this->deliveryService->createShipment($shipmentData);
    
            // Update the order with shipment details from the response
            $order->update([
                'delivery_shipment_id' => $response['ID'] ?? null,
                'delivery_tracking_no' => $response['ShipmentTrackingNo'] ?? null,
                'status'               => 'Submitted', // Initial status after sending to delivery
            ]);
    
            Log::info("Order #{$order->id} sent to Delivery Service successfully. Shipment ID: {$response['ID']}");
        } catch (\Exception $e) {
            Log::error("Failed to send Order #{$order->id} to Delivery Service: " . $e->getMessage());
        }
    }

    /**
     * Determine the ShipmentTypeID based on delivery company or other logic.
     *
     * @param int|null $deliveryCompanyId
     * @return int
     */
    protected function getShipmentTypeId(?int $deliveryCompanyId): int
    {
        // Implement logic to map delivery company to ShipmentTypeID
        // Example: if delivery_company_id == 1, ShipmentTypeID = 1; else default to 2
        if ($deliveryCompanyId === 1) {
            return 1;
        }

        return 2; // Default ShipmentTypeID
    }

    /**
     * Format the ShipmentContains field based on order items.
     *
     * @param \Illuminate\Database\Eloquent\Collection $orderItems
     * @return string
     */
    protected function formatShipmentContents($orderItems): string
    {
        return $orderItems->map(function ($item) {
            return "{$item->product->name_en} x {$item->quantity}";
        })->implode(', ');
    }

    /**
     * Calculate total shipment quantity based on order items.
     *
     * @param \Illuminate\Database\Eloquent\Collection $orderItems
     * @return int
     */
    protected function getShipmentQuantity($orderItems): int
    {
        return $orderItems->sum('quantity');
    }
}