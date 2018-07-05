<?php
/**
 * The template for displaying Portfolio posts.
 *
 * @link   https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @author 8guild
 */

get_header();

while ( have_posts() ) :
	the_post();

	/**
	 * Fires before the portfolio post content
	 *
	 * NOTE: this hook executes inside the loop
	 */
	do_action( 'silicon_portfolio_before' );

	get_template_part( 'template-parts/single/portfolio', silicon_portfolio_layout() );

	/**
	 * Fires after the portfolio post content
	 *
	 * NOTE: this hook executes inside the loop
	 *
	 * @see silicon_portfolio_navigation() 10
	 * @see silicon_related_projects() 15
	 * @see silicon_entry_comments() 20
	 */
	do_action( 'silicon_portfolio_after' );

endwhile;

get_footer();
