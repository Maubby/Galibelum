<?php
/**
 * Blog Grid | silicon_blog_grid
 *
 * @author 8guild
 */

/**
 * Get posts for autocomplete field
 *
 * @see silicon_blog_posts_autocomplete()
 */
$posts = apply_filters( 'silicon_blog_posts_autocomplete', array() );

/**
 * Get post terms for autocomplete field
 *
 * @see silicon_blog_terms_autocomplete()
 */
$terms = apply_filters( 'silicon_blog_terms_autocomplete', array() );

return array(
	'name'     => __( 'Blog Grid', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'columns',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Number of Columns', 'silicon' ),
			'std'        => 3,
			'value'      => range( 1, 6 ),
		),
		array(
			'param_name'  => 'source',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Data source', 'silicon' ),
			'description' => __( 'Choose the "List of IDs" if you want to retrieve some specific posts. If you choose the "Posts" further you can clarify the request.', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'value'       => array(
				__( 'Posts', 'silicon' ) => 'posts',
				__( 'IDs', 'silicon' )   => 'ids',
			),
		),
		array(
			'param_name'  => 'query_post__in',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'heading'     => __( 'Posts to retrieve', 'silicon' ),
			'description' => __( 'Specify items you want to retrieve, by title', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
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
			'param_name'  => 'query_taxonomies',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'heading'     => __( 'Specify the source', 'silicon' ),
			'description' => __( 'You can specify post categories, tags or custom taxonomies. NOTE: Try to avoid using terms with the same slug.', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'posts' ),
			'settings'    => array(
				'multiple'       => true,
				'sortable'       => true,
				'unique_values'  => true,
				'groups'         => true,
				'display_inline' => true,
				'min_length'     => 2,
				'values'         => $terms,
			),
		),
		array(
			'param_name'  => 'query_post__not_in',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'heading'     => __( 'Exclude posts', 'silicon' ),
			'description' => __( 'Exclude some posts from results, by title.', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'dependency'  => array( 'element' => 'source', 'value' => 'posts' ),
			'settings'    => array(
				'min_length'    => 2,
				'multiple'      => true,
				'unique_values' => true,
				'values'        => $posts,
			),
		),
		array(
			'param_name'  => 'query_posts_per_page',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Number of posts', 'silicon' ),
			'description' => __( 'Any number or "all" for displaying all posts.', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'value'       => 10,
			'dependency'  => array( 'element' => 'source', 'value_not_equal_to' => 'ids' ),
		),
		array(
			'param_name'       => 'query_orderby',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Order by', 'silicon' ),
			'group'            => __( 'Query Builder', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'date',
			'value'            => array(
				__( 'Post ID', 'silicon' )            => 'ID',
				__( 'Author', 'silicon' )             => 'author',
				__( 'Post name (slug)', 'silicon' )   => 'name',
				__( 'Date', 'silicon' )               => 'date',
				__( 'Last Modified Date', 'silicon' ) => 'modified',
				__( 'Number of comments', 'silicon' ) => 'comment_count',
				__( 'Random', 'silicon' )             => 'rand',
			),
		),
		array(
			'param_name'       => 'query_order',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'Sorting', 'silicon' ),
			'group'            => __( 'Query Builder', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'std'              => 'DESC',
			'value'            => array(
				__( 'Descending', 'silicon' ) => 'DESC',
				__( 'Ascending', 'silicon' )  => 'ASC',
			),
		),
		array(
			'param_name' => 'pagination',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Pagination', 'silicon' ),
			'group'      => __( 'Pagination', 'silicon' ),
			'std'        => 'load-more',
			'value'      => array(
				__( 'Disable', 'silicon' )         => 'disable',
				__( 'Load More', 'silicon' )       => 'load-more',
				__( 'Infinite Scroll', 'silicon' ) => 'infinite-scroll',

			),
		),
		array(
			'param_name'       => 'more_text',
			'type'             => 'textfield',
			'weight'           => 10,
			'heading'          => __( 'More Text', 'silicon' ),
			'description'      => __( 'This text will be displayed on the Load More button.', 'silicon' ),
			'group'            => __( 'Pagination', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'value'            => __( 'Load More', 'silicon' ),
			'dependency'       => array( 'element' => 'pagination', 'value' => 'load-more' ),
		),
		array(
			'param_name'       => 'more_pos',
			'type'             => 'dropdown',
			'weight'           => 10,
			'heading'          => __( 'More Position', 'silicon' ),
			'group'            => __( 'Pagination', 'silicon' ),
			'edit_field_class' => 'vc_col-sm-6',
			'dependency'       => array( 'element' => 'pagination', 'value' => 'load-more' ),
			'value'            => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name'  => 'inf_all_posts',
			'type'        => 'textfield',
			'weight'      => 10,
			'group'       => __( 'Pagination', 'silicon' ),
			'heading'     => __( '"No More Posts" text', 'silicon' ),
			'description' => __( 'This text will be shown when user scroll through all posts and no more posts left to load.', 'silicon' ),
			'dependency'  => array( 'element' => 'pagination', 'value' => 'infinite-scroll' ),
			'value'       => __( 'No more posts', 'silicon' ),
		),
	), basename( __FILE__, '.php' ) ),
);