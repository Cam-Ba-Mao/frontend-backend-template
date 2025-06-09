<?php if( isset($data['banner_slider']) && is_array($data['banner_slider']) && count($data['banner_slider']) ): ?>
<section class="isa-home-banner">
    <div class="isa-home-banner__slider swiper swiper-container">
        <div class="swiper-wrapper">
            <?php foreach( $data['banner_slider'] as $item ): ?>
            <div class="swiper-slide" data-pager-category="<?= $item['category_tab']; ?>">
                <div class="isa-home-banner__slider--container">
                    <div class="isa-home-banner__slider--overlay">
                        <div class="title-category"><?= $item['category_title']; ?></div>
                        <div class="title"><?= $item['title']; ?></div>
                        <a class="btn-text" href="<?= $item['link']['url']; ?>">
                            <?= $item['link']['title']; ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.353 12.354L14.353 19.354C14.255 19.452 14.127 19.5 13.999 19.5C13.871 19.5 13.743 19.451 13.645 19.354C13.45 19.159 13.45 18.842 13.645 18.647L19.791 12.501H3C2.724 12.501 2.5 12.277 2.5 12.001C2.5 11.725 2.724 11.501 3 11.501H19.793L13.647 5.35499C13.452 5.15999 13.452 4.84296 13.647 4.64796C13.842 4.45296 14.159 4.45296 14.354 4.64796L21.354 11.648C21.4 11.694 21.4369 11.75 21.4619 11.811C21.5129 11.933 21.5129 12.0711 21.4619 12.1931C21.4359 12.2521 21.399 12.308 21.353 12.354Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="isa-home-banner__video">
        <video muted loop autoplay>
            <source src="<?= isset($data['banner_video']) ? $data['banner_video'] : get_template_directory_uri(). '/html/dist/images/home/banner-video.mp4';?>" type="video/mp4">
        </video>
    </div>
    <div class="isa-home-banner__pager">
        <button class="pause" type="button" id="toggleButtonPause">
            <span class="icon"></span>
            <svg class="rt-progress over" xmlns="http://www.w3.org/2000/svg" width="34" height="34">
                <path d="M17 1.5c8.6 0 15.5 6.9 15.5 15.5S25.6 32.5 17 32.5 1.5 25.6 1.5 17 8.4 1.5 17 1.5" fill="none" stroke="#fff" stroke-width="3" stroke-miterlimit="10"></path>
            </svg>
            <svg class="rt-progress under" xmlns="http://www.w3.org/2000/svg" width="34" height="34">
                <path d="M17 1.5c8.6 0 15.5 6.9 15.5 15.5S25.6 32.5 17 32.5 1.5 25.6 1.5 17 8.4 1.5 17 1.5" fill="none" stroke="#fff" stroke-width="3" stroke-miterlimit="10"></path>
            </svg>
        </button>
        <div class="slider-pagination"></div>
    </div>
</section>
<?php endif; ?>