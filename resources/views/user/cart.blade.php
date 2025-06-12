@extends('user.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{url('user/css/cart.css')}}">
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
        // Utility: SweetAlert2 Toast
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

        // Load cart items from server and render
        function loadCartItems() {
            $.get("{{ route('fetchCart') }}")
            .done(function(response) {
                // Pass discount info if available
                renderCartItems(response.cartItems, response.totalPrice, response.discount, response.discountAmount);
            })
            .fail(function() {
                $('#cart-container').html('<p>{{ __('cart.error_loading') }}</p>');
                Toast.fire({ icon: 'error', title: '{{ __('cart.error_loading') }}' });
            });
        }
        // Render cart items or empty cart
        function renderCartItems(cartItems, totalPrice, discount = null, discountAmount = 0) {
            if (!cartItems.length) return renderEmptyCart();

            let cartHtml = `
            <div class="cart-table">
                <div class="cart-table__box">
                <div class="cart-table__row cart-table__row-head">
                    <div class="cart-table__col">{{ __('cart.product') }}</div>
                    <div class="cart-table__col">{{ __('cart.price') }}</div>
                    <div class="cart-table__col">{{ __('cart.quantity') }}</div>
                    <div class="cart-table__col">{{ __('cart.total') }}</div>
                </div>
                ${cartItems.map(item => renderCartRow(item)).join('')}
                </div>
            </div>
            ${renderCartBottom(totalPrice, discount, discountAmount)}
            `;
            $('#cart-container').html(cartHtml);
            attachCartEventHandlers();
            checkStockConflicts();
        }

        function renderCartRow(item) {
            const stockStatus = item.in_stock
            ? `<span class="in">{{ __('cart.in_stock') }}</span>`
            : `<span class="out">{{ __('cart.out_of_stock') }}</span>`;
            const oldPrice = item.discount > 0 ? `<del>₪${item.price}</del>` : '';
            const color = item.color
            ? `<p style="background-color: ${item.color}; height:10px;">
                <input type="hidden" name="color_id" class="colorId" value="${item.color_id}">
               </p>` : '';
            return `
            <div class="cart-table__row" data-product-id="${item.product_id}">
                <div class="cart-table__col">
                <a href="#" class="cart-table__img">
                    <img src="${item.image_url}" alt="${item.name}">
                </a>
                <div class="cart-table__info">
                    <a href="#" class="title5">${item.name} ${color}</a>
                    <span class="cart-table__info-stock">${stockStatus}</span>
                </div>
                </div>
                <div class="cart-table__col">
                <span class="cart-table__price" data-price="${item.discounted_price}">
                    ${oldPrice} ₪${item.discounted_price}
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
                <span class="cart-table__total">₪${(item.discounted_price * item.quantity).toFixed(2)}</span>
                <button class="remove-btn text-remove" data-product-id="${item.product_id}">
                    {{ __('cart.remove') }}
                </button>
                </div>
            </div>
            `;
        }
        function renderCartBottom(totalPrice, discount = null, discountAmount = 0) {
            return `
            <div class="cart-bottom">
                <div class="cart-bottom__promo">
                <h6>{{ __('checkout.apply_discount_code') }}</h6>
                <div class="box-field d-flex">
                    <input type="text" id="discount-code-input" class="form-control"
                    placeholder="{{ __('checkout.enter_discount_code') }}">
                    <button type="button" id="apply-discount-btn"
                    class="btn btn-primary mx-2">{{ __('checkout.apply') }}</button>
                </div>
                <div id="discount-message" class="mt-2">
                    ${discount ? `<div class="alert alert-success">${discount.message}: ${discount.code} (-₪${discountAmount})</div>` : ''}
                </div>
                </div>
                <div class="cart-bottom__total">
                <div class="cart-bottom__total-goods">
                    {{ __('cart.total_goods') }}: <span id="cart-total-goods">
                    ${discount ? `<div class="alert alert-success"><del>₪${totalPrice.toFixed(2)}</del> (₪${(totalPrice-discountAmount).toFixed(2)})</div>` 
                    : `₪${totalPrice.toFixed(2)}`}
                    
                    </span>
                </div>
                <span id="checkout-warning" style="display:none;">
                    {{ __('cart.checkout_disabled_message') }}
                </span>
                <a href="{{ route('checkout.index') }}" class="btn" id="checkout-btn">
                    {{ __('Continue') }}
                </a>
                </div>
            </div>
            `;
        }

        function renderEmptyCart() {
            $('#cart-container').html(`
            <div class="empty-cart-container">
                <img src="{{ asset('admin/assets/img/emptycart.png') }}" alt="Empty Cart" class="empty-cart-image">
                <p class="empty-cart-message">{{ __('cart.empty') }}</p>
                <a href="{{ route('home') }}" class="btn continue-shopping">{{ __('cart.continue_shopping') }}</a>
            </div>
            `);
        }

        // Attach all cart event handlers
        function attachCartEventHandlers() {
            // Quantity change
            $('.counter-link').off('click').on('click', function(e) {
            e.preventDefault();
            let row = $(this).closest('.cart-table__row');
            let colorId = row.find('.colorId').val();
            let input = row.find('.counter-input');
            let oldQty = parseInt(input.val()) || 0;
            let price = parseFloat(row.find('.cart-table__price').data('price')) || 0;
            let action = $(this).data('action');
            let newQty = action === 'increase' ? oldQty + 1 : oldQty - 1;
            if (newQty < 1) return;

            updateCart(row.data('product-id'), newQty, colorId, function(success, message) {
                if (success) {
                // Reload cart to update discount and totals
                loadCartItems();
                } else {
                Toast.fire({ icon: 'error', title: message });
                input.val(oldQty);
                }
            });
            });

            // Remove product
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
                    Toast.fire({ icon: 'success', title: '{{ __('cart.product_removed_success') }}' });
                    }
                });
                }
            });
            });

            // Discount code
            $('#apply-discount-btn').off('click').on('click', function() {
            applyDiscount();
            });
        }

        // Update cart quantity
        function updateCart(productId, quantity, colorId = null, callback) {
            $.post("{{ route('cart.updateQuantity') }}", {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            color_id: colorId,
            quantity: quantity,
            })
            .done(function(response) {
            callback(response.status === 'success', response.message);
            })
            .fail(function() {
            callback(false, '{{ __('cart.error_updating_cart') }}');
            });
        }

        // Remove product from cart
        function removeFromCart(productId, callback) {
            $.post("{{ route('cart.remove') }}", {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            })
            .done(function(response) {
            if (response.status === 'success') {
                updateGlobalCartCount();
                loadCartItems();
                callback(true);
            } else {
                callback(false, response.message);
            }
            })
            .fail(function() {
            callback(false, '{{ __('cart.error_removing_product') }}');
            });
        }

        // Update total price in UI
        function updateTotalPrice() {
            let totalPrice = 0;
            $('.cart-table__row').each(function() {
            let rowTotalText = $(this).find('.cart-table__total').text().replace('₪', '').trim();
            let rowTotal = parseFloat(rowTotalText) || 0;
            totalPrice += rowTotal;
            });
            $('#cart-total-goods').text(`₪${totalPrice.toFixed(2)}`);
        }

        // Show empty cart if no items
        function checkEmptyCart() {
            if (!$('.cart-table__row').length) renderEmptyCart();
        }

        // Check for stock conflicts and update checkout button
        function checkStockConflicts() {
            let hasStockIssue = false;
            $('.cart-table__row').each(function() {
            // Implement stock check logic if needed
            });
            $('#checkout-warning').toggle(hasStockIssue);
            $('#checkout-btn').prop('disabled', hasStockIssue);
        }

        // Apply discount code
        function applyDiscount() {
            let discountCode = $('#discount-code-input').val();
            $.post("{{ url('/apply-discount-code') }}", {
            _token: "{{ csrf_token() }}",
            discount_code: discountCode,
            })
            .done(function(response) {
            let alertType = response.status === 'success' ? 'success' : 'erorr';
            $('#discount-message').html('');
            Toast.fire({ icon: alertType, title: response.message });
            
            loadCartItems();
            });
        }

        // On page ready
        $(function() {
            loadCartItems();
        });
    </script>
@endsection
