<?php
/**
 * Social Buttons | silicon_socials
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Social Buttons', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'socials',
			'type'        => 'param_group',
			'heading'     => __( 'Socials', 'silicon' ),
			'description' => __( 'Choose your social networks', 'silicon' ),
			'save_always' => true,
			'value'       => urlencode( json_encode( array(
				array(
					'network' => 'twitter',
					'url'     => 'https://twitter.com/8guild',
				),
				array(
					'network' => 'facebook',
					'url'     => '#',
				),
			) ) ),
			'params'      => array(
				array(
					'param_name'       => 'network',
					'type'             => 'dropdown',
					'weight'           => 10,
					'heading'          => __( 'Network', 'silicon' ),
					'description'      => __( 'Choose the network from the given list.', 'silicon' ),
					'edit_field_class' => 'vc_col-sm-6',
					'admin_label'      => true,
					'value'            => call_user_func( function () {
						$networks = silicon_get_networks();
						if ( empty( $networks ) ) {
							return array();
						}

						$result = array();
						foreach ( $networks as $network => $data ) {
							$name            = $data['name'];
							$result[ $name ] = $network;
							unset( $name );
						}
						unset( $network, $data );

						return $result;
					} ),
				),
				array(
					'param_name'       => 'url',
					'type'             => 'textfield',
					'weight'           => 10,
					'heading'          => __( 'URL', 'silicon' ),
					'description'      => __( 'Enter the link to your social networks', 'silicon' ),
					'edit_field_class' => 'vc_col-sm-6',
					'admin_label'      => true,
				),
			),
		),
		array(
			'param_name' => 'shape',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Shape', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'std'        => 'circle',
			'value'      => array(
				__( 'No shape', 'silicon' ) => 'no',
				__( 'Circle', 'silicon' )   => 'circle',
				__( 'Rounded', 'silicon' )  => 'rounded',
				__( 'Square', 'silicon' )   => 'square',
				__( 'Polygon', 'silicon' )  => 'polygon',
			),
		),
		array(
			'param_name' => 'color',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Color', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Monochrome', 'silicon' )  => 'monochrome',
				__( 'Brand Color', 'silicon' ) => 'brand',
			),
		),
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'std'        => 'dark',
			'value'      => array(
				__( 'Light', 'silicon' ) => 'light',
				__( 'Dark', 'silicon' )  => 'dark',
			),
		),
		array(
			'param_name' => 'alignment',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Alignment', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name'  => 'is_tooltips',
			'type'        => 'checkbox',
			'weight'      => 10,
			'group'       => __( 'Design', 'silicon' ),
			'std'         => 'enable',
			'save_always' => true,
			'value'       => array(
				__( 'Enable tooltips?', 'silicon' ) => 'enable',
			),
		),
		array(
			'param_name' => 'tooltips_position',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Tooltips Position', 'silicon' ),
			'group'      => __( 'Design', 'silicon' ),
			'dependency' => array( 'element' => 'is_tooltips', 'value' => 'enable' ),
			'value'      => array(
				__( 'Top', 'silicon' )    => 'top',
				__( 'Right', 'silicon' )  => 'right',
				__( 'Left', 'silicon' )   => 'left',
				__( 'Bottom', 'silicon' ) => 'bottom',
			),
		),
	), basename( __FILE__, '.php' ) ),
);
