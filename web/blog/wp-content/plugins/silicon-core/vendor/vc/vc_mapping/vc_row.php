<?php
/**
 * Section | vc_row
 *
 * @author 8guild
 */

return array(
	'name'                    => __( 'Section', 'silicon' ),
	'category'                => __( 'Content', 'silicon' ),
	'description'             => __( 'Group content elements inside section', 'silicon' ),
	'is_container'            => true,
	'icon'                    => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'class'                   => 'vc_main-sortable-element',
	'js_view'                 => 'VcRowView',
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name'  => 'id',
			'type'        => 'el_id',
			'weight'      => 11,
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
			'param_name'  => 'offset_top',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Offset Top', 'silicon' ),
			'description' => __( 'In case you use anchor navigation and link to this row id. You can control how far it will occur from the top of the page when scrolled to it. This field accepts any positive / negative integer number.', 'silicon' ),
			'value'       => 180,
		),
		array(
			'param_name'       => 'layout',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Content Layout', 'silicon' ),
			'description'      => __( 'Choose the layout type. Note: Equal Height version use flexbox model and works only in modern browsers.', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'value'            => array(
				__( 'Boxed', 'silicon' )                   => 'boxed',
				__( 'Full Width', 'silicon' )              => 'full',
				__( 'Boxed Equal Height', 'silicon' )      => 'boxed-equal',
				__( 'Full Width Equal Height', 'silicon' ) => 'full-equal',
			),
		),
		array(
			'param_name'       => 'is_no_gap',
			'type'             => 'checkbox',
			'weight'           => 10,
			'heading'          => __( 'Remove Gaps?', 'silicon' ),
			'description'      => __( 'If enabled there will be no side paddings inside columns.', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'value'            => array( __( 'Yes', 'silicon' ) => 'enable' ),
		),
		array(
			'param_name' => 'is_overlay',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Overlay', 'silicon' ),
			'group'      => __( 'Overlay', 'silicon' ),
			'value'      => array(
				__( 'Disable', 'silicon' ) => 'disable',
				__( 'Enable', 'silicon' )  => 'enable',
			),
		),
		array(
			'param_name' => 'overlay_type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'group'      => __( 'Overlay', 'silicon' ),
			'dependency' => array( 'element' => 'is_overlay', 'value' => 'enable' ),
			'value'      => array(
				__( 'Solid Color', 'silicon' )    => 'color',
				__( 'Gradient Color', 'silicon' ) => 'gradient',
			),
		),
		array(
			'param_name' => 'overlay_color',
			'type'       => 'colorpicker',
			'weight'     => 10,
			'group'      => __( 'Overlay', 'silicon' ),
			'heading'    => __( 'Color', 'silicon' ),
			'dependency' => array( 'element' => 'overlay_type', 'value' => 'color' ),
			'value'      => '#000000',
		),
		array(
			'param_name'  => 'overlay_opacity',
			'type'        => 'textfield',
			'weight'      => 10,
			'group'       => __( 'Overlay', 'silicon' ),
			'heading'     => __( 'Opacity', 'silicon' ),
			'description' => __( 'Enter value from 0 to 100%. Where 0 is fully transparent', 'silicon' ),
			'dependency'  => array( 'element' => 'is_overlay', 'value' => 'enable' ),
			'value'       => 60,
		),
		array(
			'param_name' => 'is_parallax',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Parallax', 'silicon' ),
			'group'      => __( 'Parallax', 'silicon' ),
			'value'      => array(
				__( 'Disable', 'silicon' ) => 'disable',
				__( 'Enable', 'silicon' )  => 'enable',
			),
		),
		array(
			'param_name'  => 'parallax_bg',
			'type'        => 'attach_image',
			'weight'      => 10,
			'heading'     => __( 'Background', 'silicon' ),
			'description' => __( 'Choose Background Image for parallax here. Please do not use Design options Background Image control in order for parallax to work properly. Also this is a fallback if you use the Video Background.', 'silicon' ),
			'group'       => __( 'Parallax', 'silicon' ),
			'dependency'  => array( 'element' => 'is_parallax', 'value' => 'enable' ),
		),
		array(
			'param_name'  => 'parallax_video',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Video Background', 'silicon' ),
			'description' => __( 'You can provide a link to YouTube or Vimeo to play video on background.', 'silicon' ),
			'group'       => __( 'Parallax', 'silicon' ),
			'dependency'  => array( 'element' => 'is_parallax', 'value' => 'enable' ),
		),
		array(
			'param_name'  => 'parallax_type',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Type', 'silicon' ),
			'description' => __( 'Choose the Type of the parallax effect applied to the Background.', 'silicon' ),
			'group'       => __( 'Parallax', 'silicon' ),
			'dependency'  => array( 'element' => 'is_parallax', 'value' => 'enable' ),
			'value'       => array(
				__( 'Scroll', 'silicon' )           => 'scroll',
				__( 'Scale', 'silicon' )            => 'scale',
				__( 'Opacity', 'silicon' )          => 'opacity',
				__( 'Scroll + Opacity', 'silicon' ) => 'scroll-opacity',
				__( 'Scale + Opacity', 'silicon' )  => 'scale-opacity',
			),
		),
		array(
			'param_name'  => 'parallax_speed',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Speed', 'silicon' ),
			'description' => __( 'Parallax effect speed. Provide numbers from -1.0 to 1.0', 'silicon' ),
			'group'       => __( 'Parallax', 'silicon' ),
			'dependency'  => array( 'element' => 'is_parallax', 'value' => 'enable' ),
			'value'       => '0.4',
		),
		array(
			'param_name' => 'css',
			'type'       => 'css_editor',
			'weight'     => 10,
			'heading'    => __( 'CSS', 'silicon' ),
			'group'      => __( 'Design Options', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);
