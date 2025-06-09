<?php
/**
 * Template Name: News page
 * @package RT
 */
get_header();
    while (have_posts()) : the_post();
        do_action('rt_content_post_archive', get_the_ID()); 
    endwhile;
get_footer();