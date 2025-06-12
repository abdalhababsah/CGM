{{-- resources/views/user/wishlist.blade.php --}}
@extends('user.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('user/css/wishlist.css') }}">
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="overlay"></div>
        <div class="wrapper">
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
                                    <span class="cart-table__info-num">SKU: ${item.sku}</span>
                                </div>
                            </div>
                            <div class="cart-table__col">
                                <span class="cart-table__price">₪${parseFloat(item.price).toFixed(2)}</span>
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
                    <div class="wishlist-buttons" style="margin-top:20px; margin-bottom:20px;">
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
