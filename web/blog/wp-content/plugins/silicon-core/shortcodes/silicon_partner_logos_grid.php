<?php
/**
 * Partner Logos Grid | silicon_partner_logos_grid
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
	'skin'      => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

$raw_logos = json_decode( urldecode( $content ), true );
if ( empty( $raw_logos ) ) {
	return;
}

// Prepare items
$item_tpl = '
<div class="si-justified-item border-default-left border-default-top {skin}">
    <{tag} class="si-logos-item"{link}>
        <div class="si-logos-img">
            {image}
        </div>
        <div class="si-logos-info">
            {title}
            {desc}
        </div>
    </{tag}>
</div>';

$is_light = ( 'light' === $a['skin'] );
$logos    = array();
foreach ( $raw_logos as $_logo ) {
	// skip without images
	if ( empty( $_logo['image'] ) ) {
		continue;
	}

	$_logo = wp_parse_args( $_logo, array(
		'image'       => 0,
		'title'       => '',
		'description' => '',
		'link'        => '',
	) );

	$is_linked = ( ! empty( $_logo['link'] ) );
	$text      = strip_tags( stripslashes( trim( $_logo['title'] ) ) );
	$desc      = strip_tags( stripslashes( trim( $_logo['description'] ) ) );

	$r = array(
		'{skin}'  => $is_light ? 'border-light' : 'border-dark',
		'{tag}'   => $is_linked ? 'a' : 'div',
		'{link}'  => $is_linked ? sprintf( ' href="%s"', esc_url( $_logo['link'] ) ) : '',
		'{image}' => wp_get_attachment_image( (int) $_logo['image'], 'medium' ),
		'{title}' => silicon_get_text( $text, $is_light ? '<h4 class="si-logos-title text-white">' : '<h4 class="si-logos-title">', '</h4>' ),
		'{desc}'  => silicon_get_text( $desc, $is_light ? '<p class="text-white opacity-50">' : '<p class="text-gray">', '</p>' ),
	);

	$logos[] = str_replace( array_keys( $r ), array_values( $r ), $item_tpl );
	unset( $is_linked, $text, $desc, $r );
}
unset( $_logo );

// Wrap each 4 items into the .si-justified-row

$logos = array_map( function ( $chunks ) {
	return implode( '', $chunks );
}, array_chunk( $logos, 4 ) );

$logos = implode( '</div><div class="si-justified-row">', $logos );
$logos = '<div class="si-justified-row">' . $logos . '</div>';

// Output

$class = silicon_get_classes( array(
	'si-justified-grid',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo '<div ', $attr, '>', $logos, '</div>';
