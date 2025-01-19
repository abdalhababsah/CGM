<aside style="background-color:white;"
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
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
            <ul class="navbar-nav custom-navbar-nav"> <!-- Added 'custom-navbar-nav' class -->
                @if (Auth::user()->role == 1)
                    <!-- Main Section -->
                    <li class="nav-item">
                        <span
                            class="nav-section-title ms-3 mt-2 mb-1 text-uppercase text-xs font-weight-bolder opacity-6">
                            Main
                        </span>
                    </li>
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

                    <!-- Products Section with Dropdown -->
                    @php
                        $productsActive =
                            Route::is('admin.products.index') ||
                            Route::is('admin.brands.index') ||
                            Route::is('admin.categories.index');
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $productsActive ? '' : '' }}" data-bs-toggle="collapse"
                            href="#productsMenu" role="button" aria-expanded="{{ $productsActive ? 'true' : 'false' }}"
                            aria-controls="productsMenu">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-box-open text-icon"></i>
                            </div>
                            <span class="nav-link-text ms-1">Products</span>
                        </a>
                        <div class="collapse {{ $productsActive ? 'show' : '' }}" id="productsMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.products.index') ? 'active' : '' }}"
                                        href="{{ route('admin.products.index') }}">
                                        <span class="nav-link-text ms-2">All Products</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.brands.index') ? 'active' : '' }}"
                                        href="{{ route('admin.brands.index') }}">
                                        <span class="nav-link-text ms-2">Brands</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.categories.index') ? 'active' : '' }}"
                                        href="{{ route('admin.categories.index') }}">
                                        <span class="nav-link-text ms-2">Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-users {{ Route::is('admin.users.index') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">Users</span>
                        </a>
                    </li>
                    <!-- Inventory Section with Dropdown -->
                    @php
                        $inventoryActive =
                            Route::is('admin.hair-thickness.index') ||
                            Route::is('admin.hair-type.index') ||
                            Route::is('admin.hair-pore.index');
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $inventoryActive ? '' : '' }}" data-bs-toggle="collapse"
                            href="#inventoryMenu" role="button"
                            aria-expanded="{{ $inventoryActive ? 'true' : 'false' }}" aria-controls="inventoryMenu">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-cube text-icon"></i>
                            </div>
                            <span class="nav-link-text ms-1">Hair</span>
                        </a>
                        <div class="collapse {{ $inventoryActive ? 'show' : '' }}" id="inventoryMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.hair-thickness.index') ? 'active' : '' }}"
                                        href="{{ route('admin.hair-thickness.index') }}">
                                        <span class="nav-link-text ms-2">Hair Thickness</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.hair-type.index') ? 'active' : '' }}"
                                        href="{{ route('admin.hair-type.index') }}">
                                        <span class="nav-link-text ms-2">Hair Types</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.hair-pore.index') ? 'active' : '' }}"
                                        href="{{ route('admin.hair-pore.index') }}">
                                        <span class="nav-link-text ms-2">Hair Pores</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Orders Section -->
                    <li class="nav-item">
                        <span
                            class="nav-section-title ms-3 mt-2 mb-1 text-uppercase text-xs font-weight-bolder opacity-6">
                            Orders
                        </span>
                    </li>
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

                    <!-- Deliveries Section with Dropdown -->
                    @php
                        $deliveriesActive = Route::is('admin.deliveries.index') || Route::is('admin.areas.index');
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link {{ $deliveriesActive ? '' : '' }}" data-bs-toggle="collapse"
                            href="#deliveriesMenu" role="button"
                            aria-expanded="{{ $deliveriesActive ? 'true' : 'false' }}" aria-controls="deliveriesMenu">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-map-marker-alt text-icon"></i>
                            </div>
                            <span class="nav-link-text ms-1">Deliveries</span>
                        </a>
                        <div class="collapse {{ $deliveriesActive ? 'show' : '' }}" id="deliveriesMenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.deliveries.index') ? 'active' : '' }}"
                                        href="{{ route('admin.deliveries.index') }}">
                                        <span class="nav-link-text ms-2">Cities</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.areas.index') ? 'active' : '' }}"
                                        href="{{ route('admin.areas.index') }}">
                                        <span class="nav-link-text ms-2">Areas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Marketing Section -->
                    <li class="nav-item">
                        <span
                            class="nav-section-title ms-3 mt-2 mb-1 text-uppercase text-xs font-weight-bolder opacity-6">
                            Marketing
                        </span>
                    </li>
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

                    <!-- CMS Section -->
                    <li class="nav-item">
                        <span
                            class="nav-section-title ms-3 mt-2 mb-1 text-uppercase text-xs font-weight-bolder opacity-6">
                            CMS
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('admin.cms-management.index') ? 'active' : '' }}"
                            href="{{ route('admin.cms-management.index') }}">
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i
                                    class="fas fa-file-alt text-icon {{ Route::is('admin.cms-management.index') ? 'text-white' : 'text-icon' }}"></i>
                            </div>
                            <span class="nav-link-text ms-1">CMS</span>
                        </a>
                    </li>

                    <!-- Logout Section -->
                    <li class="nav-item">
                        <hr class="horizontal dark mt-3 mb-2">
                        <span class="nav-section-title ms-3 text-uppercase text-xs font-weight-bolder opacity-6">
                            Account
                        </span>
                    </li>
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
                    <li class="nav-item">
                    <a class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user {{ Route::is('user.profile') ? 'text-white' : 'text-icon' }}"></i>
                        </div>
                        <span class="nav-link-text ms-1">@lang('dashboard.profile')</span>
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
                                <span class="nav-link-text ms-1">@lang('dashboard.logout')</span>
                            </a>
                        </form>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</aside>

<style>
    #sidenav-main .nav-link.active,
    #sidenav-main .nav-link.active-parent {
        color: #981e24;
        /* Desired active color */
        font-weight: bold;
        /* Make active links bold */
    }
</style>
