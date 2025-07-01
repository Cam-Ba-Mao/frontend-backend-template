"use strict";

var $ = jQuery.noConflict(); // Global functions

var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;

function openPopupOverlay() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
  if ($('.iedg-popup-overlay').length) return;
  $('body').append('<div class="iedg-popup-overlay"></div>');
  $('body').addClass('is-lock').css('paddingRight', scrollbarWidth);
  $('.iedg-popup-overlay').fadeIn(speed);
}

function closePopupOverlay() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
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
} // Main functions


(function ($) {
  $.iedg_noti = function (html) {
    var time = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2500;
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
      afterLoad: function afterLoad(el) {
        $(el).addClass('loaded'); // handleIE();
      }
    });
  }

  function initSelect2() {
    if ($('.ginput_container select').length > 0) {
      $('.ginput_container select').select2({
        width: "100%",
        minimumResultsForSearch: -1
      });
    }

    if ($('.iedg-form-group select').length > 0) {
      $('.iedg-form-group select').select2({
        width: "100%",
        minimumResultsForSearch: -1
      });
    }

    if ($('select.iedg-is-select2').length > 0) {
      $('select.iedg-is-select2').select2({
        width: "100%",
        minimumResultsForSearch: -1
      });
    }

    if ($('select.iedg-is-select2-filter').length > 0) {
      $('select.iedg-is-select2-filter').select2({
        width: "100%",
        minimumResultsForSearch: -1,
        theme: "filter"
      });
    } // if( $('.pennacademy-course-ordering select').length > 0 ) {
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
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
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
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
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
        var label = $(this).prev();
        label.addClass('freeze');
      });
      $.each($('.gfield input:-webkit-autofill'), function () {
        var label = $(this).closest('.gfield').find('.gfield_label');
        label.addClass('freeze');
      });
      $.each($('.wpforms-field input:-webkit-autofill'), function () {
        var label = $(this).closest('.gfield').find('.gfield_label');
        label.addClass('freeze');
      });
    }); // Check select

    $('.ginput_container_select select').closest('.gfield').addClass('has-select');
    $('.iedg-form-group select').closest('.iedg-form-group').addClass('has-select'); // Check input

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
    if ($('.iedg-banner__lists').length < 1) return;
    $('.iedg-banner__lists').slick({
      slidesToShow: 1,
      centerMode: true,
      focusOnSelect: true,
      centerPadding: 0,
      dots: false,
      arrows: true,
      autoplay: true,
      autoplaySpeed: 3000 // adaptiveHeight: true

    });
  }

  function handleTableOfContents() {
    if ($('.ez-toc-title-container').length < 1) return;
    $(document).on('click', '.ez-toc-title-container', function () {
      if ($('.ez-toc-list').is(":visible")) {
        $('.ez-toc-list').hide('fast');
        $(this).addClass('is-active');
      } else {
        $('.ez-toc-list').show('fast');
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
  $(window).on('resize', function () {
    getRootVars();
  });
})(jQuery);

(function ($) {
  function DemoAdminBarMode() {
    $('#enable-admin-bar').on('change', function () {
      var adminBarModeStatus = $(this).prop('checked');

      if (adminBarModeStatus) {
        $('html').addClass('admin-bar-html');
        $('body').append('<div id="wpadminbar">WP Admin bar</div>').addClass('admin-bar');
      } else {
        $('html').removeClass('admin-bar-html');
        $('body').removeClass('admin-bar');
        $('#wpadminbar').remove();
        $('.js-iedg-navbar').css('margin-top', '');
      }

      if ($(window).width() <= 600) {
        DemoNavbarMove();
        $(window).on('scroll', function () {
          DemoNavbarMove();
        });
      }

      function DemoNavbarMove() {
        var top = $(window).scrollTop(),
            offsetTop = 46 - top > 0 ? 46 - top : 0;

        if ($('#wpadminbar').length && $('.js-iedg-navbar').length) {
          $('.js-iedg-navbar').css('margin-top', offsetTop);
        } else {
          $('.js-iedg-navbar').css('margin-top', '');
        }
      }
    });
  }

  $(function () {
    DemoAdminBarMode();
  });
})(jQuery);

(function ($) {
  function handleNavCollapse() {
    $('.iedg-navbar-toggler').on('click', function () {
      $('.iedg-navbar-toggler').toggleClass('is-active');
      $('.iedg-navbar-collapse').toggleClass('is-show');
      $('body').toggleClass('is-lock');
      $('body').toggleClass('is-menu-show');
      $('.iedg-search__wrap').removeClass('is-active');

      if ($(window).width() > 1200) {
        $('.iedg-navbar-collapse').css('height', 'auto');
      } else {
        var topBarHeight = $('.iedg-topbar').outerHeight();
        var navBarHeight = $('.iedg-navbar').outerHeight();
        var adminBarHeight = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0;
        var height = adminBarHeight + topBarHeight + navBarHeight;

        if ($('.js-iedg-navbar').hasClass('is-active')) {
          height = adminBarHeight + navBarHeight;
        }

        if ($('body.iedg-header-transparent').length < 1) {
          $('.iedg-navbar-collapse').css('height', 'calc(100vh - ' + height + 'px)');
        }
      }
    });
  }

  function handleSubMenu() {
    $('.iedg-navbar-nav__item .iedg-submenu-expand').on('click', function () {
      var subMenu = $(this).closest('.iedg-navbar-nav__item').find('.sub-menu');

      if (subMenu.hasClass('is-show')) {
        $(this).removeClass('is-active');
        subMenu.removeClass('is-show');
      } else {
        $(this).addClass('is-active');
        subMenu.addClass('is-show');
      }
    });
  }

  function handleNavbarFixed() {
    var topBar = $('.iedg-topbar');
    var headerNavBar = $('.iedg-header-navbar');
    var navBar = $('.iedg-navbar');
    var topBarHeight = topBar.outerHeight();
    var navBarHeight = navBar.outerHeight();
    var adminBarHeight = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0; // Desktop

    if ($(window).scrollTop() >= topBarHeight + adminBarHeight) {
      navBar.addClass('is-active');
      var topMenu = adminBarHeight;
      navBar.css('top', topMenu);
      $('body').css('padding-top', navBarHeight + adminBarHeight + 'px');
    } else {
      navBar.removeClass('is-active');
      navBar.css('top', 0);
      $('body').css('padding-top', 0);
    }
  }

  function handleLanguageMobile() {
    if ($('#iedg-language-mobile').length < 1) return;
    $('#iedg-language-mobile').on('click', function (e) {
      e.preventDefault();
      $('.iedg-nav-language-mobile .sub-menu').toggleClass('is-show');
      $('.iedg-nav-language-mobile .iedg-submenu-expand').toggleClass('is-active');
    });
  }

  function handleSearchPopup() {
    if ($('.iedg-search-cta').length < 1) return;
    $(document).on('click', '.iedg-search-cta', function (e) {
      e.preventDefault();
      $('.iedg-search__wrap').toggleClass('is-active');
      $('body').toggleClass('is-lock');
      $('.iedg-navbar-toggler').removeClass('is-active');
      $('.iedg-navbar-collapse').removeClass('is-show');
      $('body').removeClass('is-menu-show');
    });
  }

  function handleMenuClick() {
    $(document).on('click', '.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border) a', function (e) {
      if ($(window).width() > 991) {
        e.preventDefault();
        var link = $(this).attr('href');
        $('.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border)').removeClass('is-click');
        $('.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border)').removeClass('current-menu-item');
        $(this).closest('.iedg-navbar-nav__item').toggleClass('is-click');
        setTimeout(function () {
          window.location.href = link;
        }, 500);
      }
    });
  }

  $(function () {
    handleNavCollapse();
    handleLanguageMobile();
    handleSubMenu();
    handleSearchPopup();
    handleMenuClick();
    /* handleNavCollapse();
    handleSubMenu();
    handleNavbarFixed();
      $(window).on('scroll', function () {
        handleNavbarFixed();
    });
    
    $(window).on('resize', function() {
        handleNavbarFixed();
    }); */
  });
})(jQuery);

(function ($) {
  var isRunCounter = false;

  function initBanner() {
    if ($('.isa-home-banner__list').length < 1) return;
    $('.isa-home-banner__list').slick({
      slidesToShow: 1,
      centerMode: true,
      focusOnSelect: true,
      centerPadding: 0,
      dots: $('.isa-home-banner__item').length > 1 ? true : false,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 3000,
      responsive: [{
        breakpoint: 576,
        settings: {
          arrows: false
        }
      }]
    });
  }

  function initTestimonial() {
    if ($('.isa-testimonial__list').length < 1) return;
    $('.isa-testimonial__list').slick({
      lazyLoad: 'progressive',
      slide: '.isa-testimonial__item',
      slidesToShow: 1,
      centerMode: true,
      focusOnSelect: true,
      centerPadding: 0,
      dots: false,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 3000,
      fade: true
    });
    $(document).on('click', '.isa-testimonial__arrow--prev', function (e) {
      e.preventDefault();
      $('.isa-testimonial__list').slick('slickPrev');
    });
    $(document).on('click', '.isa-testimonial__arrow--next', function (e) {
      e.preventDefault();
      $('.isa-testimonial__list').slick('slickNext');
    });
  }

  function initProgram() {
    if ($('.isa-program__list').length < 1) return;
    $('.isa-program__list').slick({
      lazyLoad: 'progressive',
      slide: '.isa-program__item',
      slidesToShow: 2,
      centerMode: true,
      focusOnSelect: true,
      dots: false,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 3000,
      centerPadding: '15%',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          centerPadding: '10%'
        }
      }, {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          centerPadding: '48px'
        }
      }, {
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          centerPadding: '10%' //arrows: false,

        }
      }]
    });
    $('.isa-program__list').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      $('.isa-program__arrow--nav span').removeClass('is-active');
      $('.isa-program__arrow--nav span:eq(' + nextSlide + ')').addClass('is-active');
    });
    $(document).on('click', '.isa-program__arrow--prev', function (e) {
      e.preventDefault();
      $('.isa-program__list').slick('slickPrev');
    });
    $(document).on('click', '.isa-program__arrow--next', function (e) {
      e.preventDefault();
      $('.isa-program__list').slick('slickNext');
    });
  }

  function handlePositionCountryContent() {
    if ($('.isa-select-country__content').length < 1) return;
    $('.isa-select-country__content').each(function () {
      var title = $(this).find('.isa-select-country__title');
      var titleHeight = title.outerHeight();
      titleHeight += 32 + 16;
      $(this).closest('.isa-select-country__item').attr('style', '--countryTop: calc(100% - ' + titleHeight + 'px)');
    });
  }

  function handleCounterNumber() {
    if ($('.isa-about__item--number').length < 1) return;
    if (isRunCounter) return;
    var elValFromTop;
    var windowHeight = $(window).height(),
        windowScrollValFromTop = $(window).scrollTop();
    elValFromTop = Math.ceil($('.isa-about__item--number').offset().top);

    if (windowHeight + windowScrollValFromTop > elValFromTop) {
      counter();
      isRunCounter = true;
    }
  }

  function counter() {
    if ($('.isa-about__item--number').length < 1) return false;
    $('.isa-about__item--number').each(function () {
      $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
      }, {
        duration: 3000,
        easing: 'swing',
        step: function step(now) {
          now = Math.ceil(now);

          if (now.toString().length < 2) {
            now = '0' + now.toString();
          } else {
            now = new Intl.NumberFormat('de-DE').format(Math.ceil(now));
          }

          $(this).text(now);
        }
      });
    });
  }

  function initPartner() {
    if ($('.isa-partner__list').length < 1) return;
    $('.isa-partner__list').slick({
      lazyLoad: 'progressive',
      slide: '.isa-partner__item',
      slidesToShow: 4,
      centerMode: true,
      focusOnSelect: true,
      centerPadding: 0,
      dots: false,
      arrows: true,
      autoplay: false,
      autoplaySpeed: 3000,
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3
        }
      }, {
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      }, {
        breakpoint: 576,
        settings: {
          slidesToShow: 1
        }
      }]
    });
  }

  function handleTagPartner() {
    $('.isa-partner__tab a[data-toggle="tab"]').on('click', function (e) {
      console.log('click');
      setTimeout(function () {
        $('.isa-partner__list').slick('setPosition');
      }, 10);
    });
    $(document).on('shown.bs.tab', '.isa-partner__tab a[data-toggle="tab"]', function (e) {
      $('.isa-partner__list').slick('setPosition');
    });
  }

  $.handleMatchHeightBodyNews = function () {
    if ($('.pennacademy-news__body').length > 0) {
      $('.pennacademy-news__body').matchHeight();
    } // if( $('.pennacademy-news__desc').length > 0) {
    //     $('.pennacademy-news__desc').matchHeight();
    // }

  };

  function initEducationalPathway() {
    if ($('.pennacademy-educational-pathway__list').length < 1) return;
    $('.pennacademy-educational-pathway__list ').slick({
      slidesToShow: 1,
      centerMode: true,
      focusOnSelect: true,
      centerPadding: 0,
      dots: false,
      arrows: true,
      autoplay: false,
      autoplaySpeed: 3000,
      adaptiveHeight: true
    });
    $('.pennacademy-educational-pathway__list').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      $('.pennacademy-educational-pathway__tab .pennacademy-educational-pathway__tab-item').removeClass('active');
      $('.pennacademy-educational-pathway__tab .pennacademy-educational-pathway__tab-item:nth-child(' + (nextSlide + 1) + ')').addClass('active');
    });
  }

  function handlerTabEducationalPathway() {
    if ($('.pennacademy-educational-pathway__tab .pennacademy-educational-pathway__tab-item').length < 1) return;
    $(document).on('click', '.pennacademy-educational-pathway__tab .pennacademy-educational-pathway__tab-item', function () {
      $('.pennacademy-educational-pathway__list').slick('slickGoTo', $(this).index());
    });
  }

  function myFunction() {
    // alert('Hello');
    setTimeout(function () {
      // console.log(123);
      if ($('.pennacademy-training-bullet').length < 1) {
        return;
      } else {
        // console.log( "Index: " + $(".pennacademy-training-bullet.pennacademy-training__active").index() );
        var bullet = $(".pennacademy-training-bullet.pennacademy-training__active").index();
        console.log(bullet);

        if ($('.pennacademy-training-bullet').length - 1 == bullet) {
          $(".pennacademy-training-bullet:eq(0)").addClass('pennacademy-training__active');
          $(".pennacademy-training-bullet:eq(" + bullet + ")").removeClass('pennacademy-training__active'); // console.log($('.pennacademy-training-bullet').length)
        } else {
          $(".pennacademy-training-bullet:eq(" + (bullet + 1) + ")").addClass('pennacademy-training__active');
          $(".pennacademy-training-bullet:eq(" + bullet + ")").removeClass('pennacademy-training__active');
        }

        myFunction();
      }
    }, 3000);
  }

  $(function () {
    initBanner();
    initTestimonial();
    initProgram();
    initPartner();
    handleTagPartner();
    handleCounterNumber();
    $(window).on('scroll', function () {
      handleCounterNumber();
    });
    handlePositionCountryContent();
    $(window).resize(function () {
      handlePositionCountryContent();
    });
    $.handleMatchHeightBodyNews();
    $('.isa-partner__item--body').matchHeight();
    initEducationalPathway();
    handlerTabEducationalPathway();

    if ($('.pennacademy-educational-pathway__item').length > 0) {
      setTimeout(function () {
        var height = $('.pennacademy-educational-pathway__item.slick-current').outerHeight();
        $('.pennacademy-educational-pathway__list .slick-list').css('height', height + 'px');
      }, 300);
    } // handlerSliderPennacademyTraining();


    myFunction();
  });
})(jQuery);

(function ($) {
  function registerPostRating() {
    if ($('body.single-post .comment-form #rating').length < 1) return;
    $('#rating').hide().before('<p class="stars">\
                    <span>\
                        <a class="star-1" href="#">1</a>\
                        <a class="star-2" href="#">2</a>\
                        <a class="star-3" href="#">3</a>\
                        <a class="star-4" href="#">4</a>\
                        <a class="star-5" href="#">5</a>\
                    </span>\
                </p>');
    $(document).on('click', '#respond p.stars a', function () {
      var $star = $(this),
          $rating = $(this).closest('#respond').find('#rating'),
          $container = $(this).closest('.stars');
      $rating.val($star.text());
      $star.siblings('a').removeClass('active');
      $star.addClass('active');
      $container.addClass('selected');
      return false;
    });
    $('.acf-comment-fields').remove();
  }

  function handleCommentScroll() {
    if ($('body.single-post').length < 1) return false;

    if (window.location.hash) {
      var hash = window.location.hash;

      if (hash.search("comment-") > 0) {
        hash = hash.replace("#comment", "#li-comment");
        $('html, body').animate({
          scrollTop: $(hash).offset().top - 50
        }, 1000);
      }
    }
  }

  $(function () {
    registerPostRating();
    handleCommentScroll();
  });
})(jQuery);