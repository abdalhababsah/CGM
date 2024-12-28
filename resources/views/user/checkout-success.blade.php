@extends('user.layouts.app')

@section('title', __('checkout.success_title'))

@section('content')

<div class="detail-block detail-block_margin">
    <div class="wrapper">
        <div class="detail-block__content">
            {{-- <h1>{{ __('checkout.title') }}</h1>
            <ul class="bread-crumbs">
                <li class="bread-crumbs__item">
                    <a href="{{ route('home') }}" class="bread-crumbs__link">{{ __('checkout.home') }}</a>
                </li>
                <li class="bread-crumbs__item">{{ __('checkout.title') }}</li>
            </ul> --}}
        </div>
    </div>
</div>

<div class="container " style="margin: 50px; align-self: center;" >
    <div class="text-center">
        <img src="{{ asset('user/img/1-d14970c6.png') }}" alt="Thank You" class="img-fluid mb-4" style="max-width: 100%; height: auto;">
        
        <h2 class="text-success">Thank You for Your Order!</h2>
        <p class="text-muted">Order #{{ $order->id }} has been placed successfully.</p>
        <p class="text-secondary">You will receive a confirmation email shortly with the details of your purchase.</p>

        <div class="mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>

@endsection