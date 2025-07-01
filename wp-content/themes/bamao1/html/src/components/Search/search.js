(function ($) {
    var paged = 1;
        
    function handleLoadSearchMore() {
        $(document).on('click', '.load-more-search', function(e) {
            e.preventDefault();
            
            var element = $(this);
	        var link = $(this).attr('data-url');
	        var total = $(this).attr('data-total');
			var key = $('.iedg-search__form input[name="s"]').val();
	        paged++;

	        link += 'page/' + paged + '/?s=' + key;

	        $.ajax({
	            url: link,
	            type: 'GET',
	            cache: false,
	            beforeSend: function (xhr) {                    
	                element.addClass('is-loading');
	            }
	        }).done(function (res) {
	        	var html = $(res);
	        	$('.post-archive__content .row').append(html.find('.post-archive__content .row').html());
	        	element.removeClass('is-loading');	 
                
                $('.lazy').Lazy({
		            afterLoad: function (elm) {
		                $(elm).css('visibility', 'visible');
		            }
		        });

	        	if( parseInt(paged) >= parseInt(total) ) {
	        		element.closest('.isa-news__cta').addClass('d-none');
	        	}

	        }).fail(function (res) {
	            
	        });
        });
    }

    $(function () {
        handleLoadSearchMore();
    });
})(jQuery);