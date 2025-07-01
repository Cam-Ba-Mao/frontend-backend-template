<div class="rt-search__background"></div>
<div class="rt-search" id="search-popup">
    <div class="container">
        <div class="rt-search__form">
            <form action="<?= home_url(); ?>" id="form-search">
                <button class="rt-icon icon-search" type="submit" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                        <path
                            d="M11.9167 20.5833C16.7031 20.5833 20.5833 16.7031 20.5833 11.9167C20.5833 7.1302 16.7031 3.25 11.9167 3.25C7.1302 3.25 3.25 7.1302 3.25 11.9167C3.25 16.7031 7.1302 20.5833 11.9167 20.5833Z"
                            stroke="#202121"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        ></path>
                        <path d="M23.9957 22.75L19.2832 18.0375" stroke="#202121" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <input class="rt-search__input" type="text" name="s" value="<?= get_query_var('s'); ?>" placeholder="<?php _e('Search here...', 'rt'); ?>" />
            </form>
            <a href="javascript:void(0)" id="search-popup-close">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.0003 3.66699L3.66699 13.0003" stroke="#202121" stroke-miterlimit="10" stroke-linecap="square"></path>
                    <path d="M13.0003 13.0003L3.66699 3.66699" stroke="#202121" stroke-miterlimit="10" stroke-linecap="square"></path>
                </svg>
            </a>
        </div>
    </div>
</div>