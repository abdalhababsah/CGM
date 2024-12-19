{{-- resources/views/user/shop.blade.php --}}
@extends('user.layouts.app')

@section('styles')
    <!-- SweetAlert2 CSS -->
    <style>
        /* Remove default button styles */
        .add-to-cart-btn,
        .toggle-wishlist-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            outline: none;
        }

        .add-to-cart-btn:hover,
        .toggle-wishlist-btn:hover {
            opacity: 0.8;
        }

        .add-to-cart-btn:focus,
        .toggle-wishlist-btn:focus {
            outline: 2px solid #007BFF;
        }

        .add-to-cart-btn .icon-cart,
        .toggle-wishlist-btn .icon-heart {
            font-size: 1.5rem;
            color: #333;
        }

        .toggle-wishlist-btn.active .icon-heart {
            color: red;
        }

        .active {
            color: rgb(128, 0, 0) !important;
        }

        /* Additional styling for product listing or any other UI elements if needed */
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>@lang('shop.shop')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('shop.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('shop.shop')</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN SHOP -->
    <div class="shop">
        <div class="wrapper">
            <div class="shop-content">
                <div class="shop-aside">
                    <!-- Search Field -->
                    <div class="box-field box-field__search">
                        <input type="search" id="search" class="form-control" placeholder="@lang('shop.search')">
                        <i class="icon-search"></i>
                    </div>

                    <!-- Categories -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.categories')</span>
                        <ul id="categories-list">
                            <!-- Categories loaded via AJAX -->
                        </ul>
                    </div>

                    <!-- Brands -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.brands')</span>
                        <ul id="brands-list">
                            <!-- Brands loaded via AJAX -->
                        </ul>
                    </div>

                    <!-- Price Range -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.price')</span>
                        <div class="range-slider">
                            <input type="text" id="price-range" class="js-range-slider-price" value="" />
                        </div>
                    </div>
                </div>

                <div class="shop-main">
                    <div class="shop-main__filter">
                        <div class="shop-main__checkboxes">
                            {{-- Add checkboxes if needed for SALE/NEW --}}
                        </div>
                        <div class="shop-main__select">
                            <select id="sort" class="styled">
                                <option value="default">@lang('shop.from_expensive')</option>
                                <option value="price_asc">@lang('shop.from_cheap')</option>
                                <!-- Add more sorting options if needed -->
                            </select>
                        </div>
                    </div>

                    <div class="shop-main__items" id="products-list">
                        <!-- Products loaded via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <ul class="paging-list" id="pagination">
                        <!-- Pagination links loaded via AJAX -->
                    </ul>
                </div>
            </div>
        </div>
        <img class="promo-video__decor js-img" data-src="{{ asset('user/img/promo-video__decor.jpg') }}"
            src="{{ asset('user/img/promo-video__decor.jpg') }}" alt="">
    </div>
    <!-- SHOP EOF -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Variables for filters
            let search = '';
            let category = '';
            let brand = '';
            let priceMin = 0;
            let priceMax = 1000;
            let sort = 'default';
            let page = 1;
            let isSale = false;
            let isNew = false;

            // Array of product IDs currently in the wishlist
            // Ensure your controller passes this array
            // Example: $currentWishlistIds = [1, 2, 5]; 
            // Make sure to define $currentWishlistIds in your controller and pass it to the view
            let currentWishlistIds = @json($currentWishlistIds ?? []);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Fetch Products Data
            function fetchData() {
                $.ajax({
                    url: "{{ route('shop.fetchProducts') }}",
                    method: "GET",
                    data: {
                        search: search,
                        category: category,
                        brand: brand,
                        price_min: priceMin,
                        price_max: priceMax,
                        sort: sort,
                        page: page,
                        is_sale: isSale,
                        is_new: isNew
                    },
                    dataType: "json",
                    success: function(response) {
                        renderCategories(response.categories);
                        renderBrands(response.brands);
                        renderProducts(response.products.data);
                        renderPagination(response.products);
                    },
                    error: function(xhr, status, error) {
                        console.error('Fetch Products Error:', error);
                        showToast('@lang('shop.error_fetching')', 'error');
                    }
                });
            }

            function renderCategories(categories) {
                let categoriesList = $('#categories-list');
                categoriesList.empty();

                categories.forEach(function(categoryItem) {
                    categoriesList.append(`
                        <li>
                            <a href="#" class="category-filter ${category == categoryItem.id ? 'active' : ''}" data-id="${categoryItem.id}">
                                ${getLocalizedName(categoryItem)}
                            </a>
                        </li>
                    `);
                });

                $('.category-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedCategory = $(this).data('id');
                    if (category == selectedCategory) {
                        category = '';
                        $(this).removeClass('active');
                    } else {
                        category = selectedCategory;
                        $('.category-filter').removeClass('active');
                        $(this).addClass('active');
                    }
                    page = 1;
                    fetchData();
                });
            }

            function renderBrands(brands) {
                let brandsList = $('#brands-list');
                brandsList.empty();

                brands.forEach(function(brandItem) {
                    brandsList.append(`
                        <li>
                            <a href="#" class="brand-filter ${brand === brandItem.id ? 'active' : ''}" data-id="${brandItem.id}">
                                ${getLocalizedName(brandItem)}
                            </a>
                        </li>
                    `);
                });

                $('.brand-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedBrand = $(this).data('id');
                    if (brand === selectedBrand) {
                        brand = '';
                        $(this).removeClass('active');
                    } else {
                        brand = selectedBrand;
                        $('.brand-filter').removeClass('active');
                        $(this).addClass('active');
                    }
                    page = 1;
                    fetchData();
                });
            }

            function renderProducts(products) {
                let productsList = $('#products-list');
                productsList.empty();

                if (products.length === 0) {
                    productsList.append(`<p>@lang('shop.no_products_found')</p>`);
                    return;
                }

                products.forEach(function(product) {
                    let imageUrl = (product.images && product.images.length > 0) ? product.images[0].url :
                        'https://via.placeholder.com/262x370';
                    let isInWishlist = product.is_in_wishlist; // Directly use the flag
                    let wishlistBtnClass = isInWishlist ? 'active' : '';
                    let wishlistBtnText = isInWishlist ? '@lang('wishlist.remove')' : '@lang('wishlist.add')';

                    productsList.append(`
            <div class="products-item">
                <div class="products-item__img">
                    <img data-src="${imageUrl}"
                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                        class="js-img" alt="${getLocalizedName(product)}">
                    <div class="products-item__hover">
                        <i class="icon-search"></i>
                        <div class="products-item__hover-options">
                            <button class="toggle-wishlist-btn ${wishlistBtnClass}" data-product-id="${product.id}" aria-label="${wishlistBtnText}">
                                <i class="icon-heart"></i>
                            </button>
                            <button class="add-to-cart-btn" data-product-id="${product.id}" aria-label="{{ __('shop.add_to_cart') }}">
                                <i class="icon-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="products-item__info">
                    <span class="products-item__name">${getLocalizedName(product)}</span>
                    <span class="products-item__cost">$${product.price}</span>
                </div>
            </div>
        `);
                });

                lazyLoadImages();

                // Add to Cart
                $('.add-to-cart-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('product-id');
                    addToCart(productId, 1);
                });

                // Toggle Wishlist
                $('.toggle-wishlist-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let btn = $(this);
                    let productId = btn.data('product-id');
                    toggleWishlist(productId, btn);
                });
            }

            function addToCart(productId, quantity) {
                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            updateCartCount(response.cart_count);
                            updateGlopalCartCount();
                            showToast(response.message, 'success');
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Add to Cart Error:', error);
                        showToast('@lang('shop.add_to_cart_error')', 'error');
                    }
                });
            }

            function updateCartCount(count) {
                $('#cart-count').text(count);
            }

            function showToast(message, type) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: type,
                    title: message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            }

            function renderPagination(pagination) {
                let paginationList = $('#pagination');
                paginationList.empty();

                if (pagination.last_page <= 1) {
                    return;
                }

                // Previous Page
                if (pagination.current_page > 1) {
                    paginationList.append(`
                        <li class="paging-list__item paging-prev">
                            <a href="#" class="paging-list__link" data-page="${pagination.current_page - 1}">
                                <i class="icon-arrow"></i>
                            </a>
                        </li>
                    `);
                }

                let start = Math.max(1, pagination.current_page - 2);
                let end = Math.min(pagination.last_page, pagination.current_page + 2);

                for (let i = start; i <= end; i++) {
                    paginationList.append(`
                        <li class="paging-list__item ${i === pagination.current_page ? 'active' : ''}">
                            <a href="#" class="paging-list__link" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Next Page
                if (pagination.current_page < pagination.last_page) {
                    paginationList.append(`
                        <li class="paging-list__item paging-next">
                            <a href="#" class="paging-list__link" data-page="${pagination.current_page + 1}">
                                <i class="icon-arrow"></i>
                            </a>
                        </li>
                    `);
                }

                $('.paging-list__link').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedPage = $(this).data('page');
                    if (selectedPage !== page) {
                        page = selectedPage;
                        fetchData();
                        $('html, body').animate({
                            scrollTop: $("#products-list").offset().top - 100
                        }, 500);
                    }
                });
            }

            function getLocalizedName(item) {
                let locale = "{{ app()->getLocale() }}";
                if (locale === 'ar') {
                    return item.name_ar || item.name_en;
                } else if (locale === 'he') {
                    return item.name_he || item.name_en;
                } else {
                    return item.name_en;
                }
            }

            function initializePriceSlider() {
                let minPrice = 0;
                let maxPrice = 1000;

                $("#price-range").ionRangeSlider({
                    type: "double",
                    min: minPrice,
                    max: maxPrice,
                    from: minPrice,
                    to: maxPrice,
                    prefix: "$",
                    onFinish: function(data) {
                        priceMin = data.from;
                        priceMax = data.to;
                        page = 1;
                        fetchData();
                    }
                });
            }

            $('#search').on('input', function() {
                search = $(this).val();
                page = 1;
                fetchData();
            });

            $('#sort').on('change', function() {
                sort = $(this).val();
                page = 1;
                fetchData();
            });

            $('.shop-main__checkboxes input').on('change', function() {
                if ($(this).attr('id') === 'filter-sale') {
                    isSale = $(this).is(':checked');
                }

                if ($(this).attr('id') === 'filter-new') {
                    isNew = $(this).is(':checked');
                }

                page = 1;
                fetchData();
            });

            function lazyLoadImages() {
                $('.js-img').each(function() {
                    if ($(this).attr('data-src')) {
                        $(this).attr('src', $(this).attr('data-src'));
                        $(this).removeAttr('data-src');
                    }
                });
            }

            function toggleWishlist(productId, btn) {
                $.ajax({
                    url: "{{ route('wishlist.toggle') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'added') {
                            showToast(response.message, 'success');
                            currentWishlistIds.push(productId);
                            btn.addClass('active');
                        } else if (response.status === 'removed') {
                            showToast(response.message, 'success');
                            currentWishlistIds = currentWishlistIds.filter(id => id !== productId);
                            btn.removeClass('active');
                        } else {
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Toggle Wishlist Error:', error);
                        showToast('@lang('wishlist.toggle_error')', 'error');
                    }
                });
            }

            // Initial load
            fetchData();
            initializePriceSlider();
        });
    </script>
@endsection
