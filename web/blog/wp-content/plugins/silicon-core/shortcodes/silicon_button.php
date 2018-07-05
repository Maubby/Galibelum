<?php
/**
 * Button | silicon_button
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
	'text'             => '',
	'link'             => '',
	'type'             => 'solid',
	'shape'            => 'pill',
	'color'            => 'default',
	'color_custom'     => '', // hex
	'size'             => 'nl',
	'is_full'          => 'disable',
	'alignment'        => 'inline',
	'is_icon'          => 'disable', // checkbox, empty = disable
	'icon_library'     => 'silicon',
	'icon_position'    => 'left',
	'icon_silicon'     => '',
	'icon_socicon'     => '',
	'icon_material'    => '',
	'icon_fontawesome' => '',
	'icon_custom'      => '',
	'is_waves'         => 'disable',
	'waves_skin'       => 'light',
	'animation'        => '',
	'class'            => '',
), $shortcode ), $atts );

$is_full      = ( 'enable' === $a['is_full'] );
$is_waves     = ( 'enable' === $a['is_waves'] );
$is_inline    = ( 'inline' === $a['alignment'] );
$is_right     = ( 'right' === $a['icon_position'] );
$is_animation = ( ! empty( $a['animation'] ) );

$text = esc_html( trim( $a['text'] ) );
$link = silicon_vc_parse_link( $a['link'] );
$icon = '';

$attr  = array();
$class = array();

$attr['href']   = empty( $link['url'] ) ? '#' : esc_url( trim( $link['url'] ) );
$attr['target'] = empty( $link['target'] ) ? '' : esc_attr( trim( $link['target'] ) );
$attr['title']  = empty( $link['title'] ) ? '' : esc_attr( trim( $link['title'] ) );
$attr['rel']    = empty( $link['rel'] ) ? '' : esc_attr( trim( $link['rel'] ) );

// default button classes
$class[] = 'btn';
$class[] = 'btn-' . esc_attr( $a['type'] );
$class[] = 'btn-' . esc_attr( $a['shape'] );
$class[] = 'btn-' . esc_attr( $a['color'] );
$class[] = 'btn-' . esc_attr( $a['size'] );
$class[] = $is_full ? 'btn-block' : '';
$class[] = $is_waves ? 'waves-effect' : '';
$class[] = $is_waves ? 'waves-' . esc_attr( $a['waves_skin'] ) : '';
$class[] = $a['class']; // extra class

// is icon
if ( 'enable' === $a['is_icon'] ) {
	$library = $a['icon_library'];
	$icon    = sprintf( '<i class="%s"></i>', esc_attr( $a["icon_{$library}"] ) );
	$icon    = $is_right ? '&nbsp;' . $icon : $icon . '&nbsp;';
	unset( $library );
}

// custom color
if ( 'custom' === $a['color'] ) {
	$color   = sanitize_hex_color( $a['color_custom'] );
	$c_class = silicon_get_unique_id( 'btn-custom-' ); // custom class
	$custom  = array();

	switch ( $a['type'] ) {
		case 'solid':
			$custom[] = silicon_css_rules( ".{$c_class}", array(
				'background-color' => $color,
				'color'            => "#ffffff",
			) );
			$custom[] = silicon_css_rules( ".{$c_class}:hover", array(
				'background-color' => silicon_color_darken( $color, 8 ),
				'color'            => "#ffffff",
				'box-shadow'       => "0 14px 25px -8px " . silicon_color_rgba( $color, '.6' ),
			) );
			break;

		case 'ghost':
			$custom[] = silicon_css_rules( ".{$c_class}", array(
				'border-color' => $color,
				'color'        => $color,
			) );

			$custom[] = silicon_css_rules( ".{$c_class}::before", array(
				'background-color' => $color,
			) );

			$custom[] = silicon_css_rules( ".{$c_class}:hover", array(
				'color'      => '#ffffff',
				'box-shadow' => "0 14px 25px -8px " . silicon_color_rgba( $color, '.6' ),
			) );
			break;

		case 'link':
			$custom[] = silicon_css_rules( ".{$c_class}", array( 'color' => $color ) );
			$custom[] = silicon_css_rules( ".{$c_class}:hover", array(
				'color'            => $color,
				'background-color' => '#ffffff',
				'box-shadow'       => "0 14px 25px -8px " . silicon_color_rgba( $color, '.45' ),
			) );
			break;
	}

	$class[]                   = $c_class; // add custom class to btn class set
	$attr['data-custom-color'] = implode( '', array_filter( $custom ) );
	unset( $color, $c_class, $custom );
}

$attr['class'] = silicon_get_classes( $class );

// convert attributes to string
$attr = silicon_get_attr( $attr );

// prepare the template, 1 = attr, 2 = text, 3 = icon
$tpl = $is_right ? '<a %1$s>%2$s%3$s</a>' : '<a %1$s>%3$s%2$s</a>';

// prepare a.btn
$btn = sprintf( $tpl, $attr, $text, $icon );

// Buttons are placed in line when meet two conditions:
// alignment = inline & animation is disabled. In all other cases (alignment or animation)
// button should be wrapped into div.text-{alignment}+data-aos > a.btn
if ( $is_inline && ! $is_animation ) {
	echo $btn;
} else {
	echo silicon_get_tag( 'div', array(
		'class'    => 'text-' . esc_attr( $a['alignment'] ),
		'data-aos' => $is_animation ? esc_attr( $a['animation'] ) : '',
	), $btn );
}
