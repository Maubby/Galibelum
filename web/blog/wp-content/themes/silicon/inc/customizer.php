<?php
/**
 * Silicon Theme Customizer
 *
 * @author 8guild
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function silicon_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}

add_action( 'customize_register', 'silicon_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function silicon_customize_preview_js() {
	wp_enqueue_script( 'silicon-customizer', SILICON_TEMPLATE_URI . '/js/customizer.js', array( 'customize-preview' ), null, true );
}

add_action( 'customize_preview_init', 'silicon_customize_preview_js' );
