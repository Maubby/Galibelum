<?php
/**
 * Products | silicon_products
 *
 * @var string $shortcode Shortcode tag
 * @var array  $atts      Shortcode attributes
 * @var mixed  $content   Shortcode content
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'columns'              => 4,
	'source'               => 'categories',
	'query_post__in'       => '',
	'query_categories'     => '',
	'query_post__not_in'   => '',
	'query_featured'       => 'disable',
	'query_best_selling'   => 'disable',
	'query_top_rated'      => 'disable',
	'query_attribute'      => '',
	'query_filter'         => '',
	'query_posts_per_page' => 'all',
	'query_orderby'        => 'date',
	'query_order'          => 'DESC',
	'pagination'           => 'load-more',
	'more_text'            => __( 'Load More', 'silicon' ),
	'more_pos'             => 'center',
	'animation'            => '',
	'class'                => '',
), $shortcode ), $atts );


/* Build a Query */

$query_args = silicon_parse_array( $a, 'query_' );
$query_args = silicon_query_build( $query_args, function( $query ) use ( $a ) {
	// hard-code the defaults
	$query['post_type']   = 'product';
	$query['post_status'] = 'publish';

	$is_by_ids  = ( 'ids' === $a['source'] );
	$is_sale    = ( 'sale' === $a['source'] );
	$is_by_cats = ( 'categories' === $a['source'] );

	// if user disable the pagination prevent mysql CALC_FOUND_ROWS
	// may be save a little piece of resources
	if ( $is_by_ids
	     || 'disable' === $a['pagination']
	     || 'all' === strtolower( $a['query_posts_per_page'] )
	) {
		$query['no_found_rows'] = true;
	}

	// "post__not_in" allowed for "categories" and "sale" source type
	// exclude it if exists to correctly handle "by IDs" option
	if ( $is_by_ids && array_key_exists( 'post__not_in', $query ) ) {
		unset( $query['post__not_in'] );
	}

	// otherwise, "post__in" allowed only for "IDs" source type
	// exclude it if exists
	if ( ! $is_by_ids && array_key_exists( 'post__in', $query ) ) {
		unset( $query['post__in'] );
	}

	// include the Sale Products, behaviour is the same
	// when user choose Source = IDs
	if ( $is_sale ) {
		$query['post__in'] = wc_get_product_ids_on_sale();
	}

	// if user specify a list of IDs, fetch all posts without pagination
	if ( $is_by_ids ) {
		$query['posts_per_page'] = - 1;
	}

	// "categories" allowed only for "categories" source type
	if ( ! $is_by_cats && array_key_exists( 'categories', $query ) ) {
		unset( $query['categories'] );
	}

	// build a tax_query
	// @see WP_Query
	$tax_query = array();

	// maybe add categories to tax_queries
	if ( $is_by_cats && array_key_exists( 'categories', $query ) && ! empty( $query['categories'] ) ) {
		$categories = $query['categories'];
		unset( $query['categories'] );

		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => silicon_parse_slugs( $categories ),
		);
	}

	// maybe add product attributes to tax_query
	if ( ! $is_by_ids && ! empty( $query['attribute'] ) && ! empty( $query['filter'] ) ) {
		$attribute = $query['attribute'];
		$attribute = strstr( $attribute, 'pa_' ) ? esc_attr( $attribute ) : 'pa_' . esc_attr( $attribute );

		$tax_query[] = array(
			'taxonomy' => $attribute,
			'field'    => 'slug',
			'terms'    => array_map( 'esc_attr', explode( ',', $query['filter'] ) ),
		);

		unset( $attribute, $query['attribute'], $query['filter'] );
	}

	$query['tax_query'] = $tax_query;

	// set relations for multiple tax_queries
	if ( count( $query['tax_query'] ) > 1 ) {
		$query['tax_query']['relations'] = 'AND';
	}

	// build a custom meta_query
	// @see WP_Meta_Query
	$meta_query = array();

	// all custom meta_query allowed only for
	// "categories" or "sale" source, so will not be used
	// if user build a query by IDs
	if ( ! $is_by_ids ) {

		// Featured Products
		if ( array_key_exists( 'featured', $query ) && 'enable' === $query['featured'] ) {
			unset( $query['featured'] );
			$meta_query[] = array(
				'key'   => '_featured',
				'value' => 'yes',
			);
		}

		// Best Selling
		// NOTE: this will override the orderby and order
		if ( array_key_exists( 'best_selling', $query ) && 'enable' === $query['best_selling'] ) {
			unset( $query['best_selling'] );
			$query['meta_key'] = 'total_sales';
			$query['orderby']  = 'meta_value_num';
			$query['order']    = 'DESC';
		}

		// Top Rated
		// just remove the key, we will add a filter
		// @see WC_Shortcodes::order_by_rating_post_clauses()
		if ( array_key_exists( 'top_rated', $query ) ) {
			unset( $query['top_rated'] );
		}
	}

	// this is required to make WooCommerce filters work
	// remember the WooCommerce filter widgets?
	$query['meta_query'] = WC()->query->get_meta_query( $meta_query );

	return $query;
} );

// Top Rated custom posts_clauses
if ( 'enable' === $a['query_top_rated'] ) {
	add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
}

$query = new WP_Query( $query_args );

if ( 'enable' === $a['query_top_rated'] ) {
	remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
}

// do not execute if posts not found
if ( ! $query->have_posts() ) {
	return;
}


/* So, we have posts. Handle the attributes and show posts */

$unique_id  = silicon_get_unique_id( 'products-' );
$grid_id    = $unique_id . '-grid';
$tax        = 'product_cat';

$allowed_cols  = range( 2, 4 );
$selected_cols = absint( $a['columns'] );
$columns       = in_array( $selected_cols, $allowed_cols, true ) ? $selected_cols : 4;
unset( $allowed_cols, $selected_cols );

$class = silicon_get_classes( array(
	'masonry-grid',
	'isotope-grid',
	'products-grid',
	'woocommerce',
	'col-' . $columns,
	$a['class'],
) );

$attr = array(
	'id'       => esc_attr( $grid_id ),
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
);


/* Markup Output */

woocommerce_product_loop_start();

?>
<div <?php echo silicon_get_attr( $attr ); ?>>
	<div class="gutter-sizer"></div>
	<div class="grid-sizer"></div>

	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		echo '<div class="grid-item">';
		wc_get_template_part( 'content', 'product' );
		echo '</div>';
	endwhile;
	wp_reset_postdata();
	?>
</div>
<?php

woocommerce_product_loop_end();


/*
 * Pagination
 *
 * Pagination works when user perform a request by categories
 * and limiting the number of posts.
 *
 * In case if user disable the pagination, or try to load "all" posts,
 * or perform a request by posts, or requested number of posts less
 * than found by provided criteria the pagination won't display.
 */

$is_more = ( 'disable' !== $a['pagination'] );
$is_all  = ( 'all' === strtolower( $a['query_posts_per_page'] ) );

if ( $is_more
     && false === $is_all
     && in_array( $a['source'], array( 'categories', 'sale' ), true )
     && (int) $query->max_num_pages > 1
) {
	$class = array();

	$class[] = 'pagination';
	$class[] = 'font-family-nav';
	$class[] = 'border-default-top';
	$class[] = 'border-default-bottom';
	$class[] = 'text-' . esc_attr( $a['more_pos'] );

	$total    = (int) $query->found_posts;
	$per_page = (int) $query_args['posts_per_page'];
	$number   = $total - ( 1 * $per_page );
	$number   = ( $number > $per_page ) ? $per_page : $number;

	$text = sprintf( '<i class="si si-load-more"></i> %1$s (<span data-load-more-counter="%2$s">%2$s</span>)',
		esc_html( $a['more_text'] ),
		$number
	);

	$more = array(
		'action'  => 'silicon_products_load_more',
		'nonce'   => wp_create_nonce( 'silicon-ajax' ),
		'query'   => silicon_query_encode( $query_args ),
		'page'    => 2,
		'total'   => $total,
		'perPage' => $query_args['posts_per_page'],
		'gridID'  => $grid_id,
	);

	$nav = silicon_get_tag( 'a', array(
		'href'              => '#',
		'class'             => 'btn btn-link btn-pill btn-sm btn-default',
		'rel'               => 'nofollow',
		'data-si-load-more' => $more,
	), $text );

	unset( $total, $per_page, $number, $text, $more );

	$class = esc_attr( silicon_get_classes( $class ) );

	echo "
    <section class=\"{$class}\">
        <div class=\"spinner-wrap\">
            <div class=\"spinner-layer border-color-primary\">
                <div class=\"circle-clipper left\">
                    <div class=\"circle\"></div>
                </div>
                <div class=\"gap-patch\">
                    <div class=\"circle\"></div>
                </div>
                <div class=\"circle-clipper right\">
                    <div class=\"circle\"></div>
                </div>
            </div>
        </div>
        {$nav}
    </section>";

	unset( $class, $nav );
}