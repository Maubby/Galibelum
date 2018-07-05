<?php
/**
 * Icon | vc_icon
 *
 * @author 8guild
 */

return array(
	'name'        => __( 'Icon', 'silicon' ),
	'category'    => __( 'Content', 'silicon' ),
	'description' => __( 'Eye catching icons from libraries', 'silicon' ),
	'icon'        => 'icon-wpb-vc_icon',
	'js_view'     => 'VcIconElementView_Backend',
	'params'      => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Media Type', 'silicon' ),
			'std'        => 'icon',
			'value'      => array(
				__( 'Icon', 'silicon' )  => 'icon',
				__( 'Image', 'silicon' ) => 'image',
			)
		),
		array(
			'param_name' => 'image',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'image' ),
		),
		array(
			'param_name'  => 'image_size',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Size', 'silicon' ),
			'group'       => __( 'Design', 'silicon' ),
			'description' => __( 'Accepts only positive integer number, px.', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => 'image' ),
			'value'       => 60,
		),
		array(
			'param_name'  => 'icon_library',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Icon Library', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => 'icon' ),
			'save_always' => true,
			'value'       => array(
				__( 'Silicon Icons', 'silicon' )  => 'silicon',
				__( 'Social Icons', 'silicon' )   => 'socicon',
				__( 'Material Icons', 'silicon' ) => 'material',
				__( 'Font Awesome', 'silicon' )   => 'fontawesome',
				__( 'Custom', 'silicon' )         => 'custom',
			),
		),
		array(
			'param_name' => 'icon_silicon',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'settings'   => array( 'type' => 'silicon', 'iconsPerPage' => 100 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'silicon' ),
			'value'      => 'si si-audio',
		),
		array(
			'param_name' => 'icon_socicon',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'settings'   => array( 'type' => 'socicon', 'iconsPerPage' => 100 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'socicon' ),
		),
		array(
			'param_name' => 'icon_material',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'settings'   => array( 'type' => 'material', 'iconsPerPage' => 250 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'material' ),
		),
		array(
			'param_name' => 'icon_fontawesome',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'settings'   => array( 'type' => 'fontawesome', 'iconsPerPage' => 250 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'fontawesome' ),
		),
		array(
			'param_name'  => 'icon_custom',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Icon', 'silicon' ),
			'dependency'  => array( 'element' => 'icon_library', 'value' => 'custom' ),
			'description' => wp_kses(
				__(
					'Class should be written without leading dot. There are two options to add custom icons: <ol>
					<li>You can link your custom icon CSS file in Theme Options > Advanced</li>
					<li>You can manually enqueue custom icons CSS file in the Child Theme</li></ol>',
					'silicon'
				),
				array( 'ol' => true, 'li' => true )
			),
		),
		array(
			'param_name'  => 'icon_size',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Icon Size', 'silicon' ),
			'description' => __( 'Accepts only positive integer number, px.', 'silicon' ),
			'group'       => __( 'Design', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => 'icon' ),
			'value'       => 24
		),
		array(
			'param_name' => 'icon_color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Icon Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'icon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )    => 'dark',
				__( 'Primary', 'silicon' ) => 'primary',
				__( 'Success', 'silicon' ) => 'success',
				__( 'Info', 'silicon' )    => 'info',
				__( 'Warning', 'silicon' ) => 'warning',
				__( 'Danger', 'silicon' )  => 'danger',
				__( 'Gray', 'silicon' )    => 'gray',
				__( 'White', 'silicon' )   => 'white',
				__( 'Custom', 'silicon' )  => 'custom',
			),
		),
		array(
			'param_name' => 'icon_color_custom',
			'type'       => 'colorpicker',
			'weight'     => 10,
			'heading'    => __( 'Custom Icon Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'icon_color', 'value' => 'custom' ),
		),
		array(
			'param_name' => 'shape',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Shape', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'icon' ),
			'value'      => array(
				__( 'No', 'silicon' )      => 'no',
				__( 'Rounded', 'silicon' ) => 'rounded',
				__( 'Square', 'silicon' )  => 'square',
				__( 'Circle', 'silicon' )  => 'circle',
			),
		),
		array(
			'param_name' => 'shape_color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Shape Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'shape', 'value_not_equal_to' => 'no' ),
			'value'      => array(
				__( 'Gray', 'silicon' )     => 'gray',
				__( 'Dark', 'silicon' )     => 'dark',
				__( 'Primary', 'silicon' )  => 'primary',
				__( 'Success', 'silicon' )  => 'success',
				__( 'Info', 'silicon' )     => 'info',
				__( 'Warning', 'silicon' )  => 'warning',
				__( 'Danger', 'silicon' )   => 'danger',
				__( 'Custom', 'silicon' )   => 'custom',
			),
		),
		array(
			'param_name' => 'shape_color_custom',
			'type'       => 'colorpicker',
			'weight'     => 10,
			'heading'    => __( 'Custom Icon Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'shape_color', 'value' => 'custom' ),
		),
		array(
			'param_name'  => 'shape_size',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Shape Size', 'silicon' ),
			'description' => __( 'Accepts only positive integer number, px.', 'silicon' ),
			'group'       => __( 'Design', 'silicon' ),
			'dependency'  => array( 'element' => 'shape', 'value_not_equal_to' => 'no' ),
			'value'       => 48,
		),
		array(
			'param_name'  => 'shape_is_fill',
			'type'        => 'checkbox',
			'weight'      => 10,
			'group'       => __( 'Design', 'silicon' ),
			'save_always' => true,
			'std'         => 'disable',
			'value'       => array( __( 'Fill shape with color?', 'silicon' ) => 'enable' ),
			'dependency'  => array( 'element' => 'shape', 'value_not_equal_to' => 'no' ),
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Alignment', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
	), basename( __FILE__, '.php' ) ),
);