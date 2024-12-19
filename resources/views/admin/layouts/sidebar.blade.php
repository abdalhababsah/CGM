<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-3" href="{{ route('admin.dashboard') }}">
            {{-- <img src="{{ asset('user/img/icons/red-logo.png') }}" class="navbar-brand-img h-100" alt="main_logo"> --}}
            <span style="color: #991d25; " class="ms-1 h4 font-weight-bold">CGM Admin</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- 1. Dashboard -->
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

            <!-- 2. Products -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-box-open {{ Route::is('admin.products.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>

            <!-- 3. Orders -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.orders.index') ? 'active' : '' }}"
                    href="{{ route('admin.orders.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-shopping-cart {{ Route::is('admin.orders.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Orders</span>
                </a>
            </li>

            <!-- 4. Brands -->
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

            <!-- 5. Categories -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.categories.index') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-list-alt {{ Route::is('admin.categories.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Categories</span>
                </a>
            </li>

            <!-- 6. Delivery Locations -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.deliveries.index') ? 'active' : '' }}"
                    href="{{ route('admin.deliveries.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-map-marker-alt {{ Route::is('admin.deliveries.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Delivery Locations</span>
                </a>
            </li>

            <!-- 7. Discount Codes -->
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.discount.index') ? 'active' : '' }}"
                    href="{{ route('admin.discount.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-percent {{ Route::is('admin.discount.index') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Discount Codes</span>
                </a>
            </li>

            <!-- 8. Profile -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user {{ Route::is('profile') ? 'text-white' : 'text-icon' }}"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li> --}}

            <!-- 9. Logout -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt text-icon"></i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </form>
            </li>

            <!-- 10. Sign Up -->
            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-plus text-icon"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>