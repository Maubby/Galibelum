<?php
/**
 * WooCommerce custom actions
 *
 * Preferably for shortcodes and ajax actions
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'silicon_wc_load_products' ) ) :
	/**
	 * Load More products in "Products" shortcode
	 *
	 * AJAX callback for action "silicon_products_load_more"
	 */
	function silicon_wc_load_products() {
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
		while ( $query->have_posts() ) :
			$query->the_post();

			ob_start();

			echo '<div class="grid-item">';
			wc_get_template_part( 'content', 'product' );
			echo '</div>';

			$posts[] = silicon_content_encode( ob_get_clean() );
		endwhile;
		wp_reset_postdata();

		wp_send_json_success( $posts );
	}
endif;

if ( is_admin() ) {
	add_action( 'wp_ajax_silicon_products_load_more', 'silicon_wc_load_products' );
	add_action( 'wp_ajax_nopriv_silicon_products_load_more', 'silicon_wc_load_products' );
}

if ( ! function_exists( 'silicon_wc_products_posts' ) ) :
	/**
	 * Fetch all Products for autocomplete field.
	 *
	 * It is safe to use IDs for import, because
	 * WP Importer does not change IDs for posts.
	 *
	 * @see mapping/silicon_products.php
	 *
	 * @return array
	 */
	function silicon_wc_products_posts() {
		$cache_key   = 'silicon_products_posts';
		$cache_group = 'silicon_autocomplete';

		$posts = wp_cache_get( $cache_key, $cache_group );
		if ( false === $posts ) {
			$posts = array();
			$data  = get_posts( array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => - 1,
				'no_found_rows'       => true,
				'nopaging'            => true,
				'ignore_sticky_posts' => true,
				'suppress_filters'    => true,
			) );

			if ( ! empty( $data ) && ! is_wp_error( $data ) ) {
				foreach ( $data as $item ) {
					$posts[] = array(
						'value' => (int) $item->ID,
						'label' => esc_html( $item->post_title ),
					);
				}

				// cache for 1 day
				wp_cache_set( $cache_key, $posts, $cache_group, 86400 );
			}
		}

		return $posts;
	}
endif;

add_filter( 'silicon_products_posts_autocomplete', 'silicon_wc_products_posts', 1 );

if ( ! function_exists( 'silicon_wc_products_categories' ) ) :
	/**
	 * Fetch the Product categories for autocomplete field
	 *
	 * The taxonomy slug used as autocomplete value because
	 * of export/import issues. WP Importer creates new
	 * categories, tags, taxonomies based on import information
	 * with NEW IDs!
	 *
	 * @return array
	 */
	function silicon_wc_products_categories() {
		$cache_key   = 'silicon_products_cats';
		$cache_group = 'silicon_autocomplete';

		$data = wp_cache_get( $cache_key, $cache_group );
		if ( false === $data ) {
			$categories = get_terms( array(
				'taxonomy'     => 'product_cat',
				'hierarchical' => false,
			) );

			if ( is_wp_error( $categories ) || empty( $categories ) ) {
				return array();
			}

			$data = array();
			foreach ( $categories as $category ) {
				$data[] = array(
					'value' => $category->slug,
					'label' => $category->name,
				);
			}

			// cache for 1 day
			wp_cache_set( $cache_key, $data, $cache_group, 86400 );
		}

		return $data;
	}
endif;

add_filter( 'silicon_products_categories_autocomplete', 'silicon_wc_products_categories', 1 );

if ( ! function_exists( 'silicon_wc_products_attributes' ) ) :
	/**
	 * Get WooCommerce products attributes to fill in
	 * shortcode "query_attribute" param list.
	 *
	 * @param array $attributes Attributes
	 *
	 * @return array
	 */
	function silicon_wc_products_attributes( $attributes ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return $attributes;
		}

		$taxonomies  = wc_get_attribute_taxonomies();
		$_attributes = array();
		foreach ( $taxonomies as $tax ) {
			$_attributes[ $tax->attribute_label ] = $tax->attribute_name;
		}
		unset( $tax );

		return array_merge( $attributes, $_attributes );
	}
endif;

add_filter( 'silicon_products_attributes', 'silicon_wc_products_attributes' );

if ( ! function_exists( 'silicon_wc_products_filter_default' ) ) :
	/**
	 * Defines default value for param "query_filter" if not provided.
	 *
	 * Takes from other param value.
	 *
	 * @hooked vc_form_fields_render_field_silicon_products_query_filter_param
	 *
	 * @param array $param_settings Param settings array
	 * @param mixed $current_value  Current param value
	 * @param array $map_settings   Shortcode map settings
	 * @param array $atts           Shortcode attributes
	 *
	 * @return array
	 */
	function silicon_wc_products_filter_default( $param_settings, $current_value, $map_settings, $atts ) {
		if ( ! isset( $atts['query_attribute'] ) || 'none' === $atts['query_attribute'] ) {
			return $param_settings;
		}

		$terms = get_terms( array( 'taxonomy' => 'pa_' . $atts['query_attribute'] ) );
		$value = array();
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$value[ $term->name ] = $term->slug;
			}
		}

		if ( ! array_key_exists( 'default', $param_settings ) && ! empty( $current_value ) ) {
			$param_settings['default'] = $current_value;
		}

		if ( is_array( $value ) && ! empty( $value ) ) {
			$param_settings['value'] = $value;
		}

		return $param_settings;
	}
endif;

add_filter( 'vc_form_fields_render_field_silicon_products_query_filter_param', 'silicon_wc_products_filter_default', 10, 4 );

if ( ! function_exists( 'silicon_wc_products_filter_callback' ) ) :
	/**
	 * Return new values for Products query_filter param
	 * based on provided attribute value.
	 *
	 * This is an AJAX callback
	 *
	 * When user change query_attribute param dependency callback
	 * perform an AJAX-request to get a new options.
	 *
	 * @hooked wp_ajax_silicon_wc_attribute_terms
	 */
	function silicon_wc_products_filter_callback() {
		// Check nonce.
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'silicon-plugin' ) ) {
			wp_send_json_error( _x( 'Wrong nonce', 'ajax request', 'silicon' ) );
		}

		if ( empty( $_POST['attribute'] ) ) {
			wp_send_json_error( _x( 'You should pass "attribute" to load terms.', 'ajax request', 'silicon' ) );
		}

		$attribute = esc_attr( $_POST['attribute'] );
		if ( 'none' === $attribute ) {
			wp_send_json_error( _x( 'Can not load terms for "none" attribute.', 'ajax request', 'silicon' ) );
		}

		$terms = get_terms( array(
			'taxonomy'   => 'pa_' . $attribute,
			'hide_empty' => false,
		) );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			wp_send_json_error( _x( 'Terms for provided attribute not found', 'ajax request', 'silicon' ) );
		}

		$value = array();
		if ( ! empty( $_POST['value'] ) ) {
			$value = array_map( 'esc_attr', explode( ',', $_POST['value'] ) );
		}

		$data = array();
		foreach ( $terms as $term ) {
			$data[ $term->name ] = $term->slug;
		}
		unset( $term );

		$param = array(
			'param_name' => 'query_filter',
			'type'       => 'checkbox',
		);

		$params   = array();
		$template = '<label class="vc_checkbox-label"><input type="checkbox" id="%1$s" name="%2$s" value="%3$s" class="%4$s" %5$s> %6$s</label>';
		foreach ( $data as $label => $v ) {
			$id      = $param['param_name'] . '-' . $v;
			$class   = silicon_get_classes( array( 'wpb_vc_param_value', $param['param_name'], $param['type'] ) );
			$checked = in_array( $v, $value, true ) ? 'checked' : '';

			// 1 = id, 2 = name, 3 = value, 4 = class, 5 = checked, 6 = label
			$params[] = sprintf( $template, $id, $param['param_name'], $v, $class, $checked, $label );
			unset( $id, $class );
		}
		unset( $label, $v );

		wp_send_json_success( implode( '', $params ) );
	}
endif;

add_action( 'wp_ajax_silicon_wc_attribute_terms', 'silicon_wc_products_filter_callback' );


if ( ! function_exists( 'silicon_wc_flush_product_cache' ) ) :
	/**
	 * Flush object cache for Product shortcode.
	 *
	 * Fires when post creating, updating or deleting.
	 *
	 * @see mapping/silicon_product.php
	 *
	 * @param int $post_id Post ID
	 */
	function silicon_wc_flush_product_cache( $post_id ) {
		$type = get_post_type( $post_id );
		if ( 'product' !== $type ) {
			return;
		}

		wp_cache_delete( 'silicon_product_posts', 'silicon' );
	}
endif;

add_action( 'save_post_product', 'silicon_wc_flush_product_cache' );
add_action( 'deleted_post', 'silicon_wc_flush_product_cache' );

if ( ! function_exists( 'silicon_wc_flush_products_posts_cache' ) ) :
	/**
	 * Flush object cache for products autocomplete.
	 *
	 * Fires when post creating, updating or deleting.
	 *
	 * @see silicon_wc_products_posts()
	 *
	 * @param int $post_id Post ID
	 */
	function silicon_wc_flush_products_posts_cache( $post_id ) {
		$type = get_post_type( $post_id );
		if ( 'product' !== $type ) {
			return;
		}

		wp_cache_delete( 'silicon_products_posts', 'silicon_autocomplete' );
	}
endif;

add_action( 'save_post_product', 'silicon_wc_flush_products_posts_cache' );
add_action( 'deleted_post', 'silicon_wc_flush_products_posts_cache' );

if ( ! function_exists( 'silicon_wc_flush_products_categories_cache' ) ) :
	/**
	 * Flush object cache for Product categories autocomplete
	 *
	 * Fires when created, edited, deleted or updated a category
	 *
	 * @see silicon_wc_products_categories()
	 * @see shortcodes/mapping/silicon_products.php
	 *
	 * @see wp_update_term() taxonomy.php :: 3440
	 * @see _update_post_term_count() taxonomy.php :: 4152
	 *
	 * @param int    $term_id  Term ID or Term Taxonomy ID
	 * @param string $taxonomy Taxonomy name, exists only for "edit_term_taxonomy"
	 */
	function silicon_wc_flush_products_categories_cache( $term_id, $taxonomy = null ) {
		$cache_key   = 'silicon_products_cats';
		$cache_group = 'silicon_autocomplete';

		if ( null === $taxonomy || 'product_cat' === $taxonomy ) {
			wp_cache_delete( $cache_key, $cache_group );
		}
	}
endif;

add_action( 'create_product_cat', 'silicon_wc_flush_products_categories_cache' );
add_action( 'delete_product_cat', 'silicon_wc_flush_products_categories_cache' );
add_action( 'edit_term_taxonomy', 'silicon_wc_flush_products_categories_cache', 10, 2 );
