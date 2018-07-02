<?php
/**
 * Video Button | silicon_video_button
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Video Button', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'video',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Link to Video', 'silicon' ),
			'description' => __( 'Paste a link to video, for example https://vimeo.com/33984473 or https://www.youtube.com/watch?v=DqO90q0WZ0M', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Alignment', 'silicon' ),
			'std'        => 'center',
			'value'      => array(
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
			'std'        => 'dark',
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'white',
			),
		),
	), basename( __FILE__, '.php' ) ),
);
