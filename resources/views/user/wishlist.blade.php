{{-- resources/views/user/wishlist.blade.php --}}
@extends('user.layouts.app')

@section('styles')
    <!-- SweetAlert2 CSS -->
    <style>
        /* Existing Styles */

        /* Empty Wishlist Styles (Same as Empty Cart Styles for Consistency) */
        .empty-wishlist-container,
        .empty-cart-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 50vh;
            text-align: center;
        }

        .empty-wishlist-image,
        .empty-cart-image {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .empty-wishlist-message,
        .empty-cart-message {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .continue-shopping,
        .btn.continue-shopping {
            display: inline-block;
            padding: 0px 20px;
            background-color: #971d25;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .continue-shopping:hover,
        .btn.continue-shopping:hover {
            background-color: #7b1620;
            color: #fff;
        }

        /* Additional Styles from Wishlist */
        .cart-table__row {
            position: relative;
        }

        .wishlist-stock {
            color: green;
        }

        .wishlist-available {
            color: #971d25;
        }

        #wishlist-container {
            min-height: 65vh !important;
        }

        /* Add to Cart button styling (from wishlist) */
        .add-to-cart-btn-wishlist {
            display: inline-block;
            background-color: #971d25;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            padding: 0 15px;
            height: 34px;
            line-height: 34px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .add-to-cart-btn-wishlist:hover {
            background-color: #7b1620;
            color: #fff;
        }

        .add-to-cart-btn-wishlist i.icon-cart {
            vertical-align: middle;
            font-size: 16px;
        }

        /* Remove button styling */
        .text-remove {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 14px;
            color: #971d25;
            text-decoration: underline;
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .text-remove:hover {
            opacity: 0.8;
        }

        /* Additional Styles for Wishlist Items */
        .wishlist-buttons {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .wishlist-buttons .btn {
            /* Reuse styles from continue-shopping */
            display: inline-block;
            padding: 0px 20px;
            background-color: #971d25;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .wishlist-buttons .btn:hover {
            background-color: #7b1620;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>{{ __('wishlist.wishlist') }}</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ url('/') }}" class="bread-crumbs__link">{{ __('wishlist.home') }}</a>
                    </li>
                    <li class="bread-crumbs__item">{{ __('wishlist.wishlist') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN WISHLIST -->
    <div class="wishlist">
        <div id="wishlist-container" class="wrapper">
            <!-- Content will be dynamically injected via JavaScript -->
        </div>
    </div>
    <!-- WISHLIST EOF -->
@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script>
        $(document).ready(function() {
            // Initialize SweetAlert2 Toast
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Function to fetch wishlist items via AJAX
            function fetchWishlist() {
                $.ajax({
                    url: "{{ route('wishlist.index') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        renderWishlistItems(response.items || []);
                    },
                    error: function(xhr, status, error) {
                        console.error('Fetch Wishlist Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('wishlist.error_fetching') }}',
                            text: '{{ __('wishlist.try_again_later') }}'
                        });
                    }
                });
            }

            // Function to render wishlist items
            function renderWishlistItems(items) {
                let container = $('#wishlist-container');
                container.empty();

                if (items.length === 0) {
                    renderEmptyWishlist();
                    return;
                }

                let wishlistHtml = `
                    <div class="cart-table">
                        <div class="cart-table__box">
                            <div class="cart-table__row cart-table__row-head">
                                <div class="cart-table__col">{{ __('wishlist.product') }}</div>
                                <div class="cart-table__col">{{ __('wishlist.price') }}</div>
                                <div class="cart-table__col">{{ __('wishlist.status') }}</div>
                                <div class="cart-table__col">{{ __('wishlist.action') }}</div>
                            </div>
                            <div id="wishlist-items-container">
                `;

                items.forEach(function(item) {
                    let statusText = item.in_stock ?
                        `<span class="wishlist-stock">{{ __('wishlist.in_stock') }}</span>` :
                        `<span class="wishlist-available">{{ __('wishlist.not_available') }}</span>`;

                    wishlistHtml += `
                        <div class="cart-table__row" data-product-id="${item.product_id}">
                            <div class="cart-table__col">
                                <a href="#" class="cart-table__img">
                                    <img src="${item.image_url}" alt="${item.name}" style="width:110px;height:auto;">
                                </a>
                                <div class="cart-table__info">
                                    <a href="#" class="title5">${item.name}</a>
                                    <span class="cart-table__info-num">SKU: ${item.product_id}</span>
                                </div>
                            </div>
                            <div class="cart-table__col">
                                <span class="cart-table__price">$${parseFloat(item.price).toFixed(2)}</span>
                            </div>
                            <div class="cart-table__col">
                                ${statusText}
                            </div>
                            <div class="cart-table__col">
                                ${item.in_stock ? `<button class="add-to-cart-btn-wishlist" data-product-id="${item.product_id}"><i class="icon-cart"></i> {{ __('wishlist.add_to_cart') }}</button>` : ''}
                                <button class="remove-from-wishlist-btn text-remove" data-product-id="${item.product_id}">
                                    {{ __('wishlist.remove') }}
                                </button>
                            </div>
                        </div>
                    `;
                });

                wishlistHtml += `
                            </div>
                        </div>
                    </div>
                    <div class="wishlist-buttons" style="margin-top:20px;">
                        <a href="{{ url('/shop') }}" class="btn continue-shopping">{{ __('wishlist.go_shopping') }}</a>
                    </div>
                `;

                container.html(wishlistHtml);
                attachWishlistEventHandlers();
            }

            // Function to render empty wishlist view
            function renderEmptyWishlist() {
                const emptyHtml = `
                    <div class="empty-wishlist-container">
                        <img src="{{ asset('admin/assets/img/emptycart.png') }}" alt="Empty Wishlist" class="empty-wishlist-image">
                        <p class="empty-wishlist-message">{{ __('wishlist.no_items_in_wishlist') }}</p>
                        <a href="{{ url('/shop') }}" class="continue-shopping">{{ __('wishlist.go_shopping') }}</a>
                    </div>
                `;
                $('#wishlist-container').html(emptyHtml);
            }

            // Function to attach event handlers to wishlist items
            function attachWishlistEventHandlers() {
                // Handle Remove from Wishlist
                $('.remove-from-wishlist-btn').off('click').on('click', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('product-id');
                    confirmRemoveFromWishlist(productId);
                });

                // Handle Add to Cart from Wishlist
                $('.add-to-cart-btn-wishlist').off('click').on('click', function(e) {
                    e.preventDefault();
                    let productId = $(this).data('product-id');
                    addToCartFromWishlist(productId);
                });
            }

            // Function to confirm removal from wishlist
            function confirmRemoveFromWishlist(productId) {
                Swal.fire({
                    title: '{{ __('wishlist.confirm_remove_title') }}',
                    text: '{{ __('wishlist.confirm_remove_text') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ __('wishlist.remove') }}',
                    cancelButtonText: '{{ __('wishlist.cancel') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        removeFromWishlist(productId);
                    }
                });
            }

            // Function to remove item from wishlist via AJAX
            function removeFromWishlist(productId) {
                Swal.fire({
                    title: '{{ __('wishlist.removing') }}',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ route('wishlist.remove') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: response.message ||
                                    '{{ __('wishlist.removed_successfully') }}'
                            });
                            fetchWishlist(); // Reload wishlist items
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message ||
                                    '{{ __('wishlist.removal_failed') }}'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error('Remove from WishList Error:', error);
                        Toast.fire({
                            icon: 'error',
                            title: '{{ __('wishlist.remove_from_wishlist_error') }}'
                        });
                    }
                });
            }

            // Function to add item to cart from wishlist via AJAX
            function addToCartFromWishlist(productId) {
                Swal.fire({
                    title: '{{ __('wishlist.adding_to_cart') }}',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        quantity: 1
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: response.message || '{{ __('wishlist.added_to_cart') }}'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message ||
                                    '{{ __('wishlist.add_to_cart_failed') }}'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        console.error('Add to Cart Error:', error);
                        Toast.fire({
                            icon: 'error',
                            title: '{{ __('wishlist.add_to_cart_error') }}'
                        });
                    }
                });
            }

            // Function to show toast notifications
            function showToast(message, type) {
                Toast.fire({
                    icon: type,
                    title: message
                });
            }

            // Initial fetch of wishlist items on page load
            fetchWishlist();
        });
    </script>
@endsection
