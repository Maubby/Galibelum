<?php
/**
 * Template part for displaying the "No Sidebar List" blog layout
 *
 * @author 8guild
 */

?>
<div class="container padding-bottom-3x">

	<?php
	/**
	 * Fires right before the blog loop starts
	 */
	do_action( 'silicon_loop_before' );

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/tiles/post-horizontal' );
	endwhile;

	/**
	 * Fires right after the blog loop
	 *
	 * @see silicon_blog_pagination()
	 */
	do_action( 'silicon_loop_after' );
	?>
	
</div>