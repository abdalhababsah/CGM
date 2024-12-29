@extends('dashboard-layouts.app')

@section('content')
@push('styles')
        <style>
            /* Image Positioning */
            #total-users-card::before,
            #total-orders-card::before,
            #total-revenue-card::before,
            #pending-orders-card::before {
                right: 0;
                /* Images on the right for LTR */
                left: auto;
            }

            /* Card Content */
            .order-card .card-block {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
                text-align: left;
            }

            .order-card h2 {
                display: flex;
                flex-direction: row;
                /* Text flows from left to right */
                justify-content: space-between;
                align-items: center;
            }

            .f-left {
                float: left !important;
            }

            .f-right {
                float: right !important;
            }

            .order-card h6,
            .order-card h2,
            .order-card span {
                color: white;
                font-size: 21px;
                /* Explicitly ensure all text is white */
            }

            /* Total Users Card */
            #total-users-card {
                color: white;
                position: relative;
                overflow: hidden;
                background-color: #c98a88;
                margin-bottom: 20px;
            }

            #total-users-card .card-block {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
            }

            #total-users-card::before {
                content: '';
                position: absolute;
                top: 0;
                width: 50%;
                height: 100%;
                background-image: url('{{ asset('user/img/cards-images/card-1.png') }}'); /* Ensure this path is correct */
                background-size: cover;
                background-position: center;
                z-index: 0;
                opacity: 1;
            }

            /* Total Orders Card */
            #total-orders-card {
                color: white;
                position: relative;
                overflow: hidden;
                background-color: #c98a88;
                margin-bottom: 20px;
            }

            #total-orders-card .card-block {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
            }

            #total-orders-card::before {
                content: '';
                position: absolute;
                top: 0;
                width: 50%;
                height: 100%;
                background-image: url('{{ asset('user/img/cards-images/card-5.png') }}'); /* Ensure this path is correct */
                background-size: cover;
                background-position: center;
                z-index: 0;
                opacity: 1;
            }

            /* Total Revenue Card */
            #total-revenue-card {
                color: white;
                position: relative;
                overflow: hidden;
                background-color: #c98a88;
                margin-bottom: 20px;
            }

            #total-revenue-card .card-block {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
            }

            #total-revenue-card::before {
                content: '';
                position: absolute;
                top: 0;
                width: 50%;
                height: 100%;
                background-image: url('{{ asset('user/img/cards-images/card-3.png') }}'); /* Ensure this path is correct */
                background-size: cover;
                background-position: center;
                z-index: 0;
                opacity: 1;
            }



            /* Pending Orders Card */
            #pending-orders-card {
                color: white;
                position: relative;
                overflow: hidden;
                background-color: #981e24;
                margin-bottom: 20px;
                /* Bounce animation */
            }

            #pending-orders-card .card-block {
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
            }

            #pending-orders-card::before {
                content: '';
                position: absolute;
                top: 0;
                width: 50%;
                height: 100%;
                background-image: url('{{ asset('user/img/cards-images/card-4.png') }}'); /* Ensure this path is correct */
                background-size: cover;
                background-position: center;
                z-index: 0;
                opacity: 1;
            }

            #pending-orders-card p {
                font-size: 1.2rem;
                font-weight: bold;
                color: #ffffff;
                margin: 0;
            }
        </style>
    @endpush
    <div class="container-fluid p-0">
        <!-- Metrics Cards -->

        <div style="margin-top: 30px;" class="row">
            <div class="row">
                <!-- Total Users -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-users-card" class="card order-card">
                        <div class="card-block">
                            <h6>Total Users</h6>
                            <h2>
                                <span class="f-right">{{ $metrics['total_users'] }}</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-orders-card" class="card order-card">
                        <div class="card-block">
                            <h6 >Total Orders</h6>
                            <h2>
                                <span class="f-right">{{ $metrics['total_orders'] }}</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-revenue-card" class="card order-card">
                        <div class="card-block">
                            <h6>Total Revenue</h6>
                            <h2>
                                <span class="f-right">${{ number_format($metrics['revenue'], 2) }}</span>
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- Pending Orders -->
                <div class="col-md-4 col-xl-3">
                    <a href="{{ route('shop.index') }}">
                        <div id="pending-orders-card" class="card order-card">
                            <div class="card-block">
                                <h6>Pending Orders</h6>
                                <h2>
                                    <span class="f-right">{{ $metrics['pending_orders'] }}</span>
                                </h2>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    <!-- Charts Section -->
    <div class="row g-4  ">
        <!-- Sales Overview -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 style="color: #981e24" class="mb-0">Sales Overview</h6>
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
                    <h6 style="color: #981e24" class="mb-0">Order Status Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="order-status-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4  ">
        <!-- Top Selling Products -->
        <div class="col-lg-6 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 style="color: #981e24" class="mb-0">Top Selling Products</h6>
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
                    <h6 style="color: #981e24" class="mb-0">User Registration Trends</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="user-registration-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4  ">
        <!-- Revenue by Category -->
        <div class="col-lg-12 col-12 mb-3">
            <div class="card border-0 h-100 shadow-sm">
                <div class="card-header bg-transparent border-0 p-3">
                    <h6 style="color: #981e24" class="mb-0">Revenue by Category</h6>
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
                backgroundColor: ['#981e24', '#b66a68', '#c98a88'],
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
                backgroundColor: '#b66a68'
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
                borderColor: '#981e24',
                backgroundColor: '#b66a68',
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