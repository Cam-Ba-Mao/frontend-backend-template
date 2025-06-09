<?php if (empty($data['discover_hidden']) && !empty($data['discover_items'])) : ?>
    <?php if (is_array($data['discover_items']) && count($data['discover_items']) > 0) : ?>
        <section class="rt-discover">
            <div class="container">
                <div class="rt-discover__inner">
                    <div class="rt-discover__inner--slider">
                        <div class="rt-discover__inner--slider__main swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($data['discover_items'] as $item) : ?>
                                    <div class="swiper-slide rt-discover__inner--slider__item">
                                        <div class="text-wrapper">
                                            <?php if (!empty($item['title'])) : ?>
                                                <h3 class="text-line"><?= $item['title']; ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($item['desc'])) : ?>
                                                <p><?= $item['desc']; ?></p>
                                            <?php endif; ?>

                                            <a class="rt-btn rt-btn-primary text-line" href="#" title="<?= $item['title']; ?>" target="_blank">
                                                <span class="label"><?php _e('Xem thêm', 'rt'); ?></span>
                                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="48" height="48" rx="24" fill="white"></rect>
                                                    <path d="M32.6919 24.2871C32.6539 24.3791 32.599 24.462 32.53 24.531L28.53 28.531C28.384 28.677 28.192 28.751 28 28.751C27.808 28.751 27.616 28.678 27.47 28.531C27.177 28.238 27.177 27.763 27.47 27.47L30.1899 24.75H16C15.586 24.75 15.25 24.414 15.25 24C15.25 23.586 15.586 23.25 16 23.25H30.189L27.469 20.5301C27.176 20.2371 27.176 19.762 27.469 19.469C27.762 19.176 28.237 19.176 28.53 19.469L32.53 23.469C32.599 23.538 32.6539 23.6209 32.6919 23.7129C32.7679 23.8969 32.7679 24.1031 32.6919 24.2871Z" fill="#C33130"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <?php if (!empty($item['thumb']) && !empty($item['thumb']['url'])) : ?>
                                            <div class="thumb-container">
                                                <div class="thumb-wrapper">
                                                    <img src="<?= $item['thumb']['url']; ?>" width="100%" alt="<?= $item['title']; ?>">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="rt-discover__inner--slider__navigations">
                            <div class="rt-discover__inner--slider__prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="28" viewBox="0 0 32 28" fill="none">
                                    <g clip-path="url(#clip_0)">
                                        <path d="M15.4534 1.25559L10.0282 6.6993C8.47544 8.17965 7.25704 8.86237 5.69871 9.24177C4.86049 9.4458 4.19058 10.179 4.19138 11.1036C4.19225 12.1625 4.98683 13.0814 6.10554 13.0823C7.22425 13.0832 31.9579 13.1031 31.9579 13.1031C31.9803 13.1031 31.9985 13.121 31.9986 13.1431L32 14.8867C32 14.9088 31.9819 14.9266 31.9594 14.9266L6.10702 14.9058C3.83163 14.904 3.56584 18.2312 5.7168 18.7436C7.32689 19.1271 8.59797 19.8266 10.2499 21.4527L15.4776 26.7448C15.4929 26.7603 15.4929 26.7849 15.4777 26.8004L14.3047 27.988C14.2887 28.0041 14.2622 28.004 14.2463 27.9877L0.0113201 14.0433C-0.00375748 14.0278 -0.00375748 14.0033 0.0113201 13.9879L14.2218 0.0121844C14.2377 -0.00403897 14.2642 -0.00406558 14.2802 0.0121294L15.4534 1.19982C15.4688 1.21538 15.4687 1.24013 15.4534 1.25559Z" fill="#040F49"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip_0">
                                            <rect width="32" height="28" fill="white" transform="matrix(-1 0 0 1 32 0)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <div class="rt-discover__inner--slider__thumbs"></div>
                            <div class="rt-discover__inner--slider__next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="28" viewBox="0 0 32 28" fill="none">
                                    <g clip-path="url(#clip_1)">
                                        <path d="M16.5466 1.25559L21.9718 6.6993C23.5246 8.17965 24.743 8.86237 26.3013 9.24177C27.1395 9.4458 27.8094 10.179 27.8086 11.1036C27.8078 12.1625 27.0132 13.0814 25.8945 13.0823C24.7758 13.0832 0.0420799 13.1031 0.0420799 13.1031C0.0196575 13.1031 0.00146602 13.121 0.00144823 13.1431L1.43348e-08 14.8867C-1.86249e-05 14.9088 0.0181423 14.9266 0.0405638 14.9266L25.893 14.9058C28.1684 14.904 28.4342 18.2312 26.2832 18.7436C24.6731 19.1271 23.402 19.8266 21.7501 21.4527L16.5224 26.7448C16.5071 26.7603 16.5071 26.7849 16.5223 26.8004L17.6953 27.988C17.7113 28.0041 17.7378 28.004 17.7537 27.9877L31.9887 14.0433C32.0038 14.0278 32.0038 14.0033 31.9887 13.9879L17.7782 0.0121844C17.7623 -0.00403897 17.7358 -0.00406558 17.7198 0.0121294L16.5466 1.19982C16.5312 1.21538 16.5313 1.24013 16.5466 1.25559Z" fill="#040F49"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip_1">
                                            <rect width="32" height="28" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>