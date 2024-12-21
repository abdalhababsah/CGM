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
     * Constructor to inject the OrderService.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        // Apply the 'auth' middleware to ensure only authenticated users can access these methods
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

        // Extract relevant filter parameters from the request
        $filters = $request->only(['search', 'status', 'date_from', 'date_to']);

        // Fetch paginated orders using the OrderService
        $orders = $this->orderService->getUserOrders($userId, $filters);

        // Return the orders index view with the fetched orders
        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     *
     * @param Order $order
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // Authorization Check: Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Fetch detailed order information using the OrderService
        $order = $this->orderService->getOrderDetails($order);

        // Return the order details view with the fetched order
        return view('user.orders.show', compact('order'));
    }

    /**
     * Download the invoice PDF for the specified order.
     *
     * @param Request $request
     * @param Order $order
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function downloadInvoice(Request $request, Order $order)
    {
        // Authorization Check: Ensure the authenticated user owns the order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Determine the language for the invoice (default to English)
        $language = $request->input('language', 'en');

        try {
            // Generate the PDF invoice using the OrderService
            $pdf = $this->orderService->generateInvoice($order, $language);

            // Return the PDF as a downloadable response
            return $pdf->download("invoice-{$order->id}.pdf");
        } catch (\Exception $e) {
            // Handle any exceptions during PDF generation
            return back()->withErrors(['error' => 'Failed to generate invoice. Please try again later.']);
        }
    }
}