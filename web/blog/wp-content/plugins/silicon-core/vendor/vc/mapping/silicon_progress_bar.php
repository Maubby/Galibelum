<?php
/**
 * Progress Bar | silicon_progress_bar
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Progress Bar', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'value',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Progress Value', 'silicon' ),
			'description' => __( 'Accept positive integer number from 1 to 100%', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'label',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Label', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'is_units',
			'type'        => 'checkbox',
			'weight'      => 10,
			'std'         => 'enable',
			'save_always' => true,
			'value'       => array(
				__( 'Show units?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'  => 'is_icon',
			'type'        => 'checkbox',
			'weight'      => 10,
			'std'         => 'disable',
			'save_always' => true,
			'value'       => array(
				__( 'Add icon?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'  => 'icon_library',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Icon Library', 'silicon' ),
			'dependency'  => array( 'element' => 'is_icon', 'value' => 'enable' ),
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
			'description' => wp_kses( __( 'Class should be written without leading dot. There are two options to add custom icons: <ol><li>You can link your custom icon CSS file in Theme Options > Advanced</li><li>You can manually enqueue custom icons CSS file in the Child Theme</li></ol>', 'silicon' ), array(
				'ol' => true,
				'li' => true,
			) ),
		),
		array(
			'param_name' => 'color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )     => 'dark',
				__( 'Primary', 'silicon' )  => 'primary',
				__( 'Success', 'silicon' )  => 'success',
				__( 'Info', 'silicon' )     => 'info',
				__( 'Warning', 'silicon' )  => 'warning',
				__( 'Danger', 'silicon' )   => 'danger',
				__( 'White', 'silicon' )    => 'white',
				__( 'Gradient', 'silicon' ) => 'gradient',
				__( 'Custom', 'silicon' )   => 'custom',
			),
		),
		array(
			'param_name' => 'color_custom',
			'type'       => 'colorpicker',
			'weight'     => 10,
			'heading'    => __( 'Custom Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'color', 'value' => 'custom' ),
		),
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
		array(
			'param_name'  => 'is_animation',
			'type'        => 'checkbox',
			'weight'      => 10,
			'group'       => __( 'Design', 'silicon' ),
			'std'         => 'disable',
			'save_always' => true,
			'value'       => array(
				__( 'Animate progress bar?', 'silicon' ) => 'enable',
			),
		),
	), basename( __FILE__, '.php' ) ),
);
