(function ($) {
    function initSliderBanner() {
        if( $('.isa-home-banner__slider').length < 1 ) return;
        const progressCircle = $(".isa-home-banner__pager .rt-progress.over");
        const progressContent = $(".isa-home-banner__pager span");
        
        const sliderBanner = new Swiper('.isa-home-banner__slider', {
            slidesPerView: 1,
            spaceBetween: 16,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            autoplay: {
                delay: 6500,
                disableOnInteraction: false,
            },
           
            pagination: {
                el: '.slider-pagination',
                clickable: true,
                type: "bullets",
                bulletClass: "isa-bullet",
                bulletActiveClass: "is-active",
                renderBullet: function (index, className) {
                    var slide = this.slides[index];
                    var pagerCategory = slide.dataset.pagerCategory;
                    var pagerTitle = slide.dataset.pagerTitle;
                    return '<div class="' + className + '"><div class="pager__item"><span><strong>' + pagerCategory + '</strong></span></div> </div>';
                }
                
            },
            on: {
                
                autoplayTimeLeft(s, time, progress) {
                    // console.log(progress);
                    // progressCircle.style.setProperty("--progress", 1 - progress);
                    progressCircle.attr('style','--progress:'+ (1 - progress));
                    progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                    
                }
            },
            navigation: {
                nextEl: '.tohs-prestigious-university__arrow .tohs-swiper-next',
                prevEl: '.tohs-prestigious-university__arrow .tohs-swiper-prev',
            },       
            
        });

        var toggleButton = document.getElementById('toggleButtonPause');
        var pager = $('.isa-home-banner__pager');
        var video = $('.isa-home-banner__video video');
        var isPlaying = true;

        // Make sure the video plays inline instead of full screen
        video.attr('playsinline', '');
        video.attr('webkit-playsinline', '');

        toggleButton.addEventListener('click', function() {
            if (isPlaying) {
                pager.addClass('is-paused');
                sliderBanner.autoplay.pause();
                video.get(0).pause();
            } else {
                pager.removeClass('is-paused');
                sliderBanner.autoplay.resume();
                video.get(0).play(); 
            }
            isPlaying = !isPlaying;
        });

        handleMatchHeight();
    }

    function handleMatchHeight() {
        if( $('.isa-home-banner .isa-bullet .pager__item').length > 0) {
            $('.isa-home-banner .isa-bullet .pager__item').matchHeight();
        } 
    }

    function initSliderVistLocation() {
        if( $('.isa-vist-location__list').length < 1 ) return;

        const swiper = new Swiper('.isa-vist-location__list', {
            speed: 400,
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            allowSlideNext: true,
            pagination: {
                el: ".isa-vist-location__pagination--bulet",
                clickable: true,
            },
            navigation: {
                nextEl: '.isa-vist-location__arrow--next',
                prevEl: '.isa-vist-location__arrow--prev',
            },
           
            breakpoints: {
                1024: {
                    slidesPerView: 3,
                    
                },
                // when window width is >= 768px
                576: {
                    slidesPerView: 2,
                    
                },

                
            }
        });
    }

    let sliderInstances = {};

    function initPrestigiousUniversitySlider(elementTop, tabId) {
        if ($('.isa-prestigious-university__list').length < 1) return;

        // console.log(sliderInstances);
    
        if (sliderInstances[tabId]) {
            // Slider đã được khởi tạo, không khởi tạo lại
            return;
        }
    
        const sliderUniversity = new Swiper(elementTop, {
            slidesPerView: 1.2,
            spaceBetween: 16,
            centeredSlides: true,
            loop: true,
            lazy: true,
            speed: 500,
            pagination: {
                el: ".isa-prestigious-university__pagination--nav",
                type: "progressbar",
            },
            on: {
                init: function() {
                    updatePaginationCounter();
                    handleMatchHeightTitle();
                },
                slideChangeTransitionEnd: function() {
                    handleMatchHeightTitle();
                    updatePaginationCounter();
                },
                resize: function() {
                    handleMatchHeightTitle();
                    calcWidthSlider(); 
                }
            },
            navigation: {
                nextEl: '.isa-prestigious-university .isa-swiper-next',
                prevEl: '.isa-prestigious-university .isa-swiper-prev',
            },
            breakpoints: {
                768: {
                    spaceBetween: 32,
                    slidesPerView: 1.5,
                },
                992: {
                    slidesPerView: 1.4,
                    spaceBetween: 48,
                },
                1600: {
                    slidesPerView: 1.7,
                    spaceBetween: 54,
                },
            },
        });
    
        sliderInstances[tabId] = sliderUniversity;
    
        calcWidthSlider();
        updatePaginationCounter(); 
        handleMatchHeightTitle();
       
    }
    
    function updatePaginationCounter() {
        let currentTab = $('#UniversityTab').find('.nav-link.active').attr('id');
        let currentSwiper = document.getElementById(currentTab + '-content').querySelector('.swiper-container');
        let currentSlide = (currentSwiper.swiper.realIndex + 1).toString().padStart(2, '0');
        let totalSlides = (currentSwiper.swiper.slides.length).toString().padStart(2, '0');
    
        $('.isa-prestigious-university__pagination--count').find(".current").text(currentSlide);
        $('.isa-prestigious-university__pagination--count').find(".total").text(totalSlides);
    }

    function handleMatchHeightTitle() {
        let maxHeight = 0;
    
        $('.isa-prestigious-university .content-top__title').css('height', 'auto');
    
        $('.isa-prestigious-university .content-top__title').each(function() {
            let height = $(this).outerHeight();
            if (height > maxHeight) {
                maxHeight = height;
            }
        });
    
        $('.isa-prestigious-university .content-top__title').css('height', maxHeight + 'px');
    }
    
    function handlePrestigiousUniversityTab() {
        $('.isa-prestigious-university__mobile li').click(function () {
            var position = $(this).position();
            var scroll = $('.isa-prestigious-university__mobile').scrollLeft();
            $('.isa-prestigious-university__mobile').animate({
                'scrollLeft': scroll + position.left - 30
            }, 200);
        });
    
        if ($('#UniversityTabContent .tab-pane.active').length > 0) {
            let elementTop = '#UniversityTabContent .tab-pane.active .isa-prestigious-university__list';
            let tabId = $('#UniversityTabContent .tab-pane.active').attr('id');
            initPrestigiousUniversitySlider(elementTop, tabId);
        }
    
        $('.isa-prestigious-university__nav button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            let elementTop = '#UniversityTabContent .tab-pane.active .isa-prestigious-university__list';
            let tabId = $('#UniversityTabContent .tab-pane.active').attr('id');
            initPrestigiousUniversitySlider(elementTop, tabId);
            updatePaginationCounter();
            
        });
       
    }
    
    function calcWidthSlider() {
        let fullWidthSlider = $('#UniversityTabContent').outerWidth();
        let widthSlideCenter = $('.isa-prestigious-university__list .swiper-slide-active').outerWidth();
        let result = (fullWidthSlider - widthSlideCenter)/2;
        widthSlideCenter = widthSlideCenter + 24;
    
        $('.isa-slider-prestigious-university-container').css('max-width', widthSlideCenter + 'px'); 
        $('.isa-prestigious-university__list').attr('style','--positionArrow:'+ result +'px')
    }
    
    $(function () {
        initSliderBanner();
        initSliderVistLocation();
        handlePrestigiousUniversityTab();
        initPrestigiousUniversitySlider(); 
        handleMatchHeightTitle();
        
      
     
        $(window).on("resize", function () {

        });
    });
})(jQuery);