$(document).ready(function () {
    $('.js-products-slider').slick({
        dots: false, // Disable dots
        arrows: true, // Enable navigation arrows
        prevArrow: '<button style="z-index: 200;" id="prev" type="button" class="slick-arrow slick-prev"><i class="icon icon-arrow"></i></button>',
        nextArrow: '<button style="z-index: 200;" id="next" type="button" class="slick-arrow slick-next"><i class="icon icon-arrow"></i></button>',
        slidesToShow: 4, // Number of visible items
        slidesToScroll: 1, // Number of items to scroll
        infinite: true, // Infinite looping
        lazyLoad: 'ondemand', // Lazy load images
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
});