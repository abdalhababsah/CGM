<?php

namespace App\Services;


use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class AdminDashboardService
{
  /**
     * Get basic metrics for the dashboard.
     */
    public function getMetrics()
    {
        return [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'revenue' => Order::where('status', 'Shipped')->orWhere('status', 'Delivered')->sum('finalPrice'),
            'pending_orders' => Order::where('status', 'Pending')->count(),
        ];
    }

    /**
     * Get sales overview data for the chart.
     */
    public function getSalesOverviewData()
    {
        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return [
            'labels' => $salesData->pluck('date')->toArray(),
            'data' => $salesData->pluck('total')->toArray(),
        ];
    }

    /**
     * Get the order status distribution for a pie chart.
     */
    public function getOrderStatusDistribution()
    {
        return Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
    }

    /**
     * Get the top 5 selling products for a bar chart.
     */
    public function getTopSellingProducts()
    {
        return Product::select('name_en')
            ->withSum('orderItems', 'quantity')
            ->orderByDesc('order_items_sum_quantity')
            ->take(5)
            ->get()
            ->mapWithKeys(function ($product) {
                return [$product->name_en => $product->order_items_sum_quantity];
            });
    }

    /**
     * Get user registration trends for a line chart.
     */
    public function getUserRegistrationTrends()
    {
        $registrations = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return [
            'labels' => $registrations->pluck('date')->toArray(),
            'data' => $registrations->pluck('count')->toArray(),
        ];
    }

    /**
     * Get revenue grouped by product category for a bar chart.
     */
    public function getRevenueByCategory()
    {
        return Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name_en, SUM(order_items.total_price) as revenue')
            ->groupBy('categories.name_en')
            ->orderByDesc('revenue')
            ->pluck('revenue', 'categories.name_en');
    }
}
