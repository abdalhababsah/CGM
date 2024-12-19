{{-- resources/views/user/login.blade.php --}}
@extends('user.layouts.app')

@section('styles')
    <style>
        .login-form {
            margin-bottom: 50px;
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>@lang('login.login')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('login.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('login.login')</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN LOGIN -->
    <div class="login">
        <div class="wrapper">
            <div class="login-form js-img" data-src="{{ asset('user/img/login-form__bg.png') }}">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Social Login Options -->
                    <h3>@lang('login.login_with')</h3>
                    <ul class="login-form__social">
                        <li><a href=""><i class="icon-facebook"></i></a></li>
                        <li><a href=""><i class="icon-google"></i></a></li>
                    </ul>

                    <!-- Email Address -->
                    <div class="box-field">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus placeholder="{{ __('login.enter_email_or_nickname') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="box-field">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required
                            placeholder="{{ __('login.enter_password') }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <label class="checkbox-box checkbox-box__sm">
                        <input id="remember_me" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        @lang('login.remember_me')
                    </label>
                    <div class="d-flex flex-column">
                        <!-- Submit Button and Links -->
                        <button class="btn" type="submit">@lang('login.log_in')</button>
                        <div class="login-form__bottom">
                            @if (Route::has('register'))
                                <span>@lang('login.no_account') <a href="{{ route('register') }}">@lang('login.register_now')</a></span>
                            @endif
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">@lang('login.lost_password')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <img class="promo-video__decor js-img" data-src="{{ asset('https://via.placeholder.com/1197x1371/FFFFFF') }}"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" alt="">
    </div>
    <!-- LOGIN EOF -->
@endsection
