@extends('user.layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
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
}

#professional {
    animation: fadeInLeft 3s ease-out 0.3s forwards; /* Delayed by 0.3s */
}

#beauty_and_care {
    animation: fadeInUp 3s ease-out 0.6s forwards; /* Delayed by 0.6s */
}

#nourish_description {
    animation: fadeInRight 3s ease-out 0.9s forwards; /* Delayed by 0.9s */
}

#shop_now {
    animation: zoomIn 3s ease-out 1.2s forwards; /* Delayed by 1.2s */
}
.top-categories__item {
    animation-delay: 0.3s; /* Default delay */
}

.top-categories__item:nth-child(2) {
    animation-delay: 0.6s; /* Delay for the second item */
}

.top-categories__item:nth-child(3) {
    animation-delay: 0.9s; /* Delay for the third item */
}
</style>
@endsection
@section('content')
    <div class="main-block load-bg">
        <div class="wrapper">
            <div id="block__content" class="main-block__content">
                <span id="professional" class="saint-text">@lang('home.professional')</span>
                <h1 id="beauty_and_care" class="main-text">@lang('home.beauty_and_care')</h1>
                <p id="nourish_description">@lang('home.nourish_description')</p>
                <a id="shop_now" href="#" class="btn">@lang('home.shop_now')</a>
            </div>
        </div>
    </div>
    <!-- BEGIN TRENDING -->
    <section class="trending">
        <div class="trending-content">
            <div class="trending-top">
                <span class="saint-text">@lang('home.cosmetics')</span>
                <h2>@lang('home.trending_products')</h2>
                <p>@lang('home.nourish_description')</p>
            </div>
            <div class="tab-wrap trending-tabs">
                <ul class="nav-tab-list tabs">
                    <li class="active">
                        <a href="#trending-tab_1">@lang('home.make_up')</a>
                    </li>
                    <li>
                        <a href="#trending-tab_3">@lang('home.perfume')</a>
                    </li>
                    <li>
                        <a href="#trending-tab_5">@lang('home.skin_care')</a>
                    </li>
                    <li>
                        <a href="#trending-tab_6">@lang('home.hair_care')</a>
                    </li>
                </ul>
                <div class="box-tab-cont">
                    <div class="tab-cont" id="trending-tab_1">
                        <div class="products-items js-products-items">
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__new">new</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost">$200.95</span>
                                </div>
                            </a>
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="tab-cont hide" id="trending-tab_3">
                        <div class="products-items">
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tab-cont hide" id="trending-tab_5">
                        <div class="products-items">
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tab-cont hide" id="trending-tab_6">
                        <div class="products-items">
                            <a href="#" class="products-item">
                                <div class="products-item__type">
                                    <span class="products-item__sale">sale</span>
                                </div>
                                <div class="products-item__img">
                                    <img data-src="https://via.placeholder.com/400x570"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <i class="icon-heart"></i>
                                            <i class="icon-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">Detox body Cream</span>
                                    <span class="products-item__cost"><span>$249.95</span> $200.95</span>
                                </div>
                            </a>
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
                    <p>@lang('home.natural_description')</p>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-quality"></i>
                    </div>
                    <h4>@lang('home.quality')</h4>
                    <p>@lang('home.quality_description')</p>
                </div>
                <div class="advantages-item">
                    <div class="advantages-item__icon">
                        <i class="icon-organic"></i>
                    </div>
                    <h4>@lang('home.organic')</h4>
                    <p>@lang('home.organic_description')</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ADVANTAGES EOF   -->
    <section id="call-to-action" class="call-to-action section dark-background">

        <img src="{{ asset('user/img/scroll-image.png') }}" alt="">

        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-10">

                </div>
            </div>
        </div>

    </section>
<!-- BEGIN TOP CATEGORIES -->
<section class="top-categories">
    <div class="top-categories__text text-center">
        <span class="saint-text">@lang('home.popular_collections')</span>
        <h2 class="animate__animated animate__fadeIn">@lang('home.top_categories')</h2>
        <p class="animate__animated animate__fadeIn">@lang('home.nourish_description')</p>
    </div>
    <div class="top-categories__items d-flex justify-content-around">
        <a href="#" class="top-categories__item animate__animated animate__fadeInRight">
            <img data-src="{{ 'user/img/image-1.png' }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img img-fluid" alt="@lang('home.spa')">
            <div class="top-categories__item-hover">
                <h5>@lang('home.spa')</h5>
                <span>@lang('home.browse_products') -</span>
                <i class="icon-arrow-lg"></i>
            </div>
        </a>
        <a href="#" class="top-categories__item animate__animated animate__fadeInDown">
            <img data-src="{{ asset('user/img/image-2.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img img-fluid" alt="@lang('home.nails')">
            <div class="top-categories__item-hover">
                <h5>@lang('home.nails')</h5>
                <span>@lang('home.browse_products') -</span>
                <i class="icon-arrow-lg"></i>
            </div>
        </a>
        <a href="#" class="top-categories__item animate__animated animate__fadeInLeft">
            <img data-src="{{ 'user/img/image-3.png' }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img img-fluid" alt="@lang('home.perfume')">
            <div class="top-categories__item-hover">
                <h5>@lang('home.perfume')</h5>
                <span>@lang('home.browse_products') -</span>
                <i class="icon-arrow-lg"></i>
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
                    <a href="#" class="btn">@lang('home.shop_now')</a>
                </div>
            </div>
        </div>
        <div class="info-blocks__item info-blocks__item-reverse js-img" data-src="">
            <div class="wrapper">
                <div class="info-blocks__item-img">
                    <img data-src="{{ asset('user/img/image-5.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img" alt="@lang('home.promotion_video')">

                </div>
                <div class="info-blocks__item-text">
                    <span class="saint-text">@lang('home.about_us')</span>
                    <h2>@lang('home.who_we_are')</h2>
                    <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>

                </div>
            </div>
        </div>
    </div>
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
    </script>
    
@endsection
