"use strict";

function _slicedToArray(r, e) { return _arrayWithHoles(r) || _iterableToArrayLimit(r, e) || _unsupportedIterableToArray(r, e) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(r) { if (Array.isArray(r)) return r; }
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
var $ = jQuery.noConflict();
// Global functions
var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
function openPopupOverlay() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
  if ($('.rt-popup-overlay').length) return;
  $('body').append('<div class="rt-popup-overlay"></div>');
  $('body').addClass('is-lock').css('paddingRight', scrollbarWidth);
  $('.rt-popup-overlay').fadeIn(speed);
}
function closePopupOverlay() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 300;
  $('.rt-popup-overlay').fadeOut(speed);
  setTimeout(function () {
    $('.rt-popup-overlay').remove();
  }, speed);
  $('body').removeClass('is-lock').css('padding-right', '');
}
function getRootVars() {
  var root = document.querySelector(":root");
  root.style.setProperty("--vh", window.innerHeight / 100 + "px");
  root.style.setProperty("--mh", $('header.rt-header').outerHeight() + "px");
  root.style.setProperty("--gi", ($('#isa-gifts').length > 0 ? $('#isa-gifts').outerHeight() : 0) + "px");
}
window.addEventListener('load', function () {
  var locomotiveScroll = new LocomotiveScroll({
    lenisOptions: {
      wrapper: window,
      content: document.documentElement,
      lerp: 0.1,
      duration: 1.8,
      orientation: 'vertical',
      gestureOrientation: 'vertical',
      smoothWheel: true,
      smoothTouch: false,
      wheelMultiplier: 1,
      touchMultiplier: 2,
      normalizeWheel: true,
      easing: function easing(t) {
        return Math.min(1, 1.001 - Math.pow(2, -10 * t));
      }
    }
  });
  var homeClass = $('.page-template-home').length;

  // if (homeClass > 0) {
  //     setTimeout(function(){
  //         window.scrollTo(0, 0);

  //     }, 10);
  // }
});

// Main functions
(function ($) {
  $.rt_noti = function (html) {
    var time = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 2500;
    if ($('.rt-noti').length) return;
    $('body').append('<div class="rt-noti">' + html + '</div>');
    setTimeout(function () {
      $('.rt-noti').addClass('opening');
    }, 10);
    setTimeout(function () {
      $('.rt-noti').removeClass('opening');
    }, time);
    setTimeout(function () {
      $('.rt-noti').remove();
    }, time + 400);
  };
  function handleWordpressAdminMode() {
    if ($('#wpadminbar').length && $('.js-rt-navbar').length && $(window).width() <= 600) {
      $(window).on('scroll', function () {
        var top = $(window).scrollTop(),
          offsetTop = 46 - top > 0 ? 46 - top : 0;
        $('.js-rt-navbar').css('margin-top', offsetTop);
      });
    }
  }
  function initLazyLoad() {
    $('.lazy').Lazy({
      afterLoad: function afterLoad(el) {
        $(el).addClass('loaded');
        // handleIE();
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
    if ($('.rt-form-group select').length > 0) {
      $('.rt-form-group select').select2({
        width: "100%",
        minimumResultsForSearch: -1
      });
    }
    if ($('select.rt-is-select2').length > 0) {
      $('select.rt-is-select2').select2({
        width: "100%",
        minimumResultsForSearch: -1
      });
    }
    if ($('select.rt-is-select2-filter').length > 0) {
      $('select.rt-is-select2-filter').select2({
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
    $(document).on('click', '.rt-popup-overlay', function (e) {
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
      $('.rt-img-drop').each(function () {
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
    $('body .rt-header a[href*=\\#]:not([href=\\#])').click(function () {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('.rt-navbar-toggler').removeClass('is-active');
          $('.rt-navbar-collapse').removeClass('is-show');
          $('body').removeClass('is-lock');
          $('html, body').animate({
            scrollTop: target.offset().top - $('header .rt-navbar').outerHeight()
          }, 1000);
          return false;
        }
      }
    });
  }
  function initFormFloatLabel() {
    // Check input autofill
    $(window).bind('load', function () {
      $.each($('.rt-form-group input:-webkit-autofill'), function () {
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
    });

    // Check select
    $('.ginput_container_select select').closest('.gfield').addClass('has-select');
    $('.rt-form-group select').closest('.rt-form-group').addClass('has-select');

    // Check input
    var formFields = $('.gfield, .rt-form-group, .wpforms-field, .comment-form p');
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
  function handleLightGallery() {
    // Gallery
    $(document).on('click', '.rt-light-gallery', function (e) {
      e.preventDefault();
      var $dynamicGallery = document.querySelector(".rt-light-gallery");
      var sources = $(this).attr('data-sources');
      sources = JSON.parse(sources);
      var dynamicGallery = window.lightGallery($dynamicGallery, {
        dynamic: true,
        plugins: [lgVideo, lgThumbnail],
        // plugins: [lgVideo, lgAutoplay, lgZoom],
        dynamicEl: sources,
        download: false,
        counter: false,
        slideShowAutoplay: sources.length > 1 ? true : false,
        autoplayControls: false,
        autoplayVideoOnSlide: true,
        showCloseIcon: true,
        mobileSettings: {
          controls: true,
          showCloseIcon: true
        }
      });
      dynamicGallery.openGallery(0);
    });

    // Item
    $(document).on('click', '.rt-light-gallery-item', function (e) {
      e.preventDefault();
      var index = 0;
      var i = 0;
      var $dynamicGallery = document.querySelector(".rt-light-gallery-item");
      var sources = [];
      var element = $(this).closest('.rt-light-gallery-list');
      var urlTemp = $(this).find('img').attr('src');
      if (element.find('img').length > 0) {
        element.find('img').each(function (e) {
          if ($(this).attr('src') == urlTemp) {
            index = i;
          }
          var source = {
            "src": $(this).attr('src'),
            "thumb": $(this).attr('src'),
            "subHtml": $(this).attr('alt')
          };
          sources.push(source);
          i++;
        });
      }

      //sources = JSON.parse(sources);

      var dynamicGallery = window.lightGallery($dynamicGallery, {
        dynamic: true,
        // plugins: [lgZoom, lgVideo, lgThumbnail],
        plugins: [lgVideo, lgAutoplay],
        dynamicEl: sources,
        download: false,
        counter: false,
        slideShowAutoplay: sources.length > 1 ? true : false,
        autoplayControls: false,
        autoplayVideoOnSlide: true,
        showCloseIcon: true,
        mobileSettings: {
          controls: true,
          showCloseIcon: true
        }
      });
      dynamicGallery.openGallery(index);
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
    handleLightGallery();
  });
  $(window).on('resize', function () {
    getRootVars();
  });
})(jQuery);
(function ($) {
  function initializeCustomSelect(selectId, customSelectId) {
    var select = $(selectId);
    var customSelect = $(customSelectId);
    var optionsList = customSelect.find('.options');

    // Hide the default select box
    select.hide();

    // Populate the options list
    select.find('option').each(function () {
      var optionValue = $(this).val();
      var optionText = $(this).text();
      optionsList.append('<li data-value="' + optionValue + '">' + optionText + '</li>');
    });

    // Set the first option as the default selected and active option
    var firstOption = optionsList.find('li').first();
    firstOption.addClass('active');
    var firstOptionValue = firstOption.attr('data-value');
    var firstOptionText = firstOption.text();
    customSelect.find('.select-style').text(firstOptionText);
    select.val(firstOptionValue);

    // Click event to toggle the options list
    customSelect.find('.select-style').on('click', function () {
      optionsList.toggle();
    });

    // Click event to select an option
    customSelect.find('.options li').on('click', function () {
      var selectedOptionValue = $(this).attr('data-value');
      var selectedOptionText = $(this).text();
      customSelect.find('.select-style').text(selectedOptionText);
      select.val(selectedOptionValue);
      optionsList.find('li').removeClass('active');
      $(this).addClass('active');
      optionsList.hide();

      // Trigger a change event on the hidden select
      select.trigger('change');
    });

    // Close the options list when clicking outside the select box
    $(document).on('click', function (event) {
      if (!$(event.target).closest(customSelectId).length) {
        optionsList.hide();
      }
    });
  }
  $(function () {
    initializeCustomSelect('#select-1', '#select-position');
  });
})(jQuery);
(function ($) {
  function handleActiveMenu() {
    $(document).ready(function () {
      $(".caret").click(function () {
        // Remove 'active' and 'caret-down' from all elements
        $(".nested").removeClass("active");
        $(".caret").removeClass("current-menu-parent");

        // Add 'active' and 'caret-down' to the clicked element
        $(this).find(".nested").addClass("active");
        $(this).addClass("current-menu-parent");
      });
    });
    if ($(".rt-archive-sidebar").find('.caret').hasClass('current-menu-parent')) {
      $('.rt-archive-sidebar .current-menu-parent').find(".nested").addClass("active");
    }
    if ($(".rt-archive-sidebar").find('.caret').hasClass('current_page_item')) {
      $('.rt-archive-sidebar .current_page_item').find(".nested").addClass("active");
    }
  }
  $(function () {
    handleActiveMenu();
  });
})(jQuery);
(function ($) {
  var clsActive = "toc-active";
  var toc_sel = ".rt-details__toc";
  var item_sel = "ul.list > li";
  var scroll = new LocomotiveScroll({
    // el: document.querySelector('body'),
    wrapper: window,
    content: document.documentElement,
    lerp: 0.1,
    duration: 1.2,
    orientation: 'vertical',
    gestureOrientation: 'vertical',
    smoothWheel: true,
    smoothTouch: false,
    wheelMultiplier: 1,
    touchMultiplier: 2,
    normalizeWheel: true,
    easing: function easing(t) {
      return Math.min(1, 1.001 - Math.pow(2, -10 * t));
    }
    // smooth: true
  });
  function handleToC(selector) {
    if ($(selector).length === 0 || $(selector + " " + item_sel).length === 0) return false;
    var toc_item = document.querySelectorAll(selector + " " + item_sel);
    toc_item.forEach(function (elem) {
      elem.addEventListener('click', function () {
        var childs = this.parentElement.children;
        console.log(childs);
        for (var i = 0; i < childs.length; i++) {
          console.log(childs[i]);
          if (childs[i] !== elem) {
            childs[i].classList.remove(clsActive);
          } else {
            childs[i].classList.add(clsActive);
          }
        }
      });
    });
  }
  function handleScrollTableOfContent() {
    $(document).on('click', '.rt-details__toc a[href*=\\#]:not([href=\\#])', function (e) {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        $('.rt-details__toc li').removeClass('toc-active');
        if (target.length) {
          $(this).closest('li').addClass('toc-active');
          var scrollTop = target.offset().top;
          scrollTop = scrollTop - ($('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0);
          // scrollTop = scrollTop - ($('.rt-header').length > 0 ? $('.rt-header').outerHeight() : 0);

          scroll.scrollTo(scrollTop, {
            duration: 4
          });
          return false;
        }
      }
    });
  }
  function setActiveTableOfContent(event) {
    if ($('.rt-details__toc a[href*=\\#]:not([href=\\#])').length < 1) return;
    var scrollTop = 0;
    scrollTop = scrollTop + ($('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0);
    // scrollTop = scrollTop + ($('.rt-header').length > 0 ? $('.rt-header').outerHeight() : 0);

    var windowPos = $(window).scrollTop() + scrollTop;
    $('.rt-details__toc li').removeClass('toc-active');
    $('.rt-details__toc a[href*=\\#]:not([href=\\#])').each(function () {
      var currentLink = $(this);
      if ($(currentLink.attr("href")).length > 0) {
        var refElement = $(currentLink.attr("href"));
        if (refElement.position().top <= windowPos) {
          currentLink.closest('li').addClass("toc-active");
        }
      }
    });
    removeActiveTableOfContent();
  }
  function removeActiveTableOfContent() {
    if ($('.rt-details__toc').length < 1) return;
    $('.rt-details__toc').each(function () {
      if ($(this).find('li.toc-active').length > 1) {
        var tolTal = $(this).find('li.toc-active').length;
        var i = 1;
        $(this).find('li.toc-active').each(function () {
          if (i < tolTal) {
            $(this).removeClass('toc-active');
          }
          i++;
        });
      }
    });
  }
  $(function () {
    // handleToC(toc_sel);

    handleScrollTableOfContent();
    setActiveTableOfContent();
    $(window).scroll(function () {
      setActiveTableOfContent();
    });
  });
})(jQuery);
(function ($) {
  function initSliderFeaturedEvents() {
    if ($('.isa-featured-events__list').length < 1) return;
    var swiper = new Swiper('.isa-featured-events__list', {
      speed: 400,
      slidesPerView: 1.1,
      spaceBetween: 16,
      loop: true,
      allowSlideNext: true,
      pagination: {
        el: ".isa-featured-events__pagination--bulet",
        clickable: true
      },
      navigation: {
        nextEl: '.isa-featured-events__arrow--next',
        prevEl: '.isa-featured-events__arrow--prev'
      },
      breakpoints: {
        1400: {
          slidesPerView: 2.7
        },
        1024: {
          slidesPerView: 2.1
        },
        // when window width is >= 768px
        768: {
          slidesPerView: 1.7
        },
        576: {
          slidesPerView: 1.4,
          spaceBetween: 24
        }
      }
    });
  }
  function handleHoverFeaturedEvents() {
    // $(".isa-why-us__item").each(function () {    
    //     let headHeight = $(this).find('.isa-why-us__item--head').outerHeight();
    //     let bodyHeight = $(this).find('.isa-why-us__item--body').outerHeight();
    //     console.log(headHeight)
    //     let itemHeight = headHeight + bodyHeight
    //     $(this).attr('style', '--itemHeight:' + itemHeight + 'px; --headHeight:' + headHeight + 'px'); 
    // });

    $('.isa-featured-events__item').on({
      mouseenter: function mouseenter() {
        $(this).find('.isa-ticket').addClass('is-hover');
      },
      mouseleave: function mouseleave() {
        $(this).find('.isa-ticket').removeClass('is-hover');
      }
    });
  }
  function handlePostMore() {
    var showChar = 50;
    var ellipsestext = "...";
    $(".isa-ticket__inner--left").find('h3').each(function () {
      var content = $(this).html();
      if (content.length > showChar) {
        var c = content.substr(0, showChar);
        var h = content.substr(showChar, content.length - showChar);
        var html = c + '<span class="moreellipses">' + ellipsestext + '</span>';
        $(this).html(html);
      }
    });
  }
  $(function () {
    initSliderFeaturedEvents();
    handleHoverFeaturedEvents();
    $(window).on("resize", function () {});
    $(document).ready(function () {
      // handlePostMore();
    });
  });
})(jQuery);
(function ($) {
  function handleScrollToTop() {
    $(document).on('click', '.rt-scroll-to-top', function (e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: 0
      }, 1000);
    });
  }
  function handleDisplayScrollToTop() {
    var scrollHeight = $(document).height();
    var scrollPosition = $(window).height() + $(window).scrollTop();
    if (scrollPosition >= scrollHeight - 100) {
      $('.rt-scroll-to-top').addClass('is-active');
    } else {
      $('.rt-scroll-to-top').removeClass('is-active');
    }
  }
  $(function () {
    handleScrollToTop();
    handleDisplayScrollToTop();
    $(window).scroll(function () {
      handleDisplayScrollToTop();
    });
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
        $('.js-rt-navbar').css('margin-top', '');
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
        if ($('#wpadminbar').length && $('.js-rt-navbar').length) {
          $('.js-rt-navbar').css('margin-top', offsetTop);
        } else {
          $('.js-rt-navbar').css('margin-top', '');
        }
      }
    });
  }
  $(function () {
    DemoAdminBarMode();
  });
})(jQuery);
(function ($) {
  var body = $('body');
  var scrollUp = "scroll-up";
  var scrollDown = "scroll-down";
  var lastScroll = 0;
  function handleScrollMenu() {
    $(window).on('scroll', function () {
      calculateScroll();
    });
  }
  function calculateScroll() {
    var currentScroll = window.pageYOffset;
    if (currentScroll > lastScroll && !body.hasClass(scrollDown)) {
      // down
      body.removeClass(scrollUp);
      body.addClass(scrollDown);
    } else if (currentScroll < lastScroll && body.hasClass(scrollDown)) {
      // up
      body.removeClass(scrollDown);
      body.addClass(scrollUp);
    }
    lastScroll = currentScroll;
    if (currentScroll <= 0) {
      body.removeClass(scrollUp);
    }
  }
  function handleClickMenuButton() {
    $(document).on('click', '.rt-header__hamburger .btn', function () {
      if (document.body.classList.contains('opened-menu')) {
        $('body').removeClass('opened-menu is-lock');
        $(this).find('span').html(this.dataset.label);
        $(this).parents('.rt-header__head').each(function () {
          $(this).removeClass('open');
          $(this).removeAttr('style');
        });
      } else {
        $('body').addClass('opened-menu is-lock');
        $(this).find('span').html(this.dataset.close);
        $(this).parents('.rt-header__head').each(function () {
          $(this).addClass('open');
          $(this).css({
            height: $('.rt-header__nav').height() + 150,
            width: $('.rt-header__nav').outerWidth() + 60
          });
        });
      }
    });
  }
  $(function () {
    handleScrollMenu();
    calculateScroll();
    handleClickMenuButton();
  });
})(jQuery);
(function ($) {
  var listSel = ".rt-related-posts__list";
  function initPostsSlider() {
    if ($(listSel).length < 1) return;
    var brand = new Swiper(listSel, {
      slidesPerView: 1.5,
      spaceBetween: 20,
      loop: true,
      lazy: true,
      breakpoints: {
        576: {
          spaceBetween: 20,
          slidesPerView: 1.8
        },
        992: {
          slidesPerView: 2.2,
          spaceBetween: 20
        },
        1600: {
          slidesPerView: 2.4,
          spaceBetween: 24
        }
      }
    });
  }
  $(function () {
    initPostsSlider();
  });
})(jQuery);
(function ($) {
  var sliderInstances = {};
  function initStrategicPartnershipSlider(elementTop, tabId) {
    if ($('.isa-strategic-partnership__list').length < 1) return;

    // console.log(sliderInstances);

    if (sliderInstances[tabId]) {
      // Slider đã được khởi tạo, không khởi tạo lại
      return;
    }
    var sliderUniversity = new Swiper(elementTop, {
      slidesPerView: 1.4,
      spaceBetween: 16,
      loop: true,
      lazy: true,
      speed: 500,
      autoplay: {
        delay: 2500,
        disableOnInteraction: true,
        pauseOnMouseEnter: true
      },
      on: {
        init: function init() {
          $('.isa-strategic-partnership__list .lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
              // handleIE();
            }
          });
          handleMatchHeight();
        },
        afterInit: function afterInit() {
          $('.isa-strategic-partnership__list .lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
              // handleIE();
            }
          });
          handleMatchHeight();
        },
        slideChangeTransitionEnd: function slideChangeTransitionEnd() {
          $('.isa-strategic-partnership__list .lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
              // handleIE();
            }
          });
          handleMatchHeight();
        },
        resize: function resize() {
          $('.isa-strategic-partnership__list .lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
              // handleIE();
            }
          });
          handleMatchHeight();
        }
      },
      navigation: {
        nextEl: '.isa-strategic-partnership__arrow .isa-swiper-next',
        prevEl: '.isa-strategic-partnership__arrow .isa-swiper-prev'
      },
      breakpoints: {
        480: {
          spaceBetween: 16,
          slidesPerView: 2
        },
        992: {
          spaceBetween: 24,
          slidesPerView: 3
        },
        1400: {
          slidesPerView: 4,
          spaceBetween: 24
        }
      }
    });

    // $(elementTop).mouseenter(function() {
    //     sliderUniversity.autoplay.pause();
    //     console.log('slider pause');
    // });

    // $(elementTop).mouseleave(function() {
    //     sliderUniversity.autoplay.resume();
    //     console.log('slider resume again');
    // });

    sliderInstances[tabId] = sliderUniversity;
  }
  function handleStrategicPartnershipTab() {
    $('.isa-strategic-partnership__mobile li').click(function () {
      var position = $(this).position();
      var scroll = $('.isa-strategic-partnership__mobile').scrollLeft();
      $('.isa-strategic-partnership__mobile').animate({
        'scrollLeft': scroll + position.left - 30
      }, 200);
    });
    if ($('#StrategicTabContent .tab-pane.active').length > 0) {
      var elementTop = '#StrategicTabContent .tab-pane.active .isa-strategic-partnership__list';
      var tabId = $('#StrategicTabContent .tab-pane.active').attr('id');
      initStrategicPartnershipSlider(elementTop, tabId);
    }
    $('.isa-strategic-partnership__nav button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      var elementTop = '#StrategicTabContent .tab-pane.active .isa-strategic-partnership__list';
      var tabId = $('#StrategicTabContent .tab-pane.active').attr('id');
      initStrategicPartnershipSlider(elementTop, tabId);
    });
  }
  function handleMatchHeight() {
    if ($('.isa-strategic-partnership__item--logo').length > 0) {
      $('.isa-strategic-partnership__item--logo').matchHeight();
    }
  }
  $(function () {
    handleStrategicPartnershipTab();
    initStrategicPartnershipSlider();
    $(window).on("resize", function () {});
  });
})(jQuery);
(function ($) {
  function initSliderWhyUS() {
    if ($('.isa-why-us__list').length < 1) return;
    var swiper = new Swiper('.isa-why-us__list', {
      speed: 400,
      slidesPerView: 1.2,
      spaceBetween: 24,
      loop: true,
      allowSlideNext: true,
      pagination: {
        el: ".isa-why-us__pagination--bulet",
        clickable: true
      },
      navigation: {
        nextEl: '.isa-why-us__arrow--next',
        prevEl: '.isa-why-us__arrow--prev'
      },
      breakpoints: {
        1024: {
          slidesPerView: 2.7
        },
        // when window width is >= 768px
        768: {
          slidesPerView: 1.7
        },
        576: {
          slidesPerView: 1.4
        }
      }
    });
  }
  function handleWidthTitle() {
    if ($('.isa-why-us__title').length < 1) return;
    var widthTitle = $('.isa-why-us__title').outerWidth();
    $('.isa-why-us__title').attr('style', '--widthTitle:' + widthTitle + 'px');
  }
  function handleMatchHeight() {
    if ($('.isa-why-us__item--title').length > 0) {
      $('.isa-why-us__item--title').matchHeight();
    }
    if ($('.isa-why-us__item--desc').length > 0) {
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
    $(document).ready(function () {});
  });
})(jQuery);
(function ($) {
  var introSec = ".rt-intro";
  var discoverSec = ".rt-discover";
  var videoSel = introSec + " .video-wrapper";
  var maskSel = videoSel + " .mask";
  var sliderSel = discoverSec + "__inner--slider__main";
  var thumbSel = discoverSec + "__inner--slider__thumbs";
  var nextSel = discoverSec + "__inner--slider__next";
  var prevSel = discoverSec + "__inner--slider__prev";
  var textSel = discoverSec + " .text-line";
  var slideActiveSel = discoverSec + " .swiper-slide.swiper-slide-active";
  var btnSel = 'rt-btn-primary';
  var heroLineCls = 'hero-effect__line';
  var heroLetterCls = 'hero-effect__letter';
  var dividers = ['!', ',', '.', '&', '+', '=', '/', '\\', '<', '>', '*', '-'];
  var limits = {
    480: 3,
    576: 4,
    767: 5,
    992: 6,
    1200: 7,
    1400: 8,
    1600: 9
  };
  var delayTime = 0.1;
  var letterRatio = 1.15;
  var about = {
    execute: function execute(selector, callback) {
      var elem = document.querySelectorAll(selector);
      if (elem.length === 0) {
        return false;
      }
      if (typeof callback === 'function') {
        callback(selector, elem);
      }
    },
    init: function init() {
      about.handleVideo(maskSel);
      about.handleSlider(sliderSel);
      about.handleResize();
    },
    handleResize: function handleResize() {
      window.addEventListener('resize', function () {
        about.handleWordEffect(textSel);
      });
    },
    checkString: function checkString(str, callback) {
      if (str === '' || str === null) {
        return false;
      }
      if (typeof str === 'string' || _typeof(str) === 'object') {
        if (typeof callback === 'function') {
          callback(str);
        }
      }
    },
    getStrWidth: function getStrWidth(str) {
      var textElem = document.querySelector(textSel),
        span = null;
      var finals = 0.000;
      if (textElem === null) {
        return false;
      }

      //create a temporary span to calculate word width
      span = document.createElement('span');
      span.innerHTML = str;
      span.style.position = 'absolute';
      span.style.opacity = "0";

      //Temporarily append span to text element for calculating, then remove it
      textElem.appendChild(span);
      finals = about.getElemWidth(span, false);
      //console.log('STRING WIDTH: ', finals);
      textElem.removeChild(span);
      return finals;
    },
    getElemWidth: function getElemWidth(selector) {
      var isAll = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      if (selector === "" || selector === null || typeof selector === 'undefined') return 0;
      var result = null,
        widthWithPaddings = 0.000,
        elem = null;
      if (_typeof(selector) === 'object' || typeof selector === 'string') {
        if (_typeof(selector) === 'object') {
          elem = selector;
        }
        if (typeof selector === 'string') {
          if (isAll) {
            elem = document.querySelectorAll(selector);
          } else {
            elem = document.querySelector(selector);
          }
        }
      }
      if (elem === null) return false;
      if (!isAll) {
        result = about.getBaseWidth(elem);
      } else {
        var widths = [];
        var _iterator = _createForOfIteratorHelper(elem),
          _step;
        try {
          for (_iterator.s(); !(_step = _iterator.n()).done;) {
            var el = _step.value;
            widths.push(about.getBaseWidth(el));
          }
        } catch (err) {
          _iterator.e(err);
        } finally {
          _iterator.f();
        }
        result = widths;
      }
      return result;
    },
    getBaseWidth: function getBaseWidth(elem) {
      var result = 0.000;
      if (elem === null || typeof elem === 'undefined' || _typeof(elem) !== 'object') return result;
      var widthPadding = elem.getBoundingClientRect().width;
      var elemComputedStyle = window.getComputedStyle(elem, null);
      result = Math.ceil(widthPadding - (parseFloat(elemComputedStyle.paddingLeft) + parseFloat(elemComputedStyle.paddingRight))) * letterRatio;
      return result;
    },
    countWords: function countWords(str) {
      about.checkString(str, function (str) {
        var count = str.trim().split(/\s+/).length;
        return count;
      });
    },
    splitWords: function splitWords(str) {
      if (str === '' || str === null || typeof str === 'undefined') return [];
      var words = [],
        regex = /\s+/;
      words = str.trim().split(regex);
      return words;
    },
    splitLines: function splitLines(wordsArr, totalWidth) {
      if (wordsArr === null || typeof wordsArr === 'undefined' || !Array.isArray(wordsArr)) return false;
      var baseWidth = 0.000,
        count = wordsArr.length,
        line = [],
        totalLines = [],
        i = 0;
      do {
        var word = wordsArr[i],
          width = 0.000;
        if (i < count - 1) word += " ";
        width = about.getStrWidth(word);
        baseWidth += width;
        line.push(word);
        //console.log(line);
        if (baseWidth > totalWidth) {
          var recalWidth = about.getStrWidth(word.trim());
          if (baseWidth - width + recalWidth * 1 / letterRatio > totalWidth) {
            line.pop(word);
            baseWidth = width;
            totalLines.push(line);
            line = [];
            //console.log("word:|" + word + "|");
            line.push(word);
          } else {
            baseWidth = baseWidth - width + recalWidth * 1 / letterRatio;
            line.pop(word);
            line.push(word.trim());
          }
        }
        if (i === count - 1) {
          totalLines.push(line);
        }
        i++;
      } while (i <= count - 1);
      //console.log("totalLines:", totalLines);
      return totalLines;
    },
    handleLinesBreaker: function handleLinesBreaker(str) {
      var width = $(window).width(),
        wrapperWidth = $(textSel).width(),
        size = '';
      for (var _i = 0, _Object$entries = Object.entries(limits); _i < _Object$entries.length; _i++) {
        var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
          key = _Object$entries$_i[0],
          value = _Object$entries$_i[1];
        if (width >= key) size = key;
      }
      var wordsArr = about.splitWords(str);
      return about.splitLines(wordsArr, wrapperWidth);
    },
    handleWordEffect: function handleWordEffect(selector, elem) {
      about.execute(selector, function (selector, elem) {
        elem.forEach(function (item, index) {
          var lines = [],
            type = item.tagName,
            isBtn = false,
            regEx = /\r?\n|\r|\n/g;
          var baseDelay = delayTime;
          isBtn = type.toLowerCase() === 'a' && item.classList.contains(btnSel);
          if (isBtn) {
            //if customized button get first child's text content
            lines = item.firstChild !== null ? item.firstChild.textContent.split(regEx) : item.textContent.split(regEx);
            lines.forEach(function (line) {
              var newLine = document.createElement('div');
              newLine.classList.add(heroLineCls);
              for (var i = 0; i < line.length; i++) {
                var letter = document.createElement('span');
                var bonusDelay = i * 0.1;
                letter.classList.add(heroLetterCls);
                letter.innerText = line[i];
                letter.style.setProperty('--delay', delayTime + bonusDelay + 's');
                newLine.appendChild(letter); //add each character element to the new line

                //add each character element to first child of element
                item.replaceChild(newLine, item.firstChild);
              }
            });
          } else {
            //else get element's text content
            lines = about.handleLinesBreaker(item.textContent);
            //lines = item.textContent.split(regEx);
            item.innerHTML = "";
            if (!Array.isArray(lines)) return false;
            lines.forEach(function (line) {
              var newLine = document.createElement('div');
              newLine.classList.add(heroLineCls);
              var indexDelay = 0.01;
              baseDelay += indexDelay;

              //traversing the characters of text to add delay
              for (var i = 0; i < line.length; i++) {
                for (var j = 0; j < line[i].length; j++) {
                  var letter = document.createElement('span');
                  var letterDelay = 0.01;
                  baseDelay += letterDelay;
                  letter.classList.add(heroLetterCls);
                  letter.innerHTML = line[i][j];
                  letter.style.setProperty('--delay', baseDelay + 's');
                  newLine.appendChild(letter); //add each character element to the new line
                }
              }

              //add each character element to the element
              item.appendChild(newLine);
            });
          }
        });
      });
    },
    handleVideo: function handleVideo(selector) {
      about.execute(selector, function (selector, elem) {
        elem.forEach(function (item) {
          item.addEventListener('click', function (e) {
            e.preventDefault();
            var sources, gallery;
            sources = this.dataset.sources;
            sources = JSON.parse(sources);
            gallery = window.lightGallery(item, {
              dynamic: true,
              plugins: [lgVideo, lgAutoplay, lgThumbnail],
              dynamicEl: sources,
              download: false,
              counter: false,
              slideShowAutoplay: sources.length > 1 ? true : false,
              autoplayControls: false,
              autoplayVideoOnSlide: true,
              showCloseIcon: true,
              mobileSettings: {
                controls: true,
                showCloseIcon: true
              }
            });
            gallery.openGallery(0);
          });
        });
      });
    },
    handleSlider: function handleSlider(selector, elem) {
      about.execute(selector, function (selector, elem) {
        elem.forEach(function (item) {
          var swiper = new Swiper(selector, {
            speed: 0,
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            centeredSlides: true,
            allowTouchMove: false,
            pagination: {
              el: thumbSel,
              clickable: true
            },
            navigation: {
              nextEl: nextSel,
              prevEl: prevSel
            },
            on: {
              afterInit: function afterInit(e) {
                about.handleWordEffect(textSel);
              }
            }
          });
        });
      });
    }
  };
  $(function () {
    about.init();
  });
})(jQuery);
(function ($) {
  var paged = 1;
  function handleLoadNewsMore() {
    $(document).on('click', '.btn-ajax-read-more', function (e) {
      e.preventDefault();
      var element = $(this);
      var link = $(this).attr('data-url');
      var total = $(this).attr('data-total');
      paged++;
      link += '/page/' + paged;
      $.ajax({
        url: link,
        type: 'GET',
        cache: false,
        beforeSend: function beforeSend(xhr) {
          element.addClass('is-loading');
        }
      }).done(function (res) {
        var html = $(res);
        $('.rt-blog__inner--posts .posts-wrapper').append(html.find('.rt-blog__inner--posts .posts-wrapper').html());
        element.removeClass('is-loading');
        $('.lazy').Lazy({
          afterLoad: function afterLoad(elm) {
            $(elm).css('visibility', 'visible');
          }
        });
        if (parseInt(paged) >= parseInt(total)) {
          element.closest('.btn-readmore').addClass('d-none');
        }
      }).fail(function (res) {});
    });
  }
  $(function () {
    handleLoadNewsMore();
  });
})(jQuery);
(function ($) {
  var paged = 1;
  var eventArchiveSel = ".rt-event-archive";
  var eventListSel = eventArchiveSel + "__list";
  var eventFormSel = eventArchiveSel + "__form";
  var eventItemSel = eventArchiveSel + '__item';
  var btnLoadMoreSel = ".rt-button__loadmore";
  var btnSearchSel = ".btn-search";
  var isLoadingCls = "is-loading";
  var ajaxId = "ajaxdata";
  var eventLoadData = function eventLoadData(form) {
    var offset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    var callback = arguments.length > 2 ? arguments[2] : undefined;
    var data = $(form).serializeArray(),
      ajaxdata = document.getElementById('ajaxdata');
    data.push({
      name: 'offset',
      value: offset
    });
    $.ajax({
      data: data,
      method: 'post',
      dataType: 'json',
      url: wp_vars.ajax_url,
      beforeSend: function beforeSend() {
        $(form).find(btnSearchSel).addClass(isLoadingCls);
      },
      success: function success(response) {
        var posts = response.results.posts,
          count = response.results.count;
        console.log('COUNT: ' + response.results.count);
        console.log('POSTS: ' + response.results.posts);
        $(form).find(btnSearchSel).removeClass(isLoadingCls);
        console.log(posts, count);
        if (posts.length > 0) {
          $.each(posts, function (i, e) {
            if (i == offset) {
              $(ajaxdata).html(e);
            } else {
              $(ajaxdata).append(e);
            }
          });
          $('.lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
            }
          });
        }
        if (!$(ajaxdata).find(btnLoadMoreSel).length) {
          if (count == $(ajaxdata).find(eventItemSel).length) {
            $(ajaxdata).parent().find(btnLoadMoreSel).hide();
          } else {
            $(ajaxdata).parent().find(btnLoadMoreSel).show();
          }
        }
        if (typeof callback === 'function') {
          callback(response);
        }
      },
      error: function error() {
        $(form).removeClass('loading');
      }
    });
  };
  function handleLoadMore() {
    $(document).on('click', btnLoadMoreSel, function () {
      var _this = this;
      var form = $(eventFormSel),
        offset = $(eventItemSel).length;
      this.classList.add(isLoadingCls);
      eventLoadData(form, offset, function (response) {
        _this.classList.remove(isLoadingCls);
      });
    });
  }
  ;
  function handleFilter() {
    $(document).on('change', eventFormSel + ' select', function (e) {
      var form = $(eventFormSel);
      this.classList.add(isLoadingCls);
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: wp_vars.ajax_url,
        cache: false,
        data: $(this.form).serialize(),
        beforeSend: function beforeSend(xhr) {
          $(eventListSel).addClass('is-loading-overlay');
        }
      }).done(function (res) {
        var html = res.results.posts.join("");
        var count = 0;
        var limit = 0;
        $("#" + ajaxId).html(html);
        count = res.results.count;
        limit = res.results.perpage;
        console.log("LIMIT:" + limit + " - COUNT: " + count);
        if (count > limit) {
          $(ajaxdata).parent().find(btnLoadMoreSel).show();
        } else {
          $(ajaxdata).parent().find(btnLoadMoreSel).hide();
        }
        $(eventListSel).removeClass('is-loading-overlay');
        $('.lazy').Lazy({
          afterLoad: function afterLoad(elm) {
            $(elm).css('visibility', 'visible');
          }
        });
      }).fail(function (res) {});
    });
  }
  $(function () {
    handleFilter();
    handleLoadMore();
  });
})(jQuery);
(function ($) {
  function initSliderBanner() {
    if ($('.isa-home-banner__slider').length < 1) return;
    var progressCircle = $(".isa-home-banner__pager .rt-progress.over");
    var progressContent = $(".isa-home-banner__pager span");
    var sliderBanner = new Swiper('.isa-home-banner__slider', {
      slidesPerView: 1,
      spaceBetween: 16,
      effect: "fade",
      fadeEffect: {
        crossFade: true
      },
      loop: true,
      autoplay: {
        delay: 6500,
        disableOnInteraction: false
      },
      pagination: {
        el: '.slider-pagination',
        clickable: true,
        type: "bullets",
        bulletClass: "isa-bullet",
        bulletActiveClass: "is-active",
        renderBullet: function renderBullet(index, className) {
          var slide = this.slides[index];
          var pagerCategory = slide.dataset.pagerCategory;
          var pagerTitle = slide.dataset.pagerTitle;
          return '<div class="' + className + '"><div class="pager__item"><span><strong>' + pagerCategory + '</strong></span></div> </div>';
        }
      },
      on: {
        autoplayTimeLeft: function autoplayTimeLeft(s, time, progress) {
          // console.log(progress);
          // progressCircle.style.setProperty("--progress", 1 - progress);
          progressCircle.attr('style', '--progress:' + (1 - progress));
          progressContent.textContent = "".concat(Math.ceil(time / 1000), "s");
        }
      },
      navigation: {
        nextEl: '.tohs-prestigious-university__arrow .tohs-swiper-next',
        prevEl: '.tohs-prestigious-university__arrow .tohs-swiper-prev'
      }
    });
    var toggleButton = document.getElementById('toggleButtonPause');
    var pager = $('.isa-home-banner__pager');
    var video = $('.isa-home-banner__video video');
    var isPlaying = true;

    // Make sure the video plays inline instead of full screen
    video.attr('playsinline', '');
    video.attr('webkit-playsinline', '');
    toggleButton.addEventListener('click', function () {
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
    if ($('.isa-home-banner .isa-bullet .pager__item').length > 0) {
      $('.isa-home-banner .isa-bullet .pager__item').matchHeight();
    }
  }
  function initSliderVistLocation() {
    if ($('.isa-vist-location__list').length < 1) return;
    var swiper = new Swiper('.isa-vist-location__list', {
      speed: 400,
      slidesPerView: 1,
      spaceBetween: 24,
      loop: true,
      allowSlideNext: true,
      pagination: {
        el: ".isa-vist-location__pagination--bulet",
        clickable: true
      },
      navigation: {
        nextEl: '.isa-vist-location__arrow--next',
        prevEl: '.isa-vist-location__arrow--prev'
      },
      breakpoints: {
        1024: {
          slidesPerView: 3
        },
        // when window width is >= 768px
        576: {
          slidesPerView: 2
        }
      }
    });
  }
  var sliderInstances = {};
  function initPrestigiousUniversitySlider(elementTop, tabId) {
    if ($('.isa-prestigious-university__list').length < 1) return;

    // console.log(sliderInstances);

    if (sliderInstances[tabId]) {
      // Slider đã được khởi tạo, không khởi tạo lại
      return;
    }
    var sliderUniversity = new Swiper(elementTop, {
      slidesPerView: 1.2,
      spaceBetween: 16,
      centeredSlides: true,
      loop: true,
      lazy: true,
      speed: 500,
      pagination: {
        el: ".isa-prestigious-university__pagination--nav",
        type: "progressbar"
      },
      on: {
        init: function init() {
          updatePaginationCounter();
          handleMatchHeightTitle();
        },
        slideChangeTransitionEnd: function slideChangeTransitionEnd() {
          handleMatchHeightTitle();
          updatePaginationCounter();
        },
        resize: function resize() {
          handleMatchHeightTitle();
          calcWidthSlider();
        }
      },
      navigation: {
        nextEl: '.isa-prestigious-university .isa-swiper-next',
        prevEl: '.isa-prestigious-university .isa-swiper-prev'
      },
      breakpoints: {
        768: {
          spaceBetween: 32,
          slidesPerView: 1.5
        },
        992: {
          slidesPerView: 1.4,
          spaceBetween: 48
        },
        1600: {
          slidesPerView: 1.7,
          spaceBetween: 54
        }
      }
    });
    sliderInstances[tabId] = sliderUniversity;
    calcWidthSlider();
    updatePaginationCounter();
    handleMatchHeightTitle();
  }
  function updatePaginationCounter() {
    var currentTab = $('#UniversityTab').find('.nav-link.active').attr('id');
    var currentSwiper = document.getElementById(currentTab + '-content').querySelector('.swiper-container');
    var currentSlide = (currentSwiper.swiper.realIndex + 1).toString().padStart(2, '0');
    var totalSlides = currentSwiper.swiper.slides.length.toString().padStart(2, '0');
    $('.isa-prestigious-university__pagination--count').find(".current").text(currentSlide);
    $('.isa-prestigious-university__pagination--count').find(".total").text(totalSlides);
  }
  function handleMatchHeightTitle() {
    var maxHeight = 0;
    $('.isa-prestigious-university .content-top__title').css('height', 'auto');
    $('.isa-prestigious-university .content-top__title').each(function () {
      var height = $(this).outerHeight();
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
      var elementTop = '#UniversityTabContent .tab-pane.active .isa-prestigious-university__list';
      var tabId = $('#UniversityTabContent .tab-pane.active').attr('id');
      initPrestigiousUniversitySlider(elementTop, tabId);
    }
    $('.isa-prestigious-university__nav button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      var elementTop = '#UniversityTabContent .tab-pane.active .isa-prestigious-university__list';
      var tabId = $('#UniversityTabContent .tab-pane.active').attr('id');
      initPrestigiousUniversitySlider(elementTop, tabId);
      updatePaginationCounter();
    });
  }
  function calcWidthSlider() {
    var fullWidthSlider = $('#UniversityTabContent').outerWidth();
    var widthSlideCenter = $('.isa-prestigious-university__list .swiper-slide-active').outerWidth();
    var result = (fullWidthSlider - widthSlideCenter) / 2;
    widthSlideCenter = widthSlideCenter + 24;
    $('.isa-slider-prestigious-university-container').css('max-width', widthSlideCenter + 'px');
    $('.isa-prestigious-university__list').attr('style', '--positionArrow:' + result + 'px');
  }
  $(function () {
    initSliderBanner();
    initSliderVistLocation();
    handlePrestigiousUniversityTab();
    initPrestigiousUniversitySlider();
    handleMatchHeightTitle();
    $(window).on("resize", function () {});
  });
})(jQuery);
(function ($) {
  var stringToSlug = function stringToSlug(str) {
    var slug;
    slug = str.toLowerCase().trim();
    slug = slug.replace(/Ã¡|Ã |áº£|áº¡|Ã£|Äƒ|áº¯|áº±|áº³|áºµ|áº·|Ã¢|áº¥|áº§|áº©|áº«|áº­/gi, 'a');
    slug = slug.replace(/Ã©|Ã¨|áº»|áº½|áº¹|Ãª|áº¿|á»|á»ƒ|á»…|á»‡/gi, 'e');
    slug = slug.replace(/i|Ã­|Ã¬|á»‰|Ä©|á»‹/gi, 'i');
    slug = slug.replace(/Ã³|Ã²|á»|Ãµ|á»|Ã´|á»‘|á»“|á»•|á»—|á»™|Æ¡|á»›|á»|á»Ÿ|á»¡|á»£/gi, 'o');
    slug = slug.replace(/Ãº|Ã¹|á»§|Å©|á»¥|Æ°|á»©|á»«|á»­|á»¯|á»±/gi, 'u');
    slug = slug.replace(/Ã½|á»³|á»·|á»¹|á»µ/gi, 'y');
    slug = slug.replace(/Ä‘/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
  };
  var schoolLoadData = function schoolLoadData(form) {
    var offset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    var callback = arguments.length > 2 ? arguments[2] : undefined;
    var data = $(form).serializeArray(),
      ajaxdata = document.getElementById('ajaxdata');
    data.push({
      name: 'offset',
      value: offset
    });
    $.ajax({
      data: data,
      method: 'post',
      dataType: 'json',
      url: wp_vars.ajax_url,
      beforeSend: function beforeSend() {
        $(form).find('.btn-search').addClass('is-loading');
      },
      success: function success(response) {
        var posts = response.results.posts,
          count = response.results.count,
          loadmore = response.results.loadmore;
        $(form).find('.btn-search').removeClass('is-loading');
        if (posts.length > 0) {
          $.each(posts, function (i, e) {
            if (i == offset) {
              $(ajaxdata).find('.rt-school__list--posts').html(e);
            } else {
              $(ajaxdata).find('.rt-school__list--posts').append(e);
            }
          });
          handlePostTitle();
          $('.lazy').Lazy({
            afterLoad: function afterLoad(el) {
              $(el).addClass('loaded');
            }
          });
        }
        if (loadmore && !$(ajaxdata).find('.rt-school__list--more').length) {
          $(ajaxdata).find('.container').append(loadmore);
        } else {
          if (count == $(ajaxdata).find('.rt-school__post').length) {
            $(ajaxdata).find('.rt-school__list--more').remove();
          }
        }
        if (typeof callback === 'function') {
          callback(response);
        }
      }
    });
  };
  var schoolCountryChange = function schoolCountryChange(country, stateId) {
    $.ajax({
      method: 'post',
      url: wp_vars.ajax_url,
      data: {
        country: country,
        stateId: stateId,
        action: 'rt_school_country_change'
      },
      success: function success(response) {
        var ajaxdata = document.getElementById('ajaxdata');
        stateId = document.getElementById('rt-school__filter--' + stateId);
        if (stateId && response.results.states) {
          $(stateId).replaceWith(response.results.states);
        }
        if (response.results.label) {
          $(ajaxdata).find('h1.rt-title').html(response.results.label);
        }
        if (response.results.redirect) {
          history.pushState('', null, response.results.redirect);
        }
      }
    });
  };
  var handleLoadMore = function handleLoadMore() {
    $(document).on('click', '.rt-school__list--more .rt-button__loadmore', function () {
      var _this2 = this;
      var form = $('.rt-school__banner--form'),
        offset = $('.rt-school__post').length;
      this.classList.add('is-loading');
      schoolLoadData(form, offset, function () {
        _this2.classList.remove('is-loading');
      });
    });
  };
  var handleSubmitForm = function handleSubmitForm() {
    $(document).on('submit', '.rt-school__banner--form', function () {
      schoolLoadData(this);
      return false;
    });
  };
  var handleFormField = function handleFormField() {
    $(document).on('change', '.rt-school__banner--form input[type="radio"]', function () {
      var label = this.parentNode,
        box = this.closest('.dropdown');
      $(box).find('.active').removeClass('active');
      $(box).find('.btn-reset').removeClass('d-none');
      $(box).find('.dropdown-toggle').html(label.textContent);
      label.classList.add('active');
      if ('country' == this.name) {
        schoolCountryChange(this.value, 'state');
      }
      schoolLoadData(this.form);

      // Show dropdown-menu
      // $(box).find('.dropdown-toggle, .dropdown-menu').addClass('show');
    });
    $(document).on('click', '.rt-school__banner--form .btn-reset', function () {
      var box = this.closest('.dropdown'),
        btn = box.querySelector('.dropdown-toggle');
      $(box).find('.active').removeClass('active');
      $(box).find('input[type="radio"]').prop('checked', false);
      $(btn).html(btn.dataset.label);
      this.classList.add('d-none');
      if ('country' == box.dataset.name) {
        schoolCountryChange(0, 'state');
        $('#rt-school__filter--state').each(function (i, e) {
          $(e).find('.dropdown-menu').remove();
          $(e).find('input').prop('checked', false);
          $(e).find('.dropdown-toggle').html($(e).find('.dropdown-toggle').data('label'));
        });
      }
      schoolLoadData(this.form);

      // Show dropdown-menu
      // $(box).find('.dropdown-toggle, .dropdown-menu').addClass('show');
      // return false;
    });
    $(document).on('keyup', '.rt-school__banner--form .tax-search', function () {
      var box = this.closest('.dropdown');
      var value = stringToSlug(this.value);
      $(box).find('.items > li').each(function (i, e) {
        var count,
          name = stringToSlug(e.textContent);
        if (name.search(value) != -1) {
          e.classList.remove('d-none');
        } else {
          e.classList.add('d-none');
        }
        count = $(box).find('.items > li').not('.d-none').length;
        if (0 < count) {
          count = $(box).find('input:checked').length;
          if (count) {
            $(box).find('.btn-reset').removeClass('d-none');
          }
        } else {
          $(box).find('.btn-reset').addClass('d-none');
        }
      });
    });
  };
  var handlePostTitle = function handlePostTitle() {
    $('.rt-school__list--posts').each(function () {
      $('.rt-school__post--title').matchHeight();
    });
  };
  var handleBoxRelated = function handleBoxRelated() {
    $('.rt-school__related').each(function (i, e) {
      $(e).find('.rt-school__list--posts').addClass('swiper');
      $(e).find('.rt-school__post').wrap('<div class="swiper-slide">');
      $(e).find('.rt-school__list--posts').wrapInner('<div class="swiper-wrapper">');
      var sliderBanner = new Swiper('.rt-school__related .rt-school__list--posts', {
        slidesPerView: 1.3,
        spaceBetween: 20,
        loop: true,
        autoplay: false,
        breakpoints: {
          767: {
            slidesPerView: 2,
            spaceBetween: 24
          },
          992: {
            slidesPerView: 3,
            spaceBetween: 16
          },
          1200: {
            slidesPerView: 3,
            spaceBetween: 20
          },
          1600: {
            slidesPerView: 3,
            spaceBetween: 24
          }
        }
      });
    });
  };
  $(function () {
    handleLoadMore();
    handlePostTitle();
    handleFormField();
    handleSubmitForm();
    handleBoxRelated();
  });
})(jQuery);