<?php
/**
 * Section | vc_tta_section
 *
 * @author 8guild
 */

$markup = <<<'MARKUP'
<div class="vc_tta-panel-heading">
    <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
    	<a href="javascript:;"
    	   data-vc-accordion
    	   data-vc-target="[data-model-id='{{ model_id }}']"
    	   data-vc-container=".vc_tta-container"
    	>
	        <span class="vc_tta-title-text">{{ section_title }}</span>
	        <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
    	</a>
    </h4>
</div>
<div class="vc_tta-panel-body">
	{{ editor_controls }}
	<div class="{{ container-class }}">
	{{ content }}
	</div>
</div>
MARKUP;

return array(
	'name'                      => __( 'Section', 'silicon' ),
	'category'                  => __( 'Content', 'silicon' ),
	'description'               => __( 'Section for Tabs, Tours, Accordions.', 'silicon' ),
	'icon'                      => 'icon-wpb-ui-tta-section',
	'allowed_container_element' => 'vc_row',
	'is_container'              => true,
	'show_settings_on_create'   => false,
	'as_child'                  => array( 'only' => 'vc_tta_tour,vc_tta_tabs,vc_tta_accordion' ),
	'js_view'                   => 'VcBackendTtaSectionView',
	'custom_markup'             => $markup,
	'default_content'           => '',
	'params'                    => silicon_vc_map_params( array(
		array(
			'param_name'  => 'title',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Title', 'silicon' ),
			'description' => __( 'Enter section title', 'silicon' ),
		),
		array(
			'param_name'  => 'tab_id',
			'type'        => 'el_id',
			'weight'      => 10,
			'settings'    => array( 'auto_generate' => true ),
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
			'param_name'  => 'animation',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Animation', 'silicon' ),
			'description' => __( 'Applicable only for tabs', 'silicon' ),
			'value'       => array(
				__( 'Fade', 'silicon' )       => 'fade',
				__( 'Scale', 'silicon' )      => 'scale',
				__( 'Scale Down', 'silicon' ) => 'scaledown',
				__( 'Left', 'silicon' )       => 'left',
				__( 'Right', 'silicon' )      => 'right',
				__( 'Top', 'silicon' )        => 'top',
				__( 'Bottom', 'silicon' )     => 'bottom',
				__( 'Flip', 'silicon' )       => 'flip',
			),
		),
		array(
			'param_name' => 'is_icon',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Add icon?', 'silicon' ),
			'value'      => array(
				__( 'No', 'silicon' )  => 'disable',
				__( 'Yes', 'silicon' ) => 'enable',
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
			'dependency'       => array( 'element' => 'is_icon', 'value' => 'enable' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'left',
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
	), basename( __FILE__, '.php' ) ),
);