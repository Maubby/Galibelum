<?php
/**
 * Hot Spots | silicon_hot_spots
 *
 * @author 8guild
 */

return array(
	'name'        => __( 'HotSpots', 'silicon' ),
	'description' => __( 'Image with hotspots', 'silicon' ),
	'category'    => __( 'Silicon', 'silicon' ),
	'icon'        => 'silicon-vc-icon',
	'params'      => silicon_vc_map_params( array(
		array(
			'param_name' => 'image',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Upload Image', 'silicon' ),
		),
		array(
			'param_name' => 'hotspots',
			'type'       => 'param_group',
			'weight'     => 10,
			'params'     => array(
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
					'param_name'       => 'alignment',
					'type'             => 'dropdown',
					'weight'           => 10,
					'heading'          => __( 'Tooltip Alignment', 'silicon' ),
					'value'            => array(
						__( 'Top', 'silicon' )    => 'top',
						__( 'Right', 'silicon' )  => 'right',
						__( 'Bottom', 'silicon' ) => 'bottom',
						__( 'Left', 'silicon' )   => 'left',
					),
				),
				array(
					'param_name'       => 'top',
					'type'             => 'textfield',
					'weight'           => 10,
					'heading'          => __( 'Position Top', 'silicon' ),
					'description'      => __( 'Any positive or negative number, %.', 'silicon' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'param_name'       => 'left',
					'type'             => 'textfield',
					'weight'           => 10,
					'heading'          => __( 'Position Left', 'silicon' ),
					'description'      => __( 'Any positive or negative number, %.', 'silicon' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
			),
		),
	), basename( __FILE__, '.php' ) ),
);
