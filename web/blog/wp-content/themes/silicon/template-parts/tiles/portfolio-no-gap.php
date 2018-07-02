<?php
/**
 * Template Part for displaying the Portfolio tile without Gap.
 *
 * We call this type "Grid no Gap" or "Without Gap"
 *
 * NOTE: portfolio tiles don't work without featured image.
 *
 * @author 8guild
 */

$_post_id        = get_the_ID();
$_post_permalink = get_permalink();
$_post_settings  = silicon_get_setting( 'all', array(), $_post_id );
$_post_gallery   = array();

// Prepare the Gallery
if ( isset( $_post_settings['portfolio_layout'] ) && 'blank' !== $_post_settings['portfolio_layout'] ) {

	// Add featured image to Gallery
	if ( isset( $_post_settings['portfolio_exclude_fi'] )
	     && true === (bool) $_post_settings['portfolio_exclude_fi']
	) {
		$_post_gallery[] = (int) get_post_thumbnail_id();
	}

	// Add other images to Gallery
	if ( ! empty( $_post_settings['portfolio_gallery'] ) ) {
		$_post_gallery = array_merge( $_post_gallery,
			wp_parse_id_list( $_post_settings['portfolio_gallery'] )
		);
	}
}

?>
<article <?php post_class( 'portfolio-post portfolio-post-tile' ); ?>>

	<?php
	if ( has_post_thumbnail() ) :
		the_post_thumbnail();
	endif;
	?>

	<div class="portfolio-post-tile-icon-links">
		<?php
		if ( ! empty( $_post_gallery ) ) :
			// Get gallery items
			$_gallery_items = array_map( function ( $image_id ) {
				$item   = array();
				$meta   = wp_get_attachment_metadata( $image_id, true );
				$attach = silicon_get_attachment( $image_id );

				$item['src'] = silicon_get_image_src( $image_id );
				$item['w']   = empty( $meta['width'] ) ? get_option( 'large_size_w', 1024 ) : (int) $meta['width'];
				$item['h']   = empty( $meta['height'] ) ? get_option( 'large_size_h', 1024 ) : (int) $meta['height'];
				if ( ! empty( $attach['caption'] ) ) {
					$item['title'] = strip_tags( trim( $attach['caption'] ) );
				}

				return $item;
			}, $_post_gallery );

			echo silicon_get_tag( 'a', array(
				'href'                   => '#',
				'class'                  => 'navi-link-color',
				'data-si-gallery-inline' => $_gallery_items,
			), '<i class="si si-view"></i>' );

			unset( $_gallery_items );
		endif;
        ?>
		<a href="<?php echo esc_url( $_post_permalink ); ?>" class="navi-link-color"><i class="si si-link"></i></a>
	</div>

	<div class="portfolio-post-info">
		<div class="svg-bg">
			<svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
				<path d="m 0 10 l 100 -10, 0 100, -100 0 z" fill="white"/>
			</svg>
		</div>

		<?php
		the_title(
			sprintf( '<h3 class="portfolio-tile-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( $_post_permalink ) ),
			'</a></h3>'
		);
		?>

		<p class="portfolio-tile-text"><?php the_excerpt(); ?></p>
	</div>
</article>
