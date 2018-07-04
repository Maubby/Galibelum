<?php
/**
 * Team Member | silicon_team_member
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Team Member', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'value'      => array(
				__( 'Standard', 'silicon' )   => 'vertical',
				__( 'Horizontal', 'silicon' ) => 'horizontal',
				__( 'Card', 'silicon' )       => 'card',
			),
		),
		array(
			'param_name' => 'cover',
			'type'       => 'attach_image',
			'weight'     => 10,
			'heading'    => __( 'Cover Image', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => 'card' ),
		),
		array(
			'param_name'  => 'image',
			'type'        => 'attach_image',
			'weight'      => 10,
			'heading'     => __( 'Upload Image', 'silicon' ),
			'description' => __(
				'For optimal display recommended image sizes: type Standard - 288х288px,
				type Horizontal - 200x200px, type Card - 192x192px',
				'silicon'
			),
		),
		array(
			'param_name'  => 'name',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Name', 'silicon' ),
			'admin_label' => true,
		),
		array(
			'param_name' => 'position',
			'type'       => 'textfield',
			'weight'     => 10,
			'heading'    => __( 'Position', 'silicon' ),
		),
		array(
			'param_name'  => 'info',
			'type'        => 'textarea',
			'weight'      => 10,
			'heading'     => __( 'Additional Info', 'silicon' ),
			'description' => __( 'HTML is not allowed here.', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => 'card' ),
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
		array(
			'param_name' => 'skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Skin', 'silicon' ),
			'dependency' => array( 'element' => 'type', 'value' => array( 'vertical', 'horizontal' ) ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
	), basename( __FILE__, '.php' ) ),
);