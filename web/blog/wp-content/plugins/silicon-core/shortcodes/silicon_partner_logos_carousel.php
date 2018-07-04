<?php
/**
 * Partner Logos Carousel | silicon_partner_logos_carousel
 *
 * This shortcode uses $content
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
	'is_loop'         => 'enable',
	'is_autoplay'     => 'disable',
	'autoplay_speed'  => 3000,
	'desk_small'      => '6',
	'tablet_land'     => '4',
	'tablet_portrait' => '3',
	'mobile'          => '2',
	'margin'          => 0,
	'animation'       => '',
	'class'           => '',
), $shortcode ), $atts );

$logos = json_decode( urldecode( $content ), true );
if ( empty( $logos ) ) {
	return;
}

$is_dots = ( 'enable' === $a['is_dots'] );

$class   = array();
$class[] = 'owl-carousel';
$class[] = $is_dots ? 'carousel-with-dots' : '';
$class[] = $is_dots ? 'carousel-' . sanitize_key( $a['dots_skin'] ) : '';
$class[] = $a['class'];

// settings for carousel
$owl = array(
	'nav'             => false, // next / prev buttons
	'dots'            => $is_dots,
	'loop'            => ( 'enable' === $a['is_loop'] ),
	'autoplay'        => ( 'enable' === $a['is_autoplay'] ),
	'autoplayTimeout' => absint( $a['autoplay_speed'] ),
	'margin'          => absint( $a['margin'] ),
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

echo '<div ', $attr, '>';
foreach ( $logos as $l ) {
	$l = wp_parse_args( $l, array(
		'logo' => 0,
		'link' => '',
	) );

	$is_linked = false;
	$image     = wp_get_attachment_image( (int) $l['logo'], 'full' );

	$attr = array();
	$link = silicon_vc_parse_link( $l['link'] );

	if ( ! empty( $link['url'] ) ) {
		$is_linked = true;

		$attr['href']   = silicon_esc_url( $link['url'] );
		$attr['target'] = empty( $link['target'] ) ? '' : esc_attr( trim( $link['target'] ) );
		$attr['title']  = empty( $link['title'] ) ? '' : esc_attr( trim( $link['title'] ) );
		$attr['rel']    = empty( $link['rel'] ) ? '' : esc_attr( trim( $link['rel'] ) );
	}

	$attr['class'] = 'logo-item';

	echo silicon_get_tag( $is_linked ? 'a' : 'div', $attr, $image );
}
echo '</div>';
