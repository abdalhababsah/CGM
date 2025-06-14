<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="it-rating" content="it-rat-cd303c3f80473535b3c667d0d67a7a11">
    <meta name="cmsmagazine" content="3f86e43372e678604d35804a67860df7">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    <title>@yield('title')</title>
    <meta name="keywords" content="cgm products, curly hair products, shampoo for curly hair, skala products, curl cream, curly hair, cgm in palestine, ملفلف, منتجات شعر, شعر مجعد, شامبو للشعر المجعد, كريم للشعر المجعد" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">
    @yield('meta')
    <link rel="icon" type="image/png" href="{{ asset('user/img/logo-icon.png') }}">

    <!-- Load Default CSS -->
    <link rel="stylesheet" href="{{ asset('user/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('user/sweetalert/sweetalert2.min.css') }}">
    <!-- Conditionally Load RTL CSS -->
    @yield('styles')
    @if (in_array(app()->getLocale(), ['ar', 'he']))
        <link rel="stylesheet" href="{{ asset('user/css/rtlcss.css') }}">
    @endif
</head>

<style>
    .detail-block .overlay {
        position: absolute !important;
        /* Positions the overlay relative to .detail-block */
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
        /* Black with 50% opacity */
        z-index: 2 !important;
    }
</style>

<body class="loaded">

    <!-- BEGIN BODY -->

    <div class="main-wrapper">

        <!-- BEGIN CONTENT -->

        <main class="content">

        </main>

        <!-- CONTENT EOF   -->

        <!-- BEGIN HEADER -->

        @include('user.layouts.header')

        <!-- HEADER EOF   -->
        @yield('content')
        <!-- BEGIN FOOTER -->

        @include('user.layouts.footer')

        <!-- FOOTER EOF   -->

    </div>

    <div class="icon-load"></div>

    <!-- BODY EOF   -->
    <script src="{{ asset('user/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('user/js/ion.rangeSlider.min.js') }}" defer></script>
    <script src="{{ asset('user/js/jquery.maskedinput.js') }}" defer></script>
    <script src="{{ asset('user/js/jquery.formstyler.js') }}" defer></script>
    <script src="{{ asset('user/sweetalert/sweetalert2.min.js') }}" defer></script>
    <script src="{{ asset('user/js/lazyload.min.js') }}" defer></script>
    <script src="{{ asset('user/js/slick.min.js') }}" defer></script>
    <script src="{{ asset('user/js/customs.js') }}" defer></script>


    <script defer>
        $(document).ready(function() {
            // Setup CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /**
             * Function to fetch and update the cart count.
             */
            function updateGlobalCartCount() {
                $.ajax({
                    url: "{{ route('cart.count') }}",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('#cart-count').text(response.cart_count);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching cart count:', error);
                    }
                });
            }

            // Make updateCartCount globally accessible
            window.updateGlobalCartCount = updateGlobalCartCount;

            // Initial cart count fetch on page load
            updateGlobalCartCount();
        });
    </script>
    @yield('scripts')
</body>

</html>
