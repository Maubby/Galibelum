<?php
/**
 * Tour | vc_tta_tour
 *
 * @author 8guild
 */

$markup = <<<'MARKUP'
<div class="vc_tta-container" data-vc-action="collapse">
	<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-left vc_tta-controls-align-left">
		<div class="vc_tta-tabs-container">
			<ul class="vc_tta-tabs-list">
				<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}">
					<a href="javascript:;"
					   data-vc-container=".vc_tta"
					   data-vc-target="[data-model-id='{{ model_id }}']"
					   data-vc-target-model-id="{{ model_id }}"
					   data-vc-tabs
					>{{ section_title }}</a>
				</li>
			</ul>
		</div>
		<div class="vc_tta-panels {{container-class}}">
			{{ content }}
		</div>
	</div>
</div>
MARKUP;

$default_content = '
[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'silicon' ), 1 ) . '"][/vc_tta_section]
[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'silicon' ), 2 ) . '"][/vc_tta_section]
';

return array(
	'name'                    => __( 'Tour', 'silicon' ),
	'category'                => __( 'Content', 'silicon' ),
	'description'             => __( 'Vertical tabbed content', 'silicon' ),
	'base'                    => 'vc_tta_tour',
	'icon'                    => 'icon-wpb-ui-tab-content-vertical',
	'is_container'            => true,
	'show_settings_on_create' => false,
	'as_parent'               => array( 'only' => 'vc_tta_section' ),
	'admin_enqueue_js'        => array( vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ) ),
	'js_view'                 => 'VcBackendTtaTourView',
	'custom_markup'           => $markup,
	'default_content'         => $default_content,
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name'  => 'position',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Position', 'silicon' ),
			'description' => __( 'Select tabs section position', 'silicon' ),
			'save_always' => true,
			'value'       => array(
				__( 'Left', 'silicon' )  => 'left',
				__( 'Right', 'silicon' ) => 'right',
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
