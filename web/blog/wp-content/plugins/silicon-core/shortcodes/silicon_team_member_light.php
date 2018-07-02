<?php
/**
 * Team Member | silicon_team_member_light
 *
 * This shortcode uses $content
 * This variable contains the social networks
 *
 * This is a lightweight version of Team Member shortcode
 * for use inside the Team Grid shortcode
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
	'image'     => 0,
	'name'      => '',
	'position'  => '',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

// vars
$skin = wp_cache_get( 'silicon_team_grid_skin', 'silicon_shortcodes' );
if ( empty( $skin ) ) {
	$skin = 'dark'; // default
}

$avatar   = wp_get_attachment_image( (int) $a['image'], 'full' );
$name     = strip_tags( stripslashes( trim( $a['name'] ) ) );
$position = strip_tags( stripslashes( trim( $a['position'] ) ) );
$socials  = silicon_shortcode_build( 'silicon_socials', array(
	'socials'   => $content,
	'shape'     => 'no',
	'color'     => 'brand',
	'alignment' => 'center',
	'skin'      => esc_attr( $skin ),
) );

if ( 'light' === $skin ) {
	$name     = silicon_get_text( $name, '<h4 class="si-team-title text-white">', '</h4>' );
	$position = silicon_get_text( $position, '<span class="text-white opacity-50">', '</span>' );
} else {
	$name     = silicon_get_text( $name, '<h4 class="si-team-title">', '</h4>' );
	$position = silicon_get_text( $position, '<span class="text-gray">', '</span>' );
}

$avatar  = silicon_get_text( $avatar, '<div class="si-team-avatar">', '</div>' );
$socials = silicon_do_shortcode( $socials );

// output
$r = array(
	'{avatar}'   => $avatar,
	'{name}'     => $name,
	'{position}' => $position,
	'{socials}'  => $socials,
);

$output = str_replace( array_keys( $r ), array_values( $r ), '
<div class="si-team si-team-default-vertical">
	{avatar}
	<div class="si-team-info">
	    {name}
	    {position}
	    {socials}
	</div>
</div>' );

$class = silicon_get_classes( array(
	'si-justified-item',
	'border-default-left',
	'border-default-top',
	'border-' . esc_attr( $skin ),
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo '<div ', $attr, '>', $output, '</div>';
