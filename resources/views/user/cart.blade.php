@extends('user.layouts.app')

@section('styles')
    <!-- SweetAlert2 CSS -->
    <style>
        /* Existing styles */

        /* Empty Cart Styles */
        .empty-cart-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 50vh;
            text-align: center;
        }

        .empty-cart-image {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
        }

        .empty-cart-message {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }

        .continue-shopping {
            display: inline-block;
            padding: 0px 20px;
            background-color: #971d25;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .continue-shopping:hover {
            background-color: #7b1620;
            color: #fff;
        }

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

        .cart-table__row {
            position: relative;
        }

        .counter-box {
            display: flex;
            align-items: center;
        }

        .counter-link {
            background: none;
            border: none;
            color: #333;
            font-size: 20px;
            cursor: pointer;
            margin: 0 5px;
        }

        .counter-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="overlay"></div>
        <div class="wrapper">
            <div class="detail-block__content">
                {{-- <h1>{{ __('cart.title') }}</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ route('home') }}" class="bread-crumbs__link">{{ __('cart.home') }}</a>
                    </li>
                    <li class="bread-crumbs__item">{{ __('cart.title') }}</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- DETAIL MAIN BLOCK EOF -->

    <!-- BEGIN CART -->
    <div class="cart">
        <div class="wrapper">
            <div id="cart-container">
                <!-- Cart content will be dynamically injected via JavaScript -->
            </div>
        </div>
    </div>
    <!-- CART EOF -->
@endsection

@section('scripts')
    <!-- SweetAlert2 JS -->
    <script>
        $(document).ready(function() {

            // Initialize SweetAlert2 Toast
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

            function loadCartItems() {
                $.ajax({
                    url: "{{ route('fetchCart') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        renderCartItems(response.cartItems, response.totalPrice);
                    },
                    error: function() {
                        $('#cart-container').html('<p>{{ __('cart.error_loading') }}</p>');
                        Toast.fire({
                            icon: 'error',
                            title: '{{ __('cart.error_loading') }}'
                        });
                    }
                });
            }

            function renderCartItems(cartItems, totalPrice) {
                if (cartItems.length === 0) {
                    renderEmptyCart();
                    return;
                }

                let cartHtml = `
    <div class="cart-table">
        <div class="cart-table__box">
            <div class="cart-table__row cart-table__row-head">
                <div class="cart-table__col">{{ __('cart.product') }}</div>
                <div class="cart-table__col">{{ __('cart.price') }}</div>
                <div class="cart-table__col">{{ __('cart.quantity') }}</div>
                <div class="cart-table__col">{{ __('cart.total') }}</div>
            </div>`;

                cartItems.forEach(item => {
                    let stockStatus = item.in_stock ?
                        `<span style="color: green;">{{ __('cart.in_stock') }} (${item.available_quantity})</span>` :
                        `<span style="color: red;">{{ __('cart.out_of_stock') }}</span>`;

                    cartHtml += `
        <div class="cart-table__row" data-product-id="${item.product_id}">
            <div class="cart-table__col">
                <a href="#" class="cart-table__img">
                    <img src="${item.image_url}" alt="${item.name}">
                </a>
                <div class="cart-table__info">
                    <a href="#" class="title5">${item.name}</a>
                    <span class="cart-table__info-stock">${stockStatus}</span>
                </div>
            </div>
            <div class="cart-table__col">
                <span class="cart-table__price" data-price="${item.price}">
                    ₪${parseFloat(item.price).toFixed(2)}
                </span>
            </div>
            <div class="cart-table__col">
                <div class="cart-table__quantity">
                    <div class="counter-box">
                        <button class="counter-link counter-link__prev" data-action="decrease">-</button>
                        <input type="text" class="counter-input" value="${item.quantity}" disabled>
                        <button class="counter-link counter-link__next" data-action="increase">+</button>
                    </div>
                </div>
            </div>
            <div class="cart-table__col">
                <span class="cart-table__total">
                    ₪${(item.price * item.quantity).toFixed(2)}
                </span>
                <button class="remove-btn text-remove" data-product-id="${item.product_id}">
                    {{ __('cart.remove') }}
                </button>
            </div>
        </div>`;
                });

                cartHtml += `
        </div>
    </div>
    <div class="cart-bottom">
        <div class="cart-bottom__total">
            <div class="cart-bottom__total-goods">
                {{ __('cart.total_goods') }}: <span id="cart-total-goods">₪${totalPrice.toFixed(2)}</span>
            </div>
            <span id="checkout-warning" style="color: red; display: none;">
                {{ __('cart.checkout_disabled_message') }}
            </span>
           <a href="{{ route('checkout.index') }}" class="btn" id="checkout-btn">
            {{ __('cart.checkout') }}
            </a>
        </div>
    </div>`;

                $('#cart-container').html(cartHtml);
                attachCartEventHandlers(); // Reattach event handlers
                checkStockConflicts(); // Call conflict checker after rendering
            }

            function renderEmptyCart() {
                const emptyCartHtml = `
                <div class="empty-cart-container">
                    <img src="{{ asset('admin/assets/img/emptycart.png') }}" alt="Empty Cart" class="empty-cart-image">
                    <p class="empty-cart-message">{{ __('cart.empty') }}</p>
                    <a href="{{ route('home') }}" class="btn continue-shopping">{{ __('cart.continue_shopping') }}</a>
                </div>
                `;
                $('#cart-container').html(emptyCartHtml);
            }

            function attachCartEventHandlers() {
                $('.counter-link').off('click').on('click', function(e) {
                    e.preventDefault();
                    let row = $(this).closest('.cart-table__row');
                    let input = row.find('.counter-input');
                    let oldQty = parseInt(input.val()) || 0;
                    let price = parseFloat(row.find('.cart-table__price').data('price')) || 0;
                    let action = $(this).data('action');

                    let newQty = oldQty;
                    if (action === 'increase') {
                        newQty += 1;
                    } else if (action === 'decrease') {
                        newQty -= 1;
                    }

                    if (newQty < 1) return;


                    // Update the cart on the server first
                    updateCart(row.data('product-id'), newQty, function(success, message, updatedData) {
                        if (success) {
                            input.val(newQty);
                            let newTotal = (price * newQty).toFixed(2);
                            row.find('.cart-table__total').text(`$${newTotal}`);
                            updateTotalPrice();
                            checkStockConflicts(updatedData);

                            // Toast.fire({
                            //     icon: 'success',
                            //     title: '{{ __('cart.quantity_updated') }}'
                            // });
                            // Check for stock conflicts

                        } else {
                            // Show error and reset input value to old quantity
                            Toast.fire({
                                icon: 'error',
                                title: message
                            });
                            input.val(oldQty);
                        }
                    });
                });

                $('.remove-btn').off('click').on('click', function() {
                    let row = $(this).closest('.cart-table__row');
                    let productId = $(this).data('product-id');

                    Swal.fire({
                        title: '{{ __('cart.confirm_remove_title') }}',
                        text: '{{ __('cart.confirm_remove_text') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('cart.remove') }}',
                        cancelButtonText: '{{ __('cart.cancel') }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeFromCart(productId, function(success) {
                                if (success) {
                                    row.remove();
                                    updateTotalPrice();
                                    checkEmptyCart();
                                    checkStockConflicts();
                                    Toast.fire({
                                        icon: 'success',
                                        title: '{{ __('cart.product_removed_success') }}'
                                    });
                                }
                            });
                        }
                    });
                });
            }

            function updateCart(productId, quantity, callback) {
                $.ajax({
                    url: "{{ route('cart.updateQuantity') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            callback(true, null);
                        } else {
                            callback(false, response.message);
                        }
                    },
                    error: function() {
                        console.error('Error updating cart.');
                        callback(false, '{{ __('cart.error_updating_cart') }}');
                    },
                });
            }

            function removeFromCart(productId, callback) {
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            callback(true, null);
                            updateGlopalCartCount();
                            loadCartItems();
                        } else {
                            callback(false, response.message);
                        }
                    },
                    error: function() {
                        console.error('Error removing product.');
                        callback(false, '{{ __('cart.error_removing_product') }}');
                    },
                });
            }

            function updateTotalPrice() {
                let totalPrice = 0;
                $('.cart-table__row').each(function() {
                    let rowTotalText = $(this).find('.cart-table__total').text().replace('$', '').trim();
                    let rowTotal = parseFloat(rowTotalText) || 0;
                    totalPrice += rowTotal;
                });
                $('#cart-total-goods').text(`₪${totalPrice.toFixed(2)}`);
            }

            function checkEmptyCart() {
                if ($('.cart-table__row').length === 0) {
                    renderEmptyCart();
                }
            }

            function checkStockConflicts() {
                let hasStockIssue = false;

                $('.cart-table__row').each(function() {
                    let row = $(this);
                    let input = row.find('.counter-input');
                    let currentQty = parseInt(input.val()) || 0;
                    let stockInfo = row.find('.cart-table__info-stock').text();
                    let availableQty = parseInt(stockInfo.match(/\d+/)) || 0;

                    // Remove any existing warnings before checking
                    row.find('.stock-warning').remove();

                    // Handle stock conflict
                    if (currentQty > availableQty) {
                        hasStockIssue = true;
                        input.css('border-color', 'red'); // Highlight input field
                        row.find('.cart-table__info').append(`
                <span class="stock-warning" style="color: red; display: block;">
                    {{ __('cart.quantity_exceeds_stock') }} (${availableQty})
                </span>
            `);
                    } else {
                        input.css('border-color', '#ccc'); // Reset border color
                    }
                });

                // Update the checkout button and general warning message
                if (hasStockIssue) {
                    $('#checkout-warning').show();
                    $('#checkout-btn').prop('disabled', true);
                } else {
                    $('#checkout-warning').hide();
                    $('#checkout-btn').prop('disabled', false);
                }
            }

            loadCartItems();

        });
    </script>
@endsection
