<?php
/**
 * Image Carousel | silicon_image_carousel
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Image Carousel', 'silicon' ),
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
			'param_name' => 'is_caption',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Captions', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'is_arrows',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Show Arrows', 'silicon' ),
			'group'      => __( 'Controls', 'silicon' ),
			'value'      => array(
				__( 'Show', 'silicon' ) => 'enable',
				__( 'Hide', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'is_dots',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Show Dots', 'silicon' ),
			'group'      => __( 'Controls', 'silicon' ),
			'value'      => array(
				__( 'Show', 'silicon' ) => 'enable',
				__( 'Hide', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'dots_skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Dots Skin', 'silicon' ),
			'group'      => __( 'Controls', 'silicon' ),
			'dependency' => array( 'element' => 'is_dots', 'value' => 'enable' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
		array(
			'param_name' => 'is_loop',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Loop', 'silicon' ),
			'group'      => __( 'Behavior', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'is_autoplay',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Autoplay', 'silicon' ),
			'group'      => __( 'Behavior', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'  => 'autoplay_speed',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Autoplay Speed', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Behavior', 'silicon' ),
			'dependency'  => array( 'element' => 'is_autoplay', 'value' => 'enable' ),
			'value'       => '3000',
		),
		array(
			'param_name'  => 'is_height',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Adaptive Height', 'silicon' ),
			'description' => __( 'Helpful for images with different height. Works only with 1 item on screen.', 'silicon' ),
			'group'       => __( 'Behavior', 'silicon' ),
			'std'         => 'disable',
			'value'       => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'  => 'desk_small',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Desktop', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => '1',
		),
		array(
			'param_name'  => 'tablet_land',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Tablet Landscape', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => '1',
		),
		array(
			'param_name'  => 'tablet_portrait',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Tablet Portrait', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => '1',
		),
		array(
			'param_name'  => 'mobile',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Mobile Phone', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => '1',
		),
		array(
			'param_name'  => 'margin',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Space Between Items', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);
