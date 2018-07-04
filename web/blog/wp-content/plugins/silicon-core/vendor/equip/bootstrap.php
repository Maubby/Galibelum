<?php
/**
 * Bootstrapping the Equip
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

/**
 * Remove the Equip scripts from Revolution Slider page
 *
 * Due to the conflicts
 *
 * @param WP_Screen $screen Current screen
 */
function silicon_equip_maybe_remove_scripts( $screen ) {
	$revslider_pages = array(
		'toplevel_page_revslider',
		'slider-revolution_page_revslider_navigation',
		'slider-revolution_page_rev_addon',
	);

	if ( in_array( $screen->id, $revslider_pages ) ) {
		remove_action( 'admin_enqueue_scripts', '_equip_admin_enqueue_scripts', 10 );
	}
}

if ( is_admin() ) {
	add_action( 'current_screen', 'silicon_equip_maybe_remove_scripts' );
}
