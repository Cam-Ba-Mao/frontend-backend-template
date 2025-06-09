<?php

/**
 * Template Name: Event page
 * @package RT
 */
get_header();
while (have_posts()) : the_post();
    do_action('rt_content_event_page', get_the_ID());
endwhile;
get_footer();
