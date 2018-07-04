<?php
/**
 * Accordion | vc_tta_accordion
 *
 * @author 8guild
 */

return array(
	'name'                    => __( 'Accordion', 'silicon' ),
	'category'                => __( 'Content', 'silicon' ),
	'description'             => __( 'Collapsible content panels', 'silicon' ),
	'icon'                    => 'icon-wpb-ui-accordion',
	'is_container'            => true,
	'show_settings_on_create' => false,
	'as_parent'               => array( 'only' => 'vc_tta_section' ),
	'js_view'                 => 'VcBackendTtaAccordionView',
	'custom_markup'           => '
	<div class="vc_tta-container" data-vc-action="collapseAll">
		<div class="vc_general vc_tta vc_tta-accordion vc_tta-color-backend-accordion-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-gap-2">
		   <div class="vc_tta-panels vc_clearfix {{container-class}}">
		      {{ content }}
		      <div class="vc_tta-panel vc_tta-section-append">
		         <div class="vc_tta-panel-heading">
		            <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
		               <a href="javascript:;" aria-expanded="false" class="vc_tta-backend-add-control">
		                   <span class="vc_tta-title-text">' . __( 'Add Section', 'silicon' ) . '</span>
		                    <i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i>
						</a>
		            </h4>
		         </div>
		      </div>
		   </div>
		</div>
	</div>',
	'default_content'         => '[vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'silicon' ), 1 ) . '"][/vc_tta_section][vc_tta_section title="' . sprintf( '%s %d', __( 'Section', 'silicon' ), 2 ) . '"][/vc_tta_section]',
	'params'                  => silicon_vc_map_params( array(
		array(
			'param_name'  => 'active_section',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Active section', 'silicon' ),
			'description' => __( 'Enter active section number. To have all sections closed on initial load enter 0 or non-existing number.', 'silicon' ),
			'value'       => 1,
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
			'param_name' => 'css',
			'type'       => 'css_editor',
			'group'      => __( 'Design Options', 'silicon' ),
			'weight'     => 10,
			'heading'    => __( 'CSS', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);