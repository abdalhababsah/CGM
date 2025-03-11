<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    protected $orderService;

    /**
     * Constructor to inject the OrderService and apply middleware.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the authenticated user's orders.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Extract relevant filter parameters from the request (if any)
        $filters = $request->only(['search', 'status', 'date_from', 'date_to']);

        // Fetch paginated orders using the OrderService
        $orders = $this->orderService->getUserOrders($userId, $filters);

        // Return the orders index view with the fetched orders
        return view('user.dashboard.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     *
     * @param Order $order
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetails($order);
        $originalPrice = $order->orderItems->sum('total_price');
        $deliveryPrice = $order->deliveryLocation->price ?? 0;
        $discount = $order->discountCode ? $order->discountCode->amount : 0;
        $finalPrice = $order->finalPrice;

        return view('user.dashboard.orders.view', compact('order', 'originalPrice', 'deliveryPrice', 'discount', 'finalPrice'));
    }

}
