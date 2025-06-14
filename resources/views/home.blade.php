@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{url('user/css/home.css')}}">
@endsection

@section('title')
    @lang('home.title')
@endsection

@section('meta')
    <meta name="description" content="@lang('home.description')">
    <meta name="keywords" content="@lang('home.keywords')">
@endsection

@section('content')

    <div class="main-block load-bg">
        <div id="hero-section" class="wrapper d-flex">
            <div id="block__content" class="main-block__content">
                <span id="professional" class="saint-text">@lang('home.professional')</span>
                <h1 id="beauty_and_care" class="main-text">@lang('home.beauty_and_care')</h1>
                <p id="nourish_description">@lang('home.nourish_description')</p>
                <a id="shop_now" href="{{ route('shop.index') }}" class="btn">@lang('home.shop_now')</a>
            </div>

            <!-- Image Carousel -->
            <div class="image-carousel">
                <div class="carousel-images">
                    <img src="{{ asset('user/img/home.png') }}" alt="Image 1" loading="lazy">
                    <img src="{{ asset('user/img/home-2.png') }}" alt="Image 2" loading="lazy">
                    <img src="{{ asset('user/img/girl4.png') }}" alt="Image 3" loading="lazy">

                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN TRENDING -->
    <section class="trending">
        <div class="trending-content">
            <div class="trending-top">
                <span class="saint-text">@lang('home.cosmetics')</span>
                <h2>@lang('home.trending_products')</h2>
            </div>
            <div class="products-slider js-products-slider">

                @foreach ($commingSoons as $commingSoon)
                    <div class="products-item">
                        <div class="products-item__type">
                            <span class="products-item__new">Soon</span>
                        </div>
                        <div class="products-item__img">
                            @if ($commingSoon->image)
                            <img src="{{ asset('storage/' . $commingSoon->image) }}"
                                alt="{{ $commingSoon->name }}" loading="lazy">
                                @endif
                        </div>
                        <div class="products-item__info">
                            <span class="products-item__name">{{ $commingSoon->name }}</span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- BEGIN ADVANTAGES -->
    <div class="advantages">
        <div class="wrapper">
            <div class="advantages-items">
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-natural"></i>
                    </div>
                    <h4>@lang('home.natural')</h4>
                    {{-- <p>@lang('home.natural_description')</p> --}}
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-quality"></i>
                    </div>
                    <h4>@lang('home.quality')</h4>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-organic"></i>
                    </div>
                    <h4>@lang('home.organic')</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- ADVANTAGES EOF   -->
    <!-- BEGIN TOP CATEGORIES -->
    <section class="top-categories">
        <div class="top-categories__text text-center">
            <span class="saint-text">@lang('home.popular_collections')</span>
            <h2 class="animate__animated animate__fadeIn">@lang('home.top_categories')</h2>
        </div>
        <div class="top-categories__items d-flex justify-content-around">
            <a href="{{ route('shop.index') }}" class="top-categories__item animate__animated animate__fadeInRight">
                <img data-src="{{ 'user/img/image-1.png' }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img img-fluid" alt="@lang('home.tools')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.tools')</h5>
                </div>
            </a>
            <a href="{{ route('shop.index') }}" class="top-categories__item animate__animated animate__fadeInDown">
                <img data-src="{{ asset('user/img/image-2.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img img-fluid" alt="@lang('home.women')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.women')</h5>
                </div>
            </a>
            <a href="{{ route('shop.index') }}" class="top-categories__item animate__animated animate__fadeInLeft">
                <img data-src="{{ 'user/img/image-3.png' }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img img-fluid" alt="@lang('home.children')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.children')</h5>
                </div>
            </a>
        </div>
    </section>
    <!-- TOP CATEGORIES EOF   -->
    <!-- BEGIN INFO BLOCKS -->
    <div class="info-blocks">
        <div class="info-blocks__item js-img" data-src="">
            <div class="wrapper">
                <div class="info-blocks__item-img">
                    <img data-src="{{ asset('user/img/image-6.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img" alt="@lang('home.check_this_out')">
                </div>
                <div class="info-blocks__item-text">
                    <span class="saint-text">@lang('home.check_this_out')</span>
                    <h2>@lang('home.new_collection')</h2>
                    <span class="info-blocks__item-descr">@lang('home.check_this_out_description')</span>
                    <a href="{{ route('shop.index') }}" class="btn">@lang('home.shop_now')</a>
                </div>
            </div>
        </div>
        <div class="info-blocks__item info-blocks__item-reverse js-img" data-src="">
            <div class="wrapper">
                <div class="info-blocks__item-img">
                    <img data-src="{{ asset('user/img/image-5.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img">
                </div>
                <div class="info-blocks__item-text">
                    <span class="saint-text">@lang('home.about_us')</span>
                    <h2>@lang('home.who_we_are')</h2>
                    <span class="info-blocks__item-descr">@lang('home.who_we_are_description')</span>
                </div>
            </div>
        </div>
    </div>

    <section id="call-to-action" class="call-to-action section dark-background">
        <picture>
            <!-- Mobile Devices -->
            <source media="(max-width: 767px)" srcset="{{ asset('user/img/mobile.jpg') }}">

            <!-- Tablet Devices -->
            <source media="(min-width: 768px) and (max-width: 1023px)"
                srcset="{{ asset('user/img/scrol-image-tablet.jpg') }}">

            <!-- Desktop Devices -->
            <img src="{{ asset('user/img/scroll-image.png') }}" alt="Call to Action Image">
        </picture>
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-10">
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('user/js/products-slider.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const items = document.querySelectorAll('.top-categories__item');

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__animated', 'animate__fadeInRight');
                    }
                });
            });

            items.forEach(item => observer.observe(item));

        });

        document.addEventListener("DOMContentLoaded", function() {
            const images = document.querySelectorAll(".carousel-images img");
            let currentIndex = 0;

            function swapImages() {
                // Remove active class from the current image
                images[currentIndex].classList.remove("active");

                // Move to the next image
                currentIndex = (currentIndex + 1) % images.length;

                // Add active class to the next image
                images[currentIndex].classList.add("active");
            }

            // Set the first image to active
            images[currentIndex].classList.add("active");

            // Swap images every 3 seconds
            setInterval(swapImages, 3000);
        });
    </script>

@endsection