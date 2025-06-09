(function ($) {
    const clsActive = "toc-active";
    const toc_sel = ".rt-details__toc";
    const item_sel = "ul.list > li";
    const scroll = new LocomotiveScroll({
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
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        // smooth: true
    });

    function handleToC(selector) {
        if ($(selector).length === 0 || $(selector + " " + item_sel).length === 0)
            return false;
        var toc_item = document.querySelectorAll(selector + " " + item_sel);

        toc_item.forEach(elem => {
            elem.addEventListener('click', function () {
                let childs = this.parentElement.children;
                console.log(childs);
                for (let i = 0; i < childs.length; i++) {
                    console.log(childs[i]);
                    if (childs[i] !== elem) {
                        childs[i].classList.remove(clsActive);
                    }
                    else {
                        childs[i].classList.add(clsActive);
                    }
                }
            });
        });
    }

    function handleScrollTableOfContent() {
        $(document).on('click', '.rt-details__toc a[href*=\\#]:not([href=\\#])', function(e) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                || location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                $('.rt-details__toc li').removeClass('toc-active');

                if (target.length) {
                    $(this).closest('li').addClass('toc-active');

                    let scrollTop = target.offset().top;
                    scrollTop = scrollTop - ($('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0);
                    // scrollTop = scrollTop - ($('.rt-header').length > 0 ? $('.rt-header').outerHeight() : 0);

                    scroll.scrollTo(scrollTop, {
                        duration: 4, 
                    });
                    return false; 
                }
            }
        });
    }

    function setActiveTableOfContent(event) {
        if($('.rt-details__toc a[href*=\\#]:not([href=\\#])').length < 1) return;
        let scrollTop = 0;
        scrollTop = scrollTop + ($('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0);
        // scrollTop = scrollTop + ($('.rt-header').length > 0 ? $('.rt-header').outerHeight() : 0);

		var windowPos = $(window).scrollTop() + scrollTop;

        $('.rt-details__toc li').removeClass('toc-active');
        
        $('.rt-details__toc a[href*=\\#]:not([href=\\#])').each(function() { 
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
        if( $('.rt-details__toc').length < 1 ) return;

        $('.rt-details__toc').each(function(){
            if( $(this).find('li.toc-active').length > 1 ) {
                let tolTal = $(this).find('li.toc-active').length;
                let i = 1;
    
                $(this).find('li.toc-active').each(function() {
                    if(i < tolTal) {
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
        $(window).scroll(function() {
            setActiveTableOfContent();
        });        
    });
})(jQuery);