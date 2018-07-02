<?php
/**
 * Blog Grid | silicon_blog_grid
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
	'columns'              => 3, // 1-6
	'source'               => 'posts', // posts | ids
	'query_post__in'       => '',
	'query_taxonomies'     => '',
	'query_post__not_in'   => '',
	'query_posts_per_page' => 10,
	'query_orderby'        => 'date',
	'query_order'          => 'DESC',
	'pagination'           => 'load-more',
	'more_text'            => __( 'Load More', 'silicon' ),
	'more_pos'             => 'left',
	'inf_all_posts'        => __( 'No more posts', 'silicon' ),
	'animation'            => '',
	'class'                => '',
), $shortcode ), $atts );

/* Build a Query */

$query_args = silicon_parse_array( $a, 'query_' );
$query_args = silicon_query_build( $query_args, function ( $query ) use ( $a ) {
	// hard-code the defaults
	$query['post_type']           = 'post';
	$query['post_status']         = 'publish';
	$query['ignore_sticky_posts'] = true;

	$is_by_ids = ( 'ids' === $a['source'] );

	// "post__not_in" allowed only for "posts" source type
	// Exclude it if exists to correctly handle "by IDs" option
	if ( $is_by_ids && array_key_exists( 'post__not_in', $query ) ) {
		unset( $query['post__not_in'] );
	}

	// Otherwise, "post__in" allowed only for "IDs" source type
	// Exclude it if exists
	if ( ! $is_by_ids && array_key_exists( 'post__in', $query ) ) {
		unset( $query['post__in'] );
	}

	// If user specify a list of IDs, fetch all posts without pagination
	if ( $is_by_ids && array_key_exists( 'posts_per_page', $query ) ) {
		$query['posts_per_page'] = - 1;
	}

	// "taxonomies" allowed only for "posts" source type
	if ( $is_by_ids && array_key_exists( 'taxonomies', $query ) ) {
		unset( $query['taxonomies'] );
	}

	// Build the tax_query based on the list of term slugs
	if ( ! $is_by_ids && array_key_exists( 'taxonomies', $query ) ) {
		$terms = $query['taxonomies'];
		unset( $query['taxonomies'] );

		$taxonomies = get_taxonomies( array(
			'public'      => true,
			'object_type' => array( 'post' ),
		), 'objects' );

		// Exclude post_formats
		if ( array_key_exists( 'post_format', $taxonomies ) ) {
			unset( $taxonomies['post_format'] );
		}

		// Get only taxonomies slugs
		$taxonomies         = array_keys( $taxonomies );
		$query['tax_query'] = silicon_query_multiple_tax( $terms, $taxonomies );

		// relations for multiple tax_queries
		if ( count( $query['tax_query'] ) > 1 ) {
			$query['tax_query']['relations'] = 'AND';
		}
	}

	return $query;
} );

$query = new WP_Query( $query_args );
if ( ! $query->have_posts() ) {
	return;
}

/* So, we have posts. Handle the attributes and show posts */

$unique_id = silicon_get_unique_id( 'blog-' );
$grid_id   = $unique_id . '-grid';

$allowed_cols  = range( 1, 6 );
$selected_cols = absint( $a['columns'] );
$columns       = in_array( $selected_cols, $allowed_cols, true ) ? $selected_cols : 3;

$class = silicon_get_classes( array(
	'blog-posts',
	'masonry-grid',
	'isotope-grid',
	'col-' . $columns,
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
	while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="grid-item">
			<?php get_template_part( 'template-parts/tiles/post-tile' ); ?>
		</div>
		<?php
	endwhile;
	wp_reset_postdata();
	?>
</div>
<?php

unset( $unique_id, $allowed_cols, $selected_cols, $columns, $class, $attr );

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
$type    = esc_attr( $a['pagination'] );

if ( $is_more
     && false === $is_all
     && 'posts' === $a['source']
     && $query->max_num_pages > 1
) {
	$nav = '';
	$class = array();
	$class[] = 'pagination';
	$class[] = 'font-family-nav';
	$class[] = 'border-default-top';
	$class[] = 'border-default-bottom';

	switch ( $a['pagination'] ) {
		case 'infinite-scroll':

			// attributes for infinite scroll
			$infinite = array(
				'action'   => 'silicon_blog_grid_load_more',
				'nonce'    => wp_create_nonce( 'silicon-ajax' ),
				'page'     => 2,
				'maxPages' => (int) $query->max_num_pages,
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
				'action'  => 'silicon_blog_grid_load_more',
				'nonce'   => wp_create_nonce( 'silicon-ajax' ),
				'page'    => 2,
				'total'   => $total,
				'perPage' => $query_args['posts_per_page'],
				'query'   => silicon_query_encode( $query_args ),
				'gridID'  => $grid_id
			);

			$nav = silicon_get_tag( 'a', array(
				'href'              => '#',
				'class'             => 'btn btn-link btn-pill btn-sm btn-default',
				'rel'               => 'nofollow',
				'data-si-load-more' => $more,
			), $text );

			unset( $total, $per_page, $number, $text, $more );

			$class[] = 'text-' . esc_attr( $a['more_pos'] );
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
}
