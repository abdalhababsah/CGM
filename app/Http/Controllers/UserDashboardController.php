<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(){

        $user = Auth::user();

        // Fetch orders using the OrderService
        $orders = $this->orderService->getUserOrders($user->id);
        return view("user.dashboard.dashboard", compact('user', 'orders'));
    }
}
