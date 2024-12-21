<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    /**
     * Get filtered and paginated orders.
     */
    public function getOrders($filters)
    {
        $query = Order::with(['user', 'orderItems', 'orderLocation', 'deliveryLocation', 'discountCode'])
                      ->orderBy('created_at', 'desc'); // Default ordering

        // Apply filters
        if (!empty($filters['search'])) {
            $query->where('id', $filters['search'])
                  ->orWhereHas('user', function ($query) use ($filters) {
                      $query->where('first_name', 'like', '%' . $filters['search'] . '%')
                            ->orWhere('last_name', 'like', '%' . $filters['search'] . '%');
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
        $orders->getCollection()->transform(function ($order) {
            $this->calculateFinalPrice($order);
            return $order;
        });

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
        $order->load(['user', 'orderItems.product', 'orderLocation']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView("admin.orders.invoice.invoice-pdf-{$language}", compact('order'));
        return $pdf;
    }

    /**
     * Calculate the final price of an order.
     */
    private function calculateFinalPrice($order)
    {
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

}