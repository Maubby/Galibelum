<?php
/**
 * Counter | silicon_counter
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
	'number'           => '',
	'title'            => '',
	// description is $content
	'type'             => 'simple',
	'alignment'        => 'left',
	'icon_library'     => 'silicon',
	'icon_silicon'     => 'si si-audio',
	'icon_socicon'     => '',
	'icon_material'    => '',
	'icon_fontawesome' => '',
	'icon_custom'      => '',
	'skin'             => 'dark',
	'animation'        => '',
	'class'            => '',
), $shortcode ), $atts );

$is_iconed = in_array( $a['type'], array( 'horizontal', 'vertical' ) );

/* Main content */

$number = absint( $a['number'] );
$title  = esc_html( trim( $a['title'] ) );
$desc   = nl2br( esc_html( strip_tags( stripslashes( trim( $content ) ) ) ) );

/* Icon */

if ( $is_iconed ) {
	$library = esc_attr( $a['icon_library'] );
	$icon    = sprintf( '<span class="%s"></span>', esc_attr( $a["icon_{$library}"] ) );
	unset( $library );
} else {
	$icon = '';
}

/* Attributes */

$class = silicon_get_classes( array(
	'counter',
	'counter-' . esc_attr( $a['type'] ),
	'counter-' . esc_attr( $a['skin'] ),
	$is_iconed ? 'counter-iconed' : '',
	'simple' === $a['type'] ? 'text-' . esc_attr( $a['alignment'] ) : '',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

/* Output */

$iconed = <<<'ICONED'
<div {attr}>
    <div class="counter-icon-box {border}">
        {digit}
        <div class="counter-icon">
            {icon}
        </div>
    </div>
    <div class="counter-body">
        {title}
        {desc}
    </div>
</div>
ICONED;

$simple = '<div {attr}>{digit}{title}{desc}</div>';

$r = array(
	'{attr}'   => $attr,
	'{border}' => 'light' === $a['skin'] ? 'border-default border-light' : 'border-default',
	'{digit}'  => silicon_get_text( $number, '<h4 class="counter-digit"><span>', '</span></h4>' ),
	'{icon}'   => $icon,
	'{title}'  => silicon_get_text( $title, '<h4 class="counter-title">', '</h4>' ),
	'{desc}'   => silicon_get_text( $desc, '<p class="counter-text">', '</p>' ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $is_iconed ? $iconed : $simple );
