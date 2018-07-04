<?php
/**
 * Google Maps | silicon_map
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
	'location'     => '',
	'height'       => 500,
	'zoom'         => 14,
	'is_zoom'      => 'disable',
	'is_scroll'    => 'disable',
	'is_marker'    => 'disable',
	'marker_title' => '',
	'marker'       => '', // attachment ID
	'style'        => '', // custom base64 encoded styles
	'animation'    => '',
	'class'        => '',
), $shortcode ), $atts );

$key = silicon_get_option( 'advanced_gmaps_key' );
if ( empty( $key ) ) {
	return;
}

$marker = empty( $a['marker'] ) ? '' : esc_url( silicon_get_image_src( (int) $a['marker'] ) );
$style  = empty( $a['style'] ) ? '' : preg_replace( '/\s+/', '', urldecode( base64_decode( $a['style'] ) ) );
$class  = silicon_get_classes( array(
	'google-maps',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'                 => esc_attr( $class ),
	'data-height'           => is_numeric( $a['height'] ) ? absint( $a['height'] ) : 500,
	'data-address'          => empty( $a['location'] ) ? 'New York, USA' : esc_attr( $a['location'] ),
	'data-zoom'             => is_numeric( $a['zoom'] ) ? absint( $a['zoom'] ) : 14,
	'data-disable-controls' => ( 'enable' === $a['is_zoom'] ) ? 'false' : 'true',
	'data-scrollwheel'      => ( 'enable' === $a['is_scroll'] ) ? 'true' : 'false',
	'data-is-marker'        => ( 'enable' === $a['is_marker'] ) ? 'true' : 'false',
	'data-marker-icon'      => ( 'enable' === $a['is_marker'] && ! empty( $marker ) ) ? $marker : '',
	'data-marker-title'     => ( 'enable' === $a['is_marker'] && ! empty( $a['marker_title'] ) ) ? esc_html( $a['marker_title'] ) : '',
	'data-styles'           => json_decode( $style, true ),
	'data-aos'              => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo '<div ', $attr, '></div>';
