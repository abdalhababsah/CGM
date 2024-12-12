@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Order Details</h6>
                </div>
                <div class="card-body">
                    <h6>User Information</h6>
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>

                    <h6>Products</h6>
                    <table class="table align-items-center table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantity</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="align-middle text-left">{{ $product->name }}</td>
                                    <td class="align-middle text-center">{{ $product->pivot->quantity }}</td>
                                    <td class="align-middle text-left">${{ $product->price }}</td>
                                    <td class="align-middle text-left">${{ $product->pivot->quantity * $product->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h6 class="mt-4">Order Total: ${{ $order->total }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection