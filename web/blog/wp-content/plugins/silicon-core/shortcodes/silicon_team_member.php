<?php
/**
 * Team Member | silicon_team_member
 *
 * This shortcode uses $content
 * This variable contains the social networks
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
	'type'      => 'vertical',
	'cover'     => 0,
	'image'     => 0,
	'name'      => '',
	'position'  => '',
	'info'      => '',
	'skin'      => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

// classes
$class = array();

// use separate template for "Card" type
if ( 'card' === $a['type'] ) {

	// classes for card type
	$class[] = 'si-team-card';

	$template = '
    <section class="widget widget_silicon_author">
        <div class="silicon-author border-default">
            <div class="silicon-author-cover" {cover}></div>
            <div class="silicon-author-info font-family-nav">
                {avatar}
                <div class="silicon-author-about">
                    {name}
                    {position}
                </div>
            </div>
            <div class="silicon-author-footer">
                {info}
                {socials}
            </div>
        </div>
    </section>
    ';

	$cover    = esc_url( silicon_get_image_src( (int) $a['cover'] ) );
	$avatar   = wp_get_attachment_image( (int) $a['image'], 'full' );
	$name     = strip_tags( stripslashes( trim( $a['name'] ) ) );
	$position = strip_tags( stripslashes( trim( $a['position'] ) ) );
	$info     = strip_tags( stripslashes( trim( $a['info'] ) ) );
	$socials  = silicon_shortcode_build( 'silicon_socials', array(
		'socials' => $content,
		'shape'   => 'no',
		'color'   => 'brand',
	) );

	$cover    = empty( $cover ) ? '' : sprintf( 'style="background-image: url(%s);"', $cover );
	$avatar   = silicon_get_text( $avatar, '<div class="silicon-author-avatar">', '</div>' );
	$name     = silicon_get_text( $name, '<div class="silicon-author-name navi-link-color">', '</div>' );
	$position = silicon_get_text( $position, '<span class="silicon-author-position">', '</span>' );
	$info     = silicon_get_text( strip_tags( stripslashes( trim( $a['info'] ) ) ), '<p>', '</p>' );
	$socials  = silicon_do_shortcode( $socials );

} else {

    // classes for standard and horizontal types
    $class[] = 'si-team';
    $class[] = 'si-team-default-' . esc_attr( $a['type'] );

	$template = '
    {avatar}
    <div class="si-team-info">
        {name}
        {position}
        {socials}
    </div>';

	$cover    = '';
	$info     = '';
	$avatar   = wp_get_attachment_image( (int) $a['image'], 'full' );
	$name     = strip_tags( stripslashes( trim( $a['name'] ) ) );
	$position = strip_tags( stripslashes( trim( $a['position'] ) ) );
	$socials  = silicon_shortcode_build( 'silicon_socials', array(
		'socials'   => $content,
		'shape'     => 'no',
		'color'     => 'brand',
		'alignment' => 'horizontal' === $a['type'] ? 'left' : 'center',
		'skin'      => esc_attr( $a['skin'] ),
	) );

	if ( 'light' === $a['skin'] ) {
		$name     = silicon_get_text( $name, '<h4 class="si-team-title text-white">', '</h4>' );
		$position = silicon_get_text( $position, '<span class="text-white opacity-50">', '</span>' );
	} else {
		$name     = silicon_get_text( $name, '<h4 class="si-team-title">', '</h4>' );
		$position = silicon_get_text( $position, '<span class="text-gray">', '</span>' );
	}

	$avatar  = silicon_get_text( $avatar, '<div class="si-team-avatar">', '</div>' );
	$socials = silicon_do_shortcode( $socials );
}

// output
$r = array(
	'{cover}'    => $cover,
	'{avatar}'   => $avatar,
	'{name}'     => $name,
	'{position}' => $position,
	'{info}'     => $info,
	'{socials}'  => $socials,
);

$output  = str_replace( array_keys( $r ), array_values( $r ), $template );
$class[] = $a['class']; // extra classes from sh attributes
$attr    = silicon_get_attr( array(
	'class'    => esc_attr( silicon_get_classes( $class ) ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

echo '<div ', $attr, '>', $output, '</div>';
