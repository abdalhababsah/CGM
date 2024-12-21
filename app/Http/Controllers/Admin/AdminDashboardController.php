<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;

class AdminDashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(AdminDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $metrics = $this->dashboardService->getMetrics();
        $salesOverview = $this->dashboardService->getSalesOverviewData();
        $orderStatusDistribution = $this->dashboardService->getOrderStatusDistribution();
        $topSellingProducts = $this->dashboardService->getTopSellingProducts();
        $userRegistrationTrends = $this->dashboardService->getUserRegistrationTrends();
        $revenueByCategory = $this->dashboardService->getRevenueByCategory();

        return view('admin.dashboard', compact(
            'metrics',
            'salesOverview',
            'orderStatusDistribution',
            'topSellingProducts',
            'userRegistrationTrends',
            'revenueByCategory'
        ));
    }
}