@extends('user.layouts.app')

@section('content')

            <!-- BEGIN DETAIL MAIN BLOCK -->
            <div class="detail-block detail-block_margin">
                <div class="wrapper">
                    <div class="detail-block__content">
                        <h1>Wishlist</h1>
                        <ul class="bread-crumbs">
                            <li class="bread-crumbs__item">
                                <a href="#" class="bread-crumbs__link">Home</a>
                            </li>
                            <li class="bread-crumbs__item">Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- DETAIL MAIN BLOCK EOF   -->
            <!-- BEGIN WISHLIST -->
            <div class="wishlist">
                <div class="wrapper">
                    <div class="cart-table">
                        <div class="cart-table__box">
                            <div class="cart-table__row cart-table__row-head">
                                <div class="cart-table__col">Product</div>
                                <div class="cart-table__col">Price</div>
                                <div class="cart-table__col">status</div>
                                <div class="cart-table__col">Add to cart</div>
                            </div>
                            <div class="cart-table__row">
                                <div class="cart-table__col">
                                    <a href="#" class="cart-table__img">
                                        <img data-src="{{asset('user/img/promo-video__decor.jpg')}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    </a>
                                    <div class="cart-table__info">
                                        <a href="#" class="title5">Foundation Beshop</a>
                                        <span class="cart-table__info-num">SKU: IN1203</span>
                                    </div>
                                </div>
                                <div class="cart-table__col">
                                    <span class="cart-table__price">$200.95</span>
                                </div>
                                <div class="cart-table__col">
                                    <span class="wishlist-stock">in stock</span>
                                </div>
                                <div class="cart-table__col">
                                    <span class="cart-table__total"><a href="#" class="blog-item__link">buy now <i class="icon-arrow-md"></i></a></span>
                                </div>
                            </div>
                            <div class="cart-table__row">
                                <div class="cart-table__col">
                                    <a href="#" class="cart-table__img">
                                        <img data-src="https://via.placeholder.com/110" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                                    </a>
                                    <div class="cart-table__info">
                                        <a href="#" class="title5">Hair mask with oat extract</a>
                                        <span class="cart-table__info-num">SKU: IN1203</span>
                                    </div>
                                </div>
                                <div class="cart-table__col">
                                    <span class="cart-table__price">$200.95</span>
                                </div>
                                <div class="cart-table__col">
                                    <span class="wishlist-available">not available</span>
                                </div>
                                <div class="cart-table__col">
                                    <span class="cart-table__total"><a href="#" class="blog-item__link">buy now <i class="icon-arrow-md"></i></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wishlist-buttons">
                        <a href="#" class="btn btn-grey">clear Wishlist</a>
                        <a href="#" class="btn">go shopping</a>
                    </div>
                </div>
                <img class="promo-video__decor js-img" data-src="{{asset('user/img/promo-video__decor.jpg')}}"
                    src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" alt="">
            </div>
            <!-- WISHLIST EOF   -->
            <!-- BEGIN NEW ARRIVALS -->
            <section class="arrivals product-viewed">
                <div class="trending-top">
                    <span class="saint-text">Cosmetics</span>
                    <h2>You have viewed</h2>
                    <p>Nourish your skin with toxin-free cosmetic products. With the offers that you can’t refuse.</p>
                </div>
                <div class="products-items js-products-items">
                    <a href="#" class="products-item">
                        <div class="products-item__type">
                            <span class="products-item__sale">sale</span>
                            <span class="products-item__new">new</span>
                        </div>
                        <div class="products-item__img">
                            <img data-src="https://via.placeholder.com/400x570" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
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
                            <img data-src="https://via.placeholder.com/400x570" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
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
                            <span class="products-item__new">new</span>
                        </div>
                        <div class="products-item__img">
                            <img data-src="https://via.placeholder.com/400x570" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
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
                            <span class="products-item__new">new</span>
                        </div>
                        <div class="products-item__img">
                            <img data-src="https://via.placeholder.com/400x570" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
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
                            <img data-src="https://via.placeholder.com/400x570" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                class="js-img" alt="">
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
            </section>
            <!-- NEW ARRIVALS EOF   -->
            <!-- BEGIN INSTA PHOTOS -->
            <div class="insta-photos">
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
                <a href="#" class="insta-photo">
                    <img data-src="https://via.placeholder.com/320" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img"
                        alt="">
                    <div class="insta-photo__hover">
                        <i class="icon-insta"></i>
                    </div>
                </a>
            </div>
            <!-- INSTA PHOTOS EOF   -->


@endsection