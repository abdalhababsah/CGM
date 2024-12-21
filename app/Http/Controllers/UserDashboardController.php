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
// dd($orders);
        return view("user.dashboard.index", compact('user', 'orders'));
    }
}
