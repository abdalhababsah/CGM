{{-- resources/views/user/view-product.blade.php --}}
@extends('user.layouts.app')
@section('title', $product->name)
@section('meta')
    <meta name="keywords" content="{{ $product->name }}, {{ $product->category->name }}, {{ $product->brand->name }}">
    <meta name="description" content="{{ $product->description }}">
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="overlay"></div>
        <div class="wrapper">
            <div class="detail-block__content">
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->
    <!-- BEGIN PRODUCT -->
    <div class="product">
        <div class="wrapper">
            <div class="product-content">
                <!-- Product Slider -->
                <div class="product-slider">
                    <div class="product-slider__main">
                        @foreach ($product->images as $image)
                            <div class="product-slider__main-item">
                                <div class="products-item__type">
                                    <span
                                        class="products-item__sale {{ $product->in_stock ? 'products-item__sale' : 'products-item__new' }} ">
                                        {{ $product->in_stock ? __('view_product.in_stock') : __('view_product.out_of_stock') }}
                                    </span>
                                </div>
                                <img loading="lazy" src="{{ asset('storage/' . $image->image_url) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="product-slider__nav">
                        @foreach ($product->images as $image)
                            <div class="product-slider__nav-item">
                                <img loading="lazy" src="{{ asset('storage/' . $image->image_url) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Product Info section in your view-product.blade.php -->
                <div class="product-info">
                    <h3>{{ $product->name }}</h3>
                    <span class="product-stock {{ $product->in_stock ? 'in-stock' : 'out-of-stock' }}">
                        {{ $product->in_stock ? __('view_product.in_stock') : __('view_product.out_of_stock') }}
                    </span>
                    <span class="product-num">{{ __('view_product.sku') }}: {{ $product->sku }}</span>
                    <span class="product-price">
                        @if ($product->discount > 0)
                        <del>₪{{$product->price}}</del>
                        @endif
                        ₪{{ $product->discounted_price }}
                    </span>

                    <div class="product-detail-info">
                        <p><strong>{{ __('view_product.category') }}:</strong>
                            {{ $product->category->name }}</p>
                        <p><strong>{{ __('view_product.brand') }}:</strong>
                            {{ $product->brand->name }}</p>
                    </div>

                    <p>{{ $product->description }}</p>

                    <div class="contacts-info__social">
                        <span>{{ __('view_product.share') }}:</span>
                        <ul style="gap: 6px;">
                            <li><a href="https://www.facebook.com/curlyhairproudectpalestine/"><i
                                        class="icon-facebook"></i></a></li>
                            <li><a href="https://www.instagram.com/cgm_products_palestine/"><i class="icon-insta"></i></a>
                            </li>
                        </ul>
                    </div>

                    @if ($product->in_stock)
                        <div class="product-options">
                            <div class="product-info__quantity">
                                <span class="product-info__quantity-title">{{ __('view_product.quantity') }}:</span>
                                <div class="counter-box">
                                    <span class="counter-link counter-link__prev"><i class="icon-arrow"></i></span>
                                    <input type="text" class="counter-input" disabled value="1">
                                    <span class="counter-link counter-link__next"><i class="icon-arrow"></i></span>
                                </div>
                            </div>

                            <!-- Add color options here -->
                            @if ($product->colors->count() > 0)
                                <div class="product-info__color">
                                    <span class="product-info__color-title">{{ __('view_product.color') }}:</span>
                                    <ul id="colorSelect">
                                        @foreach ($product->colors as $color)
                                        <li value="{{ $color->id }}" style="
                                        background-color : {{ $color->hex }};">
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="out-of-stock-warning">
                            {{ __('view_product.out_of_stock_message') }}
                        </div>
                    @endif
                    <div class="product-buttons">
                        @if ($product->quantity > 0)
                            <button class="btn btn-icon add-to-cart-btn" data-product-id="{{ $product->id }}">
                                <i class="icon-cart"></i> {{ __('view_product.add_to_cart') }}
                            </button>
                        @endif
                        <button class="btn btn-grey btn-icon toggle-wishlist-btn {{ $isInWishlist ? 'active' : '' }}"
                            data-product-id="{{ $product->id }}">
                            <i class="icon-heart"></i>
                            <span class="wishlist-text">
                                {{ $isInWishlist ? __('view_product.remove_from_wishlist') : __('view_product.add_to_wishlist') }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Product Description -->
            <div class="product-detail">
                <div class="tab-wrap product-detail-tabs">
                    <ul class="nav-tab-list tabs">
                        <li class="active">
                            <a href="#product-tab_1">{{ __('view_product.description') }}</a>
                        </li>
                    </ul>
                    <div class="box-tab-cont">
                        <div class="tab-cont" id="product-tab_1">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT EOF -->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Counter functionality
            $('.counter-link__prev').click(function() {
                let input = $(this).siblings('.counter-input');
                let value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                }
            });

            $('.counter-link__next').click(function() {
                let input = $(this).siblings('.counter-input');
                let value = parseInt(input.val());
                input.val(value + 1);
            });

            // Add to Cart functionality
            $('.add-to-cart-btn').on('click', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                let quantity = $('.counter-input').val();
                let color = $('#colorSelect .active').attr('value');

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        color_id: color,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            updateCartCount(response.cart_count);
                            showToast(response.message, 'success');
                            updateGlobalCartCount()
                            console.log(response);

                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function() {
                        showToast('Error adding to cart', 'error');
                    }
                });
            });

            // Wishlist functionality
            $(document).on('click', '.toggle-wishlist-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let btn = $(this);
                let productId = btn.data('product-id');

                $.ajax({
                    url: "{{ route('wishlist.toggle') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            btn.addClass('active');
                            btn.find('.wishlist-text').text(
                                "{{ __('view_product.remove_from_wishlist') }}");
                            showToast(response.message, 'success');
                        } else if (response.status === 'removed') {
                            btn.removeClass('active');
                            btn.find('.wishlist-text').text(
                                "{{ __('view_product.add_to_wishlist') }}");
                            showToast(response.message, 'success');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Wishlist Error:', error);
                        showToast("{{ __('view_product.wishlist_error') }}", 'error');
                    }
                });
            });

            // Initialize product slider
            if ($('.product-slider__main').length) {
                $('.product-slider__main').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    asNavFor: '.product-slider__nav'
                });
                $('.product-slider__nav').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '.product-slider__main',
                    focusOnSelect: true,
                    arrows: false
                });
            }
        });

        function showToast(message, type) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000
            });
        }

        function updateCartCount(count) {
            $('#cart-count').text(count);
        }
    </script>
@endsection
