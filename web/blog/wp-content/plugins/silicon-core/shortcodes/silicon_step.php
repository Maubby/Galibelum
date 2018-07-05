<?php
/**
 * Step | silicon_step
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
	'step'      => '',
	'title'     => '',
	// descriptions is $content
	'type'      => 'simple',
	'cover'     => 0,
	'skin'      => 'dark',
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

$title = esc_html( trim( $a['title'] ) );
$desc  = nl2br( esc_html( strip_tags( stripslashes( trim( $content ) ) ) ) );

/* Background */
if ( 'image' === $a['type'] && ! empty( $a['cover'] ) ) {
	$bg = sprintf( '<div class="step-bg-image" style="background-image: url(%s);"></div>',
		esc_url( silicon_get_image_src( (int) $a['cover'] ) )
	);
} else {
	$bg = '';
}

/* Attributes for div.step element */

$class = silicon_get_classes( array(
	'step',
	'step-' . esc_attr( $a['type'] ),
	'step-' . esc_attr( $a['skin'] ),
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

/* Output */

$template = <<<'TPL'
<div {attr}>
    {bg}
    {step}
    
    <div class="step-body">
        {title}
        {desc}
    </div>
</div>
TPL;

$r = array(
	'{attr}'  => $attr,
	'{bg}'    => $bg,
	'{step}'  => silicon_get_text( esc_html( $a['step'] ), '<h3 class="step-digit">', '</h3>' ),
	'{title}' => silicon_get_text( $title, '<h3 class="step-title">', '</h3>' ),
	'{desc}'  => silicon_get_text( $desc, '<p class="step-text">', '</p>' ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
