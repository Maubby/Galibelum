<?php
/**
 * Portfolio Grid | silicon_portfolio_grid
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

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'type'                 => 'with-gap',
	'columns'              => 3,
	'source'               => 'categories',
	'query_post__in'       => '',
	'query_categories'     => '',
	'query_post__not_in'   => '',
	'query_posts_per_page' => 'all',
	'query_orderby'        => 'date',
	'query_order'          => 'DESC',
	'is_filters'           => 'enable',
	'filters_pos'          => 'center',
	'filters_exclude'      => '',
	'pagination'           => 'load-more',
	'more_text'            => __( 'Load More', 'silicon' ),
	'more_pos'             => 'center',
	'inf_all_posts'        => __( 'No more posts', 'silicon' ),
	'animation'            => '',
	'class'                => '',
), $shortcode ), $atts );

/* Build a Query */

$query_args = silicon_parse_array( $a, 'query_' );
$query_args = silicon_query_build( $query_args, function ( $query ) use ( $a ) {
	// hard-code the defaults
	$query['post_type']   = 'silicon_portfolio';
	$query['post_status'] = 'publish';
	$query['meta_query']  = array( array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' ) );

	$is_by_ids = ( 'ids' === $a['source'] );
	$tax       = 'silicon_portfolio_category';

	// "post__not_in" allowed only for "categories" source type
	// exclude it if exists to correctly handle "by IDs" option
	if ( $is_by_ids && array_key_exists( 'post__not_in', $query ) ) {
		unset( $query['post__not_in'] );
	}

	// otherwise, "post__in" allowed only for "IDs" source type
	if ( ! $is_by_ids && array_key_exists( 'post__in', $query ) ) {
		unset( $query['post__in'] );
	}

	// if user specify a list of IDs, fetch all posts without pagination
	if ( $is_by_ids ) {
		$query['posts_per_page'] = -1;
	}

	// "categories" allowed only for "categories" source type
	if ( $is_by_ids && array_key_exists( 'categories', $query ) ) {
		unset( $query['categories'] );
	}

	// build a tax_query if getting by categories, {@see WP_Query}
	if ( ! $is_by_ids && array_key_exists( 'categories', $query ) ) {
		$categories = $query['categories'];
		unset( $query['categories'] );
		$query['tax_query'] = silicon_query_single_tax( $categories, $tax );
	}

	return $query;
} );

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) {
	return;
}

/* So, we have posts. Handle the attributes and show posts */

$tax       = 'silicon_portfolio_category';
$unique_id = silicon_get_unique_id( 'portfolio-' );
$grid_id   = $unique_id . '-grid';
$layout    = esc_attr( $a['type'] );

$allowed_cols  = range( 1, 6 );
$selected_cols = absint( $a['columns'] );
$columns       = in_array( $selected_cols, $allowed_cols, true ) ? $selected_cols : 3;
if ( 'list' === $layout ) {
	$columns = 1;
}

/* Maybe display filters */

if ( 'enable' === $a['is_filters'] ) {
	$filters_id = $unique_id . '-filter';

	echo silicon_get_filters( array(
		'taxonomy'      => $tax,
		'exclude'       => $a['filters_exclude'],
		'filters_id'    => $filters_id,
		'filters_class' => 'nav-filters isotope-filter text-' . esc_attr( $a['filters_pos'] ),
		'grid_id'       => $grid_id,
		'show_all'      => __( 'All', 'silicon' ),
	) );
}

/* Markup Output */

$class = silicon_get_classes( array(
	'masonry-grid',
	'isotope-grid',
	'col-' . $columns,
	'grid-' . $layout,
	( 'enable' === $a['is_filters'] ) ? 'filtered-grid' : '',
	$a['class'],
) );


$attr = array(
	'id'       => esc_attr( $grid_id ),
	'class'    => esc_attr( $class ),
	'data-aos' => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
);

?>
<div <?php echo silicon_get_attr( $attr ); ?>>
    <div class="gutter-sizer"></div>
    <div class="grid-sizer"></div>

    <?php
    while ( $query->have_posts() ) :
        $query->the_post();

        // service + terms classes for isotope filtration
        $classes = array_merge( array( 'grid-item' ), silicon_get_post_terms( get_the_ID(), $tax ) );
        $classes = silicon_get_classes( $classes );

        echo '<div class="', esc_attr( $classes ), '">';
        get_template_part( 'template-parts/tiles/portfolio', $layout );
        echo '</div>';

        unset( $classes );
    endwhile;
    wp_reset_postdata();
    ?>
</div>
<?php
unset( $unique_id, $class, $attr );


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
     && 'categories' === $a['source']
     && (int) $query->max_num_pages > 1
) {
	$nav     = '';
	$class   = array();
	$class[] = 'pagination';
	$class[] = 'font-family-nav';
	$class[] = 'border-default-top';
	$class[] = 'border-default-bottom';

	switch ( $a['pagination'] ) {
		case 'infinite-scroll':

			// attributes for infinite scroll
			$infinite = array(
				'action'   => 'silicon_portfolio_load_more',
				'nonce'    => wp_create_nonce( 'silicon-ajax' ),
				'page'     => 2,
				'maxPages' => (int) $query->max_num_pages,
				'type'     => $layout,
				'query'    => silicon_query_encode( $query_args ),
				'gridID'   => $grid_id,
				'noMore'   => strip_tags( stripslashes( trim( $a['inf_all_posts'] ) ) ),
			);

			$nav = silicon_get_tag( 'a', array(
				'href'                    => '#',
				'class'                   => 'infinite-scroll',
				'rel'                     => 'nofollow',
				'data-si-infinite-scroll' => $infinite,
			), '' );

			$class[] = 'pagination-infinite';
			$class[] = 'text-center';

			unset( $infinite );
			break;

		case 'load-more':
		default:
			$total    = (int) $query->found_posts;
			$per_page = (int) $query_args['posts_per_page'];
			$number   = $total - ( 1 * $per_page );
			$number   = ( $number > $per_page ) ? $per_page : $number;

			$text = sprintf( '<i class="si si-load-more"></i> %1$s (<span data-load-more-counter="%2$s">%2$s</span>)',
				esc_html( $a['more_text'] ),
				$number
			);

			$more = array(
				'action'  => 'silicon_portfolio_load_more',
				'nonce'   => wp_create_nonce( 'silicon-ajax' ),
				'type'    => $layout,
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

			$class[] = 'text-' . esc_attr( $a['more_pos'] );

		    unset( $total, $per_page, $number, $text, $more );
			break;
	}

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
} // end pagination
