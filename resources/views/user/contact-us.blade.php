@extends('user.layouts.app')

@section('content')

<div class="detail-block">
    <div class="wrapper">
        <div class="detail-block__content">
            <h1>Contact</h1>
            <ul class="bread-crumbs">
                <li class="bread-crumbs__item">
                    <a href="#" class="bread-crumbs__link">Home</a>
                </li>
                <li class="bread-crumbs__item">Contact</li>
            </ul>
            <div class="detail-block__items">
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-map-pin-big"></i>
                    </div>
                    <div class="detail-block__item-info">
                        27 Division St, New<br>
                        York, NY 10002, USA
                    </div>
                </div>
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-phone"></i>
                    </div>
                    <div class="detail-block__item-info">
                        +1 345 99 71 345<br>
                        info@beshop.com
                    </div>
                </div>
                <div class="detail-block__item">
                    <div class="detail-block__item-icon">
                        <img data-src="img/main-text-decor.svg"
                            src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
                        <i class="icon-2"></i>
                    </div>
                    <div class="detail-block__item-info">
                        Mon - Fri: 9 am - 6 pm<br>
                        Sat - Sun: Holiday
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN CONTACTS INFO -->
<div class="contacts-info">
    <div class="wrapper">
        <div class="contacts-info__content">
            <div class="contacts-info__text">
                <h4>We take care of you</h4>
                <p>
                    Email us if you have any questions, we will be sure to contact you and find a solution. Also,
                    our managers will help you choose the product that suits you best, at the best price. From year
                    to year, the BeShop network develops and improves, taking into account all consumer needs and
                    market trends. But for us, the concern remains that when coming to the BeShop store, customers
                    do not have questions about the convenience and comfort of shopping, product quality and
                    the level of professionalism of sales consultants.
                </p>
            </div>
            <div class="contacts-info__social">
                <span>Find us here:</span>
                <ul>
                    <li class="m-1"><a href="#"><i class="icon-facebook"></i></a></li>
                    <li class="m-1"><a href="#"><i class="icon-insta"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- CONTACTS INFO EOF   -->
<!-- BEGIN LOGOS -->
<div class="main-logos main-logos_contacts">
    <img data-src="img/main-logo1.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo2.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo3.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo4.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
    <img data-src="img/main-logo5.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACw=" class="js-img" alt="">
</div>
<!-- LOGOS EOF   -->
<!-- BEGIN DISCOUNT -->
<div class="discount discount-contacts js-img" data-src="https://via.placeholder.com/1920x1067">
    <div class="wrapper">
        <div class="discount-info">
            <span class="saint-text">write to us</span>
            <span class="main-text">leave a message</span>
            <p>
                Write to us if you have any questions, we will definitely contact you and find a solution.
            </p>
            <form>
                <div class="box-field">
                    <input type="text" class="form-control" placeholder="Enter your name">
                </div>
                <div class="box-field">
                    <input type="email" class="form-control" placeholder="Enter your email">
                </div>
                <div class="box-field box-field__textarea">
                    <textarea class="form-control" placeholder="Enter your message"></textarea>
                </div>
                <button type="submit" class="btn">send</button>
            </form>
        </div>
    </div>
</div>
<!-- DISCOUNT EOF   -->
<!-- BEGIN CONTACTS MAP -->
<div class="contacts-map">
    <div id="map"></div>
</div>
@endsection
