<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('user\img\logo-mini.png') }}">

    <!-- Dynamic Title -->
    <title>
        @yield('title', 'CGM Dashboard')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('admin/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    @if (Auth::check() && Auth::user()->role == 0 && in_array(app()->getLocale(), ['ar', 'he']))
        <link rel="stylesheet" href="{{ asset('admin/assets/css/rtlstyles.css') }}">
    @endif

    <!-- Soft UI Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('user/sweetalert/sweetalert2.min.css') }}">
    <link id="pagestyle" href="{{ asset('admin/assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin/assets/js/quill.snow.css') }}" rel="stylesheet">
    <script src="{{ asset('admin/assets/js/quill.js.map') }}"></script>
    <script src="{{ asset('admin/assets/js/quill.js') }}"></script>
    <!-- Additional CSS (Page-Specific) -->
    @stack('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

    <!-- Sidebar Include -->
    @include('dashboard-layouts.sidebar')

    <!-- Main Content Area -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- Navbar Include -->
        @include('dashboard-layouts.header')

        <!-- Page Content -->
        @yield('content')

    </main>

    <!-- Core JS Files -->
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins/chartjs.min.js') }}"></script>


    <script>
        // Initialize Scrollbar for Windows Platform
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            };
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script src="{{ asset('admin/assets/js/soft-ui-dashboard.min.js?v=1.1.0') }}"></script>
    <script src="{{ asset('user/sweetalert/sweetalert2.min.js') }}"></script>

    <!-- Additional Scripts (Page-Specific) -->
    @stack('scripts')

</body>

</html>
