<?php
/**
 * Template part for displaying the "No Sidebar Grid Wide" blog layout
 *
 * @author 8guild
 */

?>
<div class="container-fluid padding-bottom-3x">

	<?php
	/**
	 * Fires right before the blog loop starts
	 */
	do_action( 'silicon_loop_before' );
	?>

	<div class="masonry-grid isotope-grid blog-posts col-4">
		<div class="gutter-sizer"></div>
		<div class="grid-sizer"></div>

		<?php while ( have_posts() ) : the_post(); ?>
			<div class="grid-item">
				<?php get_template_part( 'template-parts/tiles/post-tile' ); ?>
			</div>
		<?php endwhile; ?>
	</div>

	<?php
	/**
	 * Fires right after the blog loop
	 *
	 * @see silicon_blog_pagination()
	 */
	do_action( 'silicon_loop_after' );
	?>

</div>
