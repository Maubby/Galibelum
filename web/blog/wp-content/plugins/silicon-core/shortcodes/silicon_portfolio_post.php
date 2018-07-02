<?php
/**
 * Portfolio Post | silicon_portfolio_post
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
	'post'      => 0,
	'type'      => 'with-gap',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

if ( empty( $a['post'] ) ) {
	return;
}

$post = get_post( (int) $a['post'] );
if ( ! $post instanceof WP_Post ) {
	return;
}

// do not load tile if Featured Image is missing
if ( ! has_post_thumbnail( $post ) ) {
	return;
}

$class = silicon_get_classes( array(
	'portfolio-post-wrapper',
	$a['class']
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

setup_postdata( $GLOBALS['post'] =& $post );

echo '<div ', $attr, '>';
get_template_part( 'template-parts/tiles/portfolio', esc_attr( $a['type'] ) );
echo '</div>';

wp_reset_postdata();