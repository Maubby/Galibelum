<?php
/**
 * Description List | silicon_description_list
 *
 * This shortcode uses $content
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
	'type'       => 'no-icon',
	'skin'       => 'dark',
	'items'      => '', // param_group for list without icon
	'items_icon' => '', // param_group for list with icon
	'animation'  => '',
	'class'      => '',
), $shortcode ), $atts );

if ( 'with-icon' === $a['type'] ) {
	$items = json_decode( urldecode( $a['items_icon'] ), true );
} else {
	$items = json_decode( urldecode( $a['items'] ), true );
}

if ( empty( $items ) ) {
	return;
}

$is_icon = ( 'with-icon' === $a['type'] );
$output  = '';
foreach ( $items as $item ) {
	$item = wp_parse_args( $item, array(
		'title'             => '',
		'description'       => '',
		'icon_library'      => 'silicon',
		'icon_silicon'      => '',
		'icon_socicon'      => '',
		'icon_material'     => '',
		'icon_fontawesome'  => '',
		'icon_custom'       => '',
		'icon_color'        => 'dark',
		'icon_color_custom' => '',
	) );

	$icon        = '';
	$title       = esc_html( trim( $item['title'] ) );
	$description = strip_tags( stripslashes( trim( $item['description'] ) ) );

	$library = $item['icon_library'];
	if ( $is_icon && ! empty( $item["icon_{$library}"] ) ) {
		$i = array();

		$i_class = $item["icon_{$library}"];
		$i_color = esc_attr( $item['icon_color'] );
		silicon_vc_enqueue_icon_font( $library );

		$i['class'] = silicon_get_classes( array( $i_class, 'text-' . $i_color ) );
		$i['style'] = ( 'custom' === $item['icon_color'] ) ? silicon_css_color( $item['icon_color_custom'] ) : '';

		$icon = silicon_get_tag( 'i', $i, '' );
		unset( $i, $i_class, $i_color );
	}

	$output .= sprintf( '<dt class="h6">%1$s%2$s</dt><dd class="text-gray border-default-bottom">%3$s</dd>',
		$icon, $title, $description
	);

	unset( $icon, $title, $description, $library );
}

$class = esc_attr( silicon_get_classes( array(
	esc_attr( $a['type'] ),
	esc_attr( $a['skin'] ) . '-skin',
	$a['class'],
) ) );

$attr = silicon_get_attr( array(
	'class'    => $class,
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo "<dl {$attr}>{$output}</dl>";
