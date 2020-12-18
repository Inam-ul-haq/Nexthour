	/**
 * Next Hour - Movie Tv Show & Video Subscription Portal Cms Web and Mobile App
 *
 * This file contains all template JS functions
 *
 * @package Next Hour
--------------------------------------------------------------
                   Contents
--------------------------------------------------------------

 * 01 Overlay On Click On Dropdown  
 * 02 Slide Effect
 * 03 Transform Effects
 * 04 Home Slider
 * 05 Genre Custom Slider 
 * 06 Genre Custom Slider 2
 * 07 Preloader

--------------------------------------------------------------*/
(function($) {

  // Overlay On Click On Dropdown  
  $('.prime-dropdown').on('click', function(){
    $('.body-overlay-bg').toggleClass('active');
  });

  $.protip({
    defaults: {
      placement: "border",
      animate: false,
      delayIn: 0,
      delayOut: 0,
      interactive: false,
      mixin: "css-no-transition"
    }
  });
  var mid_device = Modernizr.mq('(min-width: 1200px)');
  if (mid_device) {
    // Slide Effect
    var controller = new ScrollMagic.Controller();

    // Transform Effect
    // build tween for big main poster transform 
      var tween1 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#big-main-poster-block", 1, {top: 70}, {top: 350, ease: Linear.easeNone})
        ]);
    // build scene for big main poster transform
      var scene1 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height()})
        .setTween(tween1)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);

    // build tween big main poster blur and grayscale on offset
      var tween2 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#big-main-poster-block", 1, {'-webkit-filter':'blur(' + 0 + 'px' + ')' + 'grayscale(0)'}, {'-webkit-filter':'blur(' + 4 + 'px' + ')' + 'grayscale(80%)', ease: Linear.easeNone})
        ]);
    // build scene big main poster blur and grayscale on offset
      var scene2 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height(), offset: 200})
        .setTween(tween2)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);

    // build tween for big main poster overlay background on offset
      var tween3 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#big-main-poster-block .overlay-bg", 1, {opacity: 0}, {opacity: 1, ease: Linear.easeNone})
        ]);
    // build scene for big main poster overlay background on offset
      var scene3 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height(), offset: -400})
        .setTween(tween3)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);

    // build tween for poster thumbnail
      var tween4 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#poster-thumbnail", 1, {right: "-150%", opacity: 0}, {right: "15%", opacity: 1, ease: Linear.easeNone})
        ]);
    // build scene for poster thumbnail
      var scene4 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height(), offset: -330})
        .setTween(tween4)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);

    // build tween for full movie name
      var tween5 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#full-movie-name", 1, {fontSize: "43px"}, {fontSize: "33px", ease: Linear.easeNone})
        ]);
    // build scene for full movie name
      var scene5 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height(), offset: -280})
        .setTween(tween5)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);

    // build tween for full movie name
      var tween6 = new TimelineMax ()
        .add([
          TweenMax.fromTo("#big-main-poster-block .overlay-bg", 1, {background: "linear-gradient(0deg, rgba(17, 17, 17, 0.9) 20%, transparent 100%)"}, {backgroundColor: "rgba(17, 17, 17, 0.8)", ease: Linear.easeNone})
        ]);
    // build scene for full movie name
      var scene6 = new ScrollMagic.Scene({triggerElement: "#main-custom-wrapper", duration: $(window).height()})
        .setTween(tween6)
        // .addIndicators() // add indicators (requires plugin)
        .addTo(controller);    
  }

  // Home Slider
    $("#home-slider-one").owlCarousel({
      loop: false, // repetation off then loop: false;
      items: 1,
      dots: true,
      nav: true,
      autoHeight: true,
      touchDrag: true,
      mouseDrag: true,
      margin: 0,
      autoplay: true,
      autoplayTimeout: 7000,
      slideSpeed: 10000,
      smartSpeed: 1400,
      navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: false,
        },
        1100: {
            items: 1,
            nav: true,
            dots: true,
        }
      }
    });

  // Genre Custom Slider 
    $(".genre-main-slider").owlCarousel({
      loop: false, // repetation off then loop: false;
      items: 4,
      dots: true,
      nav: false,
      autoHeight: true,
      touchDrag: true,
      mouseDrag: true,
      margin: 25,
      autoplay: false,
      autoplayTimeout: 15000,
      slideSpeed: 10000,
      smartSpeed: 1400,
      navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        500: {
            items: 2,
            nav: false,
            dots: false,
        },
        992: {
            items: 3,
            nav: false,
        },
        1100: {
            items: 4,
            nav: false,
            dots: true,
        },
        1800: {
            items: 5,
            nav: false,
            dots: true,
        }
      }
    });

  // Genre Custom Slider 2
    $(".genre-prime-slider").owlCarousel({
      loop: true, // repetation off then loop: false;
      items: 6,
      dots: false,
      nav: true,
      autoHeight: true,
      touchDrag: true,
      mouseDrag: true,
      margin: 5,
      autoWidth:true,
      autoplay: false,
      autoplayTimeout: 12000,
      slideSpeed: 10000,
      smartSpeed: 1400,
      navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false
        },
        768: {
            items: 1,
            nav: false,
            dots: false
        },
        992: {
            items: 3,
            nav: true
        },
        1100: {
            items: 6,
            nav: true,
            dots: false
        },
        1800: {
            items: 8,
            nav: true,
            dots: false
        }
      }
    });

// Preloader   
    $(window).on('load', function(){  
      setTimeout(function(){
        $('.loading').fadeOut('slow');
      }, 350);
    });     
})(jQuery);
