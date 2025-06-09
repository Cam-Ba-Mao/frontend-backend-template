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

        if($(".rt-archive-sidebar").find('.caret').hasClass('current-menu-parent') ) {
            $('.rt-archive-sidebar .current-menu-parent').find(".nested").addClass("active");
        }

        if($(".rt-archive-sidebar").find('.caret').hasClass('current_page_item') ) {
            $('.rt-archive-sidebar .current_page_item').find(".nested").addClass("active");
        }
        
    }

    $(function () {
        handleActiveMenu();
    });
})(jQuery);