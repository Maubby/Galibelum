<?php
/**
 * Portfolio Carousel | silicon_portfolio_carousel
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
	'is_height'            => 'disable',
	'dots_skin'            => 'dark',
	'desktop'              => 3,
	'tablet_land'          => 3,
	'tablet_portrait'      => 2,
	'mobile'               => 1,
	'margin'               => 30,

	// general
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

/* So, we have posts. Do the output */

$class = silicon_get_classes( array(
	'owl-carousel',
	'portfolio-carousel',
	'portfolio-carousel-' . esc_attr( $a['type'] ),
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
	'margin'          => ( 'with-gap' === $a['type'] ) ? absint( $a['margin'] ) : 0,
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
	get_template_part( 'template-parts/tiles/portfolio', $a['type'] );
endwhile;
wp_reset_postdata();
echo '</div>';
