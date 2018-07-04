<?php
/**
 * Gallery | silicon_gallery
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Gallery', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'images',
			'type'       => 'attach_images',
			'weight'     => 10,
			'heading'    => __( 'Images', 'silicon' ),
		),
		array(
			'param_name'  => 'is_caption',
			'type'        => 'checkbox',
			'weight'      => 10,
			'std'         => 'enable',
			'save_always' => true,
			'value'       => array(
				__( 'Show caption in lightbox?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'       => 'grid_type',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Grid Type', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'value'            => array(
				__( 'Grid with Gap', 'silicon' ) => 'grid-with-gap',
				__( 'Grid no Gap', 'silicon' )   => 'grid-no-gap',
			),
		),
		array(
			'param_name'       => 'columns',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Grid Columns', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 3,
			'value'            => range( 1, 6 ),
		),
	), basename( __FILE__, '.php' ) ),
);
