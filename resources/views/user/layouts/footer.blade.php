<footer class="text-center" style="background-color: #971d25;">
    <!-- Top Section: Logo -->
    <div class="container py-4">
        <div id="footer-header" class="d-flex flex-row flex-md-row justify-content-between align-items-center">
            <!-- Footer Logo -->
            <div class="d-flex align-items-center mb-3 mb-md-0">
                <img src="{{ asset('user/img/logo-white-01.svg') }}" alt="@lang('home.header_logo_alt')" width="60">
            </div>

            <!-- Navigation Links -->
            <ul id="footer-nav-links" class="nav flex-column flex-md-row">
                <li class="nav-item">
                    <a style="color: white !important" href="{{ route('home') }}" class="nav-link text-white fw-bold px-2">
                        <i class="fas fa-home me-2"></i>{{ __('home.nav_home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a style="color: white !important" href="{{ route('shop.index') }}" class="nav-link text-white fw-bold px-2">
                        <i class="fas fa-store me-2"></i>{{ __('home.nav_shop') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a style="color: white !important" href="{{ route('contact') }}" class="nav-link text-white fw-bold px-2">
                        <i class="fas fa-envelope me-2"></i>{{ __('home.nav_contact') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom Section: Wishlist, Cart, Social Media -->
    <div class="container ">
        <div class="d-flex justify-content-center justify-content-md-end align-items-center">
            <!-- Social Media Icons -->
            <div style="padding: 4px;" class="d-flex gap-3">
                <a href="https://www.facebook.com" class="text-white" target="_blank">
                    <i class="icon-facebook"></i>
                </a>
                <a href="https://www.instagram.com" class="text-white" target="_blank">
                    <i class="icon-insta"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div style="padding: 10px; color:white;" class="text-center mt-4" style="background-color: rgba(0, 0, 0, 0.05);">
        <span style="color: white">© {{ now()->year }} Copyright:</span>
        <a style="color: white" class="text-white text-decoration-none" href="#">CGM</a>
    </div>
    <div style="padding: 10px;background-color:#c98a88; " class="text-center mt-4" style="background-color: rgba(0, 0, 0, 0.05);">
        <span style=" color:white;" class="text-white">Devloped By </span>
        <a style=" color:white;" class="text-white text-decoration-none" href="https://www.thirtysix36.com/">ThirtySix36</a>
    </div>
</footer>