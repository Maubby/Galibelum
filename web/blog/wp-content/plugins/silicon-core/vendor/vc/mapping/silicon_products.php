<?php
/**
 * Products | silicon_products
 *
 * @author 8guild
 */

/**
 * Get posts for autocomplete field
 *
 * @see silicon_wc_products_posts()
 * @see silicon_wc_flush_products_posts_cache()
 */
$posts = apply_filters( 'silicon_products_posts_autocomplete', array() );

/**
 * Get post terms for autocomplete field
 *
 * @see silicon_wc_products_categories()
 * @see silicon_wc_flush_products_categories_cache()
 */
$categories = apply_filters( 'silicon_products_categories_autocomplete', array() );

/**
 * Get attributes
 *
 * @see silicon_wc_products_attributes()
 */
$attributes = apply_filters( 'silicon_products_attributes', array( __( 'None', 'silicon' ) => 'none' ) );

return array(
	'name'             => __( 'Products', 'silicon' ),
	'category'         => __( 'WooCommerce', 'silicon' ),
	'description'      => __( 'Show multiple products.', 'silicon' ),
	'icon'             => 'silicon-vc-icon',
	'admin_enqueue_js' => SILICON_PLUGIN_URI . '/js/woocommerce.js',
	'params'           => silicon_vc_map_params( array(
		array(
			'param_name' => 'columns',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Number of Columns', 'silicon' ),
			'std'        => 4,
			'value'      => range( 2, 4 ),
		),
		array(
			'param_name'  => 'source',
			'type'        => 'dropdown',
			'weight'      => 10,
			'group'       => __( 'Query Builder', 'silicon' ),
			'heading'     => __( 'Data Source', 'silicon' ),
			'description' => __( 'Choose the "List of IDs" if you want to retrieve some specific posts. If you choose the "Posts" further you can clarify the request.', 'silicon' ),
			'value'       => array(
				__( 'Categories', 'silicon' )    => 'categories',
				__( 'Sale Products', 'silicon' ) => 'sale',
				__( 'IDs', 'silicon' )           => 'ids',
			),
		),
		array(
			'param_name'  => 'query_post__in',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'group'       => __( 'Query Builder', 'silicon' ),
			'heading'     => __( 'Posts to retrieve', 'silicon' ),
			'description' => __( 'Specify items you want to retrieve, by title', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'ids' ),
			'settings'    => array(
				'multiple'       => true,
				'unique_values'  => true,
				'display_inline' => false,
				'min_length'     => 2,
				'values'         => $posts,
			),
		),
		array(
			'param_name' => 'query_categories',
			'type'       => 'autocomplete',
			'weight'     => 10,
			'group'      => __( 'Query Builder', 'silicon' ),
			'heading'    => __( 'Categories', 'silicon' ),
			'dependency' => array( 'element' => 'source', 'value' => 'categories' ),
			'settings'   => array(
				'multiple'       => true,
				'unique_values'  => true,
				'display_inline' => true,
				'min_length'     => 2,
				'values'         => $categories,
			),
		),
		array(
			'param_name'  => 'query_post__not_in',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'group'       => __( 'Query Builder', 'silicon' ),
			'heading'     => __( 'Exclude posts', 'silicon' ),
			'description' => __( 'Exclude some posts from results, by title.', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => array( 'categories', 'sale' ) ),
			'settings'    => array(
				'min_length'    => 2,
				'multiple'      => true,
				'unique_values' => true,
				'values'        => $posts,
			),
		),
		array(
			'param_name'       => 'query_featured',
			'type'             => 'checkbox',
			'weight'           => 10,
			'group'            => __( 'Query Builder', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-3',
			'dependency'       => array( 'element' => 'source', 'value' => array( 'categories', 'sale' ) ),
			'std'              => 'disable',
			'value'            => array( esc_html__( 'Featured', 'silicon' ) => 'enable' ),
		),
		array(
			'param_name'       => 'query_best_selling',
			'type'             => 'checkbox',
			'weight'           => 10,
			'group'            => __( 'Query Builder', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-3',
			'dependency'       => array( 'element' => 'source', 'value' => array( 'categories', 'sale' ) ),
			'std'              => 'disable',
			'value'            => array( esc_html__( 'Best Selling', 'silicon' ) => 'enable' ),
		),
		array(
			'param_name'       => 'query_top_rated',
			'type'             => 'checkbox',
			'weight'           => 10,
			'group'            => __( 'Query Builder', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'dependency'       => array( 'element' => 'source', 'value' => array( 'categories', 'sale' ) ),
			'std'              => 'disable',
			'value'            => array( esc_html__( 'Top Rated', 'silicon' ) => 'enable' ),
		),
		array(
			'param_name'  => 'query_attribute',
			'type'        => 'dropdown',
			'weight'      => 10,
			'save_always' => true,
			'heading'     => __( 'Attribute', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => array( 'categories', 'sale' ) ),
			'std'         => 'none',
			'value'       => $attributes,
		),
		array(
			'param_name'  => 'query_filter',
			'type'        => 'checkbox',
			'weight'      => 10,
			'save_always' => true,
			'group'       => __( 'Query Builder', 'silicon' ),
			'value'       => array( __( 'Empty', 'silicon' ) => 'empty' ),
			'dependency'  => array( 'callback' => 'siliconWCProductsAttributeDependencyCallback' ),
		),
		array(
			'param_name'  => 'query_posts_per_page',
			'type'        => 'textfield',
			'weight'      => 10,
			'group'       => __( 'Query Builder', 'silicon' ),
			'heading'     => __( 'Number of posts', 'silicon' ),
			'description' => __( 'Any number or "all" for displaying all posts.', 'silicon' ),
			'value'       => 10,
			'dependency'  => array( 'element' => 'source', 'value_not_equal_to' => 'ids' ),
		),
		array(
			'param_name'       => 'query_orderby',
			'type'             => 'dropdown',
			'weight'           => 10,
			'group'            => __( 'Query Builder', 'silicon' ),
			'heading'          => __( 'Order by', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'date',
			'value'            => array(
				__( 'Post ID', 'silicon' )            => 'ID',
				__( 'Author', 'silicon' )             => 'author',
				__( 'Post name (slug)', 'silicon' )   => 'name',
				__( 'Date', 'silicon' )               => 'date',
				__( 'Last Modified Date', 'silicon' ) => 'modified',
				__( 'Number of comments', 'silicon' ) => 'comment_count',
				__( 'Manually', 'silicon' )           => 'post__in',
				__( 'Random', 'silicon' )             => 'rand',
			),
		),
		array(
			'param_name'       => 'query_order',
			'type'             => 'dropdown',
			'weight'           => 10,
			'group'            => __( 'Query Builder', 'silicon' ),
			'heading'          => __( 'Sorting', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'value'            => array(
				__( 'Descending', 'silicon' ) => 'DESC',
				__( 'Ascending', 'silicon' )  => 'ASC',
			),
		),
		array(
			'param_name'  => 'pagination',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Pagination', 'silicon' ),
			'description' => __( 'See tab "Load More" for additional customization options. Appears when you choose Load More option.', 'silicon' ),
			'group'       => __( 'Load More', 'silicon' ),
			'std'         => 'load-more',
			'value'       => array(
				__( 'Disable', 'silicon' )   => 'disable',
				__( 'Load More', 'silicon' ) => 'load-more',
			),
		),
		array(
			'param_name'  => 'more_text',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Text', 'silicon' ),
			'description' => __( 'This text will be displayed on the Load More button.', 'silicon' ),
			'group'       => __( 'Load More', 'silicon' ),
			'value'       => __( 'Load More', 'silicon' ),
			'dependency'  => array( 'element' => 'pagination', 'value' => 'load-more' ),
		),
		array(
			'param_name' => 'more_pos',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Position', 'silicon' ),
			'group'      => __( 'Load More', 'silicon' ),
			'dependency' => array( 'element' => 'pagination', 'value' => 'load-more' ),
			'std'        => 'center',
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
	), 'silicon_products' ),
);