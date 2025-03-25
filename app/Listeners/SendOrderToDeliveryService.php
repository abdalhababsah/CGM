<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Area;
use App\Services\DeliveryService;
use Illuminate\Support\Facades\Log;

class SendOrderToDeliveryService
{
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

        // Eager load necessary relationships
        $order->load([
         'deliveryLocation:id,company_city_id',
         'user:id,first_name,last_name,phone',
         'areaLocation:id,company_area_id',
         'orderItems:id,quantity,product_id,order_id',
         'orderItems.product:id,name_en'
        ]);

        // Fetch the related city ID from deliveryLocation
        $companyCityId = $order->deliveryLocation->company_city_id ?? null;

        // Fetch company_area_id from the Area model using area_id
        $companyAreaId = $order->areaLocation->company_area_id;

        // Log the fetched IDs for debugging
        Log::info("Order #{$order->id} - CompanyCityID: {$companyCityId}, CompanyAreaID: {$companyAreaId}");

        if (!$companyCityId || !$companyAreaId) {
            Log::error("Failed to send Order #{$order->id} to Delivery Service: Missing company_city_id or company_area_id.");
            return;
        }

        // Validate preferred_language
        // $preferredLanguage = $order->preferred_language;
        // $validLanguages = ['en', 'ar', 'he']; // Define supported languages
        // if (!in_array($preferredLanguage, $validLanguages)) {
        //     Log::warning("Order #{$order->id} has invalid preferred_language: {$preferredLanguage}. Defaulting to 'en'.");
        //     $preferredLanguage = 'en'; // Default language
        // }

        // Prepare shipment data based on the API documentation
        $shipmentData = [
            'ShipmentTrackingNo' => 'new', // Must be 'new' as per API documentation
            'qrAltId'           => '',    // Empty string as per API
            'ShipmentTypeID'    => 6,
            'ClientName'        => $order->user->first_name . ' ' . $order->user->last_name,
            'ClientCityID'      => $companyCityId, // Use the company_city_id from the delivery location
            'ClientAreaID'      => $companyAreaId, // Use the company_area_id from the Area model
            'ClientPhone'       => $order->user->phone,
            'ClientPhone2'      => $order->phone2 ?? $order->user->phone,
            'ClientAddress'     => $order->orderLocation?->address ?? 'NA',
            'Alert'             => $order->note ?? '',
            'ShipmentTotal'     => $order->finalPrice ??($order->total_amount - ($order->discount ?? 0)),
            'Remarks'           => $order->note ?? '',
            'IsReturn'          => false,
            'ShipmentContains'  => $this->formatShipmentContents($order->orderItems),
            'lang'              => 'en', //$preferredLanguage,
            'ShipmentQuantity'  => 1, //$this->getShipmentQuantity($order->orderItems),
            'IsForeign'         => false,
        ];

        // Log the shipment data for debugging
        Log::info("Sending shipment data for Order #{$order->id}", $shipmentData);

        try {
            // Send the shipment data to the delivery system
            $response = $this->deliveryService->createShipment($shipmentData);
            // Log::info("response:", $response);
            // Check if response contains necessary shipment details
            if (!isset($response['ID']) || !isset($response['ShipmentTrackingNo'])) {
                Log::error("Delivery Service response missing required fields for Order #{$order->id}. Response: " . json_encode($response));
                throw new \Exception('Incomplete response from Delivery Service.');
            }

            // Update the order with shipment details from the response
            $order->update([
                'delivery_shipment_id' => $response['ID'],
                'delivery_tracking_no' => $response['ShipmentTrackingNo'],
                'status'               => 'Submitted', // Initial status after sending to delivery
            ]);

            Log::info("Order #{$order->id} sent to Delivery Service successfully. Shipment ID: {$response['ID']}");
        } catch (\Exception $e) {
            Log::error("Failed to send Order #{$order->id} to Delivery Service: " . $e->getMessage());
            return "Failed to send Order #{$order->id} to Delivery Service: " . $e->getMessage();
        }
    }

    /**
     * Format the ShipmentContains field based on order items.
     *
     * @param \Illuminate\Database\Eloquent\Collection $orderItems
     * @return string
     */
    protected function formatShipmentContents($orderItems): string
    {
        $contentsArray = $orderItems->map(function ($item) {
            return "{$item->product->name_en}x{$item->quantity}";
        })->toArray();

        $contents = implode(',', $contentsArray);

        if (strlen($contents) > 245) {
            $contents = substr($contents, 0, 240);
        }

        return mb_convert_encoding($contents, 'UTF-8');
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
