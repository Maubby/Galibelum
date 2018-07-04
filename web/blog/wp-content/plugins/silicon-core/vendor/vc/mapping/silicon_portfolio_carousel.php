<?php
/**
 * Portfolio Carousel | silicon_portfolio_carousel
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
	'name'     => __( 'Portfolio Carousel', 'silicon' ),
	'category' => __( 'Silicon', 'silicon' ),
	'icon'     => 'silicon-vc-icon',
	'params'   => silicon_vc_map_params( array(
		array(
			'param_name' => 'type',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Type', 'silicon' ),
			'value'      => array(
				__( 'With Gap', 'silicon' )    => 'with-gap',
				__( 'Without Gap', 'silicon' ) => 'no-gap',
			),
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
			'param_name' => 'is_loop',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Loop', 'silicon' ),
			'group'      => __( 'Behavior', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'is_autoplay',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Autoplay', 'silicon' ),
			'group'      => __( 'Behavior', 'silicon' ),
			'std'        => 'disable',
			'value'      => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name'  => 'autoplay_speed',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Autoplay Speed', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Behavior', 'silicon' ),
			'dependency'  => array( 'element' => 'is_autoplay', 'value' => 'enable' ),
			'value'       => '3000',
		),
		array(
			'param_name'  => 'is_height',
			'type'        => 'dropdown',
			'weight'      => 10,
			'heading'     => __( 'Adaptive Height', 'silicon' ),
			'description' => __( 'Helpful for images with different height. Works only with 1 item on screen.', 'silicon' ),
			'group'       => __( 'Behavior', 'silicon' ),
			'std'         => 'disable',
			'value'       => array(
				__( 'Enable', 'silicon' )  => 'enable',
				__( 'Disable', 'silicon' ) => 'disable',
			),
		),
		array(
			'param_name' => 'dots_skin',
			'type'       => 'dropdown',
			'weight'     => 10,
			'heading'    => __( 'Dots Skin', 'silicon' ),
			'group'      => __( 'Controls', 'silicon' ),
			'value'      => array(
				__( 'Dark', 'silicon' )  => 'dark',
				__( 'Light', 'silicon' ) => 'light',
			),
		),
		array(
			'param_name'  => 'desktop',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Desktop', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => 3,
		),
		array(
			'param_name'  => 'tablet_land',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Tablet Landscape', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => 3,
		),
		array(
			'param_name'  => 'tablet_portrait',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Tablet Portrait', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => 2,
		),
		array(
			'param_name'  => 'mobile',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Mobile Phone', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'value'       => 1,
		),
		array(
			'param_name'  => 'margin',
			'type'        => 'textfield',
			'weight'      => 10,
			'heading'     => __( 'Space Between Items', 'silicon' ),
			'description' => __( 'Any positive integer number', 'silicon' ),
			'group'       => __( 'Responsive', 'silicon' ),
			'dependency'  => array( 'element' => 'type', 'value' => 'with-gap' ),
			'value'       => 30,
		),
	), basename( __FILE__, '.php' ) )
);
