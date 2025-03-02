<header class="header">
    <div class="header-content">
        <div class="header-top " style="margin-bottom: 10px; overflow: hidden;">

            <span class="scrolling-text ">{{ $headerSlider->title }}</span>

        </div>

        <a class="header-logo" href="{{ url('/') }}">
            <img src="{{ asset('user/img/logo-white-01.svg') }}" alt="@lang('home.header_logo_alt')">
        </a>
        <div class="header-box">
            <ul class="header-nav">
                <li><a href="{{ route('home') }}"
                        class="{{ Request::is('/') ? 'active' : '' }}">{{ __('home.nav_home') }}</a></li>
                <li><a href="{{ route('shop.index') }}">{{ __('home.nav_shop') }}</a></li>
                <li><a href="{{ route('contact') }}">{{ __('home.nav_contact') }}</a></li>
                @if (!Auth::check())
                    <li><a href="{{ asset('login') }}">{{ __('home.nav_login') }}</a></li>
                @elseif(Auth::user()->role == 1)
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('home.nav_dashboard') }}</a></li>
                @elseif(Auth::user()->role == 0)
                    <li><a href="{{ route('user.dashboard') }}">{{ __('home.nav_dashboard') }}</a></li>
                @endif
                @if (Auth::check())
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                            {{ __('home.logout') }}
                        </form>
                    </li>
                @endif
            </ul>
            <ul class="header-options">


                <li><a href="{{ route('wishlist.index') }}"><i style="	color: white ;" class="icon-heart"></i></a></li>
                <li>
                    <a href="{{ route('cart.index') }}">
                        <i style="color: white ;" class="icon-cart"></i>
                        <span id="cart-count">0</span> <!-- Assigned ID for JS -->
                    </a>
                </li>
                <!-- Language Switcher -->
                <li class="language-switcher">
                    <a href="{{ route('lang.switch', ['locale' => 'en']) }}">EN</a> |
                    <a href="{{ route('lang.switch', ['locale' => 'ar']) }}">AR</a> |
                    <a href="{{ route('lang.switch', ['locale' => 'he']) }}">HE</a>
                </li>
            </ul>
        </div>
        <div class="btn-menu js-btn-menu" style="color: white"><span style="color: white">&nbsp;</span
                style="color: white"><span style="color: white">&nbsp;</span><span style="color: white">&nbsp;</span>
        </div>
    </div>
</header>

<style>

</style>
