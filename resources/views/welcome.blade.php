@extends('user.layouts.app')

@section('content')

    <div class="main-block load-bg">
        <div class="wrapper">
            <div class="main-block__content">
                <span class="saint-text">@lang('home.professional')</span>
                <h1 class="main-text">@lang('home.beauty_and_care')</h1>
                <p>@lang('home.nourish_description')</p>
                <a href="#" class="btn">@lang('home.shop_now')</a>
            </div>
        </div><img class="main-block__decor" src="{{asset('user/img/main-block-decor.png')}}" alt="">
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
    <!-- TRENDING EOF   -->
    <!-- BEGIN LOGOS -->
    <div class="main-logos">
        <img data-src="img/main-logo1.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
            alt="">
        <img data-src="img/main-logo2.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
            alt="">
        <img data-src="img/main-logo3.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
            alt="">
        <img data-src="img/main-logo4.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
            alt="">
        <img data-src="img/main-logo5.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
            alt="">
    </div>
    <!-- LOGOS EOF   -->
    <!-- BEGIN DISCOUNT -->
    <div class="discount js-img" data-src="https://via.placeholder.com/1920x900">
        <div class="wrapper">
            <div class="discount-info">
                <span class="saint-text">@lang('home.discount')</span>
                <span class="main-text">@lang('home.get_your_off', ['percentage' => '50%'])</span>
                <p>@lang('home.nourish_description')</p>
                <a href="#" class="btn">@lang('home.get_now')</a>
            </div>
        </div>
    </div>
    <!-- DISCOUNT EOF   -->
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
    <!-- BEGIN TOP CATEGORIES -->
    <section class="top-categories">
        <div class="top-categories__text">
            <span class="saint-text">@lang('home.popular_collections')</span>
            <h2>@lang('home.top_categories')</h2>
            <p>@lang('home.nourish_description')</p>
        </div>
        <div class="top-categories__items">
            <a href="#" class="top-categories__item">
                <img data-src="https://via.placeholder.com/620x700" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img" alt="@lang('home.spa')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.spa')</h5>
                    <span>@lang('home.browse_products') -</span>
                    <i class="icon-arrow-lg"></i>
                </div>
            </a>
            <a href="#" class="top-categories__item">
                <img data-src="https://via.placeholder.com/620x700" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img" alt="@lang('home.nails')">
                <div class="top-categories__item-hover">
                    <h5>@lang('home.nails')</h5>
                    <span>@lang('home.browse_products') -</span>
                    <i class="icon-arrow-lg"></i>
                </div>
            </a>
            <a href="#" class="top-categories__item">
                <img data-src="https://via.placeholder.com/620x700" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img" alt="@lang('home.perfume')">
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
        <div class="info-blocks__item js-img" data-src="https://via.placeholder.com/960x900">
            <div class="wrapper">
                <div class="info-blocks__item-img">
                    <img data-src="https://via.placeholder.com/960x900" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img" alt="@lang('home.check_this_out')">
                </div>
                <div class="info-blocks__item-text">
                    <span class="saint-text">@lang('home.check_this_out')</span>
                    <h2>@lang('home.new_collection')</h2>
                    <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>
                    <p>@lang('home.full_description')</p>
                    <a href="#" class="btn">@lang('home.shop_now')</a>
                </div>
            </div>
        </div>
        <div class="info-blocks__item info-blocks__item-reverse js-img" data-src="https://via.placeholder.com/960x900">
            <div class="wrapper">
                <div class="info-blocks__item-img">
                    <img data-src="https://via.placeholder.com/960x900" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img" alt="@lang('home.promotion_video')">
                    <iframe allowfullscreen></iframe>
                    <div class="info-blocks__item-img-overlay">
                        <span>@lang('home.promotion_video')</span>
                        <div class="info-blocks__item-img-play">
                            <img data-src="img/play-btn.png" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
                        </div>
                    </div>
                </div>
                <div class="info-blocks__item-text">
                    <span class="saint-text">@lang('home.about_us')</span>
                    <h2>@lang('home.who_we_are')</h2>
                    <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>
                    <p>@lang('home.full_description')</p>
                    <a href="#" class="info-blocks__item-link">
                        <i class="icon-video"></i>
                        @lang('home.watch_video')
                        <i class="icon-arrow-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN INSTA PHOTOS -->
    <div class="insta-photos">
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
        <a href="#" class="insta-photo">
            <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                class="js-img" alt="">
            <div class="insta-photo__hover">
                <i class="icon-insta"></i>
            </div>
        </a>
    </div>
    <!-- INSTA PHOTOS EOF   -->
@endsection
