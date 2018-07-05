<?php
/**
 * Team Member Light | silicon_team_member
 *
 * @author 8guild
 */

return array(
	'name'            => __( 'Team Member', 'silicon' ),
	'category'        => __( 'Silicon', 'silicon' ),
	'icon'            => 'silicon-vc-icon',
	'php_class_name'  => 'Silicon_Shortcode_Team_Member_Light',
	'content_element' => true,
	'as_child'        => array( 'only' => 'silicon_team_grid' ),
	'params'          => silicon_vc_map_params( array(
		array(
			'param_name'  => 'image',
			'type'        => 'attach_image',
			'weight'      => 10,
			'heading'     => __( 'Upload Image', 'silicon' ),
			'description' => __( 'For optimal display recommended image size 288х288px', 'silicon' ),
		),
		array(
			'param_name'  => 'name',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Name', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'position',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Position', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name'  => 'content',
			'type'        => 'param_group',
			'heading'     => __( 'Social Networks', 'silicon' ),
			'save_always' => true,
			'params'      => array(
				array(
					'param_name'       => 'network',
					'type'             => 'dropdown',
					'weight'           => 10,
					'heading'          => __( 'Network', 'silicon' ),
					'description'      => __( 'Choose the network from the given list.', 'silicon' ),
					'edit_field_class' => 'vc_col-sm-4',
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
					'edit_field_class' => 'vc_col-sm-8',
					'admin_label'      => true,
				),
			),
		),
	), basename( __FILE__, '.php' ) ),
);