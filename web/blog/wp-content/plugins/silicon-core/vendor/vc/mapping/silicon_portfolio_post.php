<?php
/**
 * Portfolio Post | silicon_portfolio_post
 *
 * @author 8guild
 */

return array(
	'name'     => __( 'Portfolio Post', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name'  => 'post',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Post', 'silicon' ),
			'description' => __( 'Choose a post from the dropdown list.', 'silicon' ),
			'value'       => call_user_func( function () {
				// get posts
				$_posts = get_posts( array(
					'post_type'        => 'silicon_portfolio',
					'post_status'      => 'publish',
					'posts_per_page'   => - 1,
					'no_found_rows'    => true,
					'nopaging'         => true,
					'suppress_filters' => true,
					'meta_query'       => array(
						array(
							'key'     => '_thumbnail_id',
							'compare' => 'EXISTS'
						),
					)
				) );

				$posts = array();

				$posts[ __( 'Choose a post', 'silicon' ) ] = 0;

				if ( ! empty( $_posts ) && ! is_wp_error( $_posts ) ) {
					foreach ( $_posts as $post ) {
						$title = $post->post_title ? esc_html( $post->post_title ) : __( '(no-title)', 'silicon' );
						$id    = (int) $post->ID;

						$posts[ $title ] = $id;
						unset( $title, $id );
					}
					unset( $post );
				}

				return $posts;
			} ),
		),
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'value'      => array(
				__( 'With Title', 'silicon' )     => 'with-gap',
				__( 'Title on Hover', 'silicon' ) => 'no-gap',
				__( 'List', 'silicon' )           => 'list',
			),
		),
	), basename( __FILE__, '.php' ) )
);
