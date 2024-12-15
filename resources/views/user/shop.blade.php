{{-- resources/views/user/shop.blade.php --}}
@extends('user.layouts.app')

@section('content')
<style>
    /* Remove default button styles */
.add-to-cart-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    outline: none; /* Remove focus outline if desired, but consider accessibility */
}

/* Optional: Change cursor to pointer on hover */
.add-to-cart-btn:hover {
    opacity: 0.8; /* Example hover effect */
}

/* Optional: Add focus styles for accessibility */
.add-to-cart-btn:focus {
    outline: 2px solid #007BFF; /* Visible focus indicator */
}

/* Optional: Adjust the icon size and color */
.add-to-cart-btn .icon-cart {
    font-size: 1.5rem; /* Adjust size as needed */
    color: #333; /* Adjust color as needed */
}
</style>
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>@lang('shop.shop')</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ url('/') }}" class="bread-crumbs__link">@lang('shop.home')</a>
                    </li>
                    <li class="bread-crumbs__item">@lang('shop.shop')</li>
                </ul>
            </div>
        </div>
    </div>
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
                            <!-- Categories will be loaded here via AJAX -->
                        </ul>
                    </div>

                    <!-- Brands -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.brands')</span>
                        <ul id="brands-list">
                            <!-- Brands will be loaded here via AJAX -->
                        </ul>
                    </div>

                    <!-- Price Range -->
                    <div class="shop-aside__item">
                        <span class="shop-aside__item-title">@lang('shop.price')</span>
                        <div class="range-slider">
                            <input type="text" id="price-range" class="js-range-slider-price" value="" />
                        </div>
                    </div>

                    <!-- You Have Viewed & Top 3 for Today (Optional) -->
                    <!-- ... Keep these sections if needed, modify as per AJAX requirements -->
                </div>

                <div class="shop-main">
                    <div class="shop-main__filter">
                        <div class="shop-main__checkboxes">
                            <label class="checkbox-box">
                                <input type="checkbox" id="filter-sale">
                                <span class="checkmark"></span>
                                @lang('shop.sale')
                            </label>
                            <label class="checkbox-box">
                                <input type="checkbox" id="filter-new">
                                <span class="checkmark"></span>
                                @lang('shop.new')
                            </label>
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
                        <!-- Products will be loaded here via AJAX -->
                    </div>

                    <!-- Pagination -->
                    <ul class="paging-list" id="pagination">
                        <!-- Pagination links will be loaded here via AJAX -->
                    </ul>
                </div>
            </div>
        </div>
        <img class="promo-video__decor js-img" data-src="https://via.placeholder.com/1197x1371/FFFFFF"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" alt="">
    </div>
    <!-- SHOP EOF -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Initialize variables for filters
            let search = '';
            let category = '';
            let brand = '';
            let priceMin = 0;
            let priceMax = 1000; // Adjust based on your data
            let sort = 'default';
            let page = 1;
            let isSale = false;
            let isNew = false;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Log to confirm jQuery is loaded
            console.log('jQuery version:', $.fn.jquery);

            // Function to fetch data via AJAX
            function fetchData() {
                console.log('Fetching data with filters:', {
                    search,
                    category,
                    brand,
                    price_min: priceMin,
                    price_max: priceMax,
                    sort,
                    page,
                    is_sale: isSale,
                    is_new: isNew
                });

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
                        console.log('AJAX Success:', response);

                        // Render categories
                        renderCategories(response.categories);

                        // Render brands
                        renderBrands(response.brands);

                        // Render products
                        renderProducts(response.products.data);

                        // Render pagination
                        renderPagination(response.products);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // Function to render categories
            function renderCategories(categories) {
                let categoriesList = $('#categories-list');
                categoriesList.empty();

                categories.forEach(function(categoryItem) {
                    categoriesList.append(`
                    <li>
                        <a href="#" class="category-filter ${category === categoryItem.id ? 'active' : ''}" data-id="${categoryItem.id}">
                            ${getLocalizedName(categoryItem)}
                            <span>(${categoryItem.products_count || 0})</span>
                        </a>
                    </li>
                `);
                });

                // Attach click event to category filters
                $('.category-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedCategory = $(this).data('id');
                    if (category === selectedCategory) {
                        // If the same category is clicked, deselect it
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

            // Function to render brands
            function renderBrands(brands) {
                let brandsList = $('#brands-list');
                brandsList.empty();

                brands.forEach(function(brandItem) {
                    brandsList.append(`
                    <li>
                        <a href="#" class="brand-filter ${brand === brandItem.id ? 'active' : ''}" data-id="${brandItem.id}">
                            ${getLocalizedName(brandItem)}
                            <span>(${brandItem.products_count || 0})</span>
                        </a>
                    </li>
                `);
                });

                // Attach click event to brand filters
                $('.brand-filter').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedBrand = $(this).data('id');
                    if (brand === selectedBrand) {
                        // If the same brand is clicked, deselect it
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

            // Function to render products
            // Function to render products
            function renderProducts(products) {
                let productsList = $('#products-list');
                productsList.empty();

                if (products.length === 0) {
                    productsList.append('<p>@lang('shop.no_products_found')</p>');
                    return;
                }

                products.forEach(function(product) {
                    // Ensure images array exists and has at least one image
                    let imageUrl = (product.images && product.images.length > 0) ? product.images[0].url :
                        'https://via.placeholder.com/262x370';

                    productsList.append(`
                        <a href="#" class="products-item">
                            <div class="products-item__img">
                                <img data-src="${imageUrl}"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                                     class="js-img" alt="${getLocalizedName(product)}">
                                <div class="products-item__hover">
                                    <i class="icon-search"></i>
                                    <div class="products-item__hover-options">
                                        <i class="icon-heart"></i>
                                        <button class="add-to-cart-btn " data-product-id="${product.id}">
                                            <i class="icon-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="products-item__info">
                                <span class="products-item__name">${getLocalizedName(product)}</span>
                                <span class="products-item__cost">$${product.price}</span>
                            </div>
                        </a>
                    `);


                });

                // Initialize lazy loading for images
                lazyLoadImages();

                // Attach click event to "Add to Cart" buttons
                $('.add-to-cart-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('product-id');
                    addToCart(productId, 1); // Default quantity is 1
                });
            }

            // Function to add product to cart
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
                            // Optionally, update cart count
                            updateCartCount(response.cart_count);
                            // Show success message
                            showToast(response.message, 'success');
                        } else {
                            // Show error message
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Add to Cart Error:', error);
                        showToast('@lang('shop.add_to_cart_error')', 'error');
                    }
                });
            }

            // Function to remove product from cart
            function removeFromCart(productId) {
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: "POST",
                    data: {
                        product_id: productId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            // Optionally, update cart count
                            updateCartCount(response.cart_count);
                            // Show success message
                            showToast(response.message, 'success');
                            // Reload or update cart UI
                            location.reload();
                        } else {
                            // Show error message
                            showToast(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Remove from Cart Error:', error);
                        showToast('@lang('shop.remove_from_cart_error')', 'error');
                    }
                });
            }

            // Function to update cart count (optional)
            function updateCartCount(count) {
                $('#cart-count').text(count);
            }

            // Function to show toast notifications (optional)
            function showToast(message, type) {
                // You can use a library like Toastr for better UI
                // For simplicity, using alert
                alert(message);
            }

            // Function to render pagination
            function renderPagination(pagination) {
                let paginationList = $('#pagination');
                paginationList.empty();

                if (pagination.last_page <= 1) {
                    return; // No pagination needed
                }

                // Previous Page Link
                if (pagination.current_page > 1) {
                    paginationList.append(`
                    <li class="paging-list__item paging-prev">
                        <a href="#" class="paging-list__link" data-page="${pagination.current_page - 1}">
                            <i class="icon-arrow"></i>
                        </a>
                    </li>
                `);
                }

                // Page Numbers (Showing a range around the current page for better UX)
                let start = Math.max(1, pagination.current_page - 2);
                let end = Math.min(pagination.last_page, pagination.current_page + 2);

                for (let i = start; i <= end; i++) {
                    paginationList.append(`
                    <li class="paging-list__item ${i === pagination.current_page ? 'active' : ''}">
                        <a href="#" class="paging-list__link" data-page="${i}">${i}</a>
                    </li>
                `);
                }

                // Next Page Link
                if (pagination.current_page < pagination.last_page) {
                    paginationList.append(`
                    <li class="paging-list__item paging-next">
                        <a href="#" class="paging-list__link" data-page="${pagination.current_page + 1}">
                            <i class="icon-arrow"></i>
                        </a>
                    </li>
                `);
                }

                // Attach click event to pagination links
                $('.paging-list__link').off('click').on('click', function(e) {
                    e.preventDefault();
                    let selectedPage = $(this).data('page');
                    if (selectedPage !== page) {
                        page = selectedPage;
                        fetchData();
                        // Scroll to top of products list
                        $('html, body').animate({
                            scrollTop: $("#products-list").offset().top - 100
                        }, 500);
                    }
                });
            }

            // Function to get localized name
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

            // Function to initialize price range slider
            function initializePriceSlider() {
                // Fetch the global min and max prices from the backend (optional)
                // For simplicity, we use static values here
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

            // Function to handle search input
            $('#search').on('input', function() {
                search = $(this).val();
                page = 1;
                fetchData();
            });

            // Function to handle sort selection
            $('#sort').on('change', function() {
                sort = $(this).val();
                page = 1;
                fetchData();
            });

            // Function to handle checkboxes (e.g., SALE, NEW)
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

            // Function to initialize lazy loading for images
            function lazyLoadImages() {
                $('.js-img').each(function() {
                    if ($(this).attr('data-src')) {
                        $(this).attr('src', $(this).attr('data-src'));
                        $(this).removeAttr('data-src');
                    }
                });
            }

            // Function to handle subscribe form submission
            $('#subscribe-form').on('submit', function(e) {
                e.preventDefault();
                let email = $('#subscribe-email').val();

                if (!email) {
                    alert('@lang('shop.enter_email')');
                    return;
                }

                $.ajax({
                    url: "", // Ensure you have this route defined
                    method: "POST",
                    data: {
                        email: email,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        alert(response.message || '@lang('shop.subscribe_success')');
                        $('#subscribe-email').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Subscribe Error:', error);
                        alert('@lang('shop.subscribe_error')');
                    }
                });
            });

            // Initial fetch
            fetchData();

            // Initialize price range slider after initial fetch
            initializePriceSlider();
        });
    </script>
@endsection
