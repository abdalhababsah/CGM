@extends('user.layouts.app')

@section('title', __('checkout.success_title'))

@section('content')

<div class="detail-block detail-block_margin">
    <div class="overlay"></div>
    <div class="wrapper">
        <div class="detail-block__content">
        </div>
    </div>
</div>

<div class="container " style="margin: 50px; align-self: center;" >
    <div class="text-center">
        <img src="{{ asset('user/img/com-notebook.png') }}" alt="Thank You" class="img-fluid mb-4" style="max-width: 100%; height: auto;">

        <h2 class="text-success">Thank You for Your Order!</h2>
        <p class="text-muted">You will receive your order within two or three days.</p>
        <p class="text-secondary">You will receive a confirmation email shortly with the details of your purchase.</p>

        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>

@endsection
