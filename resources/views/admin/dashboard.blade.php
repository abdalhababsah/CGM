@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Metrics Cards -->
    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card bg-primary text-white border-0 shadow-sm hover-effect">
                <div class="card-body d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="bi bi-people-fill" style="font-size: 2rem; color: #ffffff;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Total Users</h5>
                        <p class="card-text h4 mb-0">{{ $metrics['total_users'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Orders -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card bg-secondary text-white border-0 shadow-sm hover-effect">
                <div class="card-body d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="bi bi-basket-fill" style="font-size: 2rem; color: #ffffff;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Total Orders</h5>
                        <p class="card-text h4 mb-0">{{ $metrics['total_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card bg-success text-white border-0 shadow-sm hover-effect">
                <div class="card-body d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="bi bi-cash-stack" style="font-size: 2rem; color: #ffffff;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Total Revenue</h5>
                        <p class="card-text h4 mb-0">${{ number_format($metrics['revenue'], 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Orders -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card bg-warning text-white border-0 shadow-sm hover-effect">
                <div class="card-body d-flex align-items-center">
                    <div class="icon me-3">
                        <i class="bi bi-hourglass-split" style="font-size: 2rem; color: #ffffff;"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Pending Orders</h5>
                        <p class="card-text h4 mb-0">{{ $metrics['pending_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mt-3">
        <!-- Sales Overview -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0">Sales Overview</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="sales-overview-chart"></canvas>
                </div>
            </div>
        </div>
        <!-- Order Status Distribution -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0">Order Status Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="order-status-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <!-- Top Selling Products -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0">Top Selling Products</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="top-products-chart"></canvas>
                </div>
            </div>
        </div>
        <!-- User Registration Trends -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0">User Registration Trends</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="user-registration-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <!-- Revenue by Category -->
        <div class="col-lg-12 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 class="mb-0">Revenue by Category</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="revenue-category-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Utility function to generate random colors (optional for dynamic color assignments)
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // Sales Overview Chart
    new Chart(document.getElementById('sales-overview-chart'), {
        type: 'line',
        data: {
            labels: @json($salesOverview['labels']),
            datasets: [{
                label: 'Sales',
                data: @json($salesOverview['data']),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { 
                    display: true,
                    title: { display: true, text: 'Month' }
                },
                y: { 
                    display: true,
                    title: { display: true, text: 'Sales ($)' },
                    beginAtZero: true
                }
            }
        }
    });

    // Order Status Distribution Chart
    new Chart(document.getElementById('order-status-chart'), {
        type: 'pie',
        data: {
            labels: @json(array_keys($orderStatusDistribution->toArray())),
            datasets: [{
                data: @json(array_values($orderStatusDistribution->toArray())),
                backgroundColor: ['#007bff', '#ffc107', '#28a745'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                tooltip: { enabled: true }
            }
        }
    });

    // Top Selling Products Chart
    new Chart(document.getElementById('top-products-chart'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($topSellingProducts->toArray())),
            datasets: [{
                label: 'Sales Quantity',
                data: @json(array_values($topSellingProducts->toArray())),
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { 
                    display: true,
                    title: { display: true, text: 'Products' }
                },
                y: { 
                    display: true,
                    title: { display: true, text: 'Quantity Sold' },
                    beginAtZero: true
                }
            }
        }
    });

    // User Registration Trends Chart
    new Chart(document.getElementById('user-registration-chart'), {
        type: 'line',
        data: {
            labels: @json($userRegistrationTrends['labels']),
            datasets: [{
                label: 'Registrations',
                data: @json($userRegistrationTrends['data']),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { 
                    display: true,
                    title: { display: true, text: 'Month' }
                },
                y: { 
                    display: true,
                    title: { display: true, text: 'Registrations' },
                    beginAtZero: true
                }
            }
        }
    });

    // Revenue by Category Chart
    new Chart(document.getElementById('revenue-category-chart'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($revenueByCategory->toArray())),
            datasets: [{
                label: 'Revenue ($)',
                data: @json(array_values($revenueByCategory->toArray())),
                backgroundColor: '#6f42c1'
            }]
        },
        options: {
            indexAxis: 'y', // Makes the bar chart horizontal
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { 
                    display: true,
                    title: { display: true, text: 'Revenue ($)' },
                    beginAtZero: true
                },
                y: { 
                    display: true,
                    title: { display: true, text: 'Category' }
                }
            }
        }
    });
</script>

<!-- Optional: Custom CSS for Enhanced Card Styles -->
<style>
    /* Hover Effect for Cards */
    .hover-effect:hover {
        transform: translateY(-5px);
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Card Background Colors */
    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    /* Ensuring Icons Are Properly Aligned */
    .card-body .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
    }

    /* Responsive Icon Sizes */
    @media (max-width: 576px) {
        .card-body .icon i {
            font-size: 1.5rem !important;
        }
    }

    /* Prevent Horizontal Overflow */
    body, html {
        overflow-x: hidden;
    }

    /* Adjust Chart Canvas to Fit Container */
    canvas {
        width: 100% !important;
        height: 300px !important; /* Adjust as needed */
    }
</style>
@endsection