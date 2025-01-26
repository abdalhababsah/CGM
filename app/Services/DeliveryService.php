<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DeliveryService
{
    protected $baseUrl;
    protected $token;
    protected $tokenExpiry; // To handle token expiration

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.delivery.base_url'), '/');
        //if you migrate db for the first time comment these
        $this->token = Cache::get('delivery_token');
        $this->tokenExpiry = Cache::get('delivery_token_expiry');
    }

    /**
     * Authenticate with the delivery system and retrieve the token.
     */
    protected function authenticate()
    {
        // Check if token is already set and not expired
        if ($this->token && $this->tokenExpiry && now()->lt($this->tokenExpiry)) {
            return;
        }

        try {
            $response = Http::post("{$this->baseUrl}/api/Login", [
                'UserName' => config('services.delivery.username'),
                'Password' => config('services.delivery.password'),
                'DeviceToken' => config('services.delivery.device_token'),
            ]);

            if ($response->successful()) {
                $this->token = $response->json('Token');
                // Assuming the token is valid for 1 hour; adjust as per API documentation
                $this->tokenExpiry = now()->addHour();

                // Cache the token and its expiry
                Cache::put('delivery_token', $this->token, $this->tokenExpiry);
                Cache::put('delivery_token_expiry', $this->tokenExpiry, $this->tokenExpiry);

                Log::info('Successfully authenticated with Delivery Service.');
            } else {
                Log::error('Failed to authenticate with Delivery Service.', ['response' => $response->body()]);
                throw new \Exception('Authentication with Delivery Service failed.');
            }
        } catch (\Exception $e) {
            Log::critical('DeliveryService Authentication Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a POST request to the delivery API.
     */
    protected function post($endpoint, $data = [])
    {
        $this->authenticate(); // Ensure authentication before making requests

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->token}",
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}{$endpoint}", $data);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error("POST {$endpoint} failed.", ['response' => $response->body()]);
                throw new \Exception("POST {$endpoint} failed with status {$response->status()}.");
            }
        } catch (\Exception $e) {
            Log::error("DeliveryService POST Request Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send a GET request to the delivery API.
     */
    protected function get($endpoint, $params = [])
    {
        $this->authenticate(); // Ensure authentication before making requests

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->token}",
            ])->get("{$this->baseUrl}{$endpoint}", $params);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error("GET {$endpoint} failed.", ['response' => $response->body()]);
                throw new \Exception("GET {$endpoint} failed with status {$response->status()}.");
            }
        } catch (\Exception $e) {
            Log::error("DeliveryService GET Request Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new shipment.
     *
     * @param array $shipmentData
     * @return array
     */
    public function createShipment(array $shipmentData): array
    {
        return $this->post('/api/Business/CreateShipmentConfirmNew', $shipmentData);
    }

    /**
     * Update shipment status.
     *
     * @param string $shipmentTrackingNo
     * @param array $statusData
     * @return array
     */
    public function updateShipmentStatus(string $shipmentTrackingNo, array $statusData): array
    {
        return $this->post('/api/Admin/UpdateShipmentStatus', [
            'ShipmentsIds' => $shipmentTrackingNo,
            'StatusId' => $statusData['StatusId'],
            'Note' => $statusData['Note'] ?? '',
            'BranchId' => $statusData['BranchId'] ?? '',
            'DriverId' => $statusData['DriverId'] ?? '',
        ]);
    }

    /**
     * Get the current status of a shipment.
     *
     * @param string $shipmentTrackingNo
     * @return array|null
     */
    public function getShipmentStatus(string $shipmentTrackingNo): ?array
    {
        $response = $this->get('/api/Admin/GetNextShipmentStatus', ['shipmentId' => $shipmentTrackingNo]);
        return $response;
    }

    /**
     * Get list of branches.
     *
     * @return array|null
     */
    public function getBranches(): ?array
    {
        return $this->get('/api/Admin/Branches');
    }

    /**
     * Get list of drivers.
     *
     * @return array|null
     */
    public function getDrivers(): ?array
    {
        return $this->get('/api/Admin/Drivers');
    }
    /**
     * Fetch areas for a given city ID from the delivery system.
     *
     * @param int $cityId
     * @return array
     */
    public function getAreas(int $cityId): array
    {
        return $this->get('/api/Business/Areas', [
            'CityId' => $cityId,
        ]);
    }

}