<?php
/**
 * The template for displaying all pages
 * @package Iedg
 */
?>
<?php get_header();
    while (have_posts()) : the_post();
        do_action('iedg_content_general_page', get_the_ID());
    endwhile;
get_footer();
