<?php
/**
 * Testimonial | silicon_testimonial
 *
 * @author 8guild
 */

return array(
	'name'            => __( 'Testimonial', 'silicon' ),
	'category'        => __( 'Silicon', 'silicon' ),
	'icon'            => 'silicon-vc-icon',
	'php_class_name'  => 'Silicon_Shortcode_Testimonial',
	'content_element' => true,
	'params'          => silicon_vc_map_params( array(
		array(
			'param_name' => 'content',
			'type'       => 'textarea',
			'weight'     => 10,
			'heading'    => __( 'Testimonial', 'silicon' ),
		),
		array(
			'param_name' => 'avatar',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Author Avatar', 'silicon' ),
		),
		array(
			'param_name'       => 'name',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Author Name', 'silicon' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name'       => 'position',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Author Position', 'silicon' ),
			'admin_label'      => true,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Alignment', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name' => 'color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Quotation Mark Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )     => 'dark',
				__( 'Primary', 'silicon' )  => 'primary',
				__( 'Success', 'silicon' )  => 'success',
				__( 'Info', 'silicon' )     => 'info',
				__( 'Warning', 'silicon' )  => 'warning',
				__( 'Danger', 'silicon' )   => 'danger',
				__( 'Gradient', 'silicon' ) => 'gradient',
				__( 'White', 'silicon' )    => 'white',
			),
		),
	), basename( __FILE__, '.php' ) ),
);