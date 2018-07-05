<?php
/**
 * Row | vc_row
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
	'id'              => '',
	'offset_top'      => 180,
	'layout'          => 'boxed',
	'is_no_gap'       => 'disable',
	'is_overlay'      => 'disable',
	'overlay_type'    => 'color',
	'overlay_color'   => '#000000',
	'overlay_opacity' => 60,
	'is_parallax'     => 'disable',
	'parallax_bg'     => 0,
	'parallax_video'  => '',
	'parallax_type'   => 'scroll',
	'parallax_speed'  => 0.4,
	'animation'       => '',
	'class'           => '',
	'css'             => '',
), 'vc_row' ), $atts );

$is_no_gap   = ( 'enable' === $a['is_no_gap'] );
$is_overlay  = ( 'enable' === $a['is_overlay'] );
$is_parallax = ( 'enable' === $a['is_parallax'] );

// overlay
$overlay = '';
if ( $is_overlay ) {
	$o['class'] = ( 'gradient' === $a['overlay_type'] ) ? 'overlay background-gradient' : 'overlay';
	$o['style'] = silicon_css_declarations( array(
		'opacity'          => silicon_get_opacity_value( $a['overlay_opacity'] ),
		'background-color' => ( 'gradient' === $a['overlay_type'] ) ? '' : esc_attr( $a['overlay_color'] ),
	) );

	$overlay = silicon_get_tag( 'span', $o, '' );
	unset( $o );
}

// .fw-section classes
$class = silicon_get_classes( array(
	'fw-section',
	'layout-' . sanitize_key( $a['layout'] ),
	$is_no_gap ? 'section-no-gap' : '',
	$is_overlay ? 'with-overlay' : 'without-overlay',
	$is_parallax ? 'with-parallax' : 'without-parallax',
	trim( vc_shortcode_custom_css_class( $a['css'] ) ),
	$a['class'],
) );

// .fw-section attributes
$attr                    = array();
$attr['id']              = esc_attr( $a['id'] );
$attr['class']           = esc_attr( $class );
$attr['data-aos']        = ( ! empty( $a['animation'] ) ) ? esc_attr( $a['animation'] ) : '';
$attr['data-offset-top'] = (int) $a['offset_top'];

if ( $is_parallax ) {
	$metadata  = wp_get_attachment_metadata( (int) $a['parallax_bg'] );
	$jarallax  = array(
		'type'      => esc_attr( $a['parallax_type'] ),
		'speed'     => silicon_sanitize_float( $a['parallax_speed'] ),
		'imgWidth'  => empty( $metadata['width'] ) ? 'null' : (int) $metadata['width'],
		'imgHeight' => empty( $metadata['height'] ) ? 'null' : (int) $metadata['height'],
		'noAndroid' => 'true',
		'noIos'     => 'true',
	);

	$attr['data-jarallax']       = $jarallax;
	$attr['data-jarallax-video'] = esc_url( $a['parallax_video'] );
	$attr['style']               = silicon_css_background_image( (int) $a['parallax_bg'] );
}

$attr = silicon_get_attr( $attr );

// container class
switch ( $a['layout'] ) {
	case 'full':
	case 'full-equal':
		$container = 'container-fluid';
		break;

	case 'boxed':
	case 'boxed-equal':
	default:
		$container = 'container';
		break;
}

$tpl = <<<'TEMPLATE'
<section {attr}>
	{overlay}
	<div class="{container-class}">
		<div class="row">
			{content}
		</div>
	</div>
</section>
TEMPLATE;

$r = array(
	'{attr}'            => $attr,
	'{overlay}'         => $overlay,
	'{container-class}' => $container,
	'{content}'         => silicon_do_shortcode( $content ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $tpl );
