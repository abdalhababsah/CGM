<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $user = Auth::user();

        // Fetch orders using the OrderService
        $orders = $this->orderService->getUserOrders($user->id);
        $ordersCount = count($orders);

        // Calculate the date three months ago from today
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Fetch products created in the last three months
        $productsLastThreeMonths = Product::where('created_at', '>=', $threeMonthsAgo)->count();

        return view("user.dashboard.dashboard", compact('user', 'ordersCount',  'productsLastThreeMonths'));
    }
}