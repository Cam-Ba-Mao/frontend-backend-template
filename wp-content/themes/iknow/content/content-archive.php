<?php
/**
 * The template used for displaying archive page content in archive.php
 *
 * @package WordPress
 * @subpackage Iknow
 * @since Iknow 1.0
 */

$child_cats = get_categories( array(
	'parent' => $cat
) );

if (!empty($child_cats)) {
?>
<div class="section" id="content">
	<div class="container">
		<div class="columns is-multiline">
			<?php iknow_get_home_posts($cat); ?>
		</div>
	</div>
</div>
<?php
}
else {
?>
<div class="level is-mobile">
    <div class="level-left"></div>
	<?php iknow_posts_sorter(); ?>
</div>
<div class="box">
    <table class="table is-hoverable is-fullwidth">
        <thead class="is-hidden-mobile">
			<th>&nbsp;</th>
			<th class="has-text-right is-size-7"><?php esc_html_e( 'Comments', 'iknow' ); ?></th>
		<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
            <th class="has-text-right is-size-7"><?php esc_html_e( '  Helpful', 'iknow' ); ?></th>
		<?php endif; ?>
        </thead>
        <tbody>
		<?php $post_icon = apply_filters( 'iknow_post_icon', 'icon-doc' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<tr>
				<td>
					<span class="<?php echo esc_attr( $post_icon ); ?>"></span>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</td>
				<td class="has-text-right is-size-7 is-hidden-mobile"><?php echo esc_html( get_comments_number() ); ?></td>
				<?php if ( function_exists( 'iknow_get_helpful' ) ) : ?>
				<td class="has-text-right has-text-weight-medium is-size-7 is-hidden-mobile"><?php iknow_get_helpful(); ?></td>
				<?php endif; ?>
			</tr>
		<?php endwhile; // end of the loop. ?>
        </tbody>
    </table>
</div>
<?php
}

iknow_the_posts_pagination();