<?php
/**
 * Template Name: ThankYou Page
 * @package RT
 */
get_header();
    while (have_posts()) : the_post();
        do_action('rt_content_thankyou_page', get_the_ID()); 
    endwhile;
get_footer();