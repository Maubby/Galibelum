<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
 * @author 8guild
 */

get_header();

/**
 * Fires before the blog posts page (posts loop + sidebar)
 *
 * NOTE: also wraps the "none" template
 * NOTE: this hook executes outside of the loop
 */
do_action( 'silicon_home_before' );

if ( have_posts() ) {
	get_template_part( 'template-parts/blog/blog', silicon_blog_layout() );
} else {
	get_template_part( 'template-parts/none' );
}

/**
 * Fires after the blog posts page (posts loop + sidebar)
 *
 * NOTE: also wraps the "none" template
 * NOTE: this hook executes outside of the loop
 */
do_action( 'silicon_home_after' );

get_footer();
