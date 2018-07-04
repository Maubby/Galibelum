<?php
/**
 * Step | silicon_step
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Step', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'step',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Step Number', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'title',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Title', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name' => 'content',
			'type'       => 'textarea',
			'weight'     => 10,
			'heading'    => __( 'Description', 'silicon' ),
		),
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Simple', 'silicon' )     => 'simple',
				__( 'With Hover', 'silicon' ) => 'hover',
				__( 'With Image', 'silicon' ) => 'image',
			),
		),
		array(
			'param_name' => 'cover',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Cover Image', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'image' ),
		),
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
	), basename( __FILE__, '.php' ) ),
);