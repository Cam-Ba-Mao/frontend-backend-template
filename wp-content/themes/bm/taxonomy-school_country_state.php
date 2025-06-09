<?php
get_header();
    while (have_posts()) : the_post();
        do_action('rt_content_school_country_state_archive', get_the_ID()); 
    endwhile;
get_footer();