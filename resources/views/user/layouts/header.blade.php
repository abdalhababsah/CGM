<header class="header">
    <div class="header-top">
        <span>@lang('home.header_offer')</span>
        <i class="header-top-close js-header-top-close icon-close"></i>
    </div>
    <div class="header-content">
        <div class="header-logo">
            <img src="" alt="@lang('home.header_logo_alt')">
        </div>
        <div class="header-box">
            <ul class="header-nav">
                <li><a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">@lang('home.nav_home')</a></li>
                <li><a href="{{ route('shop.index') }}">@lang('home.nav_shop')</a></li>
                <li><a href="{{ route('cart.index') }}">@lang('home.nav_cart')</a></li>
                <li><a href="{{ route('wishlist.index') }}">@lang('home.nav_wishlist')</a></li>
                <li><a href="{{ asset('contacts') }}">@lang('home.nav_contact')</a></li>
                @if(!Auth::check())
                    <li><a href="{{ asset('login') }}">@lang('home.nav_login')</a></li>
                @elseif(Auth::user()->role == 1)
                    <li><a href="{{ asset('admin.dashboard') }}">@lang('home.nav_dashboard')</a></li>
                @elseif(Auth::user()->role == 0)
                    <li><a href="{{ asset('user.dashboard') }}">@lang('home.nav_dashboard')</a></li>
                @endif
            </ul>
            <ul class="header-options">
                <li><a href="#"><i class="icon-user"></i></a></li>
                <li><a href="{{ route('wishlist.index') }}"><i class="icon-heart"></i></a></li>
                <li><a href="{{ route('cart.index') }}"><i class="icon-cart"></i><span>0</span></a></li>
                <!-- Language Switcher -->
                <li class="language-switcher">
                    <a href="{{ route('lang.switch', ['locale' => 'en']) }}">EN</a> |
                    <a href="{{ route('lang.switch', ['locale' => 'ar']) }}">AR</a> |
                    <a href="{{ route('lang.switch', ['locale' => 'he']) }}">HE</a>
                </li>
            </ul>
        </div>
        <div class="btn-menu js-btn-menu"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></div>
    </div>
</header>