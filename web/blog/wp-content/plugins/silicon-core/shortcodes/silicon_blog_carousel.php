<?php
/**
 * Blog Carousel | silicon_blog_carousel
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
	// query builder
	'source'               => 'categories',
	'query_post__in'       => '',
	'query_categories'     => '',
	'query_post__not_in'   => '',
	'query_posts_per_page' => 10,
	'query_orderby'        => 'date',
	'query_order'          => 'DESC',

	// carousel
	'is_loop'              => 'disable',
	'is_autoplay'          => 'disable',
	'autoplay_speed'       => 3000,
	'is_height'            => 'enable',
	'desktop'              => 3,
	'tablet_land'          => 3,
	'tablet_portrait'      => 2,
	'mobile'               => 1,
	'margin'               => 30,

	// controls
	'dots_skin'            => 'dark',

	// general
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

/* So, we have posts. Do the output */

$class = silicon_get_classes( array(
	'owl-carousel',
	'carousel-' . esc_attr( $a['dots_skin'] ),
	$a['class'],
) );

// settings for carousel
$owl = array(
	'nav'             => false,
	'dots'            => true,
	'loop'            => ( 'enable' === $a['is_loop'] ),
	'autoplay'        => ( 'enable' === $a['is_autoplay'] ),
	'autoplayTimeout' => absint( $a['autoplay_speed'] ),
	'autoHeight'      => ( 'enable' === $a['is_height'] ),
	'margin'          => absint( $a['margin'] ),
	'responsive'      => array(
		0    => array( 'items' => absint( $a['mobile'] ) ),
		768  => array( 'items' => absint( $a['tablet_portrait'] ) ),
		991  => array( 'items' => absint( $a['tablet_land'] ) ),
		1200 => array( 'items' => absint( $a['desktop'] ) ),
	)
);

$attr = silicon_get_attr( array(
	'class'            => esc_attr( $class ),
	'data-aos'         => empty( $a['animation'] ) ? '' : esc_attr( $a['animation'] ),
	'data-si-carousel' => $owl,
) );

echo '<div ', $attr, '>';
while ( $query->have_posts() ) :
	$query->the_post();
	get_template_part( 'template-parts/tiles/post-simple' );
endwhile;
wp_reset_postdata();
echo '</div>';
