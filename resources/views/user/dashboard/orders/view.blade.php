@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">
                        @lang('dashboard.order_details.order_details') 
                        <span class="float-end">#{{ $order->id }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.order_details.product')</th>
                                    <th>@lang('dashboard.order_details.unit_price')</th>
                                    <th>@lang('dashboard.order_details.quantity')</th>
                                    <th>@lang('dashboard.order_details.total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->primaryImage->url ?? 'https://via.placeholder.com/50' }}" 
                                                     alt="{{ $item->product->{'name_' . app()->getLocale()} }}" 
                                                     class="rounded me-3" width="50">
                                                <span>{{ $item->product->{'name_' . app()->getLocale()} }}</span>
                                            </div>
                                        </td>
                                        <td>₪{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>₪{{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <!-- Customer Information -->
                    <h6>@lang('dashboard.order_details.customer_information')</h6>
                    <p><strong>@lang('dashboard.order_details.name'):</strong> {{ $order->user->name }}</p>
                    <p><strong>@lang('dashboard.order_details.email'):</strong> {{ $order->user->email }}</p>
                    <p><strong>@lang('dashboard.order_details.phone'):</strong> {{ $order->user->phone }}</p>

                    <hr>

                    <!-- Delivery Information -->
                    <h6>@lang('dashboard.order_details.delivery_information')</h6>
                    <p><strong>@lang('dashboard.order_details.address'):</strong> {{ $order->orderLocation->address ?? 'N/A' }}</p>
                    <p><strong>@lang('dashboard.order_details.city'):</strong> {{ $order->orderLocation->city ?? 'N/A' }}</p>
                    <p><strong>@lang('dashboard.order_details.country'):</strong> {{ $order->orderLocation->country ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">@lang('dashboard.order_summary.order_summary')</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>@lang('dashboard.order_summary.subtotal'):</td>
                                    <td class="text-end">₪{{ number_format($originalPrice, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('dashboard.order_summary.discount'):</td>
                                    <td class="text-end">- ₪{{ number_format($discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('dashboard.order_summary.delivery_price'):</td>
                                    <td class="text-end">₪{{ number_format($deliveryPrice, 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>@lang('dashboard.order_summary.total'):</th>
                                    <td class="text-end">
                                        <strong>₪{{ number_format($finalPrice, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border shadow-none mt-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">@lang('dashboard.actions.actions')</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('user.orders.index') }}" class="btn btn-secondary mb-3">
                        <i class="mdi mdi-arrow-left"></i> @lang('dashboard.actions.back_to_my_orders')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection