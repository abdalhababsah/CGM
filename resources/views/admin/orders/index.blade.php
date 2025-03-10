@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    @include('components._messages') <!-- Success and error messages -->

    <style>
        .col-md-3{
                 margin-top:0px !important;
        }
    </style>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Filter Orders</h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.orders.index') }}">
                        <div class="row g-3">
                            <!-- Search Filter -->
                            <div class="col-md-3">
                                <label for="search" class="form-label">Order ID or User Name</label>
                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search by ID or User Name"
                                    value="{{ request('search') }}">
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-3">
                                <label for="status" class="form-label">Order Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <!-- Date From Filter -->
                            <div class="col-md-3">
                                <label for="date_from" class="form-label">Date From</label>
                                <input
                                    type="date"
                                    id="date_from"
                                    name="date_from"
                                    class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>

                            <!-- Date To Filter -->
                            <div class="col-md-3">
                                <label for="date_to" class="form-label">Date To</label>
                                <input
                                    type="date"
                                    id="date_to"
                                    name="date_to"
                                    class="form-control"
                                    value="{{ request('date_to') }}">
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100 mt-3">Clear Filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Orders Table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Tracking Number</th>
                                    <th>User</th>
                                    <th>Ordered At</th>
                                    <th>Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            @isset($order->delivery_tracking_no)
                                            {{ $order->delivery_tracking_no }}
                                            @else
                                            <a href="{{ route('admin.orders.resend', $order->id) }}" class="btn btn-secondary btn-sm">
                                                Resend
                                            </a>
                                            @endisset
                                        </td>
                                        <td>
                                            {{ $order->user?->name }}<br>
                                            <small>{{ $order->user?->email }}</small>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                        <td>₪{{ number_format($order->finalPrice, 2) }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-gradient-{{ $order->status == 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary btn-sm">
                                                View
                                            </a>
                                            <a href="{{ route('admin.orders.delete', $order->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this order?')">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found.</td>
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
