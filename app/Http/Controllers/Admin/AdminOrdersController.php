<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdminOrdersController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->get(); // Eager load user info
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order along with its products and user info.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.product', 'user']); // Eager load order items and their products, along with user info
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Download invoice based on selected language.
     */
    public function downloadInvoice(Request $request, Order $order)
    {
        $order->load(['user', 'orderItems.product']); // Load related user and products

        $language = $request->input('language', 'en'); // Default to English if no language is selected

        // Pass the language to the view
        $pdf = Pdf::loadView("admin.orders.invoice-pdf-{$language}", compact('order'));

        return $pdf->download("invoice-{$order->id}.pdf");
    }
}