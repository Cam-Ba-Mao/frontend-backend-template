<?php
/**
 * The template for displaying all pages
 * @package Iedg
 */
?>
<?php get_header();
    do_action('iedg_content_search_page', get_the_ID()); 
get_footer();
