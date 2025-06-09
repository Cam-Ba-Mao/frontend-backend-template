<?php
/**
 * Template Name: Contact page
 * @package RT
 */
get_header();
    while (have_posts()) : the_post();
        do_action('rt_content_contact_page', get_the_ID()); 
    endwhile;
get_footer();