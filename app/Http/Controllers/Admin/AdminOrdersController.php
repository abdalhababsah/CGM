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
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems', 'orderLocation', 'deliveryLocation', 'discountCode'])
                      ->orderBy('created_at', 'desc'); // Default ordering
    
        // Search by Order ID or User Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('id', $search) // Search by Order ID
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%'); // Search by User's first or last name
            });
        }
    
        // Apply additional filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
    
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
    
        // Fetch paginated orders
        $orders = $query->paginate(10);
    
        // Transform orders after pagination
        $orders->getCollection()->transform(function ($order) {
            $originalPrice = $order->orderItems->sum('total_price');
            $deliveryPrice = $order->deliveryLocation->price ?? 0;
    
            $discount = 0;
            if ($order->discountCode) {
                if ($order->discountCode->type === 'fixed') {
                    $discount = $order->discountCode->amount;
                } elseif ($order->discountCode->type === 'percentage') {
                    $discount = ($originalPrice * $order->discountCode->amount) / 100;
                }
            }
    
            $discount = min($discount, $originalPrice);
            $order->finalPrice = $originalPrice - $discount + $deliveryPrice;
    
            return $order;
        });
    
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order along with its products and user info.
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.product', 'user', 'orderLocation', 'deliveryLocation', 'discountCode']); 
    
        // Calculate the required values for the order summary
        $originalPrice = $order->orderItems->sum('total_price'); // Sum of all item prices
        $deliveryPrice = $order->deliveryLocation->price ?? 0; // Delivery price from selected location
        
        // Calculate the discount amount
        $discount = 0;
        if ($order->discountCode) {
            if ($order->discountCode->type === 'fixed') {
                $discount = $order->discountCode->amount; // Fixed discount
            } elseif ($order->discountCode->type === 'percentage') {
                $discount = ($originalPrice * $order->discountCode->amount) / 100; // Percentage discount
            }
        }
    
        // Ensure discount does not exceed the original price
        $discount = min($discount, $originalPrice);
    
        // Final price after applying the discount and adding delivery price
        $finalPrice = $originalPrice - $discount + $deliveryPrice;
    
        return view('admin.orders.view', compact('order', 'originalPrice', 'discount', 'deliveryPrice', 'finalPrice'));
    }

    /**
     * Download invoice based on selected language.
     */
    public function downloadInvoice(Request $request, Order $order)
    {
        $order->load(['user', 'orderItems.product', 'orderLocation']); // Load related user, products, and location

        $language = $request->input('language', 'en'); // Default to English if no language is selected
        $language = 'en';
        // dd($order);
        // Pass the language to the view
        $pdf = Pdf::loadView("admin.orders.invoice.invoice-pdf-{$language}", compact('order'));

        return $pdf->download("invoice-{$order->id}.pdf");
    }
}