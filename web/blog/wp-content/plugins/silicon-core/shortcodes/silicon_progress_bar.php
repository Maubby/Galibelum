<?php
/**
 * Progress Bar | silicon_progress_bar
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
	'value'            => '',
	'label'            => '',
	'is_units'         => 'enable', // checkbox
	'is_icon'          => 'disable',
	'icon_library'     => 'silicon',
	'icon_silicon'     => '',
	'icon_socicon'     => '',
	'icon_material'    => '',
	'icon_fontawesome' => '',
	'icon_custom'      => '',
	'color'            => 'dark',
	'color_custom'     => '',
	'skin'             => 'dark',
	'is_animation'     => 'disable',
	'animation'        => '',
	'class'            => '',
), $shortcode ), $atts );

// no sense to show progress bar if value not provided
$value = absint( rtrim( $a['value'], '%' ) );
if ( empty( $value ) || ! is_numeric( $value ) ) {
	return;
}

// label
if ( ! empty( $a['label'] ) ) {
	// if user specify label - append it
	$label = sprintf( '%s &nbsp; &mdash; &nbsp; %s',
		esc_html( stripslashes( trim( $a['label'] ) ) ),
		esc_html( $value ) . ( 'enable' === $a['is_units'] ? '%' : '' )
	);
} else {
	// only value + % symbol
	$label = esc_html( $value ) . ( 'enable' === $a['is_units'] ? '%' : '' );
}

// icon
if ( 'enable' === $a['is_icon'] ) {

	// predefined color
	if ( 'gradient' === $a['color'] ) {
		$class = ( 'light' === $a['skin'] ) ? 'text-white' : '';
	} else {
		$class = 'text-' . esc_attr( $a['color'] );
	}

	// in case of custom color
	if ( 'custom' === $a['color'] ) {
		$style = sprintf( 'color: %s;', sanitize_hex_color( $a['color_custom'] ) );
	} else {
		$style = '';
	}

	$library = $a['icon_library'];
	$icon    = sprintf( '<i class="%s"></i>', esc_attr( $a["icon_{$library}"] ) );
	$icon    = silicon_get_tag( 'span', array( 'class' => $class, 'style' => $style ), $icon );
	$icon    = $icon . ' '; // there is a space after icon
	unset( $library, $class, $style );
} else {
	$icon = '';
}

$style = array();

// if animation is disabled, simply
// add a width property in style attribute
if ( 'disable' === $a['is_animation'] || empty( $a['is_animation'] ) ) {
	$style['width'] = $value . '%';
}

// if animation is enabled, in this case
// width of the rails define via javascript
// so add data-attribute
if ( 'enable' === $a['is_animation'] ) {
	$rail_attr['data-progress-value'] = $value;
} else {
	$rail_attr = array();
}

// if custom color, apply a background-color to .rails
if ( 'custom' === $a['color'] ) {
	$style['background-color'] = sanitize_hex_color( $a['color_custom'] );
}

$class = silicon_get_classes( array(
	'progress',
	'progress-' . esc_attr( $a['skin'] ),
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

$template = <<<'TPL'
<div {attr}>
    <h4 class="progress-bar-label">{icon}{label}</h4>
    <div class="progress-bar">
        <span class="rails background-{color}" style="{style}" {data}></span>
    </div>
</div>
TPL;

$r = array(
	'{attr}'  => $attr,
	'{icon}'  => $icon,
	'{label}' => $label,
	'{color}' => esc_attr( $a['color'] ),
	'{style}' => empty( $style ) ? '' : silicon_css_declarations( $style ),
	'{data}'  => empty( $rail_attr ) ? '' : silicon_get_attr( $rail_attr ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
