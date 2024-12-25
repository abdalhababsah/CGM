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
                        <p class="card-text h4 mb-0"></p>
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
                        <p class="card-text h4 mb-0"></p>
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
                        <p class="card-text h4 mb-0"></p>
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
                        <p class="card-text h4 mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>


@endsection