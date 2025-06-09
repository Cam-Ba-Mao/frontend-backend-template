<?php
$event_id = $args->ID;
$title = get_the_title($event_id);
$link = get_the_permalink($event_id);
$event_fields = get_fields($event_id);
$event_time = "";
$event_date = "";
$is_coming = false;
$desc = "";

if (isset($event_fields['event_single_content_item'][0]['editor']) && !empty($event_fields['event_single_content_item'][0]['editor'])) {
    $desc = wp_trim_words($event_fields['event_single_content_item'][0]['editor'], 30, '...');
}

if (get_the_post_thumbnail_url($event_id)) {
    $thumbnail = get_the_post_thumbnail_url($event_id, 'rt_blog_large');
} else {
    $thumbnail = get_template_directory_uri() . '/html/dist/images/no-thumbnail.png';
}

// Date
if (!empty($event_fields['event_date_start'])) {
    $event_date .= date(' d F Y', strtotime($event_fields['event_date_start']));
}

if (!empty($event_fields['event_date_end']) && !empty($event_fields['event_date_start']) && strtotime($event_fields['event_date_start']) != strtotime($event_fields['event_date_end'])) {
    $event_date .= (!empty($event_date) ? ' - ' : '') . date(' d F Y', strtotime($event_fields['event_date_end']));
}

// Time
if (!empty($event_fields['event_time_start'])) {
    $event_time .= $event_fields['event_time_start'];
}

if (!empty($event_fields['event_time_end'])) {
    $event_time .= (!empty($event_time) ? ' - ' : '') . $event_fields['event_time_end'];
}

$is_coming = $args->is_coming; //remove this function after appending query

?>
<a href="<?= $link; ?>" class="rt-event-archive__item">
    <div class="rt-event-archive__item--image" href="<?= $link; ?>">
        <img class="lazy" data-src="<?= $thumbnail; ?>" alt="<?= sanitize_title($title); ?>">
    </div>
    <div class="rt-event-archive__item--body">
        <div class="rt-event-archive__item--inner">
            <?php if (!empty($is_coming)) : ?>
                <div class="rt-event-archive__item--tag"><?php _e('Sắp diễn ra', 'isa'); ?></div>
            <?php endif; ?>
            <h2 class="rt-event-archive__item--title"><?= $title; ?></h2>
            <div class="rt-event-archive__item--info">
                <?php if (isset($event_fields['event_address']) && is_array($event_fields['event_address']) && count($event_fields['event_address']) > 0) : ?>
                    <div class="rt-event-archive__item--location">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.5 6C13.5 10.5 8 15.5 8 15.5C8 15.5 2.5 10.5 2.5 6C2.5 4.54131 3.07946 3.14236 4.11091 2.11091C5.14236 1.07946 6.54131 0.5 8 0.5C9.45869 0.5 10.8576 1.07946 11.8891 2.11091C12.9205 3.14236 13.5 4.54131 13.5 6V6Z" stroke="#202121" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8 8.5C9.38071 8.5 10.5 7.38071 10.5 6C10.5 4.61929 9.38071 3.5 8 3.5C6.61929 3.5 5.5 4.61929 5.5 6C5.5 7.38071 6.61929 8.5 8 8.5Z" stroke="#202121" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <?php foreach ($event_fields['event_address'] as $item) : ?>
                            <span><?= $item['address']; ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($event_time)) : ?>
                    <div class="rt-event-archive__item--time">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.5 15.5C12.366 15.5 15.5 12.366 15.5 8.5C15.5 4.63401 12.366 1.5 8.5 1.5C4.63401 1.5 1.5 4.63401 1.5 8.5C1.5 12.366 4.63401 15.5 8.5 15.5Z" stroke="#202121" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8.5 4.5V8.5H12.5" stroke="#202121" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span><?= $event_time; ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($desc)) : ?>
                <div class="rt-event-archive__item--desc"><?= $desc; ?></div>
            <?php endif; ?>
        </div>
    </div>
</a>