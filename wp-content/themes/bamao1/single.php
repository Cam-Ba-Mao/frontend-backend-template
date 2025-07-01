<?php
/**
 * The template for displaying all pages
 * @package Iedg
 */
?><?php get_header(); ?>
    <?php
        while (have_posts()) : the_post();
            do_action('iedg_content_single_' . get_post_type(), get_the_ID());
            // dd('iedg_content_single_' . get_post_type());
        endwhile;
        ?>
<?php get_footer();
