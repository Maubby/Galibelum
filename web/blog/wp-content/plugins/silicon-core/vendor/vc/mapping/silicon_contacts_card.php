<?php
/**
 * Contacts Card | silicon_contacts_card
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Contacts Card', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array_merge(
		array(
			array(
				'param_name'  => 'country',
				'type'        => 'textfield',
				'weight'      => 10,
				'heading'     => __( 'City / Country', 'silicon' ),
				'admin_label' => true,
			),
			array(
				'param_name' => 'icon_color',
				'type'       => 'dropdown',
				'weight'     => 10,
				'heading'    => __( 'Contacts Icon Color', 'silicon' ),
				'std'        => 'white',
				'value'      => array(
					__( 'White', 'silicon' )    => 'white',
					__( 'Dark', 'silicon' )     => 'dark',
					__( 'Primary', 'silicon' )  => 'primary',
					__( 'Info', 'silicon' )     => 'info',
					__( 'Success', 'silicon' )  => 'success',
					__( 'Warning', 'silicon' )  => 'warning',
					__( 'Danger', 'silicon' )   => 'danger',
					__( 'Gradient', 'silicon' ) => 'gradient',
				),
			),
			array(
				'param_name' => 'address_label',
				'type'       => 'textfield',
				'weight'     => 10,
				'heading'    => __( 'Label', 'silicon' ),
				'group'      => __( 'Address', 'silicon' ),
				'value'      => __( 'Find Us Here', 'silicon' ),
			),
			array(
				'param_name'  => 'address',
				'type'        => 'textarea',
				'weight'      => 10,
				'heading'     => __( 'Address', 'silicon' ),
				'description' => __( 'This field supports only one address.', 'silicon' ),
				'group'       => __( 'Address', 'silicon' ),
			),
			array(
				'param_name' => 'address_link',
				'type'       => 'textfield',
				'weight'     => 10,
				'heading'    => __( 'Address Link', 'silicon' ),
				'group'      => __( 'Address', 'silicon' ),
			),
			array(
				'param_name' => 'phone_label',
				'type'       => 'textfield',
				'weight'     => 10,
				'heading'    => __( 'Label', 'silicon' ),
				'group'      => __( 'Phone', 'silicon' ),
				'value'      => __( 'Call Us', 'silicon' ),
			),
			array(
				'param_name'  => 'phone',
				'type'        => 'textarea',
				'weight'      => 10,
				'heading'     => __( 'Phone', 'silicon' ),
				'description' => __( 'You can add as many phone numbers as you wish, every item on new line.', 'silicon' ),
				'group'       => __( 'Phone', 'silicon' ),
			),
			array(
				'param_name'  => 'phone_link',
				'type'        => 'checkbox',
				'weight'      => 10,
				'group'       => __( 'Phone', 'silicon' ),
				'save_always' => true,
				'std'         => 'disable',
				'value'       => array(
					__( 'Make clickable?', 'silicon' ) => 'enable',
				),
			),
			array(
				'param_name' => 'email_label',
				'type'       => 'textfield',
				'weight'     => 10,
				'heading'    => __( 'Label', 'silicon' ),
				'group'      => __( 'Email', 'silicon' ),
				'value'      => __( 'Write Us', 'silicon' ),
			),
			array(
				'param_name'  => 'email',
				'type'        => 'textarea',
				'weight'      => 10,
				'heading'     => __( 'Email', 'silicon' ),
				'description' => __( 'You can add as many email addresses as you wish, every item on new line.', 'silicon' ),
				'group'       => __( 'Email', 'silicon' ),
			),
			array(
				'param_name'  => 'email_link',
				'type'        => 'checkbox',
				'weight'      => 10,
				'group'       => __( 'Email', 'silicon' ),
				'save_always' => true,
				'std'         => 'disable',
				'value'       => array(
					__( 'Make clickable?', 'silicon' ) => 'enable',
				),
			),
			array(
				'param_name' => 'type',
				'type'       => 'dropdown',
				'weight'     => 10,
				'heading'    => __( 'Choose Media Type', 'silicon' ),
				'std'        => 'image',
				'value'      => array(
					__( 'Image', 'silicon' )       => 'image',
					__( 'Google Maps', 'silicon' ) => 'map',
				),
			),
			array(
				'param_name' => 'image',
				'type'       => 'attach_image',
				'weight'     => 10,
				'heading'    => __( 'Upload Image', 'silicon' ),
				'dependency' => array( 'element' => 'type', 'value' => 'image' )
			),
		),
		(array) vc_map_integrate_shortcode( 'silicon_map', 'map_', '',
			array( 'exclude_regex' => '/animation|class/' ),
			array( 'element' => 'type', 'value' => 'map' )
		)
	), basename( __FILE__, '.php' ) ),
);