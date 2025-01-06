@extends('user.layouts.app')

@section('content')
    <style>
        .section {
            min-height: 85vh;
        }

        .section-padding {
            padding: 60px 0;
        }

        /* Sidebar Navigation */
        .my-account-tab-list {
            background-color: #fff;
            margin-top: 14px;
            padding: 20px;
        }

        .my-account-tab-list .nav {
            display: flex;
            flex-direction: column;
        }

        .my-account-tab-list .nav li {
            margin-bottom: 15px;
        }

        .my-account-tab-list .nav li a {
            color: #555;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .my-account-tab-list .nav li a i {
            margin-right: 8px;
            font-size: 18px;
        }

        .my-account-tab-list .nav li a:hover,
        .my-account-tab-list .nav li a.active {
            background-color: #007bff;
            color: #fff;
        }

        /* Tab Content */
        .tab-content {
            background-color: #fff;
            padding: 30px;
        }

        /* Dashboard */
        .myaccount-content.dashboad .alert {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .myaccount-content.dashboad p {
            font-size: 16px;
            color: #333;
        }

        /* Statistics Cards */
        .stats-cards {
            margin-bottom: 30px;
        }

        .stats-card {
            background-color: #f7f7f7;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card i {
            font-size: 30px;
            margin-right: 15px;
            color: #007bff;
        }

        .stats-card .stats-info {
            display: flex;
            flex-direction: column;
        }

        .stats-card .stats-info .stats-title {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }

        .stats-card .stats-info .stats-value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        /* Tables */
        .myaccount-content table {
            width: 100%;
            border-collapse: collapse;
        }

        .myaccount-content table th,
        .myaccount-content table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .myaccount-content table th {
            background-color: #f7f7f7;
            color: #333;
        }

        .myaccount-content table tr:hover {
            background-color: #f1f1f1;
        }

        .myaccount-content table a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .myaccount-content table a:hover {
            text-decoration: underline;
        }

        /* Addresses */
        .myaccount-content.address .alert {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .myaccount-content.address .title {
            font-size: 18px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .myaccount-content.address address {
            font-style: normal;
            line-height: 1.6;
            color: #555;
        }

        .myaccount-content.address .edit-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .myaccount-content.address .edit-link:hover {
            text-decoration: underline;
        }

        /* Account Details Form */
        .myaccount-content.account-details .account-details-form form {
            width: 100%;
        }

        .myaccount-content.account-details .account-details-form .single-input-item {
            margin-bottom: 20px;
        }

        .myaccount-content.account-details .account-details-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .myaccount-content.account-details .account-details-form input[type="text"],
        .myaccount-content.account-details .account-details-form input[type="email"],
        .myaccount-content.account-details .account-details-form input[type="password"] {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        .myaccount-content.account-details .account-details-form input[type="text"]:focus,
        .myaccount-content.account-details .account-details-form input[type="email"]:focus,
        .myaccount-content.account-details .account-details-form input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .myaccount-content.account-details .account-details-form fieldset {
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .myaccount-content.account-details .account-details-form fieldset legend {
            font-weight: bold;
            padding: 0 10px;
            color: #333;
        }

        .myaccount-content.account-details .account-details-form .small {
            color: #777;
        }

        .btn {
            padding: 0px 12px !important;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .my-account-tab-list {
                margin-bottom: 30px;
            }
        }

        .li-dash {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #f7f7f7;
            border-radius: 8px;
            padding: 11px;
            margin-bottom: 10px;
            list-style: none;
            border-radius: 6px;
        }
    </style>
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                {{-- <h1>{{ __('cart.title') }}</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">{{ __('cart.home') }}</a>
                    </li>
                    <li class="bread-crumbs__item">{{ __('cart.title') }}</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <div class="section section-padding">
        <div class="container">
            <div class="row g-lg-10 g-6">
                <!-- My Account Tab List Start -->
                <div class="col-lg-3 col-12">
                    <ul class="my-account-tab-list nav flex-column">
                        <li class="li-dash">
                            <a href="#dashboad" class="active" data-bs-toggle="tab">
                                <i class="sli-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="li-dash">
                            <a href="#orders" data-bs-toggle="tab">
                                <i class="sli-notebook"></i> Orders
                            </a>
                        </li>
                        <li class="li-dash">
                            <a href="#account-info" data-bs-toggle="tab">
                                <i class="sli-user"></i> Account Details
                            </a>
                        </li>
                        <!-- resources/views/layouts/app.blade.php -->

                        <li class="li-dash">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="sli-logout"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- My Account Tab List End -->
                <!-- My Account Tab Content Start -->
                <div class="col-lg-8 col-12">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="tab-content">

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade show active" id="dashboad">
                            <div class="myaccount-content dashboad">
                                <!-- Statistics Cards Start -->
                                <div class="stats-cards row">
                                    <!-- Card 1: Total Orders -->
                                    <div class="col-md-4 mb-4">
                                        <div class="stats-card">
                                            <i class="sli-graph"></i>
                                            <div class="stats-info">
                                                <div class="stats-title">Total Orders</div>
                                                <div class="stats-value">25</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 2: Total Spent -->
                                    <div class="col-md-4 mb-4">
                                        <div class="stats-card">
                                            <i class="sli-wallet"></i>
                                            <div class="stats-info">
                                                <div class="stats-title">Total Spent</div>
                                                <div class="stats-value">₪1,250.00</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card 3: Pending Orders -->
                                    <div class="col-md-4 mb-4">
                                        <div class="stats-card">
                                            <i class="sli-hourglass"></i>
                                            <div class="stats-info">
                                                <div class="stats-title">Pending Orders</div>
                                                <div class="stats-value">5</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Statistics Cards End -->

                                <div class="alert alert-light">
                                    Hello <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                                </div>
                                <p>
                                    From your account dashboard you can view your <u>recent orders</u>, manage your
                                    <u>shipping and billing addresses</u>, and <u>edit your password and account
                                        details</u>.
                                </p>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="orders">
                            <div class="myaccount-content order">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                                    </td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>₪{{ number_format($order->total_amount, 2) }}</td>
                                                    <td><a href="order-details.html"><strong>View</strong></a></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No orders found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination Links -->
                                @if ($orders->hasPages())
                                    <div class="mt-4">
                                        {{ $orders->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="account-info">
                            <div class="myaccount-content account-details">
                                <div class="account-details-form">
                                    <form action="{{ route('profile.update') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row g-4">
                                            <div class="col-md-6 col-12">
                                                <div class="single-input-item">
                                                    <label for="first-name">First Name <abbr
                                                            class="required">*</abbr></label>
                                                    <input class="form-field" type="text" id="first-name"
                                                        name="first_name" value="{{ $user->first_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="single-input-item">
                                                    <label for="last-name">Last Name <abbr class="required">*</abbr></label>
                                                    <input class="form-field" type="text" id="last-name"
                                                        name="last_name" value="{{ $user->last_name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="email">Email Address <abbr
                                                        class="required">*</abbr></label>
                                                <input class="form-field" type="email" id="email" name="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                            <div class="col-12">
                                                <fieldset>
                                                    <legend>Password change</legend>
                                                    <div class="row g-4">
                                                        <div class="col-12">
                                                            <label for="current-pwd">Current password (leave blank to leave
                                                                unchanged)</label>
                                                            <input class="form-field" type="password" id="current-pwd"
                                                                name="current_password">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="new-pwd">New password (leave blank to leave
                                                                unchanged)</label>
                                                            <input class="form-field" type="password" id="new-pwd"
                                                                name="new_password">
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="confirm-pwd">Confirm new password</label>
                                                            <input class="form-field" type="password" id="confirm-pwd"
                                                                name="new_password_confirmation">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-dark btn-primary-hover">Save
                                                    Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->
                    </div>
                </div>
                <!-- My Account Tab Content End -->

            </div>
        </div>
    </div>
@endsection
