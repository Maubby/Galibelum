<?php
/**
 * Contacts Card | silicon_contacts_card
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
	'country'          => '',
	'icon_color'       => 'white',
	'address_label'    => __( 'Find Us Here', 'silicon' ),
	'address'          => '',
	'address_link'     => '',
	'phone_label'      => __( 'Call Us', 'silicon' ),
	'phone'            => '',
	'phone_link'       => 'disable',
	'email_label'      => __( 'Write Us', 'silicon' ),
	'email'            => '',
	'email_link'       => 'disable',
	'type'             => 'image',
	'image'            => '',
	'map_location'     => '',
	'map_height'       => 200,
	'map_zoom'         => 14,
	'map_is_zoom'      => 'disable',
	'map_is_scroll'    => 'disable',
	'map_is_marker'    => 'disable',
	'map_marker_title' => '',
	'map_marker'       => '', // attachment ID
	'map_style'        => '', // custom base64 encoded styles
	'animation'        => '',
	'class'            => '',
), $shortcode ), $atts );

$color = esc_attr( $a['icon_color'] );
$items = array();

// Address
if ( ! empty( $a['address'] ) ) {
	$address = nl2br( strip_tags( stripslashes( trim( $a['address'] ) ) ) );

	if ( ! empty( $a['address_link'] ) ) {
		$address = sprintf( '<a href="%s" class="contact-info font-family-body">%s</a>',
			esc_url( $a['address_link'] ), $address
		);
	} else {
		$address = '<span class="contact-info font-family-body">' . $address . '</span>';
	}

	$r = array(
		'{color}'   => $color,
		'{label}'   => esc_html( $a['address_label'] ),
		'{address}' => $address,
	);

	$items[] = str_replace( array_keys( $r ), array_values( $r ), '
	<li>
		<i class="si si-location background-{color}"></i>
		<span class="contact-label">{label}</span>
		{address}
	</li>
	' );

	unset( $address, $r );
}

// Phone
if ( ! empty( $a['phone'] ) ) {
	$is_active = ( 'enable' === $a['phone_link'] );
	$phone     = array_map( function ( $phone ) use ( $is_active ) {
		$phone = esc_attr( trim( $phone ) );
		if ( $is_active ) {
			return sprintf( '<a href="tel:%1$s" class="contact-info font-family-body">%2$s</a>',
				preg_replace('/\s+/', '', $phone ), // phone without spaces
				$phone
			);
		}

		return '<span class="contact-info font-family-body">' . $phone . '</span>';
	}, explode( "\n", strip_tags( stripslashes( trim( $a['phone'] ) ) ) ) );

	$r = array(
		'{color}' => $color,
		'{label}' => esc_html( $a['phone_label'] ),
		'{phone}' => implode( '', $phone ),
	);

	$items[] = str_replace( array_keys( $r ), array_values( $r ), '
	<li>
		<i class="si si-phone background-{color}"></i>
		<span class="contact-label font-family-nav">{label}</span>
		{phone}
	</li>
	' );

	unset( $is_active, $phone, $r );
}

// Email
if ( ! empty( $a['email'] ) ) {
	$is_active = ( 'enable' === $a['email_link'] );
	$email     = array_map( function ( $mail ) use ( $is_active ) {
		$mail = esc_attr( trim( $mail ) );

		if ( $is_active ) {
			return sprintf( '<a href="mailto:%1$s" class="contact-info font-family-body">%1$s</a>', $mail );
		}

		return '<span class="contact-info font-family-body">' . $mail . '</span>';
	}, explode( "\n", strip_tags( stripslashes( trim( $a['email'] ) ) ) ) );

	$r = array(
		'{color}' => $color,
		'{label}' => esc_html( $a['email_label'] ),
		'{email}' => implode( '', $email ),
	);

	$items[] = str_replace( array_keys( $r ), array_values( $r ), '
	<li>
		<i class="si si-email-black background-{color}"></i>
		<span class="contact-label font-family-nav">{label}</span>
		{email}
	</li>
	' );

	unset( $is_active, $email, $r );
}

// Prepare map
$map = '';
if ( 'image' === $a['type'] ) {
	$map = wp_get_attachment_image( (int) $a['image'], 'full' );
} elseif ( 'map' === $a['type'] ) {
	$s = silicon_parse_array( $a, 'map_' );
	$m = silicon_shortcode_build( 'silicon_map', $s );

	$map = silicon_do_shortcode( $m );
	unset( $s, $m );
}

$template = <<<'TPL'
<div {attr}>
	{map}
	<section class="widget widget_silicon_contacts border-default">
		{country}
		{contacts}
	</section>
</div>
TPL;

$class = silicon_get_classes( array(
	'contacts-card',
	$a['class'],
) );

$attr = silicon_get_attr( array(
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
) );

$r = array(
	'{attr}'     => $attr,
	'{country}'  => silicon_get_text( esc_html( $a['country'] ), '<h4 class="contacts-card-title">', '</h4>' ),
	'{contacts}' => '<ul>' . implode( '', $items ) . '</ul>',
	'{map}'      => $map,
);

echo str_replace( array_keys( $r ), array_values( $r ), $template );
