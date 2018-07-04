<?php
/**
 * Bootstrapping the Equip
 *
 * @author 8guild
 */

/**
 * Register the icons sources in Equip
 *
 * @param array $source
 *
 * @return array
 */
function silicon_equip_icon_source( $source ) {
	return array_merge( (array) $source, array(
		'silicon'     => esc_html__( 'Silicon Icons', 'silicon' ),
		'socicon'     => esc_html__( 'Social Icons', 'silicon' ),
		'material'    => esc_html__( 'Material Icons', 'silicon' ),
		'fontawesome' => esc_html__( 'Font Awesome', 'silicon' ),
	) );
}

// TODO: change equip filter names for icons

add_filter( 'equip/icon/source', 'silicon_equip_icon_source' );
add_filter( 'equip/icons/silicon', 'silicon_get_si_icons' );
add_filter( 'equip/icons/socicon', 'silicon_get_social_icons' );
add_filter( 'equip/icons/material', 'silicon_get_material_icons' );
add_filter( 'equip/icons/fontawesome', 'silicon_get_fa_icons' );
