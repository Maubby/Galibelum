<?php
/**
 * Testimonial | silicon_testimonial
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
	'avatar'    => '',
	'name'      => '',
	'position'  => '',
	'alignment' => 'left',
	'color'     => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

// no need to show shortcode if testimonial not provided
if ( empty( $content ) ) {
    return;
}

$testimonial = nl2br( esc_html( stripslashes( trim( $content ) ) ) );
$alignment   = esc_attr( $a['alignment'] );
$class       = silicon_get_classes( array(
	'testimonial',
	'testimonial-' . $alignment,
	'border-default',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

if ( ! empty( $a['avatar'] ) || ! empty( $a['name'] ) || ! empty( $a['position'] ) ) {
	$ava  = silicon_get_text( wp_get_attachment_image( (int) $a['avatar'] ), '<div class="author-avatar">', '</div>' );
	$name = silicon_get_text( esc_html( $a['name'] ), '<h4 class="testimonial-author-name">', '</h4>' );
	$pos  = silicon_get_text( esc_html( $a['position'] ), '<h5 class="testimonial-author-position text-gray">', '</h5>' );

	// if user specify name OR position
	// wrap these elements to div.testimonial-author-info
	if ( ! empty( $name ) || ! empty( $pos ) ) {
		$info = '<div class="testimonial-author-info">' . $name . $pos . '</div>';
	} else {
		$info = '';
	}

	// in case of right alignment swap info and avatar block order
	if ( 'right' === $alignment ) {
		$author = '<div class="testimonial-author">' . $info . $ava . '</div>';
	} else {
		$author = '<div class="testimonial-author">' . $ava . $info . '</div>';
	}

	unset( $ava, $name, $pos, $info );
} else {
	$author = '';
}

$template = <<<'TPL'
<div {attr}>
    <span class="quote-mark background-{color}">
        <i class="si si-quote"></i>
    </span>

    {testimonial}
    {author}
</div>
TPL;

$r = array(
	'{attr}'        => $attr,
	'{color}'       => esc_attr( $a['color'] ),
	'{testimonial}' => silicon_get_text( $testimonial, '<p>', '</p>' ),
	'{author}'      => $author,
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
