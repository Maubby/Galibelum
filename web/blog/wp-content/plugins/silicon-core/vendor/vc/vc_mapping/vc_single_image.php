<?php
/**
 * Single Image | vc_single_image
 *
 * @author 8guild
 */

return array(
	'name'        => __( 'Single Image', 'silicon' ),
	'category'    => __( 'Content', 'silicon' ),
	'description' => __( 'Simple image with CSS animation', 'silicon' ),
	'base'        => 'vc_single_image',
	'icon'        => 'icon-wpb-single-image',
	'params'      => silicon_vc_map_params( array(
		array(
			'param_name' => 'source',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Image Source', 'silicon' ),
			'value'      => array(
				__( 'Media Library', 'silicon' ) => 'media',
				__( 'External Link', 'silicon' ) => 'external',
			),
		),
		array(
			'param_name'  => 'image',
			'type'        => 'attach_image',
			'weight'      => 10,
			'heading'     => __( 'Image', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'media' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'size_media',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Size', 'silicon' ),
			'description' => __( 'Enter image size "thumbnail", "medium", "large", "full" or other sizes defined by theme. Alternatively enter size in pixels. For example: 200x100 (Width x Height).', 'silicon' ),
			'value'       => 'full',
			'dependency'  => array( 'element' => 'source', 'value' => 'media' ),
		),
		array(
			'param_name'  => 'is_caption',
			'type'        => 'checkbox',
			'weight'      => 10,
			'heading'     => __( 'Add caption?', 'silicon' ),
			'description' => __( 'Caption from the Media Library will be used.', 'silicon' ),
			'value'       => array( __( 'Yes', 'silicon' ) => 'enable' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'media' ),
		),
		array(
			'param_name'  => 'external_src',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'External link', 'silicon' ),
			'description' => __( 'Enter the external link.', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'external' ),
		),
		array(
			'param_name'  => 'size_external',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Image size', 'silicon' ),
			'description' => __( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'external' ),
		),
		array(
			'param_name'  => 'caption',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Caption', 'silicon' ),
			'description' => __( 'Enter text for image caption.', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'external' ),
		),
		array(
			'param_name' => 'shape',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Shape', 'silicon' ),
			'value'      => array(
				__( 'Default', 'silicon' ) => 'default',
				__( 'Circle', 'silicon' )  => 'circle',
				__( 'Rounded', 'silicon' ) => 'rounded',
			),
		),
		array(
			'param_name'  => 'link',
			'type'        => 'href',
			'weight'      => 10,
			'heading'     => __( 'Link', 'silicon' ),
			'description' => __( 'Enter URL if you want this image to have a link. Note: parameters like "mailto:" are also accepted.', 'silicon' ),
		),
//		array(
//			'param_name'  => 'motion', // TODO: maybe delete this option?
//			'type'        => 'dropdown',
//			'weight'      => 10,
//			'heading'     => __( 'Motion', 'silicon' ),
//			'description' => __( 'Add fancy loop animation to the image to make it stand out.', 'silicon' ),
//			'value'       => array(
//				__( 'None', 'silicon' )              => '',
//				__( 'Pulse', 'silicon' )             => 'pulse',
//				__( 'Zoom In Out', 'silicon' )       => 'zoomInOut',
//				__( 'Horizontal Motion', 'silicon' ) => 'hMotion',
//				__( 'Vertical Motion', 'silicon' )   => 'vMotion',
//			),
//		),
	), basename( __FILE__, '.php' ) ),
);