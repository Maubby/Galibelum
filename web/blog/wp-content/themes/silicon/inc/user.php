<?php
/**
 * User additions
 *
 * @author 8guild
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if Equip not installed
if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

/**
 * Add a custom user fields
 */
function silicon_user_additions() {
	try {
		$layout = equip_create_user_layout();

		$layout->add_field( 'avatar', 'media', array( 'label' => esc_html__( 'Avatar', 'silicon' ) ) );
		$layout->add_field( 'cover', 'media', array( 'label' => esc_html__( 'Cover Image', 'silicon' ) ) );
		$layout->add_field( 'position', 'text', array( 'label' => esc_html__( 'Position', 'silicon' ) ) );
		$layout->add_field( 'socials', 'socials', array( 'label' => esc_html__( 'Socials', 'silicon' ) ) );

		equip_add_user( 'silicon_additions', $layout );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'equip/register', 'silicon_user_additions' );