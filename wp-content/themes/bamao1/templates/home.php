<?php
    /* 
    Template Name: Home page
    */
    $data['categories'] = getCategories('term_order', 'ASC', 'false');
	// dd($data['categories'] );

    $data = get_fields($id);
    if (empty($data)) {
        $data = [];
    }
    // dd(get_fields($id));

?>

<?php get_header(); ?>

<?php
    require_once( THEME_URL . "/templates/home/training.php" );
    require_once( THEME_URL . "/templates/home/why-us.php" );
    require_once( THEME_URL . "/templates/home/testimonial.php" );
    require_once( THEME_URL . "/templates/home/educational-pathway.php" );
?>

<?php get_footer(); ?>
