<aside style="background-color:white;"
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <!-- Close Icon for Sidebar (Visible on Small Screens) -->
        <i class="fas fa-times p-3 cursor-pointer opacity-5 position-absolute end-0 top-0 d-xl-none" style="color: white"
            aria-hidden="true" id="iconSidenav"></i>

        <!-- Logo Container -->
        <a class="navbar-brand m-0 w-100" href="{{ route('admin.dashboard') }}">
            <div class="logo-container">
                <img src="{{ asset('user/img/cards-images/card-2.png') }}" class="navbar-brand-img" alt="main_logo">
            </div>
            {{-- Uncomment the following line if you want to add text next to the logo --}}
            {{-- <span style="color: #991d25;" class="ms-1 h4 font-weight-bold">CGM Admin</span> --}}
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        @if (Auth::check())
            <ul class="navbar-nav">

                @if (Auth::user()->role == 1)
                    <!-- 1. Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-home {{ Route::is('admin.dashboard') ? 'text-white' : 'text-icon' }}"></i>
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
                                <i
                                    class="fas fa-box-open {{ Route::is('admin.products.index') ? 'text-white' : 'text-icon' }}"></i>
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
                                <i
                                    class="fas fa-tags {{ Route::is('admin.brands.index') ? 'text-white' : 'text-icon' }}"></i>
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
                            <span class="nav-link-text ms-1">Cities</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.areas.index') ? 'active' : '' }}"
                            href="{{ route('admin.areas.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-map-marker-alt {{ Route::is('admin.areas.index') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Areas</span>
                        </a>
                    </li>

                    <!-- 7. Discount Codes -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.discount.index') ? 'active' : '' }}"
                            href="{{ route('admin.discount.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-percent {{ Route::is('admin.discount.index') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Discount Codes</span>
                        </a>
                    </li>
                    <!-- Logout -->
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
                @elseif(Auth::user()->role == 0)
                    <!-- User Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('user.dashboard') ? 'active' : '' }}"
                            href="{{ route('user.dashboard') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-home {{ Route::is('user.dashboard') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">@lang('dashboard.dashboard')</span>
                        </a>
                    </li>

                    <!-- User Orders -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('user.orders.index') ? 'active' : '' }}"
                            href="{{ route('user.orders.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-shopping-cart {{ Route::is('user.orders.index') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">@lang('dashboard.my_orders')</span>
                        </a>
                    </li>

                    
                    <!-- User Profile -->
                    {{-- <li class="nav-item">
                    <a class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user {{ Route::is('user.profile') ? 'text-white' : 'text-icon' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">@lang('dashboard.profile')</span>
                    </a>
                </li> --}}

                    <!-- Logout -->
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-sign-out-alt text-icon"></i>
                                </div>
                                <span class="nav-link-text ms-1">@lang('dashboard.logout')</span>
                            </a>
                        </form>
                    </li>
                @endif

            </ul>
        @endif
    </div>
</aside>
