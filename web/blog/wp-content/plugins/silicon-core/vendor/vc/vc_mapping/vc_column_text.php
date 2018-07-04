<?php
/**
 * Text Block | vc_column_text
 *
 * @author 8guild
 */

return array(
	'name'          => __( 'Text Block', 'silicon' ),
	'category'      => __( 'Content', 'silicon' ),
	'description'   => __( 'A block of text with WYSIWYG editor', 'silicon' ),
	'icon'          => 'icon-wpb-layer-shape-text',
	'wrapper_class' => 'clearfix',
	'params'        => silicon_vc_map_params( array(
		array(
			'param_name' => 'content',
			'type'       => 'textarea_html',
			'weight'     => 10,
			'holder'     => 'div',
			'value'      => wp_kses(
				__(
					'<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur
					adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>',
					'silicon'
				),
				array( 'p' => true )
			),
		),
		array(
			'param_name' => 'css',
			'type'       => 'css_editor',
			'weight'     => 10,
			'heading'    => __( 'CSS', 'silicon' ),
			'group'      => __( 'Design Options', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) )
);