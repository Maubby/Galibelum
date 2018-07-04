<?php
/**
 * Column | vc_column
 *
 * @var array                    $atts    Shortcode attributes
 * @var mixed                    $content Shortcode content
 * @var WPBakeryShortCode_VC_Row $this    Instance of a class
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
	'width'     => '1/1',
	'offset'    => '',
	'animation' => '',
	'class'     => '',
	'css'       => '',
), 'vc_column' ), $atts );

$class = silicon_get_classes( array(
	silicon_vc_column_class( $a['width'], $a['offset'] ),
	trim( vc_shortcode_custom_css_class( $a['css'] ) ),
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => ( ! empty( $a['animation'] ) ) ? esc_attr( $a['animation'] ) : '',
) );

echo '<div ', $attr, '>';
echo silicon_do_shortcode( $content );
echo '</div>';
