<?php
/**
 * Init the TGM
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the required plugins for current theme.
 *
 * @uses tgmpa()
 */
function silicon_tgm_init() {
	$dir = wp_normalize_path( SILICON_TEMPLATE_DIR . '/plugins' );

	$plugins = array(
		array(
			'name'     => esc_html__( 'Silicon Core', 'silicon' ),
			'slug'     => 'silicon-core',
			'source'   => $dir . '/silicon-core.zip',
			'version'  => '1.2.0',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Visual Composer', 'silicon' ),
			'slug'     => 'js_composer',
			'source'   => $dir . '/js_composer.zip',
			'version'  => '5.2',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Equip', 'silicon' ),
			'slug'     => 'equip',
			'source'   => $dir . '/equip.zip',
			'version'  => '0.7.19',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Importer by 8Guild', 'silicon' ),
			'slug'     => 'guild-importer',
			'source'   => $dir . '/guild-importer.zip',
			'version'  => '0.1.0',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Revolution Slider', 'silicon' ),
			'slug'     => 'revslider',
			'source'   => $dir . '/revslider.zip',
			'version'  => '5.4.3.1',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'WooCommerce', 'silicon' ),
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Contact Form 7', 'silicon' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Breadcrumb NavXT', 'silicon' ),
			'slug'     => 'breadcrumb-navxt',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'silicon',
		'menu'         => 'silicon-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => true,
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'silicon_tgm_init' );
