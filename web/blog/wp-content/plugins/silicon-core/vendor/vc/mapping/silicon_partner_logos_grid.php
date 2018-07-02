<?php
/**
 * Partner Logos Grid | silicon_partner_logos_grid
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Partner Logos Grid', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'content',
			'type'       => 'param_group',
			'weight'     => 10,
			'params'     => array(
				array(
					'param_name'  => 'image',
					'type'        => 'attach_image',
					'weight'      => 10,
					'heading'     => __( 'Upload Image *', 'silicon' ),
					'description' => __( 'For optimal display recommended image size 200х200px', 'silicon' ),
				),
				array(
					'param_name'  => 'title',
					'type'        => 'textfield',
					'weight'      => 10,
					'heading'     => __( 'Title', 'silicon' ),
					'admin_label' => true,
				),
				array(
					'param_name'  => 'description',
					'type'        => 'textarea',
					'weight'      => 10,
					'heading'     => __( 'Description', 'silicon' ),
					'description' => __( 'HTML is not allowed here.', 'silicon' ),
				),
				array(
					'param_name'  => 'link',
					'type'        => 'textfield',
					'weight'      => 10,
					'heading'     => __( 'Link', 'silicon' ),
					'description' => __( 'NOTE: Link is optional.', 'silicon' ),
				),
			),
		),
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