<?php
/**
 * The template for displaying 404 pages (not found)
 * @package Iedg
 */ 
get_header(); 

    do_action('rt_content_404_page', get_the_ID()); 

get_footer();