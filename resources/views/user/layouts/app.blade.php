<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="it-rating" content="it-rat-cd303c3f80473535b3c667d0d67a7a11">
    <meta name="cmsmagazine" content="3f86e43372e678604d35804a67860df7">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    <title>@yield('title')</title>
    <meta name='description' content="" />
    <meta name="keywords" content="" />
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Load Default CSS -->
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">

    <!-- Conditionally Load RTL CSS -->
    @if (in_array(app()->getLocale(), ['ar', 'he']))
        <link rel="stylesheet" href="{{ asset('user/css/rtl.css') }}">
    @endif
</head>

    @yield('styles')

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
    <script src="{{asset('user/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{ asset('user/js/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('user/js/jquery.formstyler.js') }}"></script>

    <script src="{{ asset('user/js/lazyload.min.js') }}"></script>
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <script src="{{ asset('user/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    @yield('scripts')
</body>

</html>