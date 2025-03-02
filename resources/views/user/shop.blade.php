{{-- resources/views/user/shop.blade.php --}}

@extends('user.layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('user/css/shop.css') }}">
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="overlay"></div>
        <div class="wrapper">
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN SHOP -->
    <div class="shop shop-bg">
        <div class="scale-1 wrapper">
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

                    <!-- Status -->
                    {{-- <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.status')</span>
                        <div class="shop-aside__item-content">
                            <ul id="">
                                <li>
                                    <a href="#" class="status-filter" data-id="filter-sale">@lang('shop.sale')</a>
                                </li>
                                <li>
                                    <a href="#" class="status-filter active-li" data-id="filter-new">@lang('shop.new')</a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}


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
            let filters = {
                search: '',
                categories: [],
                brands: [],
                priceMin: 0,
                priceMax: 1000,
                sort: 'default',
                page: 1,
                isSale: false,
                isNew: false,
                hairPores: [],
                hairTypes: [],
                hairThicknesses: []
            };

            let mobileInstance;
            let currentWishlistIds = @json($currentWishlistIds ?? []);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Debounce function to optimize search input
            function debounce(func, delay) {
                let debounceTimer;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => func.apply(context, args), delay);
                };
            }

            // Fetch Products Data
            function fetchData() {
                $.ajax({
                    url: "{{ route('shop.fetchProducts') }}",
                    method: "GET",
                    data: filters,
                    dataType: "json",
                    beforeSend: function() {
                        $('#loading-indicator').show();
                    },
                    success: function(response) {
                        if (response.error) {
                            showToast(response.error, 'error');
                            return;
                        }
                        renderData(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Fetch Products Error:', error);
                        showToast('@lang('shop.error_fetching')', 'error');
                    },
                    complete: function() {
                        $('#loading-indicator').hide();
                    }
                });
            }

            // Render Data
            function renderData(response) {

                renderCategories(response.categories);
                renderBrands(response.brands);
                renderHairPores(response.hair_pores);
                renderHairTypes(response.hair_types);
                renderHairThicknesses(response.hair_thicknesses);
                renderProducts(response.products.data);
                renderPagination(response.products);
            }

            // Render Functions
            function renderCategories(categoriesData) {
                let categoriesList = $('#categories-list');
                categoriesList.empty();
                categoriesData.forEach(categoryItem => {
                    let isActive = filters.categories.includes(String(categoryItem.id)) ? 'active-li' : '';
                    categoriesList.append(`<li><a href="#" class="category-filter ${isActive}" data-id="${categoryItem.id}">${categoryItem.name}</a></li>`);
                });
                bindCategoryFilterEvents();
            }

            function renderBrands(brandsData) {
                let brandsList = $('#brands-list');
                brandsList.empty();
                brandsData.forEach(brandItem => {
                    let isActive = filters.brands.includes(String(brandItem.id)) ? 'active-li' : '';
                    brandsList.append(`<li><a href="#" class="brand-filter ${isActive}" data-id="${brandItem.id}">${brandItem.name}</a></li>`);
                });
                bindBrandFilterEvents();
            }

            function renderHairPores(hairPoresData) {
                let hairPoresList = $('#hair-pores-list');
                hairPoresList.empty().append(`<option value="default">@lang('shop.all_hair_pores')</option>`);
                hairPoresData.forEach(hairPoreItem => {
                    hairPoresList.append(`<option value="${hairPoreItem.id}">${hairPoreItem.name}</option>`);
                });
                hairPoresList.val(filters.hairPores.length > 0 ? filters.hairPores[0] : 'default');
                hairPoresList.off('change').on('change', handleHairPoresChange);
            }

            function renderHairTypes(hairTypesData) {
                let hairTypesList = $('#hair-types-list');
                hairTypesList.empty().append(`<option value="default">@lang('shop.all_hair_types')</option>`);
                hairTypesData.forEach(hairTypeItem => {
                    hairTypesList.append(`<option value="${hairTypeItem.id}">${hairTypeItem.name}</option>`);
                });
                hairTypesList.val(filters.hairTypes.length > 0 ? filters.hairTypes[0] : 'default');
                hairTypesList.off('change').on('change', handleHairTypesChange);
            }

            function renderHairThicknesses(hairThicknessesData) {
                let hairThicknessesList = $('#hair-thicknesses-list');
                hairThicknessesList.empty().append(`<option value="default">@lang('shop.all_hair_thicknesses')</option>`);
                hairThicknessesData.forEach(hairThicknessItem => {
                    hairThicknessesList.append(`<option value="${hairThicknessItem.id}">${hairThicknessItem.name}</option>`);
                });
                hairThicknessesList.val(filters.hairThicknesses.length > 0 ? filters.hairThicknesses[0] : 'default');
                hairThicknessesList.off('change').on('change', handleHairThicknessesChange);
            }

            function renderProducts(productsData) {
                let productsList = $('#products-list');
                productsList.empty();
                if (productsData.length === 0) {
                    productsList.append(`<p>@lang('shop.no_products_found')</p>`);
                    return;
                }
                productsData.forEach(product => {
                    let imageUrl = product.primary_image && product.primary_image.image_url ? `/storage/${product.primary_image.image_url}` : 'https://via.placeholder.com/262x370';
                    let productUrl = `{{ url('/view-product') }}/${product.id}/${product.name_en.toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;
                    let inStock = product.in_stock ? '@lang('shop.available')' : '@lang('shop.soldOut')';
                    let backColor = product.in_stock ? 'products-item__sale' : 'products-item__soldout';
                    let newLabel = product.is_new ? `<div class="products-item__type1"><span class="products-item__new">@lang("shop.new")</span></div>` : '';
                    let addToCartButton = (product.in_stock) ? `<button class="add-to-cart-btn" data-product-id="${product.id}" aria-label="{{ __('shop.add_to_cart') }}"><i style="color:white !important;" class="icon-cart"></i></button>` : '';

                    // Price display with discount
                    let priceDisplay = product.discount > 0 ?
                        `<span class="products-item__cost"><del>₪${product.price}</del> ₪${product.discounted_price}</span>` :
                        `<span class="products-item__cost">₪${product.discounted_price}</span>`;

                    productsList.append(`
                        <div class="products-item">
                            <a href="${productUrl}" class="products-item__link">
                                <div class="products-item__img">
                                    <div class="products-item__type">
                                        <span class="${backColor}">${inStock}</span>
                                    </div>
                                    ${newLabel}
                                    <img style="object-fit:contain;" data-src="${imageUrl ?? ''}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="${product.name}">
                                    <div class="products-item__hover">
                                        <i class="icon-search"></i>
                                        <div class="products-item__hover-options">
                                            <button class="toggle-wishlist-btn ${product.is_in_wishlist ? 'active' : ''}" data-product-id="${product.id}" aria-label="${product.is_in_wishlist ? '@lang('wishlist.remove')' : '@lang('wishlist.add')'}"><i class="icon-heart"></i></button>
                                            ${addToCartButton}
                                        </div>
                                    </div>
                                </div>
                                <div class="products-item__info">
                                    <span class="products-item__name">${product.name}</span>
                                    ${priceDisplay}
                                </div>
                            </a>
                        </div>
                    `);
                });
                lazyLoadImages();
                bindProductEvents();
            }

            function renderPagination(pagination) {
                let paginationList = $('#pagination');
                paginationList.empty();
                if (pagination.last_page <= 1) return;

                // Use the links array to generate pagination
                pagination.links.forEach(link => {
                    let isActive = link.active ? 'active' : '';
                    let disabled = link.url === null ? 'disabled' : '';
                    paginationList.append(`
                        <li class="paging-list__item ${isActive} ${disabled}">
                            <a href="#" class="paging-list__link" data-page="${link.url ? new URL(link.url).searchParams.get('page') : ''}">
                                ${link.label}
                            </a>
                        </li>
                    `);
                });

                bindPaginationEvents();
            }

            // Event Handlers
            function bindCategoryFilterEvents() {
                $('.category-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedId = $(this).data('id');
                    if (filters.categories.includes(String(selectedId))) {
                        filters.categories = filters.categories.filter(id => id !== String(selectedId));
                        $(this).removeClass('active-li');
                    } else {
                        filters.categories.push(String(selectedId));
                        $(this).addClass('active-li');
                    }
                    filters.page = 1;
                    fetchData();
                });
            }

            function bindBrandFilterEvents() {
                $('.brand-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedId = $(this).data('id');
                    if (filters.brands.includes(String(selectedId))) {
                        filters.brands = filters.brands.filter(id => id !== String(selectedId));
                        $(this).removeClass('active-li');
                    } else {
                        filters.brands.push(String(selectedId));
                        $(this).addClass('active-li');
                    }
                    filters.page = 1;
                    fetchData();
                });
            }

            function bindStatusFilterEvents() {
                $('.status-filter').off('click').on('click', function(e) {

                    e.preventDefault();
                    let selectedId = $(this).data('value');
                    if (filters.statuses.includes(String(selectedId))) {
                        filters.statuses = filters.statuses.filter(id => id !== String(selectedId));
                        $(this).removeClass('active-li');
                    } else {
                        filters.statuses.push(String(selectedId));
                        $(this).addClass('active-li');
                    }
                    filters.page = 1;
                    fetchData();
                });
            }

            function handleHairPoresChange() {
                const selectedValue = $(this).val();
                filters.hairPores = selectedValue !== 'default' ? [selectedValue] : [];
                filters.page = 1;
                fetchData();
            }

            function handleHairTypesChange() {
                const selectedValue = $(this).val();
                filters.hairTypes = selectedValue !== 'default' ? [selectedValue] : [];
                filters.page = 1;
                fetchData();
            }

            function handleHairThicknessesChange() {
                const selectedValue = $(this).val();
                filters.hairThicknesses = selectedValue !== 'default' ? [selectedValue] : [];
                filters.page = 1;
                fetchData();
            }

            function bindProductEvents() {
                $('.add-to-cart-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('product-id');
                    addToCart(productId, 1);
                });
                $('.toggle-wishlist-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let btn = $(this);
                    let productId = btn.data('product-id');
                    toggleWishlist(productId, btn);
                });
            }

            // Add to Cart
            function addToCart(productId, quantity) {
                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: "POST",
                    data: { product_id: productId, quantity: quantity },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            updateCartCount(response.cart_count);
                            updateGlobalCartCount();
                            showToast(response.message, 'success');
                            console.log(response.response);

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
                    data: { product_id: productId },
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

            // Pagination Event Handler
            function bindPaginationEvents() {
                $('.paging-list__link').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedPage = $(this).data('page');
                    if (selectedPage && selectedPage !== filters.page) {
                        filters.page = selectedPage;
                        fetchData();
                        $('html, body').animate({ scrollTop: $("#products-list").offset().top - 100 }, 500);
                    }
                });
            }

            // **Initial load**
            fetchData();

            // Initialize filter sections as closed
            $('.shop-aside__item-content').hide();
            $('.shop-aside__item-title').on('click', function() {
                const $this = $(this);
                const $filterContent = $this.next('.shop-aside__item-content');
                $this.toggleClass('active');
                $filterContent.slideToggle(300);
            });

            // Price Filter Panel
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

            $(document).on('click', function(e) {
                if (!$(e.target).closest('.floating-price-filter').length) {
                    const panel = $('.price-filter-panel');
                    if (panel.is(':visible')) {
                        panel.removeClass('active');
                        setTimeout(() => panel.hide(), 300);
                    }
                }
            });

            $('#apply-mobile-price-filter').on('click', function() {
                let values = mobileInstance.result;
                filters.priceMin = values.from;
                filters.priceMax = values.to;
                filters.page = 1;
                fetchData();
                const panel = $('.price-filter-panel');
                panel.removeClass('active');
                setTimeout(() => panel.hide(), 300);
            });

            if ($(".js-range-slider-price").length) {
                var $range = $(".js-range-slider-price");
                var instance;
                $range.ionRangeSlider({
                    skin: "round",
                    type: 'double',
                    min: 0,
                    max: 200,
                    from: 0,
                    hide_min_max: 'true',
                    prefix: "₪",
                    to: 200
                });
                instance = $range.data("ionRangeSlider");
                $('#apply-price-filter').on('click', function() {
                    let values = instance.result;
                    filters.priceMin = values.from;
                    filters.priceMax = values.to;
                    filters.page = 1;
                    fetchData();
                });
            }

            $('#search').on('input', debounce(function() {
                filters.search = $(this).val();
                filters.page = 1;
                fetchData();
            }, 300));

            $('#sort').on('change', function() {
                filters.sort = $(this).val();
                filters.page = 1;
                fetchData();
            });

            // Status filter event handler
            $('.status-filter').on('click', function(e) {
                e.preventDefault();
                $('.status-filter').removeClass('active-li');
                $(this).addClass('active-li');

                let filterId = $(this).data('id');
                if (filterId === 'filter-sale') {
                    filters.isSale = true;
                    filters.isNew = false;
                } else if (filterId === 'filter-new') {
                    filters.isSale = false;
                    filters.isNew = true;
                }
                filters.page = 1;
                fetchData();
                console.log(filterId);

            });
            $('.shop-main__checkboxes input').on('change', function() {
                if ($(this).attr('id') === 'filter-sale') {
                    filters.isSale = $(this).is(':checked');
                }
                if ($(this).attr('id') === 'filter-new') {
                    filters.isNew = $(this).is(':checked');
                }
                filters.page = 1;
                fetchData();
            });
        });
    </script>
@endsection
