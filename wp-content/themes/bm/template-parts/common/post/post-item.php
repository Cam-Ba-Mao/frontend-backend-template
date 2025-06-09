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
<a class="post-item" href="<?= $link; ?>" title="<?= $title; ?>">
    <div class="img-wrapper">
        <img class="lazy" data-src="<?= $thumbnail; ?>" width="100%" alt="<?= $title; ?>">
    </div>
    <div class="text-wrapper">
        <h3><?= $title; ?></h3>
        <p><?= $except; ?></p>
        <div class="readmore">
            <span><?= $date; ?></span>
            <!-- <span><?php printf(__('%s phút đọc', 'rt'), $minute) ; ?></span> -->
        </div>
    </div>
</a>