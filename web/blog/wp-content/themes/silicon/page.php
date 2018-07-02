<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
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
	do_action( 'silicon_page_before' );

	get_template_part( 'template-parts/page' );

	/**
	 * Fires after the single post content
	 *
	 * NOTE: this hook executes inside the loop
	 *
	 * @see silicon_entry_comments() 20
	 */
	do_action( 'silicon_page_after' );

endwhile; // End of the loop.

get_footer();
