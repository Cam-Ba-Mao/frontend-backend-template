<?php
/**
 * The template for displaying all pages
 * @package Iedg
 */
?>
<?php get_header();
    

    while (have_posts()) : the_post();
       
           the_content(); 
        
    endwhile;
get_footer();