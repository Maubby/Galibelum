<?php
/**
 * Blog Post | silicon_blog_post
 *
 * @author 8guild
 */

return array(
	'name'        => __( 'Blog Post', 'silicon' ),
	'category'    => __( 'Silicon', 'silicon' ),
	'description' => __( 'Displays the single post tile', 'silicon' ),
	'icon'        => 'silicon-vc-icon',
	'params'      => silicon_vc_map_params( array(
		array(
			'param_name'  => 'post',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Post', 'silicon' ),
			'description' => __( 'Choose a post from the dropdown list.', 'silicon' ),
			'value'       => call_user_func( function () {
				$posts  = array();
				$_posts = get_posts( array(
					'post_type'           => 'post',
					'post_status'         => 'publish',
					'posts_per_page'      => - 1,
					'no_found_rows'       => true,
					'nopaging'            => true,
					'ignore_sticky_posts' => true,
					'suppress_filters'    => true,
				) );

				$posts[ __( 'Choose a post', 'silicon' ) ] = 0;

				if ( empty( $_posts ) || is_wp_error( $_posts ) ) {
					return $posts;
				}

				foreach ( $_posts as $post ) {
					$title = $post->post_title ? esc_html( $post->post_title ) : __( '(no-title)', 'silicon' );
					$id    = (int) $post->ID;

					$posts[ $title ] = $id;
					unset( $title, $id );
				}
				unset( $post );

				return $posts;
			} ),
		),
	), basename( __FILE__, '.php' ) )
);
