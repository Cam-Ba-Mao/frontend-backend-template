(function ($) {
    var lastScroll = 0;
    const body = $('body');
    const scrollUp = "scroll-up";
    const scrollDown = "scroll-down";
    const clsException = "is-transparent";

    function calculateScroll() {
        var currentScroll = window.pageYOffset;
        if (body.hasClass(clsException)) {
            if (currentScroll > lastScroll && !body.hasClass(scrollDown)) {
                body.removeClass(scrollUp);
                body.addClass(scrollDown);
            }
            else if (currentScroll < lastScroll && body.hasClass(scrollDown)) {
                body.removeClass(scrollDown);
                body.addClass(scrollUp);
            }
            lastScroll = currentScroll;
            if (currentScroll <= 0) {
                body.removeClass(scrollUp);
            }
        }
    }

    function handleScrollPage() {
        $(window).on('scroll', function() {
            calculateScroll();
        });
    }

    $(function () {
        // handleScrollPage();
    });
    
})(jQuery);