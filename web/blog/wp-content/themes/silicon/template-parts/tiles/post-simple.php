<?php
/**
 * Template Part for displaying the Blog with "Simple List" layout
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
 * @author 8guild
 */

?>
<article <?php
         post_class( 'post-tile-simple' );
         if ( has_post_thumbnail() ) {
             $bg = silicon_get_image_src( get_post_thumbnail_id() );
	         echo sprintf( ' style="background-image: url(%s)"', esc_url( $bg ) ); // NOTE: space before style
	         unset( $bg );
         }
         ?>>

	<?php silicon_entry_category(); ?>

	<footer class="post-simple-footer">
		<?php
		the_title(
			sprintf( '<h5 class="post-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_permalink() ) ),
			'</a></h5>'
		);
		echo silicon_get_entry_meta();
		?>
	</footer>
</article>
