@extends('user.layouts.app')

@section('content')
    <style>
 
    </style>
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>{{ __('cart.title') }}</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">{{ __('cart.home') }}</a>
                    </li>
                    <li class="bread-crumbs__item">{{ __('cart.title') }}</li>
                </ul>
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
                        <li class="li-dash">
                            <a href="login.html">
                                <i class="sli-logout"></i> Logout
                            </a>
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
                                                <div class="stats-value">$1,250.00</div>
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
                                                    <td>${{ number_format($order->total_amount, 2) }}</td>
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
                                                    <input class="form-field" type="text" id="last-name" name="last_name"
                                                        value="{{ $user->last_name }}" required>
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
