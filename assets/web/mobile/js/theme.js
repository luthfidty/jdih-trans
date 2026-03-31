/*======================================================
 * Template Name: Plesir - Car & Travel Mobile Template
 * Version: 1.0
 * Author: HidraTheme
 * Developed By: HidraTheme
 * Author URL: https://themeforest.net/user/hidratheme
 ======================================================*/

(function ($) {

    "use strict";

    /* PRELOADER */
    $(window).on('load', function () {
        $(".preloading").fadeOut("slow");
    });

    /* SIDE NAVIGATION */
    $('#dismiss, .overlay').on('click', function () {
        $('#sidebarleft').removeClass('active');
        $('#sidebarright').removeClass('active');
        $('.overlay').removeClass('active');
        $('body').removeClass('noscroll');
    });

    $('#sidebarleftbutton,#sidebarrightbutton').on('click', function () {
        $('.overlay').addClass('active');
        $('body').addClass('noscroll');
    });

    $('#sidebarleftbutton').on('click', function () {
        $('#sidebarleft').addClass('active');
    });

    $('#sidebarrightbutton').on('click', function () {
        $('#sidebarright').addClass('active');
    });


    /* HOMEPAGE - CAROUSEL SLIDER */
    $('.img-hero').slick({
        autoplay: true,
        dots: true,
        infinite: true,
        arrows: false,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: false
    });


    /* DEFAULT CAROUSEL */
    $('.default-carousel').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        centerMode: false,
        arrows: false,
        variableWidth: true
    });


    /* MAGNIFICPOPUP GALLERY */
    $(".gallery-list").magnificPopup({
        type: "image",
        removalDelay: 300
    });


})(jQuery);


