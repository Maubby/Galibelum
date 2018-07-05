<?php
/**
 * Product | silicon_product
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

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'product'   => 0,
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

if ( empty( $a['product'] ) ) {
	return;
}

$post = get_post( (int) $a['product'] );
if ( ! $post instanceof WP_Post ) {
	return;
}

$class = silicon_get_classes( array(
	'single-product-tile',
	'woocommerce',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

setup_postdata( $GLOBALS['post'] =& $post );

echo '<div ', $attr, '>';
wc_get_template_part( 'content', 'product' );
echo '</div>';

wp_reset_postdata();
