<?php if (!empty($data['events'])) : ?>
    <?php if (is_array($data['events']) && count($data['events']) > 0) : ?>
        <section class="isa-featured-events">
            <div class="container">
                <h2 class="isa-title"><?php _e('Sự kiện nổi bật', 'rt'); ?></h2>
            </div>
            <div class="isa-featured-events__body">
                <div class="container">
                    <div class="isa-featured-events__list swiper swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($data['events'] as $event) : ?>
                                <?php
                                $event_id = $event->ID;
                                $event_title = $event->post_title;
                                $event_link = get_the_permalink($event_id);
                                $event_desc = apply_filters('the_excerpt', get_the_excerpt($event_id));
                                $event_fields = get_fields($event_id);
                                $event_date = '';
                                $event_time = '';
                                $is_coming = false;

                                if (get_the_post_thumbnail_url($event_id)) {
                                    $event_thumb = get_the_post_thumbnail_url($event_id, 'rt_blog_large');
                                } else {
                                    $event_thumb = get_template_directory_uri() . '/html/dist/images/no-thumbnail.png';
                                }

                                // Date
                                if (isset($event_fields['event_date_start']) && !empty($event_fields['event_date_start'])) {
                                    $event_day = date('d', strtotime($event_fields['event_date_start']));
                                    $event_month = date('n', strtotime($event_fields['event_date_start']));
                                    $event_year = date('Y', strtotime($event_fields['event_date_start']));
                                    $event_date = $event_day . ' Tháng ' . $event_month . ' ' . $event_year;
                                }

                                // Time
                                if (isset($event_fields['event_time_start']) && !empty($event_fields['event_time_start'])) {
                                    $event_time .= $event_fields['event_time_start'];
                                }

                                if (isset($event_fields['event_time_end']) && !empty($event_fields['event_time_end'])) {
                                    $event_time .= (!empty($event_time) ? ' - ' : '') . $event_fields['event_time_end'];
                                }

                                if (!empty($event_fields['event_date_start']) && !empty($event_fields['event_time_start'])) {
                                    $is_coming = \RT\Core\Event\EventFunctions::isComingEvent($event_fields['event_date_start'], $event_fields['event_time_start']);
                                }
                                ?>
                                <div class="swiper-slide">
                                    <a class="isa-featured-events__item" href="<?= $event_link; ?>">
                                        <div class="isa-featured-events__item--image">
                                            <div class="rt-img-drop">
                                                <img src="<?= $event_thumb; ?>" alt="<?= $event_title; ?>">
                                            </div>
                                        </div>
                                        <div class="isa-ticket">
                                            <div class="isa-ticket__inner">
                                                <div class="isa-ticket__inner--left">
                                                    <?php if ($is_coming) : ?>
                                                        <div class="upcoming"><?php _e('Sắp diễn ra', 'rt'); ?></div>
                                                    <?php endif; ?>
                                                    <h3><?= $event_title; ?></h3>
                                                </div>
                                                <div class="isa-ticket__inner--right">
                                                    <div class="date"><?= $event_date; ?></div>
                                                    <div class="cta"><?php _e('Xem thêm', 'rt'); ?></div>
                                                </div>
                                                <svg class="o-ticket_bg -full">
                                                    <rect width="100%" height="100%" fill="white" stroke="none" stroke-width="0" mask="url(#mask-full-killer-mike_2024-08-29)"></rect>
                                                    <defs>
                                                        <mask id="mask-full-killer-mike_2024-08-29" x="0" y="0" width="100%" height="100%">
                                                            <rect width="100%" height="100%" fill="white" stroke="none" stroke-width="0"></rect>
                                                            <circle cx="0" cy="50%" r="8" fill="black"></circle>
                                                            <circle cx="100%" cy="50%" r="8" fill="black"></circle>
                                                        </mask>
                                                    </defs>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="isa-featured-events__arrow">
                    <div class="isa-featured-events__arrow--prev">
                        <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.4534 1.25559L10.0282 6.6993C8.47544 8.17965 7.25704 8.86237 5.69871 9.24177C4.86049 9.4458 4.19058 10.179 4.19138 11.1036C4.19225 12.1625 4.98683 13.0814 6.10554 13.0823C7.22425 13.0832 31.9579 13.1031 31.9579 13.1031C31.9803 13.1031 31.9985 13.121 31.9986 13.1431L32 14.8867C32 14.9088 31.9819 14.9266 31.9594 14.9266L6.10702 14.9058C3.83163 14.904 3.56584 18.2312 5.7168 18.7436C7.32689 19.1271 8.59797 19.8266 10.2499 21.4527L15.4776 26.7448C15.4929 26.7603 15.4929 26.7849 15.4777 26.8004L14.3047 27.988C14.2887 28.0041 14.2622 28.004 14.2463 27.9877L0.0113201 14.0433C-0.00375748 14.0278 -0.00375748 14.0033 0.0113201 13.9879L14.2218 0.0121844C14.2377 -0.00403897 14.2642 -0.00406558 14.2802 0.0121294L15.4534 1.19982C15.4688 1.21538 15.4687 1.24013 15.4534 1.25559Z" fill="#040F49" />
                        </svg>
                    </div>
                    <div class="isa-featured-events__arrow--next">
                        <svg width="32" height="28" viewBox="0 0 32 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5466 1.25559L21.9718 6.6993C23.5246 8.17965 24.743 8.86237 26.3013 9.24177C27.1395 9.4458 27.8094 10.179 27.8086 11.1036C27.8078 12.1625 27.0132 13.0814 25.8945 13.0823C24.7758 13.0832 0.0420799 13.1031 0.0420799 13.1031C0.0196575 13.1031 0.00146602 13.121 0.00144823 13.1431L1.43348e-08 14.8867C-1.86249e-05 14.9088 0.0181423 14.9266 0.0405638 14.9266L25.893 14.9058C28.1684 14.904 28.4342 18.2312 26.2832 18.7436C24.6731 19.1271 23.402 19.8266 21.7501 21.4527L16.5224 26.7448C16.5071 26.7603 16.5071 26.7849 16.5223 26.8004L17.6953 27.988C17.7113 28.0041 17.7378 28.004 17.7537 27.9877L31.9887 14.0433C32.0038 14.0278 32.0038 14.0033 31.9887 13.9879L17.7782 0.0121844C17.7623 -0.00403897 17.7358 -0.00406558 17.7198 0.0121294L16.5466 1.19982C16.5312 1.21538 16.5313 1.24013 16.5466 1.25559Z" fill="#040F49" />
                        </svg>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>