const lang = document.documentElement.lang || 'en'; 

let msg = {
    ar: {
        invalid_phone_number: 'رقم الهاتف غير صالح, يجب أن يكون مكونًا من 10 أرقام',
        enter_discount_code: 'ادخل رمز الخصم',
        code_not_found: 'الرمز غير موجود',
        error_applying_discount: 'حدث خطأ أثناء تطبيق الخصم',
        error_removing_discount: 'حدث خطأ أثناء إزالة الخصم',
        error_fetching_data: 'خطأ في جلب البيانات',
        unexpected_error: 'خطأ غير متوقع',
        select_delivery_location: 'اختر موقع التسليم',
        no_items_in_cart: 'لا توجد عناصر في السلة',
        discount_applied_successfully: 'تم تطبيق الخصم بنجاح',
        correct_errors_text: 'الرجاء تصحيح الأخطاء في النموذج قبل المتابعة',
        select: 'اختر',
        placing_order: 'جاري إتمام الطلب',
    },
    en: {
        invalid_phone_number: 'Invalid phone numbers, phone must be 10 digits',
        enter_discount_code: 'Enter discount code',
        code_not_found: 'Code not found',
        error_applying_discount: 'Error applying discount',
        error_removing_discount: 'Error removing discount',
        unexpected_error: 'Unexpected error',  
        select_delivery_location: 'Select delivery location',
        no_items_in_cart: 'No items in cart',
        discount_applied_successfully: 'Discount applied successfully',
        error_fetching_data: 'Error fetching data',
        correct_errors_text: 'Please correct the errors in the form before proceeding',
        select: 'Select',
        placing_order: 'Placing order',
    },
    he: {
        invalid_phone_number: 'מספר טלפון לא תקין, מספר הטלפון חייב להיות בן 10 ספרות',
        enter_discount_code: 'הכנס קוד הנחה',
        code_not_found: 'קוד לא נמצא',
        error_applying_discount: 'שגיאה בהחלת ההנחה',
        error_removing_discount: 'שגיאה בהסרת ההנחה',
        unexpected_error: 'שגיאה בלתי צפויה',
        select_delivery_location: 'בחר מיקום משלוח',
        no_items_in_cart: 'אין פריטים בעגלת הקניות',
        discount_applied_successfully: 'ההנחה הוחלה בהצלחה',
        error_fetching_data: 'שגיאה בטעינת הנתונים',
        correct_errors_text: 'נא לתקן את השגיאות בטופס לפני ההמשך',
        select: 'בחר',
        placing_order: 'מבצע הזמנה',
    }
}

let localMsg = msg[lang]; // Fallback to English if language not found

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
            $(errorSelector).text(localMsg['invalid_phone_number']);
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
                $(errorSelector).text(localMsg['invalid_phone_number']);
            } else {
                $(this).removeClass('is-invalid');
                $(errorSelector).text('');
            }
        });
    }

    // Trigger validation on blur for Phone 1 and Phone 2
    handlePhoneBlur('#phone', '#error_phone');
    handlePhoneBlur('#phone2', '#error_phone2');

    function loadCheckout() {
        $.ajax({
            url: baseURL + '/checkout/fetch-checkout',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // -------------------
                    // 1. Populate User Info
                    // -------------------
                    if (response.user) {
                        $('#first_name').val(response.user.first_name);
                        $('#last_name').val(response.user.last_name);
                        $('#email').val(response.user.email);
                        $('#phone').val(response.user.phone);
                        $('#phone').trigger('blur');
                    }

                    // -------------------
                    // 2. Populate Cart Items
                    // -------------------
                    if (response.cartItems && response.cartItems.length > 0) {
                        let orderItemsHtml = '';
                        goodsTotal = 0.00;

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
                        $('#order-items').html(`<p>localMsg['no_items_in_cart']</p>`);
                        $('#goods-total').text(`₪0.00`);
                        calculateGrandTotal();
                    }

                    // -------------------
                    // 3. Populate Discount Info
                    // -------------------
                    if (response.discountCode) {
                        discountAmount = parseFloat(response.discountCode.amount);
                        let discountText = `- ₪${discountAmount.toFixed(2)}`;

                        $('#discount-info').text(discountText);
                        $('#discount-code-input').prop('disabled', true);
                        $('#apply-discount-btn').hide();
                        $('#remove-discount-btn').removeClass('d-none');
                        $('#discount-message').html(`
                            <div class="alert alert-success">
                                ${response.discountCode.message}: <strong>${response.discountCode.code}</strong> ${discountText}
                            </div>
                        `);
                        calculateGrandTotal();
                    }

                    // -------------------
                    // 4. Populate Delivery Locations
                    // -------------------
                    if (response.deliveryLocations) {
                        let options = `<option value="" disabled selected>${localMsg['select_delivery_location']}</option>`;
                        response.deliveryLocations.forEach(function(location) {
                            options += `<option value="${location.id}" data-price="${parseFloat(location.price).toFixed(2)}">${location.city}, - ₪${parseFloat(location.price).toFixed(2)}</option>`;
                        });
                        $('#delivery-location').html(options);
                    }

                } else {
                    $('#cart-message').text(response.message || localMsg['error_fetching_data']).addClass('error');
                }
            },
            error: function() {
                $('#cart-message').text(localMsg['error_fetching_data']).addClass('error');
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
    
        deliveryPrice = parseFloat(selectedOption.data('price')) || 0.00;
        $('#delivery-price-display').text(deliveryPrice.toFixed(2));
        $('.cart-bottom__total-delivery-date').text('');
        calculateGrandTotal();
    });

    // Apply Discount Code
    $('#apply-discount-btn').click(function() {
        let discountCode = $('#discount-code-input').val().trim();

        if (!discountCode) {
            $('#discount-message').text(localMsg['enter_discount_code']).addClass(
                'warning');
            return;
        }

        $.ajax({
            url: baseURL + '/apply-discount-code',
            type: 'POST',
            data: {
                discount_code: discountCode,
                delivery_price: deliveryPrice
            },
            success: function(response) {
                if (response.status === 'success') {
                    discountAmount = parseFloat(response.discount_amount);
                    let discountText = `- ₪${discountAmount.toFixed(2)}`;
                    let discountMessage = response.message || localMsg['discount_applied_successfully'];

                    $('#discount-info').text(discountText);
                    $('#discount-code-input').prop('disabled', true);
                    $('#apply-discount-btn').hide();
                    $('#remove-discount-btn').removeClass('d-none');
                    $('#discount-message').html(`
                        <div class="alert alert-success">
                            ${discountMessage}: <strong>${discountCode}</strong> ${discountText}
                        </div>
                    `);
                    calculateGrandTotal();
                } else {
                    // Display 'not found' message in a span
                    $('#discount-message').html(`
                        <span class="error">${localMsg['code_not_found']}</span>
                    `);
                }
            },
            error: function(xhr) {
                let errorMessage = localMsg['error_applying_discount'];
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                // If discount code is not found
                if (xhr.status === 400) { // Assuming 400 status for not found
                    $('#discount-message').html(`
                        <span class="error">${localMsg['code_not_found']}</span>
                    `);
                } else {
                    $('#discount-message').html(`
                        <span class="error">${errorMessage}</span>
                    `);
                }
            }
        });
    });

    // Remove Discount Code
    $('#remove-discount-btn').click(function() {
        $.ajax({
            url: baseURL + '/remove-discount-code',
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
                } else {
                    $('#discount-message').html(`
                        <span class="error">${response.message || localMsg['error_removing_discount']}</span>
                    `);
                }
            },
            error: function(xhr) {
                $('#discount-message').html(`
                    <span class="error">${localMsg['error_removing_discount']}</span>
                `);
            }
        });
    });

    $('#delivery-location').change(function() {
        const cityId = $(this).val(); // This is the ID from your JSON
        if (cityId) {
            $.ajax({
                url: baseURL + '/checkout/fetch-areas',
                type: 'GET',
                data: {
                    city_id: cityId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let areaOptions =
                            `<option value="" disabled selected>-- ${localMsg['select']} --</option>`;
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
            console.error(localMsg['invalid_phone_number']);
            return;
        }

        // ======================================
        // SHOW LOADING on "Place Order" button
        // ======================================
        const $placeOrderBtn = $(this).find('button[type="submit"]');
        $placeOrderBtn.prop('disabled', true);
        // You could also change the button text to indicate a loading state:
        $placeOrderBtn.html(
            `<i class="fa fa-spinner fa-spin"></i> ${localMsg['placing_order']}...`);

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
                    // Optionally, redirect the user or display a success message
                    window.location.href = "/checkout/success/";
                } else {
                    // Show error
                    $('#checkout-message').html(
                        `<span class="error">${response.message || localMsg['unexpected_error']}</span>`
                    );
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
                    $('#checkout-message').html(
                        `<span class="error">${localMsg['correct_errors_text']}</span>`
                    );
                } else {
                    $('#checkout-message').html(
                        `<span class="error">${localMsg['unexpected_error']}</span>`
                    );
                }
            },
            complete: function() {
                $placeOrderBtn.prop('disabled', false);
                $placeOrderBtn.html(
                    '<i class="icon-arrow"></i>');
            }
        });
    });

    // Initial load
    loadCheckout();
});

