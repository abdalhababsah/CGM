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
                background-image: url('{{ asset('user/img/cards-images/card-1.png') }}');
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
                background-image: url('{{ asset('user/img/cards-images/card-5.png') }}');
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
                background-image: url('{{ asset('user/img/cards-images/card-3.png') }}');
                background-size: cover;
                background-position: center;
                z-index: 0;
                opacity: 1;
            }


            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            /* Pending Orders Card */
            #pending-orders-card {
                color: white;
                position: relative;
                overflow: hidden;
                background-color: #981e24;
                margin-bottom: 20px;
                animation: bounce 1.5s infinite;
                /* Bounce animation */

            }

            #pending-orders-card .card-block {
                padding: 38px 20px;
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
                background-image: url('{{ asset('user/img/cards-images/card-4.png') }}');
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
        @if (in_array(app()->getLocale(), ['ar', 'he']))
            <link rel="stylesheet" href="{{ asset('admin/assets/css/rtlstyles.css') }}">
        @endif
    @endpush
    <div class="container-fluid p-0">
        <!-- Metrics Cards -->
        <div style="margin-top: 30px;" class="container">
            <div class="row">
                <!-- Total Users -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-users-card" class="card order-card">
                        <div class="card-block">
                            <h6>@lang('dashboard.total_users')</h6>
                            <h2>
                                <span class="f-right">486</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-orders-card" class="card order-card">
                        <div class="card-block">
                            <h6>@lang('dashboard.total_orders')</h6>
                            <h2>
                                <span class="f-right">486</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-md-4 col-xl-3">
                    <div id="total-revenue-card" class="card order-card">
                        <div class="card-block">
                            <h6>@lang('dashboard.total_revenue')</h6>
                            <h2>
                                <span class="f-right">₪12,345</span>
                            </h2>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="col-md-4 col-xl-3">
                    <a href="{{ route('shop.index') }}">
                        <div id="pending-orders-card" class="card order-card">
                            <div class="card-block">
                                <h6>@lang('dashboard.back_to_shop')</h6>
                                <div class="flex-end d-flex">

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
