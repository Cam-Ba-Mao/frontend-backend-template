<?php
/**
 * Template Name: Thank You Page
 * @package RT
 */
get_header();
    while (have_posts()) : the_post();
        do_action('rt_content_thank_you', get_the_ID()); 
    endwhile;
get_footer();