(function ($) {

    function initSliderWhyUS() {
        if( $('.isa-why-us__list').length < 1 ) return;

        const swiper = new Swiper('.isa-why-us__list', {
            speed: 400,
            slidesPerView: 1.2,
            spaceBetween: 24,
            loop: true,
            allowSlideNext: true,
            pagination: {
                el: ".isa-why-us__pagination--bulet",
                clickable: true,
            },
            navigation: {
                nextEl: '.isa-why-us__arrow--next',
                prevEl: '.isa-why-us__arrow--prev',
            },
           
            breakpoints: {
                1024: {
                    slidesPerView: 2.7,
                    
                },
                // when window width is >= 768px
                768: {
                    slidesPerView: 1.7,
                    
                },
               
                576: {
                    slidesPerView: 1.4,
                    
                },
                
            }
        });
    }

    function handleWidthTitle() {
        if ($('.isa-why-us__title').length < 1) return;
        
        var widthTitle = $('.isa-why-us__title').outerWidth();
    
        $('.isa-why-us__title').attr('style', '--widthTitle:' + widthTitle + 'px');
    }

    function handleMatchHeight() {
        if( $('.isa-why-us__item--title').length > 0) {
            $('.isa-why-us__item--title').matchHeight();
        }
        if( $('.isa-why-us__item--desc').length > 0) {
            $('.isa-why-us__item--desc').matchHeight();
        }
    }

    $(function () {
        initSliderWhyUS();
        handleMatchHeight();
        // handleWidthTitle();
     
        $(window).on("resize", function () {
            handleMatchHeight();
            // handleWidthTitle();
        });

        $(document).ready(function() {
            
        });

    });
})(jQuery);