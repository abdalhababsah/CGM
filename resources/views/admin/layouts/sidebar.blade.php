<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('/') }}">
            <img src="{{ asset('admin/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Soft UI Dashboard 3</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home {{ Route::is('admin.dashboard') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <!-- Brands -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.brands.index') ? 'active' : '' }}"
                    href="{{ route('admin.brands.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tags {{ Route::is('admin.brands.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Brands</span>
                </a>
            </li>
            <!-- Categories -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.categories.index') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-list-alt {{ Route::is('admin.categories.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>
            <!-- Products -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-box {{ Route::is('admin.products.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <!-- Orders -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.orders.index') ? 'active' : '' }}"
                    href="{{ route('admin.orders.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shopping-cart {{ Route::is('admin.orders.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>
            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('profile') ? 'active' : '' }}" href="">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user {{ Route::is('profile') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <!-- Sign In -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-in-alt text-icon"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <!-- Sign Up -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus text-icon"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>
</aside>