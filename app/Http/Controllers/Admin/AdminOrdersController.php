<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class AdminOrdersController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->getOrders($request->all());
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order along with its products and user info.
     */
    public function show(Order $order)
    {
        $order = $this->orderService->getOrderDetails($order);
        $originalPrice = $order->orderItems->sum('total_price');
        $deliveryPrice = $order->deliveryLocation->price ?? 0;
        $discount = $order->discountCode ? $order->discountCode->amount : 0;
        $finalPrice = $order->finalPrice;

        return view('admin.orders.view', compact('order', 'originalPrice', 'deliveryPrice', 'discount', 'finalPrice'));
    }

    /**
     * Download invoice based on selected language.
     */
    public function downloadInvoice(Request $request, Order $order)
    {
        $language = $request->input('language', 'en');
        $pdf = $this->orderService->generateInvoice($order, $language);
        return $pdf->download("invoice-{$order->id}.pdf");
    }
}