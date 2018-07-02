<?php
/**
 * Content Box | silicon_content_box
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Content Box', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Media Type', 'silicon' ),
			'std'        => 'icon',
			'value'      => array(
				__( 'None', 'silicon' )        => 'none',
				__( 'Font Icon', 'silicon' )   => 'icon',
				__( 'Media Icon', 'silicon' )  => 'icon-image',
				__( 'Cover Image', 'silicon' ) => 'image-cover',
			),
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
			'std'        => 'si si-camera',
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
			'param_name' => 'media_icon',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Media Icon', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'icon-image' )
		),
		array(
			'param_name' => 'cover',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Cover Image', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'image-cover' )
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
			'param_name' => 'link_text',
			'type'       => 'textfield',
			'weight'     => 10,
			'heading'    => __( 'Link Text', 'silicon' ),
			'std'        => __( 'Read More', 'silicon' ),
		),
		array(
			'param_name' => 'link_url',
			'type'       => 'vc_link',
			'weight'     => 10,
		),
		array(
			'param_name' => 'color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Primary', 'silicon' )  => 'primary',
				__( 'Success', 'silicon' )  => 'success',
				__( 'Info', 'silicon' )     => 'info',
				__( 'Warning', 'silicon' )  => 'warning',
				__( 'Danger', 'silicon' )   => 'danger',
				__( 'Gradient', 'silicon' ) => 'gradient',
			),
		),
	), basename( __FILE__, '.php' ) ),
);