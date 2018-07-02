<?php
/**
 * Pricings | silicon_pricings
 *
 * @author 8guild
 */

return array(
	'name'                    => __( 'Pricings', 'silicon' ),
	'category'                => __( 'Silicon', 'silicon' ),
	'description'             => __( 'Container for Pricing Plan', 'silicon' ),
	'icon'                    => 'silicon-vc-icon',
	'as_parent'               => array( 'only' => 'silicon_pricing_plan' ),
	'content_element'         => true,
	'show_settings_on_create' => false,
	'is_container'            => true,
	'php_class_name'          => 'Silicon_Shortcode_Pricings',
	'js_view'                 => 'VcColumnView',
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name' => 'is_switch',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Period Switch', 'silicon' ),
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'       => 'label',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Label Period 1', 'silicon' ),
			'edit_field_class' => 'vc_col-md-6',
			'value'            => __( 'Monthly', 'silicon' ),
			'dependency'       => array( 'element' => 'is_switch', 'value' => 'enable' ),
		),
		array(
			'param_name'       => 'label_alt',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Label Period 1', 'silicon' ),
			'edit_field_class' => 'vc_col-md-6',
			'value'            => __( 'Annually', 'silicon' ),
			'dependency'       => array( 'element' => 'is_switch', 'value' => 'enable' ),
		),
		array(
			'param_name'       => 'description',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Label Description', 'silicon' ),
			'edit_field_class' => 'vc_col-md-6',
			'dependency'       => array( 'element' => 'is_switch', 'value' => 'enable' ),
		),
		array(
			'param_name'       => 'description_alt',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Label Description', 'silicon' ),
			'edit_field_class' => 'vc_col-md-6',
			'value'            => __( 'Save 20%', 'silicon' ),
			'dependency'       => array( 'element' => 'is_switch', 'value' => 'enable' ),
		),
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Switch Skin', 'silicon' ),
			'dependency' => array( 'element' => 'is_switch', 'value' => 'enable' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'white',
			),
		),
		array(
			'param_name' => 'color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Switch Color', 'silicon' ),
			'dependency' => array( 'element' => 'skin', 'value' => 'dark' ),
			'value'      => array(
				__( 'Primary', 'silicon' ) => 'primary',
				__( 'Success', 'silicon' ) => 'success',
				__( 'Info', 'silicon' )    => 'info',
				__( 'Warning', 'silicon' ) => 'warning',
				__( 'Danger', 'silicon' )  => 'danger',
				__( 'Dark', 'silicon' )    => 'dark',
			),
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Switch Alignment', 'silicon' ),
			'dependency' => array( 'element' => 'is_switch', 'value' => 'enable' ),
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
	), basename( __FILE__, '.php' ) )
);
