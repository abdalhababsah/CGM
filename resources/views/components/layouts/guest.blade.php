{{-- resources/views/user/forgot-password.blade.php --}}
@extends('user.layouts.app')

@section('styles')
    <style>
        /* Reuse the same styles as login-form for consistency */
        .login-form {
            margin-bottom: 50px;
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin" style="background-image: url({{asset('user/img/website.png')}});">
        <div class="overlay"></div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN FORGOT PASSWORD -->
    <div class="login"> <!-- Reusing the 'login' class for consistent styling -->
        <div class="wrapper">
            <div class="login-form js-img" data-src="">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                {{ $slot }}

            </div>
        </div>
    </div>

@endsection
