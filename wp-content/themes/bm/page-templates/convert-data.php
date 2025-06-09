<?php
/**
 * Template Name: Convert data page
 * @package RT
 */

$arrs = [28762];

foreach($arrs as $key => $arr) {
    echo $arr . "<br>";

    $my_post = array(
        'ID'          => $arr,
        'post_type'   => 'scholarship',
    );
    wp_update_post( $my_post );

   /*  $tag = array( 2124 ); // Correct. This will add the tag with the id 5.
    wp_set_post_terms( $arr, $tag, 'cat_experience' ); */
}