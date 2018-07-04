<?php
/**
 * Google Maps | silicon_map
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Google Maps', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'location',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Location', 'silicon' ),
			'description' => __( 'Enter any search query, which you can find on Google Maps, e.g. "New York, USA".', 'silicon' ),
		),
		array(
			'param_name'       => 'height',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Map height', 'silicon' ),
			'description'      => __( 'Height of the map in pixels.', 'silicon' ),
			'value'            => 400,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name'       => 'zoom',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Zoom', 'silicon' ),
			'description'      => __( 'The initial Map zoom level', 'silicon' ),
			'value'            => 14,
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name'       => 'is_zoom',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Zoom Controls', 'silicon' ),
			'description'      => __( 'Enable or disable map controls like pan, zoom, etc.', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'disable',
			'value'            => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'       => 'is_scroll',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Scroll Wheel', 'silicon' ),
			'description'      => __( 'Enable or disable scroll wheel zooming on the map.', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'disable',
			'value'            => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'  => 'is_marker',
			'type'        => 'checkbox',
			'weight'      => 10,
			'description' => __( 'Enable or disable marker on the map.', 'silicon' ),
			'save_always' => true,
			'value'       => array(
				__( 'Add Marker', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'       => 'marker_title',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'Marker Title', 'silicon' ),
			'description'      => __( 'Optional title appears on marker hover.', 'silicon' ),
			'dependency'       => array( 'element' => 'is_marker', 'value' => 'enable' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name'       => 'marker',
			'type'             => 'attach_image',
			'weight'           => 10,
			'heading'          => __( 'Custom Marker', 'silicon' ),
			'dependency'       => array( 'element' => 'is_marker', 'value' => 'enable' ),
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'param_name'  => 'style',
			'type'        => 'textarea_raw_html',
			'weight'      => 10,
			'heading'     => __( 'Custom Styling', 'silicon' ),
			'description' => wp_kses( __( 'Generate your styles in <a href="https://snazzymaps.com/editor" target="_blank">Snazzymaps Editor</a> and paste JavaScript Style Array in field above', 'silicon' ), array(
				'a' => array( 'href' => true, 'target' => true ),
			) ),
		),
	), 'silicon_map' ),
);
