<?php
/**
 * Menu customization
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
 * Add custom fields into the menu items
 *
 * These fields allowed only for top-level menu items
 */
function silicon_menu_top_level_fields() {
	try {
		$layout = equip_create_menu_layout();
		$layout->add_field( 'is_mega_menu', 'select', array(
			'label'   => esc_html__( 'Display sub-menu items as Mega Menu?', 'silicon' ),
			'default' => 'disable',
			'options' => array(
				'enable'  => esc_html__( 'Yes', 'silicon' ),
				'disable' => esc_html__( 'No', 'silicon' ),
			),
		) );

		$layout->add_field( 'is_anchor', 'select', array(
			'label'   => esc_html__( 'Link to Anchor', 'silicon' ),
			'default' => 'disable',
			'options' => array(
				'enable'  => esc_html__( 'Enable', 'silicon' ),
				'disable' => esc_html__( 'Disable', 'silicon' ),
			)
		) );

		equip_add_menu( 'silicon_additions', $layout, array( 'exclude' => 'children' ) );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'equip/register', 'silicon_menu_top_level_fields' );
