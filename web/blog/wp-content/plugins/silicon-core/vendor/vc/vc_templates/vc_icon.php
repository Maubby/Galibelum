<?php
/**
 * Icon | vc_icon
 *
 * @var array                     $atts    Shortcode attributes
 * @var mixed                     $content Shortcode content
 * @var WPBakeryShortCode_VC_Icon $this    Instance of a class
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
	'type'               => 'icon',

	// image type
	'image'              => '',
	'image_size'         => 60, // px

	// icon type
	'icon_library'       => 'silicon',
	'icon_silicon'       => 'si si-audio',
	'icon_socicon'       => '',
	'icon_material'      => '',
	'icon_fontawesome'   => '',
	'icon_custom'        => '',
	'icon_size'          => 24, // px
	'icon_color'         => 'default',
	'icon_color_custom'  => '',
	'shape'              => 'no',
	'shape_color'        => 'gray',
	'shape_color_custom' => '',
	'shape_size'         => 48, // px
	'shape_is_fill'      => 'disable',

	// both
	'alignment'          => 'left',
	'animation'          => '',
	'class'              => '',
), 'vc_icon' ), $atts );

$class = array();
$style = array();

if ( 'image' === $a['type'] ) {
	$icon           = wp_get_attachment_image( $a['image'] );
	$style['width'] = empty( $a['image_size'] ) ? '' : absint( $a['image_size'] ) . 'px';
} else {
	$library = $a['icon_library'];
	silicon_vc_enqueue_icon_font( $library );
	$icon    = esc_attr( $a[ 'icon_' . $library ] ); // icon class

	// icon size, if specified
	$fs = empty( $a['icon_size'] ) ? '' : 'font-size: ' . absint( $a['icon_size'] ) . 'px;';

	// icon color + custom
	$class[] = 'text-' . esc_attr( $a['icon_color'] );
	if ( 'custom' === $a['icon_color'] && ! empty( $a['icon_color_custom'] ) ) {
		$style['color'] = sanitize_hex_color( $a['icon_color_custom'] );
	}

	// shape
	if ( 'no' !== $a['shape'] ) {
		$color = esc_attr( $a['shape_color'] );
		$size  = absint( $a['shape_size'] );

		$class[] = 'border-default';
		$class[] = 'border-color-' . $color;
		$class[] = 'si-icon-shape-' . esc_attr( $a['shape'] );

		if ( 'enable' === $a['shape_is_fill'] ) {
			$class[] = 'si-icon-shape-filled';
			$class[] = 'background-' . $color;
		}

		$style['width'] = $style['height'] = $size . 'px';

		// in case of custom color make sure you use
		// correct property for normal and filled shape
		if ( 'custom' === $color ) {
			$property           = ( 'enable' === $a['shape_is_fill'] ) ? 'background-color' : 'border-color';
			$style[ $property ] = sanitize_hex_color( $a['shape_color_custom'] );
			unset( $property );
		}

		unset( $color, $size );
	} else {
		$style['width'] = $style['height'] = empty( $a['icon_size'] ) ? '24px' : absint( $a['icon_size'] ) . 'px';
	}

	$icon = silicon_get_tag( 'i', array( 'class' => $icon, 'style' => $fs ), '' );
	unset( $library, $fs );
}

$template = <<<'TPL'
<div class="sc-icon text-{alignment} {extra-class}" {animation}>
    <div class="sc-icon-inner {class}" style="{inner-style}">
        {icon}
    </div>
</div>
TPL;

$r = array(
	'{alignment}'   => esc_attr( $a['alignment'] ),
	'{extra-class}' => esc_attr( $a['class'] ),
	'{animation}'   => empty( $a['animation'] ) ? '' : 'data-aos="' . esc_attr( $a['animation'] ) . '"',
	'{class}'       => esc_attr( silicon_get_classes( $class ) ),
	'{inner-style}' => esc_attr( silicon_css_declarations( $style ) ),
	'{icon}'        => $icon,
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
