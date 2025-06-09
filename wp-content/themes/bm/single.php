<?php
/**
 * The template for displaying all pages
 * @package Iedg
 */
?><?php get_header(); ?>
    <?php
        while (have_posts()) : the_post();
            do_action('rt_content_single_' . get_post_type(), get_the_ID());
        endwhile;
        ?>
<?php get_footer();
