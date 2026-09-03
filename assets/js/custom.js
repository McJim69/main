jQuery( document ).ready(function( $ ) {
	"use strict";

    $(function() {
        $( "#tabs" ).tabs();
    });

    $("#preloader").animate({
        'opacity': '0'
    }, 600, function(){
        setTimeout(function(){
            $("#preloader").css("visibility", "hidden").fadeOut();
        }, 300);
    });
    
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      var box = $('.header-text').height();
      var header = $('header').height();

      if (scroll >= box - header) {
        $("header").addClass("background-header");
      } else {
        $("header").removeClass("background-header");
      }
    });

	if ($('.owl-testimonials').length) {
        $('.owl-testimonials').owlCarousel({
            loop: true,
            nav: false,
            dots: true,
            items: 1,
            margin: 30,
            autoplay: false,
            smartSpeed: 700,
            autoplayTimeout: 6000,
            responsive: {
                0: {
                    items: 1,
                    margin: 0
                },
                460: {
                    items: 1,
                    margin: 0
                },
                576: {
                    items: 2,
                    margin: 20
                },
                992: {
                    items: 2,
                    margin: 30
                }
            }
        });
    }

    $(".Modern-Slider").slick({
        autoplay:true,
        autoplaySpeed:10000,
        speed:600,
        slidesToShow:1,
        slidesToScroll:1,
        pauseOnHover:false,
        dots:false,
        pauseOnDotsHover:true,
        cssEase:'linear',
       // fade:true,
        draggable:false,
        prevArrow:'<button class="PrevArrow"></button>',
        nextArrow:'<button class="NextArrow"></button>', 
    });

    // Custom Video Lightbox Overlay for movie streaming links
    const overlay = $('<div id="videoPlayerOverlay"><button class="close-overlay">&times;</button><div class="video-container" style="position: relative; width: 100%; display: flex; justify-content: center;"></div></div>');
    $('body').append(overlay);

    const closeBtn = overlay.find(".close-overlay");
    const container = overlay.find(".video-container");

    function closeVideo() {
        overlay.css("display", "none");
        container.empty();
    }

    closeBtn.on("click", closeVideo);
    overlay.on("click", function(e) {
        if (e.target === overlay[0]) {
            closeVideo();
        }
    });

    $(document).on("click", "a.lightbox", function(e) {
        e.preventDefault();
        const videoUrl = $(this).attr("href");
        
        container.html(`
            <video controls autoplay>
                <source src="${videoUrl}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `);
        overlay.css("display", "flex");
    });
});