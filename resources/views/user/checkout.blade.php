@extends('user.layouts.app')

@section('title', __('checkout.title'))
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
<style>
.box-field .form-control {
    margin-top: 0px !important;
}
    .d-none {
    display: none !important;
}
/* Styling for the select elements */
.styled-select {
    position: relative;
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

.styled-select select {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background: #f4f4f4;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px 15px;
    font-size: 14px;
    color: #333;
    transition: all 0.3s ease-in-out;
    width: 100%;
    outline: none;
}

.styled-select select:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.styled-select::after {
    content: "▼";
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    font-size: 12px;
    color: #999;
}

.styled-select .invalid-feedback {
    font-size: 12px;
    color: #d9534f;
    margin-top: 5px;
}
</style>
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

    <!-- BEGIN CHECKOUT -->
    <div class="checkout">
        <div class="wrapper">
            <div class="checkout-content">
                <div class="checkout-form">
                    <!-- Checkout Form -->
                    <form id="checkout-form" method="POST" action="{{ route('checkout.submit') }}">
                        @csrf

                        <!-- User Information -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.info_about_you') }}</h6>
                            <div class="box-field">
                                <input style="margin-top: 0px !important;" type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="{{ __('checkout.enter_first_name') }}" required>
                                <span class="invalid-feedback" id="error_first_name"></span>
                            </div>
                            <div class="box-field">
                                <input style="margin-top: 0px !important;" type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="{{ __('checkout.enter_last_name') }}" required>
                                <span class="invalid-feedback" id="error_last_name"></span>
                            </div>
                            <div class="box-field__row">
                                <!-- Phone Number 1 -->
                                <div class="box-field">
                                    <input style="margin-top: 0px !important;" type="tel" id="phone" name="phone" class="form-control"
                                        placeholder="{{ __('checkout.enter_phone') }}" maxlength="10" required>
                                    <span class="invalid-feedback" id="error_phone"></span>
                                </div>

                                <!-- Phone Number 2 -->
                                <div class="box-field">
                                    <input style="margin-top: 0px !important;" type="tel" id="phone2" name="phone2" class="form-control"
                                        placeholder="{{ __('checkout.enter_phone2') }}" maxlength="10">
                                    <span class="invalid-feedback" id="error_phone2"></span>
                                </div>

                            </div>
                            <div class="box-field">
                                <input style="margin-top: 0px !important;" disabled type="email" id="email" name="email" class="form-control"
                                    placeholder="{{ __('checkout.enter_email') }}" required>
                                <span class="invalid-feedback" id="error_email"></span>
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.delivery_info') }}</h6>

                            <!-- Delivery Location -->
                            <div class="box-field styled-select">
                                <select name="delivery_location_id" id="delivery-location" class="form-select" required>
                                    <option value="" disabled selected>{{ __('checkout.select_delivery_location') }}</option>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                                <span class="invalid-feedback" id="error_delivery_location_id"></span>
                            </div>

                            <div class="box-field styled-select">
                                <select id="area" name="area" class="form-select" required>
                                    <option value="" disabled selected>{{ __('checkout.select_area') }}</option>
                                    <!-- Options will be populated via AJAX -->
                                </select>
                                <span class="invalid-feedback" id="error_area"></span>
                            </div>
                            <!-- City -->
                            <div class="box-field">
                                <input style="margin-top: 0px !important;" type="text" id="city" name="city" class="form-control"
                                    placeholder="{{ __('checkout.enter_city') }}" required>
                                <span class="invalid-feedback" id="error_city"></span>
                            </div>

                            <!-- Address -->
                            <div class="box-field">
                                <input style="margin-top: 0px !important;" type="text" id="address" name="address" class="form-control"
                                    placeholder="{{ __('checkout.enter_address') }}" required>
                                <span class="invalid-feedback" id="error_address"></span>
                            </div>
                        </div>

                        <!-- Discount Code -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.apply_discount_code') }}</h6>
                            <div class="box-field d-flex" style="display: flex">
                                <input style="margin-top: 0px !important;" type="text" id="discount-code-input" class="form-control"
                                    placeholder="{{ __('checkout.enter_discount_code') }}">
                                <button type="button" id="apply-discount-btn"
                                    class="btn btn-primary mx-2">{{ __('checkout.apply') }}</button>
                                <button type="button" id="remove-discount-btn"
                                    class="btn btn-danger d-none">{{ __('checkout.remove') }}</button>
                            </div>
                            <div id="discount-message" class="mt-2">
                                <!-- Applied discount info will appear here -->
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.note') }}</h6>
                            <div class="box-field box-field__textarea">
                                <textarea id="note" name="note" class="form-control" placeholder="{{ __('checkout.order_note') }}"></textarea>
                                <span class="invalid-feedback" id="error_note"></span>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="checkout-buttons" style="margin-bottom: 30px;">
                            <a href="{{ route('cart.index') }}" class="btn btn-grey btn-icon">
                                <i class="icon-arrow"></i> {{ __('checkout.back') }}
                            </a>
                            <button type="submit" class="btn btn-icon btn-next">
                                {{ __('checkout.place_order') }} <i class="icon-arrow"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="checkout-info">
                    <div class="checkout-order">
                        <h5>{{ __('checkout.your_order') }}</h5>
                        <div id="order-items">
                            <!-- Order items will be populated via AJAX -->
                        </div>
                    </div>

                    <div class="cart-bottom__total">
                        <div class="cart-bottom__total-goods">
                            {{ __('checkout.goods') }}: <span id="goods-total">₪0.00</span>
                        </div>
                        <div class="cart-bottom__total-promo">
                            {{ __('checkout.discount_on_promo_code') }}:
                            <span id="discount-info">₪0.00</span>
                        </div>
                        <div class="cart-bottom__total-delivery">
                            {{ __('checkout.delivery') }}: <span
                                class="cart-bottom__total-delivery-date">{{ __('checkout.select_delivery_location_placeholder') }}</span>
                            <span>₪<span id="delivery-price-display">0.00</span></span>
                        </div>
                        <div class="cart-bottom__total-num">
                            {{ __('checkout.total') }}:
                            <span id="grand-total">₪0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <img class="promo-video__decor js-img" data-src="https://via.placeholder.com/1197x1371/FFFFFF"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" alt=""> --}}
    </div>
@endsection
@section('styles')
    <!-- Existing SweetAlert2 CSS -->
    <style>
        /* Custom styles */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
        }
    </style>
@endsection

@section('scripts')
    <!-- Removed intl-tel-input JS -->

    <script>
        $(document).ready(function() {
            // Set up AJAX to include CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize variables
            let deliveryPrice = 0.00;
            let discountAmount = 0.00;
            let goodsTotal = 0.00;
            let grandTotal = 0.00;

            // Function to validate phone numbers
            function validatePhoneNumbers() {
                let isValid = true;

                // Validate Phone 1
                let phone1 = $('#phone').val().trim();
                if (!/^\d{10}$/.test(phone1)) {
                    $('#phone').addClass('is-invalid');
                    $('#error_phone').text('{{ __('checkout.phone_must_be_10_digits') }}');
                    isValid = false;
                } else {
                    $('#phone').removeClass('is-invalid');
                    $('#error_phone').text('');
                }

                // Validate Phone 2 (if not empty)
                let phone2 = $('#phone2').val().trim();
                if (phone2 !== '') {
                    if (!/^\d{10}$/.test(phone2)) {
                        $('#phone2').addClass('is-invalid');
                        $('#error_phone2').text('{{ __('checkout.phone_must_be_10_digits') }}');
                        isValid = false;
                    } else {
                        $('#phone2').removeClass('is-invalid');
                        $('#error_phone2').text('');
                    }
                } else {
                    $('#phone2').removeClass('is-invalid');
                    $('#error_phone2').text('');
                }

                return isValid;
            }

            // Trigger validation on blur for Phone 1
            $('#phone').on('blur', function() {
                let phone = $(this).val().trim();
                if (!/^\d{10}$/.test(phone)) {
                    $(this).addClass('is-invalid');
                    $('#error_phone').text('{{ __('checkout.phone_must_be_10_digits') }}');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#error_phone').text('');
                }
            });

            // Trigger validation on blur for Phone 2
            $('#phone2').on('blur', function() {
                let phone = $(this).val().trim();
                if (phone !== '' && !/^\d{10}$/.test(phone)) {
                    $(this).addClass('is-invalid');
                    $('#error_phone2').text('{{ __('checkout.phone_must_be_10_digits') }}');
                } else {
                    $(this).removeClass('is-invalid');
                    $('#error_phone2').text('');
                }
            });

            // Function to fetch and populate delivery locations
            function loadDeliveryLocations() {
                $.ajax({
                    url: "{{ route('checkout.fetchDeliveryLocations') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            let options =
                                '<option value="" disabled selected>{{ __('checkout.select_delivery_location') }}</option>';
                            response.deliveryLocations.forEach(function(location) {
                                options +=
                                    `<option value="${location.id}" data-price="${parseFloat(location.price).toFixed(2)}">${location.city}, - ₪${parseFloat(location.price).toFixed(2)}</option>`;
                            });
                            $('#delivery-location').html(options);

                            // If there's an old value (e.g., validation error), select it and trigger change
                            @if (old('delivery_location_id'))
                                $('#delivery-location').val("{{ old('delivery_location_id') }}")
                                    .change();
                            @endif
                        } else {
                            console.error(response.message ||
                                '{{ __('checkout.error_fetching_delivery_locations') }}');
                            $('#delivery-message').text(response.message ||
                                '{{ __('checkout.error_fetching_delivery_locations') }}').addClass(
                                'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('{{ __('checkout.error_fetching_delivery_locations') }}');
                        $('#delivery-message').text(
                            '{{ __('checkout.error_fetching_delivery_locations') }}').addClass(
                            'error');
                    }
                });
            }

            // Function to fetch and populate user data and cart items
            function loadUserAndCartData() {
                $.ajax({
                    url: "{{ route('checkout.checkout.fetch') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Populate User Information
                            if (response.user) {
                                $('#first_name').val(response.user.first_name);
                                $('#last_name').val(response.user.last_name);
                                $('#email').val(response.user.email);
                                $('#phone').val(response.user.phone);
                                $('#phone').trigger('blur'); // Trigger validation
                            }

                            // Populate Cart Items
                            if (response.cartItems && response.cartItems.length > 0) {
                                let orderItemsHtml = '';
                                goodsTotal = 0.00; // Reset to avoid accumulation

                                response.cartItems.forEach(function(item) {
                                    orderItemsHtml += `
                                        <div class="checkout-order__item">
                                            <a href="#" class="checkout-order__item-img">
                                                <img src="${item.image_url}" class="js-img" alt="${item.name}">
                                            </a>
                                            <div class="checkout-order__item-info">
                                                <a class="title6" href="#">${item.name} <span>x${item.quantity}</span></a>
                                                <span class="checkout-order__item-price">₪${parseFloat(item.total).toFixed(2)}</span>
                                            </div>
                                        </div>
                                    `;
                                    goodsTotal += parseFloat(item.total);
                                });
                                $('#order-items').html(orderItemsHtml);
                                $('#goods-total').text(`₪${goodsTotal.toFixed(2)}`);
                                calculateGrandTotal();
                            } else {
                                $('#order-items').html('<p>{{ __('checkout.no_items_in_cart') }}</p>');
                                $('#goods-total').text(`₪0.00`);
                                calculateGrandTotal();
                            }

                            // If a discount is already applied, display it
                            if (response.discountCode) {
                                discountAmount = parseFloat(response.discountCode.amount);
                                let discountText = '';
                                if (response.discountCode.type === 'fixed') {
                                    discountText = `-₪${discountAmount.toFixed(2)}`;
                                } else if (response.discountCode.type === 'percentage') {
                                    discountText = `-${discountAmount.toFixed(2)}%`;
                                }

                                $('#discount-info').text(discountText);
                                $('#discount-code-input').prop('disabled', true);
                                $('#apply-discount-btn').hide();
                                $('#remove-discount-btn').removeClass('d-none');
                                $('#discount-message').html(`
                                    <div class="alert alert-success">
                                        {{ __('checkout.discount_applied_success') }}: <strong>${response.discountCode.code}</strong> ${discountText}
                                    </div>
                                `);
                                calculateGrandTotal();
                            }
                        } else {
                            console.error(response.message ||
                                '{{ __('checkout.error_fetching_cart_items') }}');
                            $('#cart-message').text(response.message ||
                                '{{ __('checkout.error_fetching_cart_items') }}').addClass('error');
                        }
                    },
                    error: function(xhr) {
                        console.error('{{ __('checkout.error_fetching_cart_items') }}');
                        $('#cart-message').text('{{ __('checkout.error_fetching_cart_items') }}')
                            .addClass('error');
                    }
                });
            }

            // Function to calculate and update the grand total
            function calculateGrandTotal() {
                grandTotal = goodsTotal + deliveryPrice - discountAmount;
                grandTotal = grandTotal < 0 ? 0 : grandTotal;
                $('#grand-total').text(`₪${grandTotal.toFixed(2)}`);
            }

            // Event listener for delivery location change
            $('#delivery-location').change(function() {
                let selectedOption = $(this).find('option:selected');
                let deliveryLocationId = $(this).val();
                deliveryPrice = parseFloat(selectedOption.data('price')) || 0.00;
                $('#delivery-price-display').text(deliveryPrice.toFixed(2));
                $('.cart-bottom__total-delivery-date').text('');
                calculateGrandTotal();
            });

            // Apply Discount Code
            $('#apply-discount-btn').click(function() {
                let discountCode = $('#discount-code-input').val().trim();
                let deliveryLocationId = $('#delivery-location').val();

                if (!discountCode) {
                    console.warn('{{ __('checkout.enter_discount_code') }}');
                    $('#discount-message').text('{{ __('checkout.enter_discount_code') }}').addClass(
                        'warning');
                    return;
                }

                if (!deliveryLocationId) {
                    console.warn('{{ __('checkout.select_delivery_location_first') }}');
                    $('#discount-message').text('{{ __('checkout.select_delivery_location_first') }}')
                        .addClass('warning');
                    return;
                }

                $.ajax({
                    url: "{{ route('checkout.applyDiscountCode') }}",
                    type: 'POST',
                    data: {
                        discount_code: discountCode,
                        delivery_price: deliveryPrice
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            discountAmount = parseFloat(response.discount_amount);
                            let discountText = '';
                            if (response.type === 'fixed') {
                                discountText = `- ₪${discountAmount.toFixed(2)}`;
                            } else if (response.type === 'percentage') {
                                discountText = `- ₪${discountAmount.toFixed(2)}`;
                            }

                            $('#discount-info').text(discountText);
                            $('#discount-code-input').prop('disabled', true);
                            $('#apply-discount-btn').hide();
                            $('#remove-discount-btn').removeClass('d-none');
                            $('#discount-message').html(`
                                <div class="alert alert-success">
                                    {{ __('checkout.discount_applied_success') }}: <strong>${response.code}</strong> ${discountText}
                                </div>
                            `);
                            calculateGrandTotal();
                            console.log('{{ __('checkout.discount_applied_success') }}');
                        } else {
                            // Display 'not found' message in a span
                            $('#discount-message').html(`
                                <span class="error">{{ __('checkout.discount_code_not_found') }}</span>
                            `);
                            console.error(response.message ||
                                '{{ __('checkout.error_applying_discount') }}');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = '{{ __('checkout.error_applying_discount') }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        // If discount code is not found
                        if (xhr.status === 400) { // Assuming 400 status for not found
                            $('#discount-message').html(`
                                <span class="error">{{ __('checkout.discount_code_not_found') }}</span>
                            `);
                            console.error('{{ __('checkout.discount_code_not_found') }}');
                        } else {
                            $('#discount-message').html(`
                                <span class="error">${errorMessage}</span>
                            `);
                            console.error(errorMessage);
                        }
                    }
                });
            });

            // Remove Discount Code
            $('#remove-discount-btn').click(function() {
                $.ajax({
                    url: "{{ route('checkout.removeDiscountCode') }}",
                    type: 'POST',
                    data: {},
                    success: function(response) {
                        if (response.status === 'success') {
                            discountAmount = 0.00;
                            $('#discount-info').text(`$0.00`);
                            $('#discount-code-input').prop('disabled', false).val('');
                            $('#apply-discount-btn').show();
                            $('#remove-discount-btn').addClass('d-none');
                            $('#discount-message').html('');
                            calculateGrandTotal();
                            console.log('{{ __('checkout.remove_discount_success') }}');
                        } else {
                            $('#discount-message').html(`
                                <span class="error">${response.message || '{{ __('checkout.error_removing_discount') }}'}</span>
                            `);
                            console.error(response.message ||
                                '{{ __('checkout.error_removing_discount') }}');
                        }
                    },
                    error: function(xhr) {
                        $('#discount-message').html(`
                            <span class="error">{{ __('checkout.error_removing_discount') }}</span>
                        `);
                        console.error('{{ __('checkout.error_removing_discount') }}');
                    }
                });
            });

            $('#delivery-location').change(function() {
                const cityId = $(this).val(); // This is the ID from your JSON
                if (cityId) {
                    $.ajax({
                        url: "{{ route('checkout.checkout.fetchAreas') }}",
                        type: 'GET',
                        data: {
                            city_id: cityId
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                let areaOptions =
                                    '<option value="" disabled selected>{{ __('checkout.select_area') }}</option>';
                                response.areas.forEach(area => {
                                    areaOptions +=
                                        `<option value="${area.id}">${area.name}</option>`;
                                });
                                $('#area').html(areaOptions);
                            } else {
                                alert('No areas found');
                            }
                        },
                        error: function() {
                            alert('Error fetching areas');
                        }
                    });
                }
            });

            $('#checkout-form').submit(function(e) {
                e.preventDefault(); // We'll handle the AJAX submission manually

                // Validate phone numbers before submission
                if (!validatePhoneNumbers()) {
                    console.error('{{ __('checkout.invalid_phone_numbers') }}');
                    return;
                }

                // ======================================
                // SHOW LOADING on "Place Order" button
                // ======================================
                const $placeOrderBtn = $(this).find('button[type="submit"]');
                $placeOrderBtn.prop('disabled', true);
                // You could also change the button text to indicate a loading state:
                $placeOrderBtn.html(
                    '<i class="fa fa-spinner fa-spin"></i> {{ __('checkout.place_order') }}');

                // Gather form data
                let formData = {
                    first_name: $('#first_name').val().trim(),
                    last_name: $('#last_name').val().trim(),
                    email: $('#email').val().trim(),
                    phone: $('#phone').val().trim(),
                    phone2: $('#phone2').val().trim(),
                    city: $('#city').val().trim(),
                    area: $('#area').val().trim(),
                    address: $('#address').val().trim(),
                    note: $('#note').val().trim(),
                    delivery_location_id: $('#delivery-location').val(),
                    discount_code: discountAmount > 0 ? $('#discount-code-input').val().trim() : null,
                };

                $.ajax({
                    url: "{{ route('checkout.submit') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log('{{ __('checkout.order_placed_successfully') }}');
                            // Optionally, redirect the user or display a success message
                            window.location.href = "/checkout/success/" + response.order_id;
                        } else {
                            // Show error
                            $('#checkout-message').html(
                                `<span class="error">${response.message || '{{ __('checkout.unexpected_error') }}'}</span>`
                            );
                            console.error(response.message ||
                                '{{ __('checkout.unexpected_error') }}');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            // Clear previous error states
                            $('.form-control').removeClass('is-invalid');
                            $('.invalid-feedback').text('');

                            for (let field in errors) {
                                $(`#error_${field}`).text(errors[field][0]);
                                $(`#${field}`).addClass('is-invalid');
                            }
                            console.error(
                                '{{ __('checkout.correct_errors') }}: {{ __('checkout.correct_errors_text') }}'
                                );
                            $('#checkout-message').html(
                                `<span class="error">{{ __('checkout.correct_errors') }}: {{ __('checkout.correct_errors_text') }}</span>`
                            );
                        } else {
                            $('#checkout-message').html(
                                `<span class="error">{{ __('checkout.unexpected_error') }}</span>`
                            );
                            console.error('{{ __('checkout.unexpected_error') }}');
                        }
                    },
                    complete: function() {
                        // ======================================
                        // HIDE LOADING or revert "Place Order" button
                        // ======================================
                        $placeOrderBtn.prop('disabled', false);
                        $placeOrderBtn.html(
                            '{{ __('checkout.place_order') }} <i class="icon-arrow"></i>');
                    }
                });
            });
            // Initial load
            loadDeliveryLocations();
            loadUserAndCartData();
        });
    </script>
@endsection
