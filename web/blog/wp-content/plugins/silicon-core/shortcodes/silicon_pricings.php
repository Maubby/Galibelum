<?php
/**
 * Pricings | silicon_pricings
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
	'is_switch'       => 'enable',
	'label'           => __( 'Monthly', 'silicon' ),
	'label_alt'       => __( 'Annually', 'silicon' ),
	'description'     => '',
	'description_alt' => __( 'Save 20%', 'silicon' ),
	'skin'            => 'dark',
	'color'           => 'primary',
	'alignment'       => 'left',
	'animation'       => '',
	'class'           => '',
), $shortcode ), $atts );

$switch = '';
if ( 'enable' === $a['is_switch'] ) {
	$template = '
    <div class="pricing-toggle font-family-nav text-{skin}">
        <span class="pricing-label on">{label}</span>
        <div class="btn-toggle">
            <span class="btn-toggle-bg background-{color}"></span>
            <span class="togler background-{color}"></span>
        </div>
        <span class="pricing-label">{label-alt}</span>
    </div>
    ';

	$label = esc_html( trim( $a['label'] ) );
	if ( ! empty( $a['description'] ) ) {
		$label .= '<small> ' . esc_html( trim( $a['description'] ) ) . '</small>';
	}

	$label_alt = esc_html( trim( $a['label_alt'] ) );
	if ( ! empty( $a['description_alt'] ) ) {
		$label_alt .= '<small> ' . esc_html( trim( $a['description_alt'] ) ) . '</small>';
	}

	$r = array(
		'{skin}'      => esc_attr( $a['skin'] ),
		'{label}'     => $label,
		'{label-alt}' => $label_alt,
		'{color}'     => ( 'white' === $a['skin'] ) ? 'white' : esc_attr( $a['color'] ),
	);

	$switch = str_replace( array_keys( $r ), array_values( $r ), $template );
	unset( $template, $label, $label_alt, $r );
}

$class = silicon_get_classes( array(
	'pricings-container',
	'text-' . esc_attr( $a['alignment'] ),
    $a['class'],
) );

$template = <<<'TPL'
<div class="{class}" {animation}>
    {switch}
    <div class="pricing-container-inner">
        {content}
    </div>
</div>
TPL;

$r = array(
	'{class}'     => esc_attr( $class ),
	'{animation}' => empty( $a['animation'] ) ? '' : 'data-aos="' . esc_attr( $a['animation'] ) . '"',
	'{switch}'    => $switch,
	'{content}'   => silicon_do_shortcode( $content ),
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
