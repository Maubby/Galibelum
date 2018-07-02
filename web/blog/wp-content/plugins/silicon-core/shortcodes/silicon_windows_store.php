<?php
/**
 * Windows Store | silicon_windows_store
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
	'name'      => __( 'Windows Store', 'silicon' ),
	'text'      => __( 'Download on the', 'silicon' ),
	'link'      => '',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

/**
 * Filter the path to Windows Store button background
 *
 * @param string $path URI to background image
 */
$image = apply_filters( 'silicon_shortcode_windows_store_bg', SILICON_PLUGIN_URI . '/img/market-btns/windows.png' );
$name  = esc_html( $a['name'] );
$text  = silicon_get_text( esc_html( $a['text'] ), '<span>', '</span>' ) . $name;
$link  = silicon_vc_parse_link( $a['link'] );
$class = silicon_get_classes( array(
	'market-btn',
	'btn-windows',
	$a['class'],
) );

$attributes             = array();
$attributes['href']     = empty( $link['url'] ) ? '#' : esc_url( trim( $link['url'] ) );
$attributes['target']   = empty( $link['target'] ) ? '' : esc_attr( trim( $link['target'] ) );
$attributes['title']    = empty( $link['title'] ) ? '' : esc_attr( trim( $link['title'] ) );
$attributes['rel']      = empty( $link['rel'] ) ? '' : esc_attr( trim( $link['rel'] ) );
$attributes['class']    = esc_attr( $class );
$attributes['data-aos'] = ( ! empty( $a['animation'] ) ) ? esc_attr( $a['animation'] ) : '';
$attributes['style']    = silicon_css_background_image( $image );

echo silicon_get_tag( 'a', $attributes, $text );
