@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages') <!-- Success and error messages -->

    <style>
        .col-md-3{
            margin-top:0px !important;
        }
    </style>
    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>@lang('dashboard.user_orders.orders_table')</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.user_orders.order_id')</th>
                                    <th>@lang('dashboard.user_orders.user')</th>
                                    <th>@lang('dashboard.user_orders.ordered_at')</th>
                                    <th>@lang('dashboard.user_orders.total')</th>
                                    <th class="text-center">@lang('dashboard.user_orders.status')</th>
                                    <th class="text-center">@lang('dashboard.user_orders.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            {{ $order->user->name }}<br>
                                            <small>{{ $order->user->email }}</small>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                        <td>₪{{ number_format($order->finalPrice, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-gradient-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(__('dashboard.user_orders.' . strtolower($order->status))) }}
                                            </span>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                                @lang('dashboard.user_orders.view')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">@lang('dashboard.user_orders.no_orders_found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $orders->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection