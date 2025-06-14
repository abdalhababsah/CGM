$(window).on('load', function () {
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		$('body').addClass('ios');
	} else{
		$('body').addClass('web');
	};

	if ($(window).width() < 767) {
		setTimeout(function () {
			$('body').removeClass('loaded');
			$('.main-block').removeClass('load-bg');
		}, 1000);
		setTimeout(function() {
			$( "head" ).append( '<link rel="preconnect" href="https://fonts.gstatic.com">' );
			$( "head" ).append( '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&family=Mrs+Saint+Delafield&family=Tenor+Sans&display=swap" rel="stylesheet">' );


		}, 1300);
	} else {
		setTimeout(function () {
			$('body').removeClass('loaded');
		}, 1000);
		setTimeout(function() {
			$( "head" ).append( '<link rel="preconnect" href="https://fonts.gstatic.com">' );
			$( "head" ).append( '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@700&family=Mrs+Saint+Delafield&family=Tenor+Sans&display=swap" rel="stylesheet">' );

		}, 500);

	}

	setTimeout(function () {
		var tag = document.createElement('script');

		// tag.src = "https://www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		// firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	}, 3000);
});

/* viewport width */
function viewport(){
	var e = window,
		a = 'inner';
	if ( !( 'innerWidth' in window ) )
	{
		a = 'client';
		e = document.documentElement || document.body;
	}
	return { width : e[ a+'Width' ] , height : e[ a+'Height' ] }
};
/* viewport width */


$(function(){

	var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	if (isSafari) {
		$('body').addClass('safari');
	};

	/* lazy */
	if ($('.js-img').length) {
		var jsImg = $(".js-img");
		new LazyLoad(jsImg, {
			root: null,
			rootMargin: "0px",
			threshold: 0
		});
	};
	/* lazy */

	/* burger */
	$('.js-btn-menu').on('click', function(){
		$(this).toggleClass('active');
		$('.header-box').toggleClass('active');
		$('html').toggleClass('scroll-off');
	});

	$('.content').on('click', function(){
		$('.js-btn-menu').removeClass('active');
		$('.header-box').removeClass('active');
		$('html').removeClass('scroll-off');
	});

	/* burger */

	$('.header-nav li a').on('click', function(e){
		// e.preventDefault();
		$(this).parent().siblings('li').find('ul').removeClass('active');
		$(this).parent().find('ul').toggleClass('active');
	});

	/* header scroll */
	$(window).scroll(function () {
		var scroll = $(window).scrollTop();
		if (scroll >= 1) {
			$(".header-content").addClass("fixed");
		} else {
			$(".header-content").removeClass("fixed");
		}
	});
	/* header scroll */

	/* placeholder*/
	$('input, textarea').each(function(){
 		var placeholder = $(this).attr('placeholder');
 		$(this).focus(function(){ $(this).attr('placeholder', '');});
 		$(this).focusout(function(){
 			$(this).attr('placeholder', placeholder);
 		});
 	});
	/* placeholder*/

	/* phone mask */

	/* phone mask */

	/* close header top */
	$('.js-header-top-close').on('click', function(){
		$(this).parent().css('display', 'none');
	});
	/* close header top */

	/* custom select */
	if($('.styled').length) {
		$('.styled').styler();
	};
	/* custom select */

	/* product page slider */
	if ($('.product-slider').length) {
		$('.product-slider__main').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: false,
			arrows: false,
			fade: true,
			asNavFor: '.product-slider__nav'
		});
		$('.product-slider__nav').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			dots: false,
			arrows: false,
			asNavFor: '.product-slider__main',
			focusOnSelect: true
		});
	};
	/* product page slider */

	/* product color change */
	$('.product-info__color li').on('click', function(){
		$('.product-info__color li').removeClass('active');
		$(this).addClass('active');
	});
	/* product color change */

	/* form rating */
	if ($('.rating').length) {
        $('.rating').addRating();
	};
	/* form rating */

	/* checkout payment radio btn */
	$('.checkout-payment__item .radio-box').on('click', function(){
		$('.checkout-payment__item').removeClass('active');
		$(this).parents('.checkout-payment__item').addClass('active');
	});
	/* checkout payment radio btn */

	/* profile order toggle */
	$('.profile-orders__col-btn').on('click', function () {
		$(this).parents('.profile-orders__item').toggleClass('active');
        $(this).parents('.profile-orders__item').siblings('.profile-orders__item').removeClass('active');
    });
	/* profile order toggle */

	/* product like */
	$('.products-item__hover-options .icon-heart').on('click', function (e) {
		e.preventDefault();
		$(this).toggleClass('active');
    });
	/* product like */
});

var handler = function(){

	if($('.js-products-items').length) {
		$('.js-products-items').slick('refresh');
	}

	if($('.js-testimonials-slider').length) {
		$('.js-testimonials-slider').slick('refresh');
	}

	var height_footer = $('footer').height();
	var height_header = $('header').height();


	var viewport_wid = viewport().width;
	var viewport_height = viewport().height;
}

$(window).on('resize', function(){
	if($('.main-block').length) {
		$('.main-block').removeClass('load-bg');
	}
});

if($('.radio-box__info-content').length) {
	if ($(window).width() < 767) {
		$(window).scroll(function() {
			$('.radio-box__info-content').removeClass('active');
		});
		$('.radio-box__info').click(function(){
			$(this).find('.radio-box__info-content').toggleClass('active');
		});
	}

}

$(window).bind('load', handler);
$(window).bind('resize', handler);


