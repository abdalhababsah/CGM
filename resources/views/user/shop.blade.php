{{-- resources/views/user/shop.blade.php --}}

@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('user/css/shop.css') }}">
    <style>
        /* Base styles for the title */
        .shop-aside__item-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 24px;
            line-height: 100%;
            text-transform: capitalize;
            padding: 10px 0;
            color: #222222;
            font-family: "Tenor Sans";
            border-bottom: 2px solid #222222;
            margin-bottom: 15px;
            position: relative;
            cursor: pointer;
        }

        /* Plus/Minus icon styles */
        .shop-aside__item-title::after {
            content: '+';
            font-size: 20px;
            transition: transform 0.3s ease;
            margin-left: 10px;
            /* Space for LTR */
            margin-right: 10px;
            /* Space for RTL */
        }

        /* Active state */
        .shop-aside__item-title.active::after {
            content: '-';
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .shop-aside__item-title {
                font-size: 16px;
            }

            .shop-aside__item-title::after {
                font-size: 18px;
            }
        }

        @media screen and (max-width: 767px) {
            .shop-aside__item-title {
                margin-bottom: 10px;
            }
        }

        /* Updated Floating Price Filter styles */
        .floating-price-filter {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .price-filter-button {
            width: 45px;
            /* Reduced from 60px */
            height: 45px;
            /* Reduced from 60px */
            border-radius: 50%;
            color: white;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .price-filter-button img {
    width: 100%; /* Make the icon fill the button's width */
    height: 100%; /* Make the icon fill the button's height */
    object-fit: cover; /* Ensure the icon scales proportionally */
    border-radius: 50%; /* Maintain the circular shape */
}
        .price-filter-button i {
            font-size: 18px;
            /* Reduced from 24px */
        }

        .price-filter-panel {
            display: none;
            position: fixed;
            bottom: 75px;
            /* Adjusted to be closer to button */
            right: 20px;
            background: white;
            padding: 15px;
            /* Reduced padding */
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            width: 260px;
            transform: scale(0.8);
            transform-origin: bottom right;
            transition: all 0.3s ease;
        }

        .price-filter-panel h4 {
            font-size: 16px;
            /* Smaller title */
            margin-bottom: 10px;
            font-weight: 500;
        }

        /* Style for the range slider container */
        .price-filter-panel .range-slider {
            margin: 10px 0;
            padding: 0 10px;
        }

        /* Style for the IonRangeSlider elements */
        .price-filter-panel .irs {
            margin-bottom: 20px;
        }

        /* Style for the Apply Filter button */
        #apply-mobile-price-filter {
            background-color: rgb(151 29 37);
            color: white;
            border: none;

            padding: 8px 15px;
            font-size: 14px;
            width: 100%;
            cursor: pointer;
            margin-top: 68px;
            transition: background-color 0.3s ease;
        }

        #apply-mobile-price-filter:hover {
            background-color: #333333;
        }

        /* Fix for IonRangeSlider display issues */
        .price-filter-panel .irs-with-grid {
            height: 60px;
        }

        .price-filter-panel .irs-grid {
            display: none;
            /* Hide the grid if not needed */
        }

        /* Ensure the panel is visible when active */
        .price-filter-panel.active {
            transform: scale(1);
            opacity: 1;
            visibility: visible;
        }

        /* Media Query for Mobile */
        @media (max-width: 768px) {
            .floating-price-filter {
                display: block;
            }

            /* Hide the original price filter in sidebar */
            .shop-aside .shop-aside__item:has(.js-range-slider-price) {
                display: none;
            }

            /* Adjust panel position for smaller screens */
            .price-filter-panel {
                width: calc(100% - 40px);
                right: 20px;
                left: 20px;
                bottom: 75px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="overlay"></div>
        <div class="wrapper">
            {{-- Breadcrumbs and Title can be uncommented if needed --}}
            {{-- 
            <div class="detail-block__content">
                <h1>@lang('shop.shop')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">@lang('shop.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('shop.shop')</li>
                </ul>
            </div>
            --}}
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
                        <div class="shop-aside__item-content">
                            <ul id="categories-list">
                                <!-- Categories loaded via AJAX -->
                            </ul>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.brands')</span>
                        <div class="shop-aside__item-content">
                            <ul id="brands-list">
                                <!-- Brands loaded via AJAX -->
                            </ul>
                        </div>
                    </div>


                    <!-- Price Range -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.price')</span>
                        <div class="shop-aside__item-content">
                            <div class="range-slider-container">
                                <div class="range-slider">
                                    <input type="text" id="price-range" class="js-range-slider-price" value="" />
                                </div>
                                <button id="apply-price-filter" class="btn-price-filter">
                                    @lang('shop.filter_price')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="shop-main">
                    <div class="shop-main__filter">
                        <div class="shop-main__filter-container">
                            <div class="shop-main__select">
                                <select id="sort" class="styled">
                                    <option value="default">@lang('shop.default_sort')</option>
                                    <option value="price_asc">@lang('shop.from_cheap')</option>
                                    <option value="price_desc">@lang('shop.from_expensive')</option>
                                </select>
                            </div>
                            <div class="shop-main__select">
                                <select id="hair-types-list" class="styled">
                                    <option value="default">@lang('shop.hair_pores')</option>

                                </select>
                            </div>
                            <div class="shop-main__select">
                                <select id="hair-pores-list" class="styled">
                                    <option value="default">@lang('shop.hair_types')</option>

                                </select>
                            </div>
                            <div class="shop-main__select">
                                <select id="hair-thicknesses-list" class="styled">
                                    <option value="default">@lang('shop.hair_thicknesses')</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="shop-main__items" id="products-list">
                        <!-- Products loaded via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <ul class="paging-list" id="pagination" style="margin-bottom: 30px;">
                        <!-- Pagination links loaded via AJAX -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Floating Price Filter for Mobile -->
        <div class="floating-price-filter">
            <button class="price-filter-button">
                <img src="{{asset('user/img/filter-price.png')}}" alt="">
            </button>
            <div class="price-filter-panel">
                <h4>@lang('shop.price')</h4>
                <div class="range-slider">
                    <input type="text" id="mobile-price-range" class="js-range-slider-price-mobile" value="" />
                </div>
                <button id="apply-mobile-price-filter">
                    @lang('shop.filter_price')
                </button>
            </div>
        </div>
    </div>
    <!-- SHOP EOF -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Variables for filters
            let search = '';
            let categories = []; // Array for multiple categories
            let brands = []; // Array for multiple brands
            let priceMin = 0;
            let priceMax = 1000;
            let sort = 'default';
            let page = 1;
            let isSale = false;
            let isNew = false;
            let hairPore = 'default';
            let hairType = 'default';
            let hairThickness = 'default';
            // **New Filter Variables without Selection Limits**
            let hairPores = [];
            let hairTypes = [];
            let hairThicknesses = [];
            let mobileInstance;
            // Array of product IDs currently in the wishlist
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
                        categories: categories, // Send array
                        brands: brands, // Send array
                        price_min: priceMin,
                        price_max: priceMax,
                        sort: sort,
                        page: page,
                        is_sale: isSale,
                        is_new: isNew,
                        hair_pores: hairPores,
                        hair_types: hairTypes,
                        hair_thicknesses: hairThicknesses
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            showToast(response.error, 'error');
                            return;
                        }
                        renderCategories(response.categories);
                        renderBrands(response.brands);
                        renderHairPores(response.hair_pores);
                        renderHairTypes(response.hair_types);
                        renderHairThicknesses(response.hair_thicknesses);
                        renderProducts(response.products.data);
                        renderPagination(response.products);
                    },
                    error: function(xhr, status, error) {
                        console.error('Fetch Products Error:', error);
                        showToast('@lang('shop.error_fetching')', 'error');
                    }
                });
            }

            // Render Categories with Multi-Select
            function renderCategories(categoriesData) {
                let categoriesList = $('#categories-list');
                categoriesList.empty();

                categoriesData.forEach(function(categoryItem) {
                    let isActive = categories.includes(String(categoryItem.id)) ? 'active-li' : '';
                    categoriesList.append(`
                        <li>
                            <a href="#" class="category-filter ${isActive}" data-id="${categoryItem.id}">
                                ${getLocalizedName(categoryItem)}
                            </a>
                        </li>
                    `);
                });

                $('.category-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedId = $(this).data('id');
                    if (categories.includes(String(selectedId))) {
                        // Deselect
                        categories = categories.filter(id => id !== String(selectedId));
                        $(this).removeClass('active-li');
                    } else {
                        // Select
                        categories.push(String(selectedId));
                        $(this).addClass('active-li');
                    }
                    page = 1;
                    fetchData();
                });
            }

            // Render Brands with Multi-Select
            function renderBrands(brandsData) {
                let brandsList = $('#brands-list');
                brandsList.empty();

                brandsData.forEach(function(brandItem) {
                    let isActive = brands.includes(String(brandItem.id)) ? 'active-li' : '';
                    brandsList.append(`
                        <li>
                            <a href="#" class="brand-filter ${isActive}" data-id="${brandItem.id}">
                                ${getLocalizedName(brandItem)}
                            </a>
                        </li>
                    `);
                });

                $('.brand-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedId = $(this).data('id');
                    if (brands.includes(String(selectedId))) {
                        // Deselect
                        brands = brands.filter(id => id !== String(selectedId));
                        $(this).removeClass('active-li');
                    } else {
                        // Select
                        brands.push(String(selectedId));
                        $(this).addClass('active-li');
                    }
                    page = 1;
                    fetchData();
                });
            }

            function renderHairPores(hairPoresData) {
                let hairPoresList = $('#hair-pores-list');
                hairPoresList.empty();

                // Add default option
                hairPoresList.append(`
        <option value="default">@lang('shop.all_hair_pores')</option>
    `);

                // Populate select with options
                hairPoresData.forEach(function(hairPoreItem) {
                    hairPoresList.append(`
            <option value="${hairPoreItem.id}">
                ${getLocalizedName(hairPoreItem)}
            </option>
        `);
                });

                // Set the selected value
                hairPoresList.val(hairPores.length > 0 ? hairPores[0] : 'default');

                // Handle change event
                hairPoresList.off('change').on('change', function() {
                    const selectedValue = $(this).val();
                    hairPores = selectedValue !== 'default' ? [selectedValue] : [];
                    page = 1;
                    fetchData();
                });
            }

            // Render Hair Types

            function renderHairTypes(hairTypesData) {
                let hairTypesList = $('#hair-types-list');
                hairTypesList.empty();

                // Add default option
                hairTypesList.append(`
        <option value="default">@lang('shop.all_hair_types')</option>
    `);

                // Populate select with options
                hairTypesData.forEach(function(hairTypeItem) {
                    hairTypesList.append(`
            <option value="${hairTypeItem.id}">
                ${getLocalizedName(hairTypeItem)}
            </option>
        `);
                });

                // Set the selected value
                hairTypesList.val(hairTypes.length > 0 ? hairTypes[0] : 'default');

                // Handle change event
                hairTypesList.off('change').on('change', function() {
                    const selectedValue = $(this).val();
                    hairTypes = selectedValue !== 'default' ? [selectedValue] : [];
                    page = 1;
                    fetchData();
                });
            }

            // Render Hair Thicknesses
            function renderHairThicknesses(hairThicknessesData) {
                let hairThicknessesList = $('#hair-thicknesses-list');
                hairThicknessesList.empty();

                // Add default option
                hairThicknessesList.append(`
        <option value="default">@lang('shop.all_hair_thicknesses')</option>
    `);

                // Populate select with options
                hairThicknessesData.forEach(function(hairThicknessItem) {
                    hairThicknessesList.append(`
            <option value="${hairThicknessItem.id}">
                ${getLocalizedName(hairThicknessItem)}
            </option>
        `);
                });

                // Set the selected value
                hairThicknessesList.val(hairThicknesses.length > 0 ? hairThicknesses[0] : 'default');

                // Handle change event
                hairThicknessesList.off('change').on('change', function() {
                    const selectedValue = $(this).val();
                    hairThicknesses = selectedValue !== 'default' ? [selectedValue] : [];
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
                    // Determine image URL
                    let imageUrl = product.primary_image && product.primary_image.image_url ?
                        `/storage/${product.primary_image.image_url}` :
                        'https://via.placeholder.com/262x370';

                    let isInWishlist = product.is_in_wishlist;
                    let wishlistBtnClass = isInWishlist ? 'active' : '';
                    let wishlistBtnText = isInWishlist ? '@lang('wishlist.remove')' : '@lang('wishlist.add')';
                    let inStock = product.quantity > 0 ? '@lang('shop.available')' : '@lang('shop.soldOut')';
                    let back_color = product.quantity > 0 ? 'products-item__sale' : 'products-item__new';
                    let productUrl =
                        `{{ url('/view-product') }}/${product.id}/${product.name_en.toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;

                    // Determine whether to display the "Add to Cart" button
                    let addToCartButton = '';
                    if (product.quantity > 0) {
                        addToCartButton = `
                            <button class="add-to-cart-btn" data-product-id="${product.id}" aria-label="{{ __('shop.add_to_cart') }}">
                                <i style="color:white !important;" class="icon-cart"></i>
                            </button>
                        `;
                    }

                    productsList.append(`
                        <div class="products-item">
                            <a href="${productUrl}" class="products-item__link">
                                <div class="products-item__img">
                                    <div class="products-item__type">
                                        <span class="${back_color}">${inStock}</span>
                                    </div>
                                    <img style="object-fit:contain;" data-src="${imageUrl}"
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                        class="js-img" alt="${getLocalizedName(product)}">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <button class="toggle-wishlist-btn ${wishlistBtnClass}" data-product-id="${product.id}" aria-label="${wishlistBtnText}">
                                                <i class="icon-heart"></i>
                                            </button>
                                            ${addToCartButton}
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">${getLocalizedName(product)}</span>
                                    <span class="products-item__cost">₪${product.price}</span>
                                </div>
                            </a>
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
            if ($(".js-range-slider-price-mobile").length) {
                $(".js-range-slider-price-mobile").ionRangeSlider({
                    skin: "round",
                    type: 'double',
                    min: 0,
                    max: 999,
                    from: 0,
                    hide_min_max: 'true',
                    prefix: "₪",
                    to: 999
                });

                mobileInstance = $(".js-range-slider-price-mobile").data("ionRangeSlider");
            }

            // Toggle Price Filter Panel
            $('.price-filter-button').on('click', function() {
                const panel = $('.price-filter-panel');
                if (panel.is(':visible')) {
                    panel.removeClass('active');
                    setTimeout(() => panel.hide(), 300);
                } else {
                    panel.show();
                    setTimeout(() => panel.addClass('active'), 10);
                }
            });

            // Close panel when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.floating-price-filter').length) {
                    const panel = $('.price-filter-panel');
                    if (panel.is(':visible')) {
                        panel.removeClass('active');
                        setTimeout(() => panel.hide(), 300);
                    }
                }
            });

            // Apply mobile price filter
            $('#apply-mobile-price-filter').on('click', function() {
                let values = mobileInstance.result;
                priceMin = values.from;
                priceMax = values.to;
                page = 1;
                fetchData();

                // Close the panel
                const panel = $('.price-filter-panel');
                panel.removeClass('active');
                setTimeout(() => panel.hide(), 300);
            });


            /* shop range */
            if ($(".js-range-slider-price").length) {
                var $range = $(".js-range-slider-price");
                var instance;
                var min = 0;
                var max = 999;

                $range.ionRangeSlider({
                    skin: "round",
                    type: 'double',
                    min: min,
                    max: max,
                    from: 0,
                    hide_min_max: 'true',
                    prefix: "₪",
                    to: 999
                });

                instance = $range.data("ionRangeSlider");

                // Add click event handler for the filter button
                $('#apply-price-filter').on('click', function() {
                    let values = instance.result;
                    priceMin = values.from;
                    priceMax = values.to;
                    page = 1;
                    fetchData();
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

            // **Initial load**
            fetchData();

            // Initialize filter sections as closed
            $('.shop-aside__item-content').hide();

            // Handle click events on filter titles to toggle visibility
            $('.shop-aside__item-title').on('click', function() {
                const $this = $(this);
                const $filterContent = $this.next('.shop-aside__item-content');

                // Toggle active class for the title
                $this.toggleClass('active');

                // Toggle the filter content with animation
                $filterContent.slideToggle(300);
            });
        });
    </script>
@endsection
