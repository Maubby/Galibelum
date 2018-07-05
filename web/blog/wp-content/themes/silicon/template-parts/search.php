<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @author  8guild
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-tile border-default' ); ?>>
	<div class="post-body">

		<?php
		the_title(
			sprintf( '<h3 class="post-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_permalink() ) ),
			'</a></h3>'
		);

		the_content( '' );
		?>

	</div>
</article>