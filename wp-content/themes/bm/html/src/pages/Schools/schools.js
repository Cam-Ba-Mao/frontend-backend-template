(function ($) {

    const stringToSlug = (str) => {
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

    const schoolLoadData = (form, offset = 0, callback) => {
        let data = $(form).serializeArray(),
            ajaxdata = document.getElementById('ajaxdata');
        data.push({ name: 'offset', value: offset });
        $.ajax({
            data: data,
            method: 'post',
            dataType: 'json',
            url: wp_vars.ajax_url,
            beforeSend: () => {
                $(form).find('.btn-search').addClass('is-loading');
            },
            success: (response) => {
                let
                    posts = response.results.posts,
                    count = response.results.count,
                    loadmore = response.results.loadmore;
                $(form).find('.btn-search').removeClass('is-loading');
                if (posts.length > 0) {
                    $.each(posts, (i, e) => {
                        if (i == offset) {
                            $(ajaxdata).find('.rt-school__list--posts').html(e);
                        }
                        else {
                            $(ajaxdata).find('.rt-school__list--posts').append(e);
                        }
                    });
                    handlePostTitle();
                    $('.lazy').Lazy({
                        afterLoad: (el) => {
                            $(el).addClass('loaded');
                        }
                    });
                }
                if (loadmore && !$(ajaxdata).find('.rt-school__list--more').length) {
                    $(ajaxdata).find('.container').append(loadmore);
                }
                else {
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

    const schoolCountryChange = (country, stateId) => {
        $.ajax({
            method: 'post',
            url: wp_vars.ajax_url,
            data: {
                country: country,
                stateId: stateId,
                action: 'rt_school_country_change',
            },
            success: (response) => {
                const ajaxdata = document.getElementById('ajaxdata');
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

    const handleLoadMore = () => {
        $(document).on('click', '.rt-school__list--more .rt-button__loadmore', function () {
            let form = $('.rt-school__banner--form'),
                offset = $('.rt-school__post').length;
            this.classList.add('is-loading');
            schoolLoadData(form, offset, () => {
                this.classList.remove('is-loading');
            });
        });
    };

    const handleSubmitForm = () => {
        $(document).on('submit', '.rt-school__banner--form', function () {
            schoolLoadData(this);
            return false;
        });
    };

    const handleFormField = () => {
        
        $(document).on('change', '.rt-school__banner--form input[type="radio"]', function () {
            const label = this.parentNode,
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
            const box = this.closest('.dropdown'),
                btn = box.querySelector('.dropdown-toggle');
            $(box).find('.active').removeClass('active');
            $(box).find('input[type="radio"]').prop('checked', false);
            $(btn).html(btn.dataset.label);
            this.classList.add('d-none');

            if ('country' == box.dataset.name) {
                schoolCountryChange(0, 'state');
                $('#rt-school__filter--state').each((i, e) => {
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
            const box = this.closest('.dropdown');
            const value = stringToSlug(this.value);
            $(box).find('.items > li').each((i, e) => {
                let count, name = stringToSlug(e.textContent);
                if (name.search(value) != -1) {
                    e.classList.remove('d-none');
                }
                else {
                    e.classList.add('d-none');
                }
                count = $(box).find('.items > li').not('.d-none').length;
                if (0 < count) {
                    count = $(box).find('input:checked').length;
                    if (count) {
                        $(box).find('.btn-reset').removeClass('d-none');
                    }
                }
                else {
                    $(box).find('.btn-reset').addClass('d-none');
                }
            });
        });
    };

    const handlePostTitle = () => {
        $('.rt-school__list--posts').each(() => {
            $('.rt-school__post--title').matchHeight();
        });
    };

    const handleBoxRelated = () => {
        $('.rt-school__related').each((i, e) => {
            $(e).find('.rt-school__list--posts').addClass('swiper');
            $(e).find('.rt-school__post').wrap('<div class="swiper-slide">');
            $(e).find('.rt-school__list--posts').wrapInner('<div class="swiper-wrapper">');
            const sliderBanner = new Swiper('.rt-school__related .rt-school__list--posts', {
                slidesPerView: 1.3,
                spaceBetween: 20,
                loop: true,
                autoplay: false,
                breakpoints: {
                    767: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 16,
                    },
                    1200: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                    },
                    1600: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
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