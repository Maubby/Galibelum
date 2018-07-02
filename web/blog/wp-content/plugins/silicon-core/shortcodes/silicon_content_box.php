<?php
/**
 * Content Box | silicon_content_box
 *
 * This shortcode uses $content variable
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
	'type'             => 'icon',
	'icon_library'     => 'silicon',
	'icon_silicon'     => 'si si-camera',
	'icon_socicon'     => '',
	'icon_material'    => '',
	'icon_fontawesome' => '',
	'icon_custom'      => '',
	'media_icon'       => 0,
	'cover'            => 0,
	'title'            => '',
	// $content is description
	'link_text'        => __( 'Read More', 'silicon' ),
	'link_url'         => '',
	'color'            => 'primary',
	'animation'        => '',
	'class'            => '',
), $shortcode ), $atts );

$title = esc_html( trim( $a['title'] ) );
$desc  = nl2br( esc_html( strip_tags( stripslashes( trim( $content ) ) ) ) );

/* Prepare icon */

if ( 'icon' === $a['type'] ) {
	// font icon

	$library = $a['icon_library'];
	$icon    = sprintf( '<span class="%2$s"><i class="%1$s"></i></span>',
		esc_attr( $a["icon_{$library}"] ),
        ('gradient' === $a['color'] ) ? 'color-gradient-light-bg' : 'text-' . esc_attr( $a['color'] )
	);
	unset( $library );
} elseif ( 'icon-image' === $a['type'] && ! empty( $a['media_icon'] ) ) {
	// media icon

	$icon = wp_get_attachment_image( (int) $a['media_icon'] );
} elseif ( 'image-cover' === $a['type'] && ! empty( $a['cover'] ) ) {
	// cover image

	$icon = wp_get_attachment_image( (int) $a['cover'], 'full' );
} else {
	// none

	$icon = '';
}

/* Button */
if ( ! empty( $a['link_url'] ) && ! empty( $a['link_text'] ) ) {
	$link = silicon_vc_parse_link( $a['link_url'] );
	if ( empty( $link['url'] ) ) {
		$button = '';
	} else {
		$link['href']  = silicon_esc_url( $link['url'] );
		$link['class'] = 'btn btn-pill btn-default btn-link margin-top-none';
		unset( $link['url'] );

		$button = silicon_get_tag( 'a', $link, esc_html( $a['link_text'] ) );
	}
} else {
    $button = '';
}

/* Attributes for div.content-box element */

$class = silicon_get_classes( array(
	'content-box',
	'content-box-' . esc_attr( $a['type'] ),
	'text-center',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

/* Output */

$template = <<<'TPL'
<div {attr}>
    <header class="content-box-header">
        {icon}
    </header>

    <div class="content-box-body">
        {title}
        {desc}
    </div>
    
    {button}
    <span class="content-box-decoration-line background-{color}"></span>
</div>
TPL;

$r = array(
	'{attr}'   => $attr,
	'{icon}'   => $icon,
	'{title}'  => silicon_get_text( $title, '<h4 class="content-box-title">', '</h4>' ),
	'{desc}'   => silicon_get_text( $desc, '<p class="content-box-text">', '</p>' ),
	'{button}' => $button,
	'{color}'  => esc_attr( $a['color'] ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
