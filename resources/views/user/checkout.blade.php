@extends('user.layouts.app')

@section('title', __('checkout.title'))

<style>
.form-control {
    margin-top: 0px !important;
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

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    display: block;
    color: #dc3545;
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
                    <form id="checkout-form" method="POST" action="{{ route('checkout.submit') }}" novalidate>
                        @csrf

                        <!-- User Information -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.info_about_you') }}</h6>
                            <div class="box-field">
                                <input type="text" id="first_name" name="first_name" class="form-control"
                                    placeholder="{{ __('checkout.enter_first_name') }}" required>
                                <span class="invalid-feedback" id="error_first_name"></span>
                            </div>
                            <div class="box-field">
                                <input type="text" id="last_name" name="last_name" class="form-control"
                                    placeholder="{{ __('checkout.enter_last_name') }}" required>
                                <span class="invalid-feedback" id="error_last_name"></span>
                            </div>
                            <!-- Phone Number 1 -->
                            <div class="box-field">
                                <input type="tel" id="phone" name="phone" class="form-control"
                                    placeholder="{{ __('checkout.enter_phone') }}" pattern="05\d{8}" maxlength="10" required>
                                <span class="invalid-feedback" id="error_phone"></span>
                            </div>

                            <!-- Phone Number 2 -->
                            <div class="box-field">
                                <input type="tel" id="phone2" name="phone2" class="form-control"
                                    placeholder="{{ __('checkout.enter_phone2') }}" maxlength="10" required>
                                <span class="invalid-feedback" id="error_phone2"></span>
                            </div>
                            <div class="box-field">
                                <input disabled type="email" id="email" name="email" class="form-control"
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
                                <input type="text" id="city" name="city" class="form-control"
                                    placeholder="{{ __('checkout.enter_city') }}" required>
                                <span class="invalid-feedback" id="error_city"></span>
                            </div>

                            <!-- Address -->
                            <div class="box-field">
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="{{ __('checkout.enter_address') }}" required>
                                <span class="invalid-feedback" id="error_address"></span>
                            </div>
                        </div>

                        <!-- Discount Code -->
                        <div class="checkout-form__item">
                            <h6>{{ __('checkout.apply_discount_code') }}</h6>
                            <div class="box-field d-flex">
                                <input type="text" id="discount-code-input" class="form-control"
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
                        <div id="checkout-message" class="invalid-feedback d-none"></div>
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('user/js/checkout.js') }}"></script>
@endsection
