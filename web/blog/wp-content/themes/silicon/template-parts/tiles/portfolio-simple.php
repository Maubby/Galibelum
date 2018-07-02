<?php
/**
 * Template Part for displaying the Portfolio tile for Related Projects.
 *
 * NOTE: portfolio tiles don't work without featured image.
 *
 * @author 8guild
 */

?>
<article <?php post_class( 'portfolio-post portfolio-post-tile' ); ?>>

	<?php
	if ( has_post_thumbnail() ) :
		the_post_thumbnail();
	endif;
	?>

	<div class="portfolio-post-tile-icon-links">
		<a href="<?php the_permalink(); ?>" class="navi-link-color"><i class="si si-link"></i></a>
	</div>

	<div class="portfolio-post-info">
		<div class="svg-bg">
			<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
				<path d="m 0 10 l 100 -10, 0 100, -100 0 z" fill="white"/>
			</svg>
		</div>

		<?php
		the_title(
			sprintf( '<h3 class="portfolio-tile-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_permalink() ) ),
			'</a></h3>'
		);
		?>

		<p class="portfolio-tile-text"><?php the_excerpt(); ?></p>
	</div>
</article>
