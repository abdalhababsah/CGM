@extends('dashboard-layouts.app')

@section('content')
<style>
    .order-card {
        color: #fff;
    }

    .bg-c-blue {
        background: linear-gradient(45deg, #4099ff, #73b4ff);
    }

    .bg-c-green {
        background: linear-gradient(45deg, #2ed8b6, #59e0c5);
    }

    .bg-c-yellow {
        background: linear-gradient(45deg, #FFB64D, #ffcb80);
    }

    .bg-c-pink {
        background: linear-gradient(45deg, #FF5370, #ff869a);
    }

    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        border: none;
        margin-bottom: 30px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .card .card-block {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .order-card h2 {
        font-size: 2rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .order-card h6 {
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .order-card i {
        font-size: 2rem;
        margin-right: 10px;
        color: rgba(255, 255, 255, 0.8);
    }

    .order-card .f-left {
        margin-right: auto;
    }

    .order-card .f-right {
        margin-left: auto;
    }
</style>
<div class="container-fluid p-0">
    <!-- Metrics Cards -->
    <div class="container">
        <div class="row">
            <!-- Total Users -->
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6>Total Users</h6>
                        <h2>
                            <i class="fa fa-users f-left"></i>
                            <span class="f-right">486</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6>Total Orders</h6>
                        <h2>
                            <i class="fa fa-rocket f-left"></i>
                            <span class="f-right">486</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6>Total Revenue</h6>
                        <h2>
                            <i class="fa fa-refresh f-left"></i>
                            <span class="f-right">$12,345</span>
                        </h2>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6>Pending Orders</h6>
                        <h2>
                            <i class="fa fa-credit-card f-left"></i>
                            <span class="f-right">27</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
