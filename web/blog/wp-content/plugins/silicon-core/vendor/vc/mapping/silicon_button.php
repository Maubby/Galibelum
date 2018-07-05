<?php
/**
 * Button | silicon_button
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Button', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'text',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Button Text', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name' => 'link',
			'type'       => 'vc_link',
			'weight'     => 10,
		),
		array(
			'param_name'       => 'type',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Type', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'value'            => array(
				__( 'Solid', 'silicon' ) => 'solid',
				__( 'Ghost', 'silicon' ) => 'ghost',
				__( 'Link', 'silicon' )  => 'link',
			),
		),
		array(
			'param_name'       => 'shape',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Shape', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'value'            => array(
				__( 'Pill', 'silicon' )    => 'pill',
				__( 'Rounded', 'silicon' ) => 'rounded',
				__( 'Square', 'silicon' )  => 'square',
			),
		),
		array(
			'param_name'       => 'color',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Color', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'value'            => array(
				__( 'Default', 'silicon' )  => 'default',
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
			'dependency' => array( 'element' => 'color', 'value' => 'custom' ),
		),
		array(
			'param_name'       => 'size',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Size', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'std'              => 'nl',
			'value'            => array(
				__( 'Small', 'silicon' )  => 'sm',
				__( 'Normal', 'silicon' ) => 'nl',
				__( 'Large', 'silicon' )  => 'lg',
			),
		),
		array(
			'param_name'       => 'is_full',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Make button full-width?', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'value'            => array(
				__( 'No', 'silicon' )  => 'disable',
				__( 'Yes', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'       => 'alignment',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Alignment', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-4',
			'value'            => array(
				__( 'Inline', 'silicon' ) => 'inline',
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name'  => 'is_icon',
			'type'        => 'checkbox',
			'weight'      => 10,
			'save_always' => true,
			'std'         => 'disable',
			'value'       => array(
				__( 'Add icon?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name'       => 'icon_library',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Icon Library', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'dependency'       => array( 'element' => 'is_icon', 'value' => 'enable' ),
			'save_always'      => true,
			'value'            => array(
				__( 'Silicon Icons', 'silicon' )  => 'silicon',
				__( 'Social Icons', 'silicon' )   => 'socicon',
				__( 'Material Icons', 'silicon' ) => 'material',
				__( 'Font Awesome', 'silicon' )   => 'fontawesome',
				__( 'Custom', 'silicon' )         => 'custom',
			),
		),
		array(
			'param_name'       => 'icon_position',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Icon Position', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'dependency'       => array( 'element' => 'is_icon', 'value' => 'enable' ),
			'value'            => array(
				__( 'Left', 'silicon' )  => 'left',
				__( 'Right', 'silicon' ) => 'right',
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
					'Class should be written without leading dot. There are two options to add custom icons: <ol>
					<li>You can link your custom icon CSS file in Theme Options > Advanced</li>
					<li>You can manually enqueue custom icons CSS file in the Child Theme</li></ol>',
					'silicon'
				),
				array( 'ol' => true, 'li' => true )
			),
		),
		array(
			'param_name' => 'is_waves',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Waves Effect', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'waves_skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Waves Color', 'silicon' ),
			'dependency' => array( 'element' => 'is_waves', 'value' => 'enable' ),
			'std'        => 'light',
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
	), basename( __FILE__, '.php' ) ),
);
