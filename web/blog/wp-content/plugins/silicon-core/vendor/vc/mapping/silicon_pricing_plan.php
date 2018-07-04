<?php
/**
 * Pricing Plan | silicon_pricing_plan
 *
 * @author 8guild
 */

return array(
	'name'            => __( 'Pricing Plan', 'silicon' ),
	'category'        => __( 'Silicon', 'silicon' ),
	'icon'            => 'silicon-vc-icon',
	'php_class_name'  => 'Silicon_Shortcode_Pricing_Plan',
	'content_element' => true,
	'params'          => silicon_vc_map_params( array_merge(
		array(
			array(
				'param_name'  => 'name',
				'type'        => 'textfield',
				'weight'      => 10,
				'heading'     => __( 'Pricing Name', 'silicon' ),
				'admin_label' => true,
			),
			array(
				'param_name'  => 'currency',
				'type'        => 'textfield',
				'weight'      => 10,
				'heading'     => __( 'Currency', 'silicon' ),
			),
			array(
				'param_name'       => 'price',
				'type'             => 'textfield',
				'weight'           => 10,
				'heading'          => __( 'Price 1', 'silicon' ),
				'description'      => __( 'Represents the price for one period, i.e. Month', 'silicon' ),
				'edit_field_class' => 'vc_col-md-6',
				'admin_label'      => true,
			),
			array(
				'param_name'       => 'price_alt',
				'type'             => 'textfield',
				'weight'           => 10,
				'heading'          => __( 'Price 2', 'silicon' ),
				'description'      => __( 'Represents the price for another period, i.e. Year', 'silicon' ),
				'edit_field_class' => 'vc_col-md-6',
			),
			array(
				'param_name'       => 'period',
				'type'             => 'textfield',
				'weight'           => 10,
				'heading'          => __( 'Period 1', 'silicon' ),
				'edit_field_class' => 'vc_col-md-6',
				'value'            => __( 'per month', 'silicon' ),
			),
			array(
				'param_name'       => 'period_alt',
				'type'             => 'textfield',
				'weight'           => 10,
				'heading'          => __( 'Period 2', 'silicon' ),
				'description'      => __( 'Works only inside Pricings shortcode and when period switch is enabled.', 'silicon' ),
				'edit_field_class' => 'vc_col-md-6',
				'value'            => __( 'per year', 'silicon' ),
			),
			array(
				'param_name'  => 'content',
				'type'        => 'textarea',
				'weight'      => 10,
				'heading'     => __( 'Features', 'silicon' ),
				'description' => __( 'NOTE: items separated by newline will be converted to list.', 'silicon' ),
			),
			array(
				'param_name'  => 'color',
				'type'        => 'dropdown',
				'weight'      => 10,
				'heading'     => __( 'Pricing Skin', 'silicon' ),
				'description' => __( 'Applies to Pricing name, Currency and Price', 'silicon' ),
				'group'       => __( 'Design', 'silicon' ),
				'value'       => array(
					__( 'Primary', 'silicon' ) => 'primary',
					__( 'Success', 'silicon' ) => 'success',
					__( 'Info', 'silicon' )    => 'info',
					__( 'Warning', 'silicon' ) => 'warning',
					__( 'Danger', 'silicon' )  => 'danger',
					__( 'Dark', 'silicon' )    => 'dark',
				),
			),
			array(
				'param_name'  => 'is_featured',
				'type'        => 'checkbox',
				'weight'      => 10,
				'group'       => __( 'Design', 'silicon' ),
				'save_always' => true,
				'std'         => 'disable',
				'value'       => array(
					__( 'Make featured?', 'silicon' ) => 'enable',
				),
			),
		),
		(array) vc_map_integrate_shortcode( 'silicon_button', 'button_', __( 'Button', 'silicon' ),
			array( 'exclude_regex' => '/animation|icon|alignment/' )
		)
	), basename( __FILE__, '.php' ) ),
);
