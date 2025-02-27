@extends('dashboard-layouts.app')

@section('content')
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            :root {
                --primary-color: #2c3e50;
                --secondary-color: #34495e;
                --accent-color: #3498db;
                --success-color: #2ecc71;
                --warning-color: #f1c40f;
                --danger-color: #e74c3c;
                --light-bg: #f8f9fa;
                --dark-bg: #2c3e50;
            }

            /* Add this to your existing styles */
            .chart-container {
                position: relative;
                height: 300px;
                /* Fixed height for charts */
                width: 100%;
            }

            .chart-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
                margin-bottom: 2rem;
                border: none;
                height: auto;
                /* Changed from 100% */
            }

            /* Remove the canvas styles that were causing the issue */
            canvas {
                width: 100% !important;
                height: 100% !important;
            }

            /* Dashboard Container */
            .dashboard-container {
                padding: 2rem;
                background-color: #f5f6fa;
                min-height: 100vh;
            }

            /* Dashboard Header */
            .dashboard-header {
                margin-bottom: 2rem;
            }

            .dashboard-title {
                font-size: 1.8rem;
                color: var(--primary-color);
                font-weight: 600;
                margin-bottom: 1rem;
            }

            /* Stats Cards */
            .stat-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: none;
                position: relative;
                overflow: hidden;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            }

            .stat-card::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100%;
                background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .stat-title {
                font-size: 0.9rem;
                color: #6c757d;
                margin-bottom: 0.5rem;
            }

            .stat-value {
                font-size: 1.8rem;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 0.5rem;
            }

            .stat-trend {
                font-size: 0.8rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Chart Cards */
            .chart-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
                margin-bottom: 2rem;
                border: none;
            }

            .chart-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .chart-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: var(--primary-color);
            }

            .chart-actions {
                display: flex;
                gap: 1rem;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .dashboard-container {
                    padding: 1rem;
                }

                .stat-card {
                    margin-bottom: 1rem;
                }
            }
        </style>
    @endpush

    <div class="dashboard-container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard Overview</h1>
            <p class="text-muted">Welcome back, {{ Auth()->user()->first_name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <!-- Users Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <h6 class="stat-title">Total Users</h6>
                    <h3 class="stat-value">{{ number_format($metrics['total_users']) }}</h3>
                    <div class="stat-trend text-success">

                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </div>
                    <h6 class="stat-title">Total Orders</h6>
                    <h3 class="stat-value">{{ number_format($metrics['total_orders']) }}</h3>
                    <div class="stat-trend text-success">

                    </div>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">
                        <i class="fas fa-dollar-sign fa-lg"></i>
                    </div>
                    <h6 class="stat-title">Total Revenue</h6>
                    <h3 class="stat-value">₪{{ $metrics['revenue'] }}</h3>
                    <div class="stat-trend text-success">

                    </div>
                </div>
            </div>

            <!-- Pending Orders Card -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <h6 class="stat-title">Pending Orders</h6>
                    <h3 class="stat-value">{{ number_format($metrics['pending_orders']) }}</h3>
                    <div class="stat-trend text-danger">

                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <!-- Charts Section -->
        <div class="row g-4">
            <!-- Sales Overview -->
            <div class="col-12 col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title">Sales Overview</h5>
                        <div class="chart-actions">

                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="sales-overview-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-12 col-lg-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title">Top Products</h5>
                        <div class="chart-actions">

                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="top-products-chart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Revenue by Category -->
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title">Revenue by Category</h5>
                        <div class="chart-actions">

                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenue-category-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Common Chart.js Configuration
        Chart.defaults.font.family = "'Poppins', sans-serif";
        Chart.defaults.scale.grid.color = 'rgba(0, 0, 0, 0.05)';
        Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        Chart.defaults.plugins.tooltip.padding = 10;
        Chart.defaults.plugins.tooltip.cornerRadius = 6;
        Chart.defaults.plugins.tooltip.titleFont.size = 14;
        Chart.defaults.plugins.tooltip.bodyFont.size = 13;

        // Utility Functions
        function formatCurrency(value) {
            return '₪' + value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function getGradient(ctx, chartArea, startColor, endColor) {
            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
            gradient.addColorStop(0, startColor);
            gradient.addColorStop(1, endColor);
            return gradient;
        }

        // Sales Overview Chart
        const salesOverviewChart = new Chart(
            document.getElementById('sales-overview-chart'), {
                type: 'line',
                data: {
                    labels: @json($salesOverview['labels']),
                    datasets: [{
                        label: 'Sales',
                        data: @json($salesOverview['data']),
                        borderColor: '#3498db',
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return null;
                            return getGradient(ctx, chartArea, 'rgba(52, 152, 219, 0.1)',
                                'rgba(52, 152, 219, 0)');
                        },
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3498db',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return formatCurrency(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            },
                            ticks: {
                                color: '#6c757d',
                                callback: function(value) {
                                    return formatCurrency(value);
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            }
        );

        // Top Products Chart
        const topProductsChart = new Chart(
            document.getElementById('top-products-chart'), {
                type: 'bar',
                data: {
                    labels: @json(array_keys($topSellingProducts->toArray())),
                    datasets: [{
                        label: 'Sales Quantity',
                        data: @json(array_values($topSellingProducts->toArray())),
                        backgroundColor: '#2ecc71',
                        borderRadius: 6,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        }
                    }
                }
            }
        );

        // Revenue by Category Chart
        const revenueCategoryChart = new Chart(
            document.getElementById('revenue-category-chart'), {
                type: 'bar',
                data: {
                    labels: @json(array_keys($revenueByCategory->toArray())),
                    datasets: [{
                        label: 'Revenue',
                        data: @json(array_values($revenueByCategory->toArray())),
                        backgroundColor: function(context) {
                            const colors = ['#3498db', '#2ecc71', '#e74c3c', '#f1c40f', '#9b59b6'];
                            return colors[context.dataIndex % colors.length];
                        },
                        borderRadius: 6,
                        barThickness: 20
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return formatCurrency(context.parsed.x);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            },
                            ticks: {
                                color: '#6c757d',
                                callback: function(value) {
                                    return formatCurrency(value);
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6c757d'
                            }
                        }
                    }
                }
            }
        );

        // Animate Numbers
        function animateValue(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                element.textContent = Math.floor(progress * (end - start) + start).toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Initialize number animations
        document.addEventListener('DOMContentLoaded', function() {
            const statValues = document.querySelectorAll('.stat-value');
            statValues.forEach(element => {
                const value = parseInt(element.textContent.replace(/[^0-9]/g, ''));
                element.textContent = '0';
                animateValue(element, 0, value, 2000);
            });
        });

        // Add interactivity to filter buttons
        document.querySelectorAll('.chart-actions select, .chart-actions button').forEach(element => {
            element.addEventListener('click', function(e) {
                // Prevent default for buttons
                if (this.tagName === 'BUTTON') {
                    e.preventDefault();
                }

                // Add your filter/export logic here
                console.log('Action triggered:', this.textContent);
            });
        });

        // Responsive handling
        function handleResize() {
            const charts = [salesOverviewChart, topProductsChart, revenueCategoryChart];
            charts.forEach(chart => {
                chart.resize();
            });
        }

        window.addEventListener('resize', handleResize);

        // Optional: Add loading states
        function showLoading(chartId) {
            const canvas = document.getElementById(chartId);
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'loading-overlay';
            loadingOverlay.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        `;
            canvas.parentNode.appendChild(loadingOverlay);
        }

        function hideLoading(chartId) {
            const canvas = document.getElementById(chartId);
            const loadingOverlay = canvas.parentNode.querySelector('.loading-overlay');
            if (loadingOverlay) {
                loadingOverlay.remove();
            }
        }
    </script>
@endsection
