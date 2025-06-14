<?php

namespace App\Services;

use App\Mail\InvoiceMail;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Log;

class OrderService
{
    /**
     * Get filtered and paginated orders.
     */
    public function getOrders($filters)
    {
        $query = Order::with(['user'])
                  ->where('is_deleted', false)
                  ->orderBy('created_at', 'desc'); // Default ordering

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
            $q->where('id', $filters['search'])
              ->orWhereHas('user', function ($q2) use ($filters) {
                  $q2->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $filters['search'] . '%']);
              });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Fetch paginated orders
        $orders = $query->paginate(10);

        // Transform orders
        // $orders->getCollection()->transform(function ($order) {
        //     // $this->calculateFinalPrice($order);
        //     return $order;
        // });

        return $orders;
    }

    /**
     * Load and calculate details for a specific order.
     */
    public function getOrderDetails(Order $order)
    {
        $order->load(['orderItems.product', 'user', 'orderLocation', 'deliveryLocation', 'discountCode']);
        $this->calculateFinalPrice($order);
        return $order;
    }

    /**
     * Generate a PDF for the order invoice.
     */
    public function generateInvoice(Order $order, string $language = 'en')
    {
        // Load necessary relationships
        $order = $this->getOrderDetails($order);
        $originalPrice = $order->orderItems->sum('total_price');
        $deliveryPrice = $order->deliveryLocation->price ?? 0;
        $discount = $order->discountCode ?
        // $this->calculateDiscount($order->discountCode, $originalPrice)
        $order->discount : 0;

        $finalPrice = $order->finalPrice;
        // Ensure the Blade template exists

        if (!view()->exists("admin.orders.invoice.invoice-pdf-{$language}")) {
            throw new Exception('Invoice view not found.');
        }
        $pdf = Pdf::loadView("admin.orders.invoice.invoice-pdf-{$language}", compact('order' ,'originalPrice','discount','deliveryPrice','finalPrice'));

        // Return the PDF instance directly
        return $pdf;
    }

    /**
     * Calculate the final price of an order.
     */
    private function calculateFinalPrice($order)
    {
        $originalPrice = $order->orderItems->sum('total_price');
        $deliveryPrice = $order->deliveryLocation->price ?? 0;

        $order->discount = $this->calculateDiscount($order->discountCode, $originalPrice);

        $order->finalPrice = $originalPrice - $order->discount + $deliveryPrice;
    }

    public function calculateDiscount($discountCode , $originalPrice)
    {
        $discount = 0;

        if ($discountCode) {
            if ($discountCode->type === 'fixed') {
                $discount = $discountCode->amount;
            } elseif ($discountCode->type === 'percentage') {
                $discount = ($originalPrice * $discountCode->amount) / 100;
            }
        }

        $discount = min($discount, $originalPrice);
        $discount = round($discount, 2);
        return $discount;
    }
    /**
     * Get paginated orders for a specific user with optional filters.
     *
     * @param int $userId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getUserOrders(int $userId, array $filters = []): LengthAwarePaginator
    {
        $query = Order::with(['orderItems.product', 'orderLocation', 'deliveryLocation', 'discountCode'])
                      ->where('user_id', $userId)
                      ->orderBy('created_at', 'desc');

        // Search by Order ID
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('id', $search);
        }

        // Apply additional filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Fetch paginated orders
        $orders = $query->paginate(10);

        // Transform orders
        $orders->getCollection()->transform(function ($order) {
            $this->calculateFinalPrice($order);
            return $order;
        });

        return $orders;
    }

    /**
     * Send the invoice email to the user.
     *
     * @param Order $order
     * @param mixed $invoicePath
     * @return void
     */
    public function sendInvoiceEmail(Order $order, mixed $invoicePath)
    {
        Mail::to($order->user->email)->send(new InvoiceMail($order, $invoicePath));
    }

    /**
     * Process post-checkout actions, such as sending the invoice email.
     *
     * @param Order $order
     * @return void
     */
    public function postCheckout(Order $order)
    {
        try {
            // Generate the invoice PDF
            $invoicePath = $this->generateInvoice($order);
            // Send the invoice email to the user
            $this->sendInvoiceEmail($order, $invoicePath);

        } catch (Exception $e) {
            Log::error('postCheckout error :'.$e->getMessage());
        }
    }
    /**
     * Delete an order by marking it as deleted (soft delete).
     *
     * @param Order $order
     * @return void
     */
    public function deleteOrder($order)
    {
        $order->update(['is_deleted'=> true]);
    }

    /**
     * Return order to restore the quantity of item.
     *
     * @param Order $order
     * @return void
     */
    public function returnOrder($order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                Log::info("Order #{$order->id} is returned. the old Quantity of Product:{$product->quantity}");
                $product->quantity += $item->quantity; 
                $product->save();
                Log::info("Order #{$order->id} is returned. Quantity {$item->quantity} re-added to Product #{$product->id} stock.");
            } else {
                Log::warning("Order #{$order->id} is returned, but the associated product was not found.");
            }
        }
    }
}
