@extends('user.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('user/css/contact-us.css') }}">
@endsection
@section('content')
    <div class="detail-block">
        <div class="overlay"></div>
        <div class="wrapper">
            <div class="detail-block__content">
                <div class="detail-block__items">
                    <div class="detail-block__item">
                        <div class="detail-block__item-icon">
                            <i class="icon-map-pin-big"></i>
                        </div>
                        <div class="detail-block__item-info">
                            Palestine<br>
                        </div>
                    </div>
                    <div class="detail-block__item">
                        <div class="detail-block__item-icon">
                            <i class="icon-phone"></i>
                        </div>
                        <div class="detail-block__item-info">
                            +972592106900<br>
                            info@cgm.com
                        </div>
                    </div>
                    <div class="detail-block__item">
                        <div class="detail-block__item-icon">
                            <i class="icon-2"></i>
                        </div>
                        <div class="detail-block__item-info">
                            Open 24/7
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN ABOUT US -->
    <div class="contacts-info">
        <div class="wrapper">
            <div class="contacts-info__content">
                <div class="contacts-info__text">
                    <h2 style="color:#971d25 !important;">@lang('contactus.about_us')</h2>
                    <h3 style="margin-top:29px; color:#c98a88;">@lang('contactus.who_we_are')</h3>
                    <p>@lang('contactus.welcome')</p>
                    <p>@lang('contactus.our_story')</p>
                </div>
                <!-- Floating Images -->
                <div class="about-us-images">
                    <img style="display: none" src="{{ asset('user/img/cards-images/card-1.png') }}" alt="Image 1">
                    <img src="{{ asset('user/img/image-5.png') }}" alt="Image 2">
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT US EOF -->
    <!-- BEGIN MISSION -->
    <div class="contacts-info contacts-info-2">
        <div class="wrapper">
            <div class="contacts-info__content">
                <div class="contacts-info__text">
                    <h3 style="color:#c98a88;">@lang('contactus.mission.title')</h3>
                    <div>
                        <p>@lang('contactus.mission.embrace')</p>
                        <p>@lang('contactus.mission.promote')</p>
                        <p>@lang('contactus.mission.empower')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MISSION EOF -->
    <!-- BEGIN VISION -->
    <div style="margin-bottom: 56px;" class="contacts-info contacts-info-2">
        <div class="overlay"></div>
        <div class="wrapper">
            <div class="contacts-info__content">
                <div class="contacts-info__text">
                    <h3 style="color:#c98a88;">@lang('contactus.vision.title')</h3>
                    <p>@lang('contactus.vision.content')</p>
                </div>
                <div class=" about-us-images-2">
                    <img class="img-3" src="{{ asset('user/img/cards-images/card-3.png') }}" alt="Image 3">
                </div>
            </div>
        </div>
    </div>
    <!-- VISION EOF -->
    <!-- BEGIN DISCOUNT -->
    <div class="discount discount-contacts js-img" data-src="{{ asset('user/img/scroll-image.png') }}">

        <div class="wrapper">

            <div class="discount-info">
                <span style="font-size: 50px; " class="main-text">@lang('contactus.write_to_us')</span>
                <p style="color:#ffffff">
                    @lang('contactus.write_to_us_description')
                </p>
                @if (session('success'))
                    <div class="success">
                        {{ session('success') }}
                        <button type="button" class="close-btn" aria-label="Close">&times;</button>
                    </div>
                @endif
                <!-- Contact Us Form -->
                <form id="contact-form-container" action="{{ route('contact.submit') }}" method="POST">
                    @csrf <!-- CSRF Protection -->
                    <div class="box-field">
                        <input type="text" name="name" class="form-control" placeholder="@lang('contactus.enter_name')"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="box-field">
                        <input type="email" name="email" class="form-control" placeholder="@lang('contactus.enter_email')"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="box-field box-field__textarea">
                        <textarea name="message" class="form-control" placeholder="@lang('contactus.enter_message')" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn">@lang('contactus.send')</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.success .close-btn');

            closeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const message = this.parentElement;
                    // Fade out the message
                    message.style.opacity = '0';
                    // After the transition, remove the element from the DOM
                    setTimeout(function() {
                        message.remove();
                    }, 500); // Match the transition duration
                });
            });
        });
    </script>
    <!-- DISCOUNT EOF -->
@endsection
