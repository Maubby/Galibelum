<?php
/**
 * Template Part for displaying the posts in Blog for List No Sidebar layout only
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
 * @author 8guild
 */
?>
<article <?php post_class( 'post-horizontal' ); ?>>
	<div class="row">
		<div class="col-sm-4">

			<?php
			the_title(
				sprintf( '<h3 class="post-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_permalink() ) ),
				'</a></h3>'
			);

			/**
			* Displays meta information for the post author, comments and post date.
			*
			* @see silicon_tile_footer() 20
			*/
			do_action( 'silicon_tile_footer' );
			?>
			<div class="padding-bottom-1x visible-xs"></div>
		</div>
		<div class="col-sm-8">

			<?php
			/**
			 * Displays post thumbnail, categories and post format.
			 *
			 * @see silicon_tile_header() 10
			 */
			do_action( 'silicon_tile_header' );
			?>

			<div class="post-body">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>
</article>
