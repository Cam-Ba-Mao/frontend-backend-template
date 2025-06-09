
<?php if(!empty($data['related']) && $data['related']->have_posts()): ?>
<section class="rt-related-posts">
    <div class="container"> 
        <div class="rt-related-posts__head"> 
            <h3 class="rt-title"><?php _e('Bài viết liên quan', 'rt'); ?></h3>

            <?php if( !empty($data['back_link']) ): ?>
            <a class="rt-related-posts__head--cta" href="<?= $data['back_link']; ?>"><?php _e('Xem thêm', 'rt'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <g clip-path="url(#clip0_1129_472)">
                        <path d="M1 7.00009H8.586L6.293 9.29309C6.19749 9.38534 6.12131 9.49568 6.0689 9.61769C6.01649 9.73969 5.9889 9.87091 5.98775 10.0037C5.9866 10.1365 6.0119 10.2681 6.06218 10.391C6.11246 10.5139 6.18671 10.6256 6.2806 10.7195C6.3745 10.8134 6.48615 10.8876 6.60905 10.9379C6.73194 10.9882 6.86362 11.0135 6.9964 11.0123C7.12918 11.0112 7.2604 10.9836 7.3824 10.9312C7.50441 10.8788 7.61475 10.8026 7.707 10.7071L11.707 6.70709C11.8001 6.6142 11.874 6.50385 11.9244 6.38236C11.9748 6.26087 12.0008 6.13063 12.0008 5.99909C12.0008 5.86756 11.9748 5.73731 11.9244 5.61582C11.874 5.49433 11.8001 5.38398 11.707 5.29109L7.707 1.29109C7.51923 1.10358 7.26466 0.998348 6.99929 0.998535C6.73393 0.998723 6.47951 1.10432 6.292 1.29209C6.10449 1.47986 5.99926 1.73443 5.99944 1.9998C5.99963 2.26516 6.10523 2.51958 6.293 2.70709L8.586 5.00009H1C0.734784 5.00009 0.48043 5.10545 0.292893 5.29298C0.105357 5.48052 0 5.73488 0 6.00009C0 6.26531 0.105357 6.51966 0.292893 6.7072C0.48043 6.89473 0.734784 7.00009 1 7.00009Z" fill="#212121"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_1129_472">
                        <rect width="12" height="12" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="rt-related-posts__body">
        <div class="container">
            <div class="rt-related-posts__list swiper">
                <div class="swiper-wrapper">
                    <?php while ($data['related']->have_posts()): $data['related']->the_post();?>
                        <?php
                            $id = get_the_ID();
                            $link = get_permalink();
                            $title = get_the_title();
                            $except = get_the_excerpt();
                            $content = get_the_content();
                            $minute = round( str_word_count($content) / 240 );
                            $date = get_the_date('d.m.Y', $id);

                            if (get_the_post_thumbnail_url($id)) {
                                $thumbnail = get_the_post_thumbnail_url($id, 'rt_blog_large');
                            } else {
                                $thumbnail = get_template_directory_uri(). '/html/dist/images/no-thumbnail.png';
                            }
                        ?>
                        <div class="swiper-slide">
                            <a class="rt-related-posts__post" href="<?= $link; ?>">
                                <div class="rt-related-posts__post--image rt-img-drop">
                                    <img src="<?= $thumbnail; ?>" alt="<?= $title; ?>">
                                    
                                    <?php if( isset($data['show_cat']) && $data['show_cat'] == true && !empty($data['termName']) ): ?>
                                        <span><?= $data['termName']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="rt-related-posts__post--title">
                                    <h2 class="rt-title"><?= $title; ?></h2>
                                </div>
                                <div class="rt-related-posts__post--excerpt">
                                    <span><?= $except; ?></span>
                                    <div class="readmore">
                                        <span><?= $date; ?></span>
                                        <!-- <span><?php printf(__('%s phút đọc', 'rt'), $minute) ; ?></span> -->
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif;