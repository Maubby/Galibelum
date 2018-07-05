<?php
/**
 * Team Grid | silicon_team_grid
 *
 * @author 8guild
 */

return array(
	'name'                    => __( 'Team Grid', 'silicon' ),
	'category'                => __( 'Silicon', 'silicon' ),
	'icon'                    => 'silicon-vc-icon',
	'as_parent'               => array( 'only' => 'silicon_team_member_light' ),
	'content_element'         => true,
	'show_settings_on_create' => false,
	'is_container'            => true,
	'php_class_name'          => 'Silicon_Shortcode_Team_Grid',
	'js_view'                 => 'VcColumnView',
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
	), basename( __FILE__, '.php' ) ),
);