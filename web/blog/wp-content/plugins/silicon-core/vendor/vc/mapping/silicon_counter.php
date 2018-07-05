<?php
/**
 * Counter | silicon_counter
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Counter', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'number',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Number', 'silicon' ),
			'description' => __( 'Any positive integer number.', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'title',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Title', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name' => 'content',
			'type'       => 'textarea',
			'weight'     => 10,
			'heading'    => __( 'Description', 'silicon' ),
		),
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Simple', 'silicon' )            => 'simple',
				__( 'Circle Horizontal', 'silicon' ) => 'horizontal',
				__( 'Circle Vertical', 'silicon' )   => 'vertical',
			),
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Alignment', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'simple' ),
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name'  => 'icon_library',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Icon Library', 'silicon' ),
			'group'       => __( 'Design', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => array( 'horizontal', 'vertical' ) ),
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
			'group'      => __( 'Design', 'silicon' ),
			'std'        => 'si si-audio',
			'settings'   => array( 'type' => 'silicon', 'iconsPerPage' => 100 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'silicon' ),
		),
		array(
			'param_name' => 'icon_socicon',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'settings'   => array( 'type' => 'socicon', 'iconsPerPage' => 100 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'socicon' ),
		),
		array(
			'param_name' => 'icon_material',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'settings'   => array( 'type' => 'material', 'iconsPerPage' => 250 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'material' ),
		),
		array(
			'param_name' => 'icon_fontawesome',
			'type'       => 'iconpicker',
			'weight'     => 10,
			'heading'    => __( 'Icon', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'settings'   => array( 'type' => 'fontawesome', 'iconsPerPage' => 250 ),
			'dependency' => array( 'element' => 'icon_library', 'value' => 'fontawesome' ),
		),
		array(
			'param_name'  => 'icon_custom',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Icon', 'silicon' ),
			'group'       => __( 'Design', 'silicon' ),
			'dependency'  => array( 'element' => 'icon_library', 'value' => 'custom' ),
			'description' => wp_kses(
				__(
					'Class should be written without leading dot. There are two options to add custom icons:<ol>
					<li>You can link your custom icon CSS file in Theme Options > Advanced</li>
					<li>You can manually enqueue custom icons CSS file in the Child Theme</li></ol>',
					'silicon'
				),
				array( 'ol' => true, 'li' => true )
			),
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
	), basename( __FILE__, '.php' ) ),
);
