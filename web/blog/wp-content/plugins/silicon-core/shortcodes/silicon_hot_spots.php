<?php
/**
 * Hot Spots | silicon_hot_spots
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
	'image'     => '',
	'hotspots'  => '', // param_group for list of hotspots
	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

$hotspots = json_decode( urldecode( $a['hotspots'] ), true );
if ( empty( $hotspots ) ) {
	return;
}

$output = '';
$list   = '';

$i = 1;
foreach ( $hotspots as $hotspot ) {
	$hotspot = wp_parse_args( $hotspot, array(
		'title'       => '',
		'description' => '',
		'alignment'   => 'top',
		'top'         => '',
		'left'        => '',
	) );


	$title       = esc_html( trim( $hotspot['title'] ) );
	$description = strip_tags( stripslashes( trim( $hotspot['description'] ) ) );
	$alignment   = 'align-' . $hotspot['alignment'];

	$top  = empty( $hotspot['top'] ) ? 0 : round( silicon_sanitize_float( $hotspot['top'] ), 2 ) . '%';
	$left = empty( $hotspot['left'] ) ? 0 : round( silicon_sanitize_float( $hotspot['left'] ), 2 ) . '%';

	$hotspot_attr = silicon_get_attr( array(
		'class' => 'hotspot font-family-headings',
		'style' => "top:{$top}; left:{$left};"
	) );

	$output .= sprintf(
		'<div %1$s>
			<span>%2$s</span>
			<div class="hotspot-tooltip border-default %5$s">
				<h5>%3$s</h5>
				<p class="font-family-body text-gray text-sm">%4$s</p>
			</div>
		</div>',
		$hotspot_attr, $i, $title, $description, $alignment
	);

	$list .= sprintf( '<dt class="h5">%1$s. %2$s</dt><dd class="text-gray border-default-bottom">%3$s</dd>',
		$i, $title, $description
	);

	$i++;
}

$class = esc_attr( silicon_get_classes( array(
	'hotspots-container',
	$a['class'],
) ) );

$attr = silicon_get_attr( array(
	'class'    => $class,
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

/* Output */

$template = <<<'TPL'
<div {attr}>
	{image}
	{output}
</div>
<dl class="hotspot-list padding-top-2x padding-bottom-2x visible-xs">
	{list}
</dl>
TPL;

$r = array(
	'{attr}'   => $attr,
	'{image}'  => wp_get_attachment_image( (int) $a['image'], 'full' ),
	'{output}' => $output,
	'{list}'   => $list,
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
