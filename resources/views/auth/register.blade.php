{{-- resources/views/user/register.blade.php --}}
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
                {{-- <h1>@lang('register.registration')</h1> --}}
                {{-- <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('register.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('register.registration')</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN REGISTRATION -->
    <div class="login registration">
        <div class="wrapper">
            <div class="login-form js-img" data-src="{{ asset('user/img/login-form__bg.png') }}">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Social Registration Options -->
                    <h3>{{__('register.register_with')}}</h3>
                    <ul class="login-form__social">
                        <li>
                            <a href="{{ route('auth.google') }}" class="google-login">
                                <i class="icon-google"></i>
                            </a>
                        </li>
                    </ul>

                    <!-- Name Fields -->
                    <div class="box-field__row">
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="first_name" :value="__('register.first_name')" />
                            <x-text-input id="first_name" class="form-control" type="text" name="first_name" :value="old('first_name')" required autofocus placeholder="{{__('register.enter_first_name')}}"  />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="last_name" :value="__('register.last_name')" />
                            <x-text-input id="last_name" class="form-control" type="text" name="last_name" :value="old('last_name')" required placeholder="{{__('register.enter_last_name')}}" />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Contact Fields -->
                    <div class="box-field__row">
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="phone" :value="__('register.phone')" />
                            <x-text-input id="phone" class="form-control" name="phone" :value="old('phone')" required placeholder="{{__('register.enter_phone')}}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="email" :value="__('register.email')" />
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required placeholder="{{__('register.enter_email')}}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="box-field__row">
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="password" :value="__('register.password')" />
                            <x-text-input id="password" class="form-control" type="password" name="password" required placeholder="{{__('register.enter_password')}}" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="box-field">
                            <x-input-label style="margin-bottom: 10px;" for="password_confirmation" :value="__('register.confirm_password')" />
                            <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required placeholder="{{__('register.confirm_password_placeholder')}}" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />

                    <!-- Submit Button and Links -->
                    <button class="btn" type="submit">@lang('register.register')</button>
                    
                    <div class="login-form__bottom">
                        @if (Route::has('login'))
                            <span>@lang('register.already_account') <a href="{{ route('login') }}">@lang('register.log_in')</a></span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- LOGIN EOF -->
@endsection