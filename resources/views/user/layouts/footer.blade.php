<footer class="text-center" style="background-color: #971d25 !important;">
    <!-- Top Section: Logo -->
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Footer Logo -->
            <div class="d-flex align-items-center">
                <img src="{{ asset('user/img/logo-white-01.svg') }}" alt="@lang('home.header_logo_alt')" width="120">
            </div>

            <!-- Navigation Links -->
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link text-white fw-bold">
                        <i class="fas fa-home me-2"></i>{{ __('home.nav_home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shop.index') }}" class="nav-link text-white fw-bold">
                        <i class="fas fa-store me-2"></i>{{ __('home.nav_shop') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link text-white fw-bold">
                        <i class="fas fa-envelope me-2"></i>{{ __('home.nav_contact') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom Section: Wishlist, Cart, Social Media -->
    <div class="container mt-4">
        <div class="d-flex justify-content-end align-items-center">
            <!-- Social Media Icons -->
            <div class="d-flex gap-2 align-items-center">
                <a href="https://www.facebook.com" class="text-white me-3" target="_blank">
                    <i class="icon-facebook"></i>
                </a>
                <a href="https://www.instagram.com" class="text-white" target="_blank">
                    <i class="icon-insta"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3 mt-4" style="background-color: rgba(0, 0, 0, 0.05);">
        <span class="text-white">© 2020 Copyright:</span>
        <a class="text-white text-decoration-none" href="https://mdbootstrap.com/">MDBootstrap.com</a>
    </div>
</footer>