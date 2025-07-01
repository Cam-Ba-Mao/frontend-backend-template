<?php

/**
 * Template Name: About Us page
 * @package RT
 */
get_header();
while (have_posts()) : the_post();
    do_action('rt_content_about_us_page', get_the_ID());
endwhile;
get_footer();
