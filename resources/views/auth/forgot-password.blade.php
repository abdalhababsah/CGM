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
        <div class="wrapper">
            <div class="detail-block__content">
                {{-- <h1>@lang('login.forgot_password')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('login.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('login.forgot_password')</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN FORGOT PASSWORD -->
    <div class="login"> <!-- Reusing the 'login' class for consistent styling -->
        <div class="wrapper">
            <div class="login-form js-img" data-src="{{ asset('user/img/login-form__bg.png') }}">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="box-field">
                        <x-input-label style="margin-bottom: 20px;" for="email" :value="__('login.email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus placeholder="{{ __('login.enter_your_email') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="d-flex flex-column">
                        <!-- Submit Button and Links -->
                        <button class="btn" type="submit">@lang('login.send_reset_link')</button>
                        <div class="login-form__bottom">
                            <span>@lang('login.remembered_password') <a href="{{ route('login') }}">@lang('login.log_in_now')</a></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <img class="promo-video__decor js-img" data-src="{{ asset('https://via.placeholder.com/1197x1371/FFFFFF') }}"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" alt="">
    </div>
    <!-- FORGOT PASSWORD EOF -->
@endsection