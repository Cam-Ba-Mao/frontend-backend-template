(function ($) {
    function registerPostRating() {
        if( $('body.single-post .comment-form #rating').length < 1 ) return;
        
        $( '#rating' )
            .hide()
            .before(
                '<p class="stars">\
                    <span>\
                        <a class="star-1" href="#">1</a>\
                        <a class="star-2" href="#">2</a>\
                        <a class="star-3" href="#">3</a>\
                        <a class="star-4" href="#">4</a>\
                        <a class="star-5" href="#">5</a>\
                    </span>\
                </p>'
            );

        $(document).on('click','#respond p.stars a', function() {
            var $star   	= $( this ),
				$rating 	= $( this ).closest( '#respond' ).find( '#rating' ),
				$container 	= $( this ).closest( '.stars' );

			$rating.val( $star.text() );
			$star.siblings( 'a' ).removeClass( 'active' );
			$star.addClass( 'active' );
			$container.addClass( 'selected' );

			return false;
        });

        $('.acf-comment-fields').remove();
    }

    function handleCommentScroll() {
        if( $('body.single-post').length < 1 ) return false;
        
        if( window.location.hash ) {
            var hash = window.location.hash;
            if(hash.search("comment-") > 0) {
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