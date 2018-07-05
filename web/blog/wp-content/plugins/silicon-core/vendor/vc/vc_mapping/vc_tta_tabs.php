<?php
/**
 * Tabs | vc_tta_tabs
 *
 * @author 8guild
 */

$markup = <<<'TPL'
<div class="vc_tta-container" data-vc-action="collapse">
	<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-top vc_tta-controls-align-left">
		<div class="vc_tta-tabs-container">
			<ul class="vc_tta-tabs-list">
				<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}" data-element_type="vc_tta_section">
					<a href="javascript:;"
						data-vc-tabs data-vc-container=".vc_tta"
						data-vc-target="[data-model-id='{{ model_id }}']"
						data-vc-target-model-id="{{ model_id }}"
					><span class="vc_tta-title-text">{{ section_title }}</span></a>
				</li>
			</ul>
		</div>
		<div class="vc_tta-panels vc_clearfix {{container-class}}">
			{{ content }}
		</div>
	</div>
</div>
TPL;

$default_content = '
[vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'silicon' ), 1 ) . '"][/vc_tta_section]
[vc_tta_section title="' . sprintf( '%s %d', __( 'Tab', 'silicon' ), 2 ) . '"][/vc_tta_section]
';

return array(
	'name'                    => __( 'Tabs', 'silicon' ),
	'category'                => __( 'Content', 'silicon' ),
	'description'             => __( 'Tabbed content', 'silicon' ),
	'icon'                    => 'icon-wpb-ui-tab-content',
	'is_container'            => true,
	'show_settings_on_create' => false,
	'as_parent'               => array( 'only' => 'vc_tta_section' ),
	'admin_enqueue_js'        => array( vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ) ),
	'js_view'                 => 'VcBackendTtaTabsView',
	'custom_markup'           => $markup,
	'default_content'         => $default_content,
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name'  => 'alignment',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Alignment', 'silicon' ),
			'description' => __( 'Select tabs alignment', 'silicon' ),
			'save_always' => true,
			'value'       => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
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
			'param_name'  => 'is_borders',
			'type'        => 'checkbox',
			'weight'      => 10,
			'std'         => 'disable',
			'save_always' => true,
			'value'       => array(
				__( 'Add borders?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name' => 'css',
			'type'       => 'css_editor',
			'group'      => __( 'Design Options', 'silicon' ),
			'weight'     => 10,
			'heading'    => __( 'CSS', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);