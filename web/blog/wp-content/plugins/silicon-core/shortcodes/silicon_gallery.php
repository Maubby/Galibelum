<?php
/**
 * Gallery | silicon_gallery
 *
 * @var string $shortcode Shortcode tag
 * @var array  $atts      Shortcode attributes
 * @var mixed  $content   Shortcode content
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'images'     => '',
	'is_caption' => 'enable',
	'grid_type'  => 'grid-with-gap',
	'columns'    => 3,
	'animation'  => '',
	'class'      => '',
), $shortcode ), $atts );

if ( empty( $a['images'] ) ) {
	return;
}

/* Prepare variables */

$images        = wp_parse_id_list( $a['images'] );
$is_caption    = ( 'enable' === $a['is_caption'] );
$allowed_cols  = range( 1, 6 );
$selected_cols = absint( $a['columns'] );
$columns       = in_array( $selected_cols, $allowed_cols, true ) ? $selected_cols : 3;
unset( $allowed_cols, $selected_cols );

/* Prepare gallery items */

$template = <<<'TEMPLATE'
<div class="grid-item">
	<a href="{href}" class="si-gallery-item" data-size="{size}">
		{image}
		{caption}
	</a>
</div>
TEMPLATE;

$items = array();
foreach ( $images as $image_id ) {
	// attach caption if it is enabled in shortcode settings
	// and caption exists in media metadata
	$caption = '';
	if ( $is_caption ) {
		$attachment = silicon_get_attachment( $image_id );
		if ( ! empty( $attachment['caption'] ) ) {
			$caption = sprintf( '<figure>%1$s</figure>',
				esc_html( $attachment['caption'] )
			);
		}
		unset( $attachment );
	}

	$image = wp_get_attachment_image( $image_id, 'large' );

	// prepare the size
	$metadata = wp_get_attachment_metadata( $image_id, true );
	if ( empty( $metadata['width'] ) || empty( $metadata['height'] ) ) {
		$metadata = wp_parse_args( $metadata, array(
			'width'  => get_option( 'large_size_w', 1024 ),
			'height' => get_option( 'large_size_h', 1024 ),
		) );
	}

	$size = array( (int) $metadata['width'], (int) $metadata['height'] );
	$size = implode( 'x', $size ); // convert to {width}x{height}

	$r = array(
		'{href}'    => esc_url( silicon_get_image_src( $image_id ) ),
		'{size}'    => $size,
		'{image}'   => $image,
		'{caption}' => $caption,
	);

	$items[] = str_replace( array_keys( $r ), array_values( $r ), $template );
	unset( $r, $caption, $image, $metadata, $size );
}

$items = implode( '', $items );

/* Output */

$class = silicon_get_classes( array(
	'masonry-grid',
	'isotope-grid',
	'gallery-grid',
	esc_attr( $a['grid_type'] ),
	'col-' . $columns,
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'           => esc_attr( $class ),
	'data-si-gallery' => 'true',
	'data-aos'        => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo "
<div {$attr}>
	<div class=\"gutter-sizer\"></div>
	<div class=\"grid-sizer\"></div>
	{$items}
</div>";
