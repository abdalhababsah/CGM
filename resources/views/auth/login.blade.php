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
        <div class="overlay"></div>
        <div class="wrapper">
            <div class="detail-block__content">
                {{-- <h1>@lang('login.login')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('login.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('login.login')</li>
                </ul> --}}
            </div>
        </div>
    </div>

    <div class="login">
        <div class="wrapper">
            <div class="login-form js-img" data-src="{{ asset('user/img/login-form__bg.png') }}">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <h3>@lang('login.login_with')</h3>
                <ul class="login-form__social">
                    <li>
                        <a href="{{ route('auth.google') }}" class="google-login">
                            <i class="icon-google"></i>
                        </a>
                    </li>
                </ul>

                <!-- Regular Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="box-field">
                        <x-input-label style="margin-bottom: 10px;" for="email" :value="__('login.email')" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                            required autofocus placeholder="{{ __('login.enter_email_or_nickname') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="box-field">
                        <x-input-label style="margin-bottom: 10px;" for="password" :value="__('login.password')" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required
                            placeholder="{{ __('login.enter_password') }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>


                    <!-- Submit Button and Links -->
                    <div class="d-flex flex-column">
                        <button class="btn" type="submit">@lang('login.log_in')</button>
                        <div class="login-form__bottom">
                            @if (Route::has('register'))
                                <span>@lang('login.no_account') <a href="{{ route('register') }}">@lang('login.register_now')</a></span>
                            @endif

                            @if (Route::has('password.request'))
                            <br>
                                <a href="{{ route('password.request') }}">@lang('login.lost_password')</a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- LOGIN EOF -->
@endsection
