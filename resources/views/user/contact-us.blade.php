@extends('user.layouts.app')

@section('content')

<div class="detail-block">
    <div class="wrapper">
        <div class="detail-block__content">
            <div class="detail-block__items">
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-map-pin-big"></i>
                    </div>
                    <div class="detail-block__item-info">
                        Palestine<br>
                        
                    </div>
                </div>
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-phone"></i>
                    </div>
                    <div class="detail-block__item-info">
                        +972592106900<br>
                        info@cgm.com
                    </div>
                </div>
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-2"></i>
                    </div>
                    <div class="detail-block__item-info">
                        Open 24/7
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN ABOUT US -->
<div class="contacts-info">
    <div class="wrapper">
        <div class="contacts-info__content">
            <div class="contacts-info__text">
                <h2>@lang('contactus.about_us')</h2>
                <h3>@lang('contactus.who_we_are')</h3>
                <p>@lang('contactus.welcome')</p>
                <p>@lang('contactus.our_story')</p>
            </div>
        </div>
    </div>
</div>
<!-- ABOUT US EOF -->

<!-- BEGIN MISSION -->
<div class="contacts-info">
    <div class="wrapper">
        <div class="contacts-info__content">
            <div class="contacts-info__text">
                <h3>@lang('contactus.mission.title')</h3>
                <ul>
                    <li>@lang('contactus.mission.embrace')</li>
                    <li>@lang('contactus.mission.promote')</li>
                    <li>@lang('contactus.mission.empower')</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- MISSION EOF -->

<!-- BEGIN VISION -->
<div class="contacts-info">
    <div class="wrapper">
        <div class="contacts-info__content">
            <div class="contacts-info__text">
                <h3>@lang('contactus.vision.title')</h3>
                <p>@lang('contactus.vision.content')</p>
            </div>
        </div>
    </div>
</div>
<!-- VISION EOF -->

<!-- BEGIN LOGOS -->
<div class="main-logos main-logos_contacts">
    <img data-src="img/main-logo1.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo2.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo3.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo4.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo5.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
</div>
<!-- LOGOS EOF -->
<div class="info-blocks">
    <div class="info-blocks__item js-img" data-src="">
        <div class="wrapper">
            <div class="info-blocks__item-img">
                <img data-src="{{ asset('user/img/image-6.png') }}" src="data:image/gif;base64,R0lGODlhAQABAAAAACw="
                    class="js-img" alt="@lang('home.check_this_out')">
            </div>
            <div class="info-blocks__item-text">
                <span class="saint-text">@lang('home.check_this_out')</span>
                <h2>@lang('home.new_collection')</h2>
                <span class="info-blocks__item-descr">@lang('home.nourish_description')</span>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN DISCOUNT -->
<div class="discount discount-contacts js-img" data-src="https://via.placeholder.com/1920x1067">
    <div class="wrapper">
        <div class="discount-info">
            <span class="saint-text">@lang('contactus.leave_message')</span>
            <span class="main-text">@lang('contactus.write_to_us')</span>
            <p>
                @lang('contactus.write_to_us_description')
            </p>
            <form>
                <div class="box-field">
                    <input type="text" class="form-control" placeholder="@lang('contactus.enter_name')">
                </div>
                <div class="box-field">
                    <input type="email" class="form-control" placeholder="@lang('contactus.enter_email')">
                </div>
                <div class="box-field box-field__textarea">
                    <textarea class="form-control" placeholder="@lang('contactus.enter_message')"></textarea>
                </div>
                <button type="submit" class="btn">@lang('contactus.send')</button>
            </form>
        </div>
    </div>
</div>
<!-- DISCOUNT EOF -->

@endsection