<?php
/**
 * Team Grid | silicon_team_grid
 *
 * This shortcode uses $content
 * This is a container shortcode for Team Member Light
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
	'skin'      => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

$regex = get_shortcode_regex( array( 'silicon_team_member_light' ) );
preg_match_all( "/$regex/", $content, $matches );
$members = array_filter( $matches[0] );

if ( empty( $content ) || empty( $members ) ) {
	return;
}

$func = function( $chunks ) {
	return implode( '', $chunks );
};

// Wrap each 4 items into the .si-justified-row
$members = array_map( $func, array_chunk( $members, 4 ) );
$members = implode( '</div><div class="si-justified-row">', $members );
$members = '<div class="si-justified-row">' . $members . '</div>';

$class = silicon_get_classes( array(
	'si-justified-grid',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

// save skin variable for child shortcodes
wp_cache_set( 'silicon_team_grid_skin', $a['skin'], 'silicon_shortcodes' );

echo '<div ', $attr, '>';
echo silicon_do_shortcode( $members );
echo '</div>';

wp_cache_delete( 'silicon_team_grid_skin', 'silicon_shortcodes' );
