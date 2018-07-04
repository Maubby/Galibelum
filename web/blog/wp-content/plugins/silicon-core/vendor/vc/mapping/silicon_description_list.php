<?php
/**
 * Description List | silicon_description_list
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Description List', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'List Type', 'silicon' ),
			'value'      => array(
				__( 'No Icon', 'silicon' )   => 'no-icon',
				__( 'With Icon', 'silicon' ) => 'with-icon',
			),
		),
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
		array(
			'param_name' => 'items',
			'type'       => 'param_group',
			'heading'    => __( 'Items', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'no-icon' ),
			'params'     => array(
				array(
					'param_name'  => 'title',
					'type'        => 'textfield',
					'weight'      => 10,
					'heading'     => __( 'Title', 'silicon' ),
					'admin_label' => true,
				),
				array(
					'param_name' => 'description',
					'type'       => 'textarea',
					'weight'     => 10,
					'heading'    => __( 'Description', 'silicon' ),
				),
			),
		),
		array(
			'param_name' => 'items_icon',
			'type'       => 'param_group',
			'heading'    => __( 'Items', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'with-icon' ),
			'params'     => array(
				array(
					'param_name'  => 'title',
					'type'        => 'textfield',
					'weight'      => 10,
					'heading'     => __( 'Title', 'silicon' ),
					'admin_label' => true,
				),
				array(
					'param_name' => 'description',
					'type'       => 'textarea',
					'weight'     => 10,
					'heading'    => __( 'Description', 'silicon' ),
				),
				array(
					'param_name' => 'icon_library',
					'type'       => 'dropdown',
					'weight'     => 10,
					'heading'    => __( 'Icon Library', 'silicon' ),
					'value'      => array(
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
					'description' => wp_kses(
						__(
							'Class should be written without leading dot. There are two options to add custom icons:
							<ol><li>You can link your custom icon CSS file in Theme Options > Advanced</li>
							<li>You can manually enqueue custom icons CSS file in the Child Theme</li></ol>',
							'silicon'
						),
						array( 'ol' => true, 'li' => true )
					),
				),
				array(
					'param_name' => 'icon_color',
					'type'       => 'dropdown',
					'weight'     => 10,
					'heading'    => __( 'Icon Color', 'silicon' ),
					'value'      => array(
						__( 'Dark', 'silicon' )    => 'dark',
						__( 'Primary', 'silicon' ) => 'primary',
						__( 'Success', 'silicon' ) => 'success',
						__( 'Info', 'silicon' )    => 'info',
						__( 'Warning', 'silicon' ) => 'warning',
						__( 'Danger', 'silicon' )  => 'danger',
						__( 'White', 'silicon' )   => 'white',
						__( 'Gray', 'silicon' )    => 'gray',
						__( 'Custom', 'silicon' )  => 'custom',
					),
				),
				array(
					'param_name' => 'icon_color_custom',
					'type'       => 'colorpicker',
					'weight'     => 10,
					'heading'    => __( 'Custom Icon Color', 'silicon' ),
					'dependency' => array( 'element' => 'icon_color', 'value' => 'custom' ),
				),
			),
		),
	), basename( __FILE__, '.php' ) ),
);
