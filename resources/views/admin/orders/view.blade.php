@extends('dashboard-layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Order Details <span class="float-end">#{{ $order->id }}</span></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->primaryImage->url ?? 'https://via.placeholder.com/50' }}" 
                                                     alt="{{ $item->product->name_en }}" 
                                                     class="rounded me-3" width="50">
                                                <span>{{ $item->product->name_en }}</span>
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

                    <h6>Customer Information</h6>
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Phone:</strong> {{ $order->user->phone }}</p>

                    <hr>

                    <h6>Delivery Information</h6>
                    <p><strong>Address:</strong> {{ $order->orderLocation->address ?? 'N/A' }}</p>
                    <p><strong>City:</strong> {{ $order->orderLocation->city ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border shadow-none">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-end">₪{{ number_format($originalPrice, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Discount:</td>
                                    <td class="text-end">- ₪{{ number_format($discount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Delivery Price:</td>
                                    <td class="text-end">₪{{ number_format($deliveryPrice, 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <th>Total:</th>
                                    <td class="text-end">
                                        <strong>₪{{ number_format($finalPrice, 2) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border shadow-none mt-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="font-size-16 mb-0">Actions</h5>
                </div>
                <div class="card-body text-center">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-3">
                        <i class="mdi mdi-arrow-left"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.orders.invoice.download', ['order' => $order->id, 'language' => 'en']) }}" 
                       class="btn btn-primary">
                        <i class="mdi mdi-download"></i> Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection