<?php
/**
 * Inner Section | vc_row_inner
 *
 * @author 8guild
 */

return array(
	'name'                    => __( 'Inner Section', 'silicon' ),
	'description'             => __( 'Place content elements inside the inner row', 'silicon' ),
	'content_element'         => false,
	'is_container'            => true,
	'icon'                    => 'icon-wpb-row',
	'weight'                  => 1000,
	'show_settings_on_create' => false,
	'js_view'                 => 'VcRowView',
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name'  => 'id',
			'type'        => 'el_id',
			'weight'      => 10,
			'heading'     => __( 'Section ID', 'silicon' ),
			'description' => wp_kses(
				__(
					'Make sure Section ID is unique and valid according to
					<a href="http://www.w3schools.com/tags/att_global_id.asp" target="_blank">w3c specification</a>.
					This ID can be used for anchor navigation.',
					'silicon'
				),
				array( 'a' => array( 'href' => true, 'target' => true ) )
			),
		),
		array(
			'param_name' => 'css',
			'type'       => 'css_editor',
			'group'      => __( 'Design Options', 'silicon' ),
			'weight'     => 10,
			'heading'    => __( 'CSS', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);