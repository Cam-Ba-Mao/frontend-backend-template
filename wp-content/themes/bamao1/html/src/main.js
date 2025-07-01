var $ = jQuery.noConflict();
// Global functions
var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

function openPopupOverlay(speed = 300) {
    if ($('.iedg-popup-overlay').length) return;
    $('body').append('<div class="iedg-popup-overlay"></div>');
    $('body').addClass('is-lock').css('paddingRight', scrollbarWidth);
    $('.iedg-popup-overlay').fadeIn(speed);
}

function closePopupOverlay(speed = 300) {
    $('.iedg-popup-overlay').fadeOut(speed);
    setTimeout(function () {
        $('.iedg-popup-overlay').remove();
    }, speed);
    $('body').removeClass('is-lock').css('padding-right', '');
}

function getRootVars() {
    var root = document.querySelector(":root");
    root.style.setProperty("--vh", window.innerHeight / 100 + "px");
    root.style.setProperty("--mh", $('header .iedg-navbar').outerHeight() + "px");
}

// Main functions
(function ($) {
    $.iedg_noti = function (html, time = 2500) {
        if ($('.iedg-noti').length) return;
        $('body').append('<div class="iedg-noti">' + html + '</div>');
        setTimeout(function () {
            $('.iedg-noti').addClass('opening');
        }, 10);
        setTimeout(function () {
            $('.iedg-noti').removeClass('opening');
        }, time);
        setTimeout(function () {
            $('.iedg-noti').remove();
        }, time + 400);
    };

    function handleWordpressAdminMode() {
        if ($('#wpadminbar').length && $('.js-iedg-navbar').length && $(window).width() <= 600) {
            $(window).on('scroll', function () {
                var top = $(window).scrollTop(),
                    offsetTop = 46 - top > 0 ? 46 - top : 0;
                $('.js-iedg-navbar').css('margin-top', offsetTop);
            });
        }
    }

    function initLazyLoad() {
        $('.lazy').Lazy({
            afterLoad: function (el) {
                $(el).addClass('loaded');
                // handleIE();
            }
        });
    }

    function initSelect2() {
        if( $('.ginput_container select').length > 0 ) {
            $('.ginput_container select').select2({
                width: "100%",
                minimumResultsForSearch: -1
            });
        }

        if( $('.iedg-form-group select').length > 0 ) {
            $('.iedg-form-group select').select2({
                width: "100%",
                minimumResultsForSearch: -1
            });
        }

        if( $('select.iedg-is-select2').length > 0 ) {
            $('select.iedg-is-select2').select2({
                width: "100%",
                minimumResultsForSearch: -1
            });
        }

        if( $('select.iedg-is-select2-filter').length > 0 ) {
            $('select.iedg-is-select2-filter').select2({
                width: "100%",
                minimumResultsForSearch: -1,
                theme: "filter"
            });
        }
        

        // if( $('.pennacademy-course-ordering select').length > 0 ) {
        //     $('.pennacademy-course-ordering select').select2({
        //         width: "resolve",
        //         minimumResultsForSearch: -1
        //     });
        // }

        /* if( $('.wpforms-field select').length > 0 ) {
            $('.wpforms-field select').select2({
                width: "100%",
                minimumResultsForSearch: -1
            });
        } */
       
    }

    function initPopup() {
        $('[data-popup-target]').on('click', function (e) {
            e.preventDefault();
            var popupTarget = $(this).data('popup-target'),
                popupContent = $('[data-popup-content="' + popupTarget + '"]');
            if (popupContent.length == 0) return;
            popupContent.addClass('is-active');
            openPopupOverlay();
        });

        $('[data-popup-close]').on('click', function (e) {
            e.preventDefault();
            $(this).closest('[data-popup-content]').removeClass('is-active');
            closePopupOverlay();
        });

        $(document).on('click', '.iedg-popup-overlay', function (e) {
            $('[data-popup-content]').removeClass('is-active');
            closePopupOverlay();
        });
    }

    function handleIE() {
        var userAgent, ieReg, ie;
        userAgent = window.navigator.userAgent;
        ieReg = /msie|Trident.*rv[ :]*11\./gi;
        ie = ieReg.test(userAgent);

        if (ie) {
            $('.iedg-img-drop').each(function () {
                var $container = $(this),
                    imgLazy = $(this).find('img').attr('src'),
                    picLazy = $(this).find('source').attr('srcset'),
                    imgUrl = picLazy ? picLazy : imgLazy;
                if (imgUrl) {
                    $container.css('backgroundImage', 'url(' + imgUrl + ')').addClass('custom-object-fit');
                }
            });
        }
    }

    function initAnchorScroll() {
        $('a.js-anchor-scroll[href*=\\#]:not([href=\\#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });

        $('body .iedg-header a[href*=\\#]:not([href=\\#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {

                    $('.iedg-navbar-toggler').removeClass('is-active');
                    $('.iedg-navbar-collapse').removeClass('is-show');
                    $('body').removeClass('is-lock');

                    $('html, body').animate({
                        scrollTop: target.offset().top - $('header .iedg-navbar').outerHeight()
                    }, 1000);
                    return false;
                }
            }
        });
    }


    function initFormFloatLabel() {
        // Check input autofill
        $(window).bind('load', function () {
            $.each($('.iedg-form-group input:-webkit-autofill'), function () {
                var label = $(this).prev()
                label.addClass('freeze');
            });

            $.each($('.gfield input:-webkit-autofill'), function () {
                var label = $(this).closest('.gfield').find('.gfield_label')
                label.addClass('freeze');
            });

            $.each($('.wpforms-field input:-webkit-autofill'), function () {
                var label = $(this).closest('.gfield').find('.gfield_label')
                label.addClass('freeze');
            });
        });

        // Check select
        $('.ginput_container_select select').closest('.gfield').addClass('has-select');
        $('.iedg-form-group select').closest('.iedg-form-group').addClass('has-select');

        // Check input
        var formFields = $('.gfield, .iedg-form-group, .wpforms-field, .comment-form p');
        formFields.each(function () {
            var field = $(this),
                input = field.find('input:not([type="radio"]):not([type="checkbox"]):not([type="hidden"]), textarea'),
                label = field.find('label');

            if (input.attr('type') != 'file') {
                input.focus(function () {                    
                    label.addClass('freeze');
                });
            }

            input.focusout(function () {
                checkInput();
            });

            if (input.val() && input.val().length) {
                label.addClass('freeze');
            }

            function checkInput() {
                var valueLength = input.val().length;

                if (valueLength > 0) {
                    label.addClass('freeze');
                } else {
                    label.removeClass('freeze');
                }
            }

            input.change(function () {
                checkInput();
            });
        });
    }

    function handleBanner() {
        if( $('.iedg-banner__lists').length < 1) return;

        $('.iedg-banner__lists').slick({
            slidesToShow: 1,
            centerMode: true,
            focusOnSelect: true,
            centerPadding: 0,
            dots: false,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 3000,
            // adaptiveHeight: true
        });
    } 

    function handleTableOfContents() {
        if( $('.ez-toc-title-container').length < 1 ) return;

        $(document).on('click', '.ez-toc-title-container', function() {
            if( $('.ez-toc-list').is(":visible") ) {
                $('.ez-toc-list').hide( 'fast' );
                $(this).addClass('is-active');
            } else {
                $('.ez-toc-list').show( 'fast' );
                $(this).removeClass('is-active');
            }
            
        });
    }
    
    $(function () {
        getRootVars();
        initLazyLoad();
        initSelect2();
        initPopup();
        handleWordpressAdminMode();
        initFormFloatLabel();
        initAnchorScroll();

        handleBanner(); 
        handleTableOfContents();
    });

    $(window).on('resize', function() {
        getRootVars();
    });
})(jQuery);