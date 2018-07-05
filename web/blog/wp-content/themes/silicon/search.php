<?php
/**
 * The template for displaying search results pages.
 *
 * @link   https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @author 8guild
 */

get_header();

/**
 * Fires at the most top of the Search page
 *
 * @see silicon_search_open_wrapper() 5
 */
do_action( 'silicon_search_before' );

if ( have_posts() ) :

	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/search' );
	endwhile;

	silicon_search_pagination();

else :

	get_template_part( 'template-parts/none' );

endif;

/**
 * Fires at the most bottom of the Search page
 *
 * @see silicon_search_close_wrapper() 5
 */
do_action( 'silicon_search_after' );

get_footer();
