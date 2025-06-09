(function ($) {

    const listSel = ".rt-related-posts__list";

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
                    slidesPerView: 1.8,
                },
                992: {
                    slidesPerView: 2.2,
                    spaceBetween: 20,
                },
                1600: {
                    slidesPerView: 2.4,
                    spaceBetween: 24,
                }
            }
        });
    }

    $(function () {
        initPostsSlider();
    });

})(jQuery);