<?php
/**
 * Video Button | silicon_video_button
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
	'video'     => '',
	'alignment' => 'center',
	'skin'      => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

if ( empty( $a['video'] ) ) {
	return;
}

$class = silicon_get_classes( array(
	'video-popup',
	'text-' . esc_attr( $a['alignment'] ),
	$a['class'],
) );

$template = <<<'TPL'
<div class="{class}" {animation}>
	<a href="{video}" class="video-popup-btn border-default {border-skin}">
		<i class="si si-play text-{skin}"></i>
	</a>
</div>
TPL;

$r = array(
	'{class}'       => esc_attr( $class ),
	'{animation}'   => empty( $a['animation'] ) ? '' : 'data-aos="' . esc_attr( $a['animation'] ) . '"',
	'{video}'       => esc_url( trim( $a['video'] ) ),
	'{border-skin}' => ( 'white' === $a['skin'] ) ? 'border-light' : '',
	'{skin}'        => esc_attr( $a['skin'] ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
