<?php
/**
 * Socials | silicon_socials
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
	'socials'           => '',
	'shape'             => 'circle',
	'color'             => 'monochrome',
	'skin'              => 'dark',
	'alignment'         => 'left',
	'is_tooltips'       => 'disable', // checkbox, should be enable
	'tooltips_position' => 'top',
	'animation'         => '',
	'class'             => '',
), $shortcode ), $atts );

$socials  = json_decode( urldecode( $a['socials'] ), true );
$networks = silicon_get_networks();
if ( empty( $socials ) || empty( $networks ) ) {
	return;
}

$shape = esc_attr( $a['shape'] );
$color = esc_attr( $a['color'] );
$skin  = esc_attr( $a['skin'] );
$t_pos = esc_attr( $a['tooltips_position'] );

$bordered = array( 'circle', 'rounded', 'square' );
$is_tips  = ( 'enable' === $a['is_tooltips'] );

$polygon = '
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36.594 38.719">
    <path d="M157,43.455L144.256,55.547l2.506,21.4,24,4.236L179.83,58Z" stroke="#e9e9e9" stroke-width="1px" fill="transparent" transform="translate(-143.75 -42.969)"/>
</svg>
';

$wrapper = silicon_get_attr( array(
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
	'class'    => esc_attr( silicon_get_classes( array(
		'social-bar',
		'text-' . esc_attr( $a['alignment'] ),
		$a['class']
	) ) )
) );

echo '<div ', $wrapper, '>';
foreach ( $socials as $social ) {
	// skip items with undefined data
	if ( empty( $social['network'] ) || empty( $social['url'] ) ) {
		continue;
	}

	$network = $social['network'];
	if ( ! array_key_exists( $network, $networks ) ) {
		continue;
	}

	$name  = esc_attr( $networks[ $network ]['name'] );
	$class = silicon_get_classes( array(
		'social-button',
		esc_attr( $networks[ $network ]['helper'] ),
		'sb-shape-' . $shape,
		'sb-' . $color,
		'sb-' . $skin,
		in_array( $shape, $bordered, true ) ? 'border-default' : '',
	) );

	$r = array(
		'{url}'     => silicon_esc_url( $social['url'] ),
		'{class}'   => esc_attr( $class ),
		'{tip}'     => $is_tips ? sprintf( 'data-toggle="tooltip" data-placement="%s" title="%s"', $t_pos, $name ) : '',
		'{polygon}' => ( 'polygon' === $shape ) ? $polygon : '',
		'{icon}'    => esc_attr( $networks[ $network ]['icon'] ),
	);

	echo str_replace( array_keys( $r ), array_values( $r ),
        '<a href="{url}" class="{class}" {tip}>
            {polygon}
            <i class="{icon} unhvrd"></i>
            <i class="{icon} hvrd"></i>
        </a>'
    );

	unset( $network, $name, $class, $r );
}
echo '</div>';
