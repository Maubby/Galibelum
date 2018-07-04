<?php
/**
 * Portfolio Grid | silicon_portfolio_grid
 *
 * @author 8guild
 */

/**
 * Get posts for autocomplete field
 *
 * @param array $posts
 */
$posts = apply_filters( 'silicon_portfolio_posts_autocomplete', array() );

/**
 * Get post terms for autocomplete field
 *
 * @param array $categories
 */
$categories = apply_filters( 'silicon_portfolio_categories_autocomplete', array() );

return array(
	'name'     => __( 'Portfolio Grid', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'value'      => array(
				__( 'Grid', 'silicon' )        => 'with-gap',
				__( 'Grid no Gap', 'silicon' ) => 'no-gap',
				__( 'List', 'silicon' )        => 'list',
			),
		),
		array(
			'param_name' => 'columns',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Columns', 'silicon' ),
			'std'        => 3,
			'value'      => range( 1, 6 ),
			'dependency' => array( 'element' => 'type', 'value' => array( 'with-gap', 'no-gap' ) )
		),
		array(
			'param_name'  => 'source',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Data source', 'silicon' ),
			'group'       => __( 'Query Builder', 'silicon' ),
			'description' => __(
				'Choose the "List of IDs" if you want to retrieve some specific posts.
				If you choose the "Categories" further you can clarify the request.',
				'silicon'
			),
			'value'       => array(
				__( 'Categories', 'silicon' ) => 'categories',
				__( 'IDs', 'silicon' )        => 'ids',
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
			'dependency'  => array( 'element' => 'source', 'value' => 'categories' ),
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
			'group'       => __( 'Query Builder', 'silicon' ),
			'heading'     => __( 'Number of posts', 'silicon' ),
			'description' => __( 'Any number or "all" for displaying all posts.', 'silicon' ),
			'value'       => 'all',
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
			'param_name' => 'is_filters',
			'type'       => 'dropdown',
			'weight'     => 10,
			'group'      => __( 'Filters', 'silicon' ),
			'heading'    => __( 'Enable filters?', 'silicon' ),
			'value'      => array(
				__( 'Yes', 'silicon' ) => 'enable',
				__( 'No', 'silicon' )  => 'disable',
			),
		),
		array(
			'param_name' => 'filters_pos',
			'type'       => 'dropdown',
			'weight'     => 10,
			'group'      => __( 'Filters', 'silicon' ),
			'heading'    => __( 'Filters position', 'silicon' ),
			'dependency' => array( 'element' => 'is_filters', 'value' => 'enable' ),
			'std'        => 'center',
			'value'      => array(
				__( 'Left', 'silicon' )   => 'left',
				__( 'Center', 'silicon' ) => 'center',
				__( 'Right', 'silicon' )  => 'right',
			),
		),
		array(
			'param_name'  => 'filters_exclude',
			'type'        => 'autocomplete',
			'weight'      => 10,
			'group'       => __( 'Filters', 'silicon' ),
			'heading'     => __( 'Exclude from filter list', 'silicon' ),
			'description' => __( 'Enter categories won\'t be shown in the filters list. This option is useful if you specify some categories in General tab.', 'silicon' ),
			'dependency'  => array( 'element' => 'is_filters', 'value' => 'enable' ),
			'settings'    => array(
				'multiple'       => true,
				'min_length'     => 2,
				'unique_values'  => true,
				'display_inline' => true,
				'values'         => $categories,
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
			'param_name'  => 'more_text',
			'type'        => 'textfield',
			'weight'      => 10,
			'group'       => __( 'Pagination', 'silicon' ),
			'heading'     => __( 'Text', 'silicon' ),
			'description' => __( 'This text will be displayed on the Load More button.', 'silicon' ),
			'value'       => __( 'Load More', 'silicon' ),
			'dependency'  => array( 'element' => 'pagination', 'value' => 'load-more' ),
		),
		array(
			'param_name' => 'more_pos',
			'type'       => 'dropdown',
			'weight'     => 10,
			'group'      => __( 'Pagination', 'silicon' ),
			'heading'    => __( 'Position', 'silicon' ),
			'dependency' => array( 'element' => 'pagination', 'value' => 'load-more' ),
			'std'        => 'center',
			'value'      => array(
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
	), basename( __FILE__, '.php' ) )
);
