<?php
/**
 * Image Carousel | silicon_image_carousel
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
	'images'          => '',
	'is_caption'      => 'disable',
	'is_arrows'       => 'enable',
	'is_dots'         => 'enable',
	'dots_skin'       => 'dark',
	'is_loop'         => 'disable',
	'is_autoplay'     => 'disable',
	'autoplay_speed'  => 3000,
	'is_height'       => 'disable',
	'desk_small'      => '1',
	'tablet_land'     => '1',
	'tablet_portrait' => '1',
	'mobile'          => '1',
	'margin'          => 0,
	'animation'       => '',
	'class'           => '',
), $shortcode ), $atts );

if ( empty( $a['images'] ) ) {
	return;
}

$images     = wp_parse_id_list( $a['images'] );
$is_caption = ( 'enable' === $a['is_caption'] );
$is_arrows  = ( 'enable' === $a['is_arrows'] );
$is_dots    = ( 'enable' === $a['is_dots'] );

$class   = array();
$class[] = 'owl-carousel';
$class[] = $is_dots ? 'carousel-with-dots' : '';
$class[] = $is_dots ? 'carousel-' . sanitize_key( $a['dots_skin'] ) : '';
$class[] = $is_caption ? 'with-captions' : 'without-captions';
$class[] = $a['class'];

// prepare images
$items = array();
foreach ( $images as $image_id ) {
	$classes = array( 'carousel-item' );
	$caption = '';
	if ( $is_caption ) {
		$classes[]  = 'wp-caption';
		$attachment = silicon_get_attachment( $image_id );
		if ( ! empty( $attachment['caption'] ) ) {
			$caption = sprintf(
				'<figcaption class="wp-caption-text">%s</figcaption>',
				esc_html( $attachment['caption'] )
			);
		}
	}

	$r = array(
		'{class}'   => implode( ' ', array_filter( $classes ) ),
		'{image}'   => wp_get_attachment_image( $image_id, 'full' ),
		'{caption}' => $caption,
	);

	$items[] = str_replace( array_keys( $r ), array_values( $r ),
		'<figure class="{class}">{image}{caption}</figure>'
	);

	unset( $classes, $caption, $r );
}

// settings for carousel
$owl = array(
	'nav'             => $is_arrows, // next / prev buttons
	'dots'            => $is_dots,
	'loop'            => ( 'enable' === $a['is_loop'] ),
	'autoplay'        => ( 'enable' === $a['is_autoplay'] ),
	'autoplayTimeout' => absint( $a['autoplay_speed'] ),
	'margin'          => absint( $a['margin'] ),
	'autoHeight'      => ( 'enable' === $a['is_height'] ),
	'responsive'      => array(
		0    => array( 'items' => absint( $a['mobile'] ) ),
		768  => array( 'items' => absint( $a['tablet_portrait'] ) ),
		991  => array( 'items' => absint( $a['tablet_land'] ) ),
		1200 => array( 'items' => absint( $a['desk_small'] ) ),
	)
);

// carousel attributes
$attr = silicon_get_attr( array(
	'class'            => esc_attr( silicon_get_classes( $class ) ),
	'data-aos'         => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
	'data-si-carousel' => $owl,
) );

echo '<div ', $attr, '>', implode( '', $items ), '</div>';
