@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .header-content {
            background-color: rgb(151 29 37) !important;
        }

        /* Keyframes for fade-in animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Default hidden state */
        #block__content,
        #professional,
        #beauty_and_care,
        #nourish_description,
        #shop_now {
            opacity: 0;
        }

        /* Animation triggers */
        #block__content {
            animation: fadeInUp 3s ease-out forwards;
            width: 50%;
        }

        #professional {
            animation: fadeInLeft 3s ease-out 0.3s forwards;
            /* Delayed by 0.3s */
        }

        #beauty_and_care {
            animation: fadeInUp 3s ease-out 0.6s forwards;
            /* Delayed by 0.6s */
        }

        #nourish_description {
            animation: fadeInRight 3s ease-out 0.9s forwards;
            /* Delayed by 0.9s */
        }

        #shop_now {
            animation: zoomIn 3s ease-out 1.2s forwards;
            /* Delayed by 1.2s */
        }

        .top-categories__item {
            animation-delay: 0.3s;
            /* Default delay */
        }

        .top-categories__item:nth-child(2) {
            animation-delay: 0.6s;
            /* Delay for the second item */
        }

        .top-categories__item:nth-child(3) {
            animation-delay: 0.9s;
            /* Delay for the third item */
        }

        .image-carousel {
            width: 40%;
            /* Allocate space for carousel */
            position: relative;
            height: 500px;
            /* Match height of images */
            margin: 0;
            /* Reset margins for cleaner alignment */

        }

        .carousel-images {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Header Content */
        .main-block__content {
            flex: 1 1 400px;
            /* Allow content to shrink or grow and set a minimum width */
            padding-right: 20px;
        }

        /* Image Carousel */
        .image-carousel {
            flex: 1 1 400px;
            /* Allow carousel to shrink or grow and set a minimum width */
            position: relative;
            height: 500px;
            /* Match the height of images */
            margin: 0;
        }

        .carousel-images img {
            border: 8px solid white;
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 100px;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-images img.active {
            opacity: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            #hero-section {
                flex-direction: column;
                /* Stack items vertically on smaller screens */
            }

            #block__content {
                width: 100%;
                margin-top: 39px;
            }

            .main-block__content,
            .image-carousel {
                width: 100%;
                /* Make both sections take full width */
            }

            .image-carousel {
                height: 300px;
                /* Adjust height for smaller screens */
            }
        }

        /* Hero Section Flex Container */
        #hero-section {
            margin-top: 43px;
            display: flex;
            flex-wrap: wrap;
            /* Enable wrapping for child elements */
            align-items: center;
            /* Center items vertically */
            justify-content: space-between;
            /* Maintain space between items */
            gap: 20px;
            /* Add gap between items */
        }
    </style>
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
                    <img src="https://via.placeholder.com/400x570" alt="Image 1">
                    <img src="https://via.placeholder.com/400x570" alt="Image 2">
                    <img src="https://via.placeholder.com/400x570" alt="Image 3">

                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN TRENDING -->
    <section class="trending" style="direction: ltr;">
        <div class="trending-content">
            <div class="trending-top">
                <span class="saint-text">@lang('home.cosmetics')</span>
                <h2>@lang('home.trending_products')</h2>
            </div>
            <div class="products-slider js-products-slider">
                <div class="products-item">
                    <div class="products-item__type">
                        <span class="products-item__new">Soon</span>
                    </div>
                    <div class="products-item__img">
                        <img style="object-fit: contain;" data-src="{{ asset('user/img/comming-soon-1.png') }}"
                            src="{{ asset('user/img/comming-soon-1.png') }}" class="js-img" alt="">
                    </div>
                    <div class="products-item__info">
                        <span class="products-item__name">Bomba De Vitaminas</span>
                    </div>
                </div>
                <div class="products-item">
                    <div class="products-item__type">
                        <span class="products-item__new">Soon</span>
                    </div>
                    <div class="products-item__img">
                        <img style="object-fit: contain;" data-src="{{ asset('user/img/comming-soon-21.png') }}"
                            src="{{ asset('user/img/comming-soon-21.png') }}" class="js-img" alt="">
                    </div>
                    <div class="products-item__info">
                        <span class="products-item__name">Raizes Do Morro</span>
                    </div>
                </div>
                <div class="products-item">
                    <div class="products-item__type">
                        <span class="products-item__new">Soon</span>
                    </div>
                    <div class="products-item__img">
                        <img style="object-fit: contain;" data-src="{{ asset('user/img/comming-soon-31.png') }}"
                            src="{{ asset('user/img/comming-soon-31.png') }}" class="js-img" alt="">
                    </div>
                    <div class="products-item__info">
                        <span class="products-item__name">Cacau</span>
                    </div>
                </div>
                <div class="products-item">
                    <div class="products-item__type">
                        <span class="products-item__new">Soon</span>
                    </div>
                    <div class="products-item__img">
                        <img style="object-fit: contain;" data-src="{{ asset('user/img/comming-soon-41.png') }}"
                            src="{{ asset('user/img/comming-soon-41.png') }}" class="js-img" alt="">
                    </div>
                    <div class="products-item__info">
                        <span class="products-item__name">Vitamin C And Collagen</span>
                    </div>
                </div>
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
                    {{-- <p>@lang('home.quality_description')</p> --}}
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-organic"></i>
                    </div>
                    <h4>@lang('home.organic')</h4>
                    {{-- <p>@lang('home.organic_description')</p> --}}
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
            {{-- <p class="animate__animated animate__fadeIn">@lang('home.nourish_description')</p> --}}
        </div>
        <div class="top-categories__items d-flex justify-content-around">
            <a href="#" class="top-categories__item animate__animated animate__fadeInRight">
                <img data-src="{{ 'user/img/image-1.png' }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img img-fluid" alt="@lang('home.men')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.men')</h5>
                </div>
            </a>
            <a href="#" class="top-categories__item animate__animated animate__fadeInDown">
                <img data-src="{{ asset('user/img/image-2.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img img-fluid" alt="@lang('home.women')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.women')</h5>
                </div>
            </a>
            <a href="#" class="top-categories__item animate__animated animate__fadeInLeft">
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
                    <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>
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
                    <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>

                </div>
            </div>
        </div>
    </div>

    <section id="call-to-action" class="call-to-action section dark-background">
        <img src="{{ asset('user/img/scroll-image.png') }}" alt="">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-10">
                </div>
            </div>
        </div>
    </section>


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


        $(document).ready(function() {
            $('.js-products-slider').slick({
                dots: false,
                prevArrow: '<button id="prev" type="button" class="slick-arrow slick-prev"><i class="icon icon-arrow"></i></button>',
                nextArrow: '<button id="next" type="button" class="slick-arrow slick-next"><i class="icon icon-arrow"></i></button>',
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                lazyLoad: 'progressive',
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 1023,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 650,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            });
        });
    </script>
@endsection
