<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeliveryService;

class TestController extends Controller
{
    /**
     * Test fetching areas from the DeliveryService.
     */
    public function testGetAreas(Request $request, DeliveryService $deliveryService)
    {
        // This API for returning areas and cities 

        // // For demonstration, let's fetch areas for cityId=1 (or use a query param).
        // $cityId = $request->input('city_id', 2);

        // try {
        //     $response = $deliveryService->getAreas((int) $cityId);
        //     // Dump or return JSON
        //     return response()->json([
        //         'status'   => 'success',
        //         'city_id'  => $cityId,
        //         'response' => $response,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status'  => 'error',
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }
    }
}