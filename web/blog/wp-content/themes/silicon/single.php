<?php
/**
 * The template for displaying all single posts.
 *
 * @link   https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @author 8guild
 */

get_header();

while ( have_posts() ) :
	the_post();

	/**
	 * Fires before the single post content
	 *
	 * NOTE: this hook executes inside the loop
	 */
	do_action( 'silicon_single_before' );

	get_template_part( 'template-parts/single/single', silicon_single_layout() );

	/**
	 * Fires after the single post content
	 *
	 * NOTE: this hook executes inside the loop
	 *
	 * @see silicon_related_posts() 15
	 * @see silicon_entry_comments() 20
	 */
	do_action( 'silicon_single_after' );

endwhile;

get_footer();
