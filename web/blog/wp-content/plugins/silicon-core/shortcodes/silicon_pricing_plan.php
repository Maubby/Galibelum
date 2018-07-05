<?php
/**
 * Pricing Plan | silicon_pricing_plan
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
	'name'                => '',
	'currency'            => '',
	'price'               => '',
	'price_alt'           => '',
	'period'              => __( 'per month', 'silicon' ),
	'period_alt'          => __( 'per year', 'silicon' ),
	'color'               => 'primary',
	'is_featured'         => 'disable',

	// button
	'button_text'         => '',
	'button_link'         => '',
	'button_type'         => 'solid',
	'button_shape'        => 'pill',
	'button_color'        => 'default',
	'button_color_custom' => '', // hex
	'button_size'         => 'nl',
	'button_is_full'      => 'disable',
	'button_is_waves'     => 'disable',
	'button_waves_skin'   => 'light',
	'button_class'        => '',

	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

if ( empty( $a['price'] ) ) {
	return;
}

$features = strip_tags( stripslashes( trim( $content ) ) );
if ( ! empty( $features ) ) {
	// convert to list if divided by newline
	if ( false !== strpos( $features, "\n" ) ) {
		$features = array_filter( explode( "\n", $features ) );
		$features = implode( '</li><li>', $features );
		$features = '<ul class="pricing-info-list text-left text-gray"><li>' . $features . '</li></ul>';
	} else {
		$features = '<p class="pricing-info-list text-left text-gray">' . $features . '</p>';
	}
}

$button = '';
if ( ! empty( $a['button_text'] ) && ! empty( $a['button_link'] ) ) {
	$ba = silicon_parse_array( $a, 'button_' );
	$ba['alignment'] = 'center';

	$sh     = silicon_shortcode_build( 'silicon_button', $ba );
	$button = silicon_do_shortcode( $sh );
	unset( $sh, $ba );
}

$class = silicon_get_classes( array(
	'pricing',
	'border-default',
	'text-center',
	( 'enable' === $a['is_featured'] ) ? 'pricing-featured' : '',
	$a['class'],
) );

$template = <<<'TPL'
<div class="{class}" {animation}>
    <div class="pricing-header">
        <h4 class="pricing-title text-{color}">{name}</h4>
        <div class="pricing-price-container">
            <div class="pricing-price">
                <span class="pricing-currency text-{color}">{currency}</span>
                <div class="pricing-price-value font-family-headings text-{color}">{price}</div>
                <div class="pricing-price-period font-family-headings">{period}</div>
            </div>
            <div class="pricing-price hidden-value">
                <span class="pricing-currency text-{color}">{currency}</span>
                <div class="pricing-price-value font-family-headings text-{color}">{price-alt}</div>
                <div class="pricing-price-period font-family-headings">{period-alt}</div>
            </div>
        </div>
    </div>
    <div class="pricing-body">
        <div class="pricing-info text-center">
            {features}
        </div>
        {button}
    </div>
</div>
TPL;

$r = array(
	'{class}'      => esc_attr( $class ),
	'{animation}'  => empty( $a['animation'] ) ? '' : 'data-aos="' . esc_attr( $a['animation'] ) . '"',
	'{color}'      => esc_attr( $a['color'] ),
	'{name}'       => esc_html( trim( $a['name'] ) ),
	'{currency}'   => esc_html( trim( $a['currency'] ) ),
	'{price}'      => esc_html( $a['price'] ),
	'{period}'     => esc_html( trim( $a['period'] ) ),
	'{price-alt}'  => empty( $a['price_alt'] ) ? esc_html( $a['price'] ) : esc_html( $a['price_alt'] ),
	'{period-alt}' => empty( $a['period_alt'] ) ? esc_html( trim( $a['period'] ) ) : esc_html( $a['period_alt'] ),
	'{features}'   => $features,
	'{button}'     => $button,
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
