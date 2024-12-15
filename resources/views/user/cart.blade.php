@extends('user.layouts.app')
@section('styles')
    <style>
        /* Empty Cart Styles */
        .empty-cart-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 50vh;
            /* Ensure minimum height */
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
        }

        .text-remove {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 14px;
            /* Adjust font size if needed */
            color: #971d25;
            /* Color for "Remove" text */
            text-decoration: underline;
            /* Optional: Adds underline to indicate it's clickable */
            position: absolute;
            bottom: 10px;
            /* Position it towards the bottom */
            right: 10px;
            /* Align it to the right */
        }

        .text-remove:hover {
            opacity: 0.8;
            /* Optional: Adds hover effect */
        }

        .cart-table__row {
            position: relative;
            /* Ensure relative positioning for the row */
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN DETAIL MAIN BLOCK -->
    <div class="detail-block detail-block_margin">
        <div class="wrapper">
            <div class="detail-block__content">
                <h1>{{ __('cart.title') }}</h1>
                <ul class="bread-crumbs">
                    <li class="bread-crumbs__item">
                        <a href="{{ url('/') }}" class="bread-crumbs__link">{{ __('cart.home') }}</a>
                    </li>
                    <li class="bread-crumbs__item">{{ __('cart.title') }}</li>
                </ul>
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
    <script>
        $(document).ready(function() {
            function loadCartItems() {
                $.ajax({
                    url: "{{ route('cart.index') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        renderCartItems(response.cartItems, response.totalPrice);
                    },
                    error: function() {
                        $('#cart-container').html('<p>{{ __('cart.error_loading') }}</p>');
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
                    cartHtml += `
                <div class="cart-table__row" data-product-id="${item.product_id}">
                    <div class="cart-table__col">
                        <a href="#" class="cart-table__img">
                            <img src="${item.image_url}" alt="${item.name}">
                        </a>
                        <div class="cart-table__info">
                            <a href="#" class="title5">${item.name}</a>
                            <span class="cart-table__info-stock">{{ __('cart.in_stock') }}</span>
                        </div>
                    </div>
                    <div class="cart-table__col">
                        <span class="cart-table__price" data-price="${item.price}">
                            $${parseFloat(item.price).toFixed(2)}
                        </span>
                    </div>
                    <div class="cart-table__col">
                        <div class="cart-table__quantity">
                            <div class="counter-box">
                                <button class="counter-link counter-link__prev" data-action="decrease">
                                    <i class="icon-arrow"></i>
                                </button>
                                <input type="text" class="counter-input" value="${item.quantity}" disabled>
                                <button class="counter-link counter-link__next" data-action="increase">
                                    <i class="icon-arrow"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="cart-table__col">
                        <span class="cart-table__total">
                            $${(item.price * item.quantity).toFixed(2)}
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
                        {{ __('cart.total_goods') }}: <span id="cart-total-goods">$${totalPrice.toFixed(2)}</span>
                    </div>
                    <a href="{{ url('/') }}" class="btn">{{ __('cart.checkout') }}</a>
                </div>
            </div>`;

                $('#cart-container').html(cartHtml);
                attachCartEventHandlers();
            }

            function renderEmptyCart() {
                const emptyCartHtml = `
            <div class="empty-cart-container">
                <img src="{{ asset('admin/assets/img/emptycart.png') }}" alt="Empty Cart" class="empty-cart-image">
                <p class="empty-cart-message">{{ __('cart.empty') }}</p>
                <a href="{{ url('/') }}" class="btn continue-shopping">{{ __('cart.continue_shopping') }}</a>
            </div>
        `;
                $('#cart-container').html(emptyCartHtml);
            }

            function attachCartEventHandlers() {
                $('.counter-link').off('click').on('click', function(e) {
                    e.preventDefault();

                    let row = $(this).closest('.cart-table__row');
                    let input = row.find('.counter-input');
                    let price = parseFloat(row.find('.cart-table__price').data('price')) || 0;
                    let currentQty = parseInt(input.val()) || 0;
                    let newQty = currentQty;

                    if ($(this).data('action') === 'increase') {
                        newQty += 1;
                    } else if ($(this).data('action') === 'decrease') {
                        newQty -= 1;
                    }

                    if (newQty < 1) return;

                    input.val(newQty);
                    row.find('.cart-table__total').text(`$${(price * newQty).toFixed(2)}`);
                    updateTotalPrice();

                    updateCart(row.data('product-id'), newQty);
                });

                $('.remove-btn').off('click').on('click', function() {
                    let row = $(this).closest('.cart-table__row');
                    let productId = $(this).data('product-id');

                    row.remove();
                    updateTotalPrice();

                    removeFromCart(productId);
                    checkEmptyCart();
                });
            }

            function updateCart(productId, quantity) {
                $.ajax({
                    url: "{{ route('cart.updateQuantity') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity,
                    },
                    success: function(response) {
                        if (response.status !== 'success') {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        console.error('Error updating cart.');
                    },
                });
            }

            function removeFromCart(productId) {
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                    },
                    success: function(response) {
                        if (response.status !== 'success') {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        console.error('Error removing product.');
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
                $('#cart-total-goods').text(`$${totalPrice.toFixed(2)}`);
            }

            function checkEmptyCart() {
                if ($('.cart-table__row').length === 0) {
                    renderEmptyCart();
                }
            }

            loadCartItems();
        });
    </script>
@endsection
