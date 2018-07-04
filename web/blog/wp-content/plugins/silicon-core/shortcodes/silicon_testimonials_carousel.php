<?php
/**
 * Testimonials Carousel | silicon_testimonials_carousel
 *
 * This shortcode is container and uses $content variable
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
	'is_dots'         => 'enable',
	'dots_skin'       => 'dark',
	'is_loop'         => 'disable',
	'is_autoplay'     => 'disable',
	'autoplay_speed'  => 3000,
	'is_height'       => 'disable',
	'desk_small'      => '3',
	'tablet_land'     => '3',
	'tablet_portrait' => '2',
	'mobile'          => '1',
	'margin'          => 0,
	'animation'       => '',
	'class'           => '',
), $shortcode ), $atts );

if ( empty( $content ) ) {
    return;
}

$is_dots = ( 'enable' === $a['is_dots'] );

// classes
$class   = array();
$class[] = 'testimonials-carousel';
$class[] = 'owl-carousel';
$class[] = $is_dots ? 'carousel-with-dots' : '';
$class[] = $is_dots ? 'carousel-' . esc_attr( $a['dots_skin'] ) : '';
$class[] = $a['class'];

// carousel settings
$owl = array(
	'nav'             => false,
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

$attr = silicon_get_attr( array(
	'class'            => esc_attr( silicon_get_classes( $class ) ),
	'data-aos'         => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
	'data-si-carousel' => $owl,
) );

echo '<div ', $attr, '>', silicon_do_shortcode( $content ), '</div>';
