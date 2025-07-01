<?php
    $data['categories'] = getCategories('term_order', 'ASC', 'false');
    $data['post'] = getCar();
	// dd($data['post'] );
?>

<?php get_header(); ?>
<?php foreach($data['categories'] as $cat ): ?>
    <a href="<?= get_term_link($cat); ?>"><?= $cat->name; ?></a>
<?php endforeach; ?>
<?php get_footer(); ?>
