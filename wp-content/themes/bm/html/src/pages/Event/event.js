(function ($) {
	var paged = 1;
	const eventArchiveSel = ".rt-event-archive";
	const eventListSel = eventArchiveSel + "__list";
	const eventFormSel = eventArchiveSel + "__form";
	const eventItemSel = eventArchiveSel + '__item';
	const btnLoadMoreSel = ".rt-button__loadmore";
	const btnSearchSel = ".btn-search";
	const isLoadingCls = "is-loading";
	const ajaxId = "ajaxdata";

	const eventLoadData = (form, offset = 0, callback) => {
		let data = $(form).serializeArray(), ajaxdata = document.getElementById('ajaxdata');
		data.push({ name: 'offset', value: offset });
		$.ajax({
			data: data,
			method: 'post',
			dataType: 'json',
			url: wp_vars.ajax_url,
			beforeSend: () => {
				$(form).find(btnSearchSel).addClass(isLoadingCls);
			},
			success: (response) => {
				let posts = response.results.posts,
					count = response.results.count;

				console.log('COUNT: ' + response.results.count);
				console.log('POSTS: ' + response.results.posts);
				$(form).find(btnSearchSel).removeClass(isLoadingCls);
				console.log(posts, count);
				if (posts.length > 0) {
					$.each(posts, (i, e) => {
						if (i == offset) {
							$(ajaxdata).html(e);
						}
						else {
							$(ajaxdata).append(e);
						}
					});
					$('.lazy').Lazy({
						afterLoad: (el) => {
							$(el).addClass('loaded');
						}
					});
				}



				if (!$(ajaxdata).find(btnLoadMoreSel).length) {
					if (count == $(ajaxdata).find(eventItemSel).length) {
						$(ajaxdata).parent().find(btnLoadMoreSel).hide();
					}
					else {
						$(ajaxdata).parent().find(btnLoadMoreSel).show();
					}
				}

				if (typeof callback === 'function') {
					callback(response);
				}
			},
			error: () => {
				$(form).removeClass('loading');
			}
		});
	};

	function handleLoadMore() {
		$(document).on('click', btnLoadMoreSel, function () {
			let form = $(eventFormSel),
				offset = $(eventItemSel).length;

			this.classList.add(isLoadingCls);
			eventLoadData(form, offset, (response) => {
				this.classList.remove(isLoadingCls);
			});
		});
	};

	function handleFilter() {

		$(document).on('change', eventFormSel + ' select', function (e) {
			let form = $(eventFormSel);
			this.classList.add(isLoadingCls);

			$.ajax({
				type: 'post',
				dataType: 'json',
				url: wp_vars.ajax_url,
				cache: false,
				data: $(this.form).serialize(),
				beforeSend: function (xhr) {
					$(eventListSel).addClass('is-loading-overlay');
				}
			}).done(function (res) {
				var html = res.results.posts.join("");
				let count = 0;
				let limit = 0;
				$("#" + ajaxId).html(html);
				count = res.results.count;
				limit = res.results.perpage;
				console.log("LIMIT:" + limit + " - COUNT: " + count);
				if (count > limit) {
					$(ajaxdata).parent().find(btnLoadMoreSel).show();
				}
				else {
					$(ajaxdata).parent().find(btnLoadMoreSel).hide();
				}

				$(eventListSel).removeClass('is-loading-overlay');

				$('.lazy').Lazy({
					afterLoad: function (elm) {
						$(elm).css('visibility', 'visible');
					}
				});

			}).fail(function (res) {

			});

		});
	}

	$(function () {
		handleFilter();
		handleLoadMore();
	});
})(jQuery);