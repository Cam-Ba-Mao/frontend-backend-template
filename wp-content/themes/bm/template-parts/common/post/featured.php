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
<div class="rt-blog__inner--featured__item">
    <a href="<?= $link; ?>" title="<?= $title; ?>">
        <h2 class="rt-title"><img class="lazy" data-src="<?= get_template_directory_uri(); ?>/html/dist/images/blog/star.svg" width="16" alt="<?php _e("Tin nổi bật", "rt"); ?>"><?php _e("Tin nổi bật", "rt"); ?></h2>

        <div class="img-wrapper">
            <img class="lazy" data-src="<?= $thumbnail; ?>" width="100%" alt="<?= sanitize_title($title); ?>">
        </div>
        <h3><?= $title; ?></h3>
        <p><?= $except; ?></p>

        <div class="readmore">
            <span><?= $date; ?></span>
            <!-- <span><?php printf(__('%s phút đọc', 'rt'), $minute) ; ?></span> -->
        </div>
    </a>
</div>