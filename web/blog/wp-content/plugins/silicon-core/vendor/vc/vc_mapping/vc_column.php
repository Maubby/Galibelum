<?php
/**
 * Column | vc_column
 *
 * @author 8guild
 */

return array(
	'name'            => __( 'Column', 'silicon' ),
	'description'     => __( 'Place content elements inside the column', 'silicon' ),
	'icon'            => 'icon-wpb-row',
	'is_container'    => true,
	'content_element' => false,
	'js_view'         => 'VcColumnView',
	'params'          => silicon_vc_map_params( array(
		array(
			'param_name'  => 'width',
			'type'        => 'dropdown',
			'weight'      => -50,
			'heading'     => __( 'Width', 'silicon' ),
			'description' => __( 'Select column width.', 'silicon' ),
			'group'       => __( 'Responsive Options', 'silicon' ),
			'std'         => '1/1',
			'value'       => array(
				__( '1 column - 1/12', 'silicon' )    => '1/12',
				__( '2 columns - 1/6', 'silicon' )    => '1/6',
				__( '3 columns - 1/4', 'silicon' )    => '1/4',
				__( '4 columns - 1/3', 'silicon' )    => '1/3',
				__( '5 columns - 5/12', 'silicon' )   => '5/12',
				__( '6 columns - 1/2', 'silicon' )    => '1/2',
				__( '7 columns - 7/12', 'silicon' )   => '7/12',
				__( '8 columns - 2/3', 'silicon' )    => '2/3',
				__( '9 columns - 3/4', 'silicon' )    => '3/4',
				__( '10 columns - 5/6', 'silicon' )   => '5/6',
				__( '11 columns - 11/12', 'silicon' ) => '11/12',
				__( '12 columns - 1/1', 'silicon' )   => '1/1',
			),
		),
		array(
			'param_name'  => 'offset',
			'type'        => 'column_offset',
			'weight'      => -50,
			'heading'     => __( 'Responsiveness', 'silicon' ),
			'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'silicon' ),
			'group'       => __( 'Responsive Options', 'silicon' ),
		),
		array(
			'param_name' => 'css',
			'type'       => 'css_editor',
			'weight'     => -50,
			'heading'    => __( 'CSS', 'silicon' ),
			'group'      => __( 'Design Options', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);
