<?php
/**
 * Google Play | silicon_google_play
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Google Play Button', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'text',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Text', 'silicon' ),
			'admin_label' => true,
			'std'         => __( 'Download on the', 'silicon' ),
		),
		array(
			'param_name' => 'link',
			'type'       => 'vc_link',
			'weight'     => 10,
		),
	), 'silicon_google_play' ),
);