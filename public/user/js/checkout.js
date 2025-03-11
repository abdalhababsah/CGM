$(document).ready(function() {

    let baseURL = $('meta[name="url"]').attr('content');

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

        isValid = validatePhone('#phone', '#error_phone');
        isValid = validatePhone('#phone2', '#error_phone2');

        return isValid;
    }

    function validatePhone(phoneSelector, errorSelector) {
        let phone = $(phoneSelector).val().trim();

        if (!/^\d{10}$/.test(phone)) {
            $(phoneSelector).addClass('is-invalid');
            $(errorSelector).text('phone_must_be_10_digits');
            return false;
        } else {
            $(phoneSelector).removeClass('is-invalid');
            $(errorSelector).text('');
            return true;
        }
    }

    // Function to handle phone validation on blur
    function handlePhoneBlur(phoneSelector, errorSelector) {
        $(phoneSelector).on('blur', function() {
            let phone = $(this).val().trim();
            if (!/^\d{10}$/.test(phone)) {
                $(this).addClass('is-invalid');
                $(errorSelector).text('phone_must_be_10_digits');
            } else {
                $(this).removeClass('is-invalid');
                $(errorSelector).text('');
            }
        });
    }

    // Trigger validation on blur for Phone 1 and Phone 2
    handlePhoneBlur('#phone', '#error_phone');
    handlePhoneBlur('#phone2', '#error_phone2');

    // Function to fetch and populate delivery locations
    function loadDeliveryLocations() {
        $.ajax({
            url: baseURL + '/checkout/fetch-delivery-locations',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let options =
                        '<option value="" disabled selected> select delivery location </option>';
                    response.deliveryLocations.forEach(function(location) {
                        options +=
                            `<option value="${location.id}" data-price="${parseFloat(location.price).toFixed(2)}">${location.city}, - ₪${parseFloat(location.price).toFixed(2)}</option>`;
                    });
                    $('#delivery-location').html(options);

                } else {
                    console.error(response.message ||
                        'error_fetching_delivery_locations');
                    $('#delivery-message').text(response.message ||
                        'checkout.error_fetching_delivery_locations').addClass(
                        'error');
                }
            },
            error: function(xhr) {
                console.error('.error_fetching_delivery_locations');
                $('#delivery-message').text(
                    '.error_fetching_delivery_locations').addClass(
                    'error');
            }
        });
    }

    // Function to fetch and populate user data and cart items
    function loadUserAndCartData() {
        $.ajax({
            url: baseURL + '/checkout/fetch-checkout',
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
                        $('#order-items').html('<p>no_items_in_cart</p>');
                        $('#goods-total').text(`₪0.00`);
                        calculateGrandTotal();
                    }

                    // If a discount is already applied, display it
                    if (response.discountCode) {
                        discountAmount = parseFloat(response.discountCode.amount);
                        let discountText = `- ₪${discountAmount.toFixed(2)}`;

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
                        'checkout.error_fetching_cart_items');
                    $('#cart-message').text(response.message ||
                        'checkout.error_fetching_cart_items').addClass('error');
                }
            },
            error: function(xhr) {
                console.error('checkout.error_fetching_cart_items');
                $('#cart-message').text('checkout.error_fetching_cart_items')
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
            console.warn('checkout.enter_discount_code');
            $('#discount-message').text('checkout.enter_discount_code').addClass(
                'warning');
            return;
        }

        $.ajax({
            url: baseURL + '/checkout/apply-discount-code',
            type: 'POST',
            data: {
                discount_code: discountCode,
                delivery_price: deliveryPrice
            },
            success: function(response) {
                if (response.status === 'success') {
                    discountAmount = parseFloat(response.discount_amount);
                    let discountText = `- ₪${discountAmount.toFixed(2)}`;

                    $('#discount-info').text(discountText);
                    $('#discount-code-input').prop('disabled', true);
                    $('#apply-discount-btn').hide();
                    $('#remove-discount-btn').removeClass('d-none');
                    $('#discount-message').html(`
                        <div class="alert alert-success">
                            discount_applied_success: <strong>${discountCode}</strong> ${discountText}
                        </div>
                    `);
                    calculateGrandTotal();
                    console.log('discount_applied_success');
                } else {
                    // Display 'not found' message in a span
                    $('#discount-message').html(`
                        <span class="error">{{ __('checkout.discount_code_not_found') }}</span>
                    `);
                    console.error(response.message ||error_applying_discount);

                }
            },
            error: function(xhr) {
                let errorMessage = 'error_applying_discount';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                // If discount code is not found
                if (xhr.status === 400) { // Assuming 400 status for not found
                    $('#discount-message').html(`
                        <span class="error">{{ __('checkout.discount_code_not_found') }}</span>
                    `);
                    console.error('discount_code_not_found');
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
            url: baseURL + '/checkout/remove-discount-code',
            type: 'POST',
            data: {},
            success: function(response) {
                if (response.status === 'success') {
                    discountAmount = 0.00;
                    $('#discount-info').text(`0.00`);
                    $('#discount-code-input').prop('disabled', false).val('');
                    $('#apply-discount-btn').show();
                    $('#remove-discount-btn').addClass('d-none');
                    $('#discount-message').html('');
                    calculateGrandTotal();
                    console.log('remove_discount_success');
                } else {
                    $('#discount-message').html(`
                        <span class="error">${response.message || 'error_removing_discount'}</span>
                    `);
                    console.error(response.message ||
                        'error_removing_discount');
                }
            },
            error: function(xhr) {
                $('#discount-message').html(`
                    <span class="error">error_removing_discount</span>
                `);
                console.error('error_removing_discount');
            }
        });
    });

    $('#delivery-location').change(function() {
        const cityId = $(this).val(); // This is the ID from your JSON
        if (cityId) {
            $.ajax({
                url: baseURL + '/checkout/checkout/fetch-areas',
                type: 'GET',
                data: {
                    city_id: cityId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let areaOptions =
                            '<option value="" disabled selected> -- select -- </option>';
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
            console.error('invalid_phone_numbers');
            return;
        }

        // ======================================
        // SHOW LOADING on "Place Order" button
        // ======================================
        const $placeOrderBtn = $(this).find('button[type="submit"]');
        $placeOrderBtn.prop('disabled', true);
        // You could also change the button text to indicate a loading state:
        $placeOrderBtn.html(
            '<i class="fa fa-spinner fa-spin"></i> order placing...');

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
            url: baseURL + '/checkout/submit',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    console.log('order_placed_successfully');
                    // Optionally, redirect the user or display a success message
                    window.location.href = "/checkout/success/";
                } else {
                    // Show error
                    $('#checkout-message').html(
                        `<span class="error">${response.message || 'unexpected_error'}</span>`
                    );
                    console.error(response.message || 'unexpected_error');
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
                        'checkout.correct_errors'
                        );
                    $('#checkout-message').html(
                        `<span class="error">checkout.correct_errors_text</span>`
                    );
                } else {
                    $('#checkout-message').html(
                        `<span class="error">unexpected_error</span>`
                    );
                    console.error('unexpected_error');
                }
            },
            complete: function() {
                $placeOrderBtn.prop('disabled', false);
                $placeOrderBtn.html(
                    'place_order <i class="icon-arrow"></i>');
            }
        });
    });
    // Initial load
    loadDeliveryLocations();
    loadUserAndCartData();
});

