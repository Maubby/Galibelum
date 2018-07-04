<?php
/**
 * Product | silicon_product
 *
 * @author 8guild
 */

return array(
	'name'        => __( 'Product', 'silicon' ),
	'category'    => __( 'WooCommerce', 'silicon' ),
	'description' => __( 'Show a single product.', 'silicon' ),
	'icon'        => 'silicon-vc-icon',
	'params'      => silicon_vc_map_params( array(
		array(
			'param_name'  => 'product',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Product', 'silicon' ),
			'description' => __( 'Choose a product from the dropdown list.', 'silicon' ),
			'value'       => call_user_func( function () {
				$cache_key   = 'silicon_product_posts';
				$cache_group = 'silicon';

				$data = wp_cache_get( $cache_key, $cache_group );
				if ( false === $data ) {
					// get posts
					$posts = get_posts( array(
						'post_type'           => 'product',
						'post_status'         => 'publish',
						'posts_per_page'      => - 1,
						'no_found_rows'       => true,
						'nopaging'            => true,
						'ignore_sticky_posts' => true,
						'suppress_filters'    => true,
					) );

					if ( ! empty( $posts ) && ! is_wp_error( $posts ) ) {
						$data = array();

						// first post empty
						$data[ __( 'Choose a product', 'silicon' ) ] = 0;

						foreach ( $posts as $post ) {
							$title = $post->post_title ? esc_html( $post->post_title ) : __( '(no-title)', 'silicon' );
							$id    = (int) $post->ID;

							$data[ $title . ' : ' . $id ] = $id;
							unset( $title, $id );
						}
						unset( $post );

						// cache for 1 day
						wp_cache_set( $cache_key, $data, $cache_group, 86400 );
					}
				}

				return $data;
			} ),
		),
	), 'silicon_product' ),
);
