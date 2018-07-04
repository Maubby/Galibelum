<?php
/**
 * Hooks and callbacks related to blog
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'silicon_blog_posts_autocomplete' ) ) :
	/**
	 * Fetch all Blog posts for autocomplete field.
	 *
	 * It is safe to use IDs for import, because
	 * WP Importer does not change IDs for posts.
	 *
	 * @return array
	 */
	function silicon_blog_posts_autocomplete() {
		$cache_key   = 'silicon_blog_posts';
		$cache_group = 'silicon_autocomplete';

		$posts = wp_cache_get( $cache_key, $cache_group );
		if ( false === $posts ) {
			$posts  = array();
			$_posts = get_posts( array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => - 1,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'nopaging'            => true,
			) );

			if ( ! empty( $_posts ) && ! is_wp_error( $_posts ) ) {
				foreach ( $_posts as $post ) {
					$posts[] = array(
						'value' => (int) $post->ID,
						'label' => esc_html( $post->post_title ),
					);
				}

				// cache for 1 day
				wp_cache_set( $cache_key, $posts, $cache_group, 86400 );
			}
		}

		return $posts;
	}
endif;

add_filter( 'silicon_blog_posts_autocomplete', 'silicon_blog_posts_autocomplete', 1 );

/**
 * Flush object cache for blog posts.
 *
 * Fires when post creating, updating or deleting.
 *
 * @see silicon_blog_posts_autocomplete()
 *
 * @param int $post_id Post ID
 */
function silicon_blog_flush_posts_cache( $post_id ) {
	$type = get_post_type( $post_id );
	if ( 'post' !== $type ) {
		return;
	}

	wp_cache_delete( 'silicon_blog_posts', 'silicon_autocomplete' );
}

add_action( 'save_post_post', 'silicon_blog_flush_posts_cache' );
add_action( 'deleted_post', 'silicon_blog_flush_posts_cache' );

/**
 * Fetch all public terms of blog posts for autocomplete field
 *
 * The taxonomy slug used as autocomplete value because
 * of export/import issues. WP Importer creates new
 * categories, tags, taxonomies based on import information
 * with NEW IDs!
 *
 * @see shortcodes/mapping/silicon_blog.php
 *
 * @return array
 */
function silicon_blog_terms_autocomplete() {
	$taxonomies = get_taxonomies( array(
		'public'      => true,
		'object_type' => array( 'post' )
	), 'objects' );

	// Exclude post_formats
	if ( array_key_exists( 'post_format', $taxonomies ) ) {
		unset( $taxonomies['post_format'] );
	}

	$terms = get_terms( array(
		'taxonomy'     => array_keys( $taxonomies ),
		'hierarchical' => false,
	) );

	if ( ! is_array( $terms ) || empty( $terms ) ) {
		return array();
	}

	$group_default = __( 'Taxonomies', 'silicon' );

	$data = array();
	foreach ( (array) $terms as $term ) {
		if ( isset( $taxonomies[ $term->taxonomy ] )
		     && isset( $taxonomies[ $term->taxonomy ]->labels )
		     && isset( $taxonomies[ $term->taxonomy ]->labels->name )
		) {
			$group = $taxonomies[ $term->taxonomy ]->labels->name;
		} else {
			$group = $group_default;
		}

		$data[] = array(
			'label'    => $term->name,
			'value'    => $term->slug,
			'group_id' => $term->taxonomy,
			'group'    => $group,
		);
	}

	usort( $data, function( $i, $j ) {
		$a = strtolower( trim( $i['group'] ) );
		$b = strtolower( trim( $j['group'] ) );;

		if ( $a == $b ) {
			return 0;
		} elseif ( $a > $b ) {
			return 1;
		} else {
			return - 1;
		}
	} );

	return $data;
}

add_filter( 'silicon_blog_terms_autocomplete', 'silicon_blog_terms_autocomplete', 1 );

/**
 * Load More posts in "Blog Grid" shortcode
 *
 * Fires for both pagination types: Load More and Infinity Scroll
 *
 * AJAX callback for action "silicon_blog_grid_load_more"
 */
function silicon_blog_load_more() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'silicon-ajax' ) ) {
		wp_send_json_error( _x( 'Wrong nonce', 'ajax request', 'silicon' ) );
	}

	if ( empty( $_POST['query'] ) ) {
		wp_send_json_error( _x( 'Param "query" required to load posts', 'ajax request', 'silicon' ) );
	}

	$query_args = silicon_query_decode( $_POST['query'] );
	if ( null === $query_args ) {
		wp_send_json_error( _x( 'Invalid "query" param', 'ajax request', 'silicon' ) );
	}

	$query_args['paged'] = (int) $_POST['page'];

	$query = new WP_Query( $query_args );
	if ( ! $query->have_posts() ) {
		wp_send_json_error( _x( 'Posts not found', 'ajax request', 'silicon' ) );
	}

	$posts = array();
	while( $query->have_posts() ) {
		$query->the_post();
		ob_start();
		echo '<div class="grid-item">';
		get_template_part( 'template-parts/tiles/post-tile' );
		echo '</div>';

		$posts[] = silicon_content_encode( ob_get_clean() );
	}
	wp_reset_postdata();
	wp_send_json_success( $posts );
}

if ( is_admin() ) {
	add_action( 'wp_ajax_silicon_blog_grid_load_more', 'silicon_blog_load_more' );
	add_action( 'wp_ajax_nopriv_silicon_blog_grid_load_more', 'silicon_blog_load_more' );
}