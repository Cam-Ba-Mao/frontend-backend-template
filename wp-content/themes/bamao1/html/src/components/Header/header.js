(function ($) {
    function handleNavCollapse() {
        $('.iedg-navbar-toggler').on('click', function () {
            $('.iedg-navbar-toggler').toggleClass('is-active');
            $('.iedg-navbar-collapse').toggleClass('is-show');
            $('body').toggleClass('is-lock');
            $('body').toggleClass('is-menu-show');

            $('.iedg-search__wrap').removeClass('is-active');

            if( $(window).width() > 1200 ) {
                $('.iedg-navbar-collapse').css('height', 'auto');
            } else {
                let topBarHeight = $('.iedg-topbar').outerHeight();
                let navBarHeight = $('.iedg-navbar').outerHeight();
                let adminBarHeight = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0;

                let height = adminBarHeight + topBarHeight + navBarHeight;
                if( $('.js-iedg-navbar').hasClass('is-active') ) {
                    height = adminBarHeight + navBarHeight;
                }
                
                if( $('body.iedg-header-transparent').length < 1 ) {
                    $('.iedg-navbar-collapse').css('height', 'calc(100vh - '+ height +'px)');
                }                
            }
        });
    }
    
    function handleSubMenu() {
        $('.iedg-navbar-nav__item .iedg-submenu-expand').on('click', function() {
            let subMenu = $(this).closest('.iedg-navbar-nav__item').find('.sub-menu');

            if( subMenu.hasClass('is-show') ) {
                $(this).removeClass('is-active');
                subMenu.removeClass('is-show');
            } else {
                $(this).addClass('is-active');
                subMenu.addClass('is-show');
            }
            
        });
    }

    function handleNavbarFixed() {
        let topBar = $('.iedg-topbar');
        let headerNavBar = $('.iedg-header-navbar');
        let navBar = $('.iedg-navbar');

        let topBarHeight = topBar.outerHeight();
        let navBarHeight = navBar.outerHeight();
        let adminBarHeight = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0;

        // Desktop
        if ($(window).scrollTop() >= topBarHeight + adminBarHeight ) {
            navBar.addClass('is-active');
            let topMenu = adminBarHeight;            
            navBar.css('top', topMenu);
            $('body').css('padding-top', (navBarHeight + adminBarHeight) + 'px');
        } else {
            navBar.removeClass('is-active');
            navBar.css('top', 0);
            $('body').css('padding-top', 0);
        }
    }

    function handleLanguageMobile() {
        if($('#iedg-language-mobile').length < 1) return;

        $('#iedg-language-mobile').on('click', function(e) {
            e.preventDefault();
            
            $('.iedg-nav-language-mobile .sub-menu').toggleClass('is-show');
            $('.iedg-nav-language-mobile .iedg-submenu-expand').toggleClass('is-active');
        });
    }

    function handleSearchPopup() {
        if( $('.iedg-search-cta').length < 1 ) return;
        
        $(document).on('click', '.iedg-search-cta', function(e) {
            e.preventDefault();
            
            $('.iedg-search__wrap').toggleClass('is-active');
            $('body').toggleClass('is-lock');

            $('.iedg-navbar-toggler').removeClass('is-active');
            $('.iedg-navbar-collapse').removeClass('is-show');
            $('body').removeClass('is-menu-show');
        });
    }

    function handleMenuClick() {
        $(document).on('click', '.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border) a', function(e) {
            if( $(window).width() > 991 ) {
                e.preventDefault();

                let link = $(this).attr('href');
    
                $('.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border)').removeClass('is-click');
                $('.iedg-navbar-nav .iedg-navbar-nav__item:not(.iedg-nav-none-border)').removeClass('current-menu-item');
                $(this).closest('.iedg-navbar-nav__item').toggleClass('is-click');
    
                setTimeout(function(){
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