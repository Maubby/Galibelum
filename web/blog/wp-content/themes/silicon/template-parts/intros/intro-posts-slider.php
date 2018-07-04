<?php
/**
 * Template for displaying "Featured Posts Slider" intro section
 *
 * @author 8guild
 */

$_intro_id = silicon_get_setting( 'intro', 0 );
if ( empty( $_intro_id ) ) {
	return;
}

$_settings = silicon_get_meta( $_intro_id, '_silicon_intro_posts' );
$_settings = wp_parse_args( $_settings, array(
	'posts'          => array(),
	'is_arrows'      => true,
	'is_dots'        => false,
	'is_loop'        => false,
	'is_autoplay'    => false,
	'autoplay_speed' => 4000,
	'offset'         => 115,
) );

// get posts
$_posts = array_map( 'intval', array_filter( $_settings['posts'], 'is_numeric' ) );
if ( empty( $_posts ) ) {
	return;
}

$_query = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'post__in'            => $_posts,
	'posts_per_page'      => - 1,
	'suppress_filters'    => true,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'nopaging'            => true,
	'orderby'             => 'post__in', // keep the order of how posts are added
) );

if ( ! $_query->have_posts() ) {
    return;
}

/**
 * Filter the Featured Posts Slider carousel options. Based on owlCarousel.js
 *
 * @param array $carousel owlCarousel options
 * @param array $settings Current meta box settings
 * @param int   $intro_id Current post ID
 */
$_owl = apply_filters( 'silicon_intro_posts_slider_carousel', array(
	'nav'             => (bool) $_settings['is_arrows'], // next / prev buttons
	'dots'            => (bool) $_settings['is_dots'],
	'loop'            => (bool) $_settings['is_loop'],
	'autoplay'        => (bool) $_settings['is_autoplay'],
	'autoplayTimeout' => absint( $_settings['autoplay_speed'] ),
    'autoHeight'      => true,
    'margin'          => 0,
	'items'           => 1,
), $_settings, $_intro_id );

?>
<section class="intro-section intro-featured-posts">
    <div class="owl-carousel carousel-light" data-si-carousel='<?php echo json_encode( $_owl ); ?>'>

        <?php while( $_query->have_posts() ) : $_query->the_post(); ?>
            <article <?php
                     post_class( 'featured-post' );
                     if ( has_post_thumbnail() ) :
                         $_bg = silicon_get_image_src( get_post_thumbnail_id() );
                         echo sprintf( ' style="background-image: url(%s);"', esc_url( $_bg ) ); // NOTE: there is a space before style
                         unset( $_bg );
                     endif;
                     ?>>
                <span class="overlay"></span>
                <div class="container padding-bottom-4x" style="padding-top: <?php echo absint( $_settings['offset'] ); ?>px;">
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-sm-10">
                            <div class="post-header">
                                <?php silicon_entry_category(); ?>
                            </div>
                            <div class="post-body">
                                <?php
                                the_title(
                                    sprintf( '<h2 class="post-title"><a href="%s" class="navi-link-color navi-link-hover-color">',
                                        esc_url( get_permalink() )
                                    ),
                                    '</a></h2>'
                                );

                                echo '<p class="text-white opacity-60">', get_the_excerpt(), '</p>';
                                ?>
                            </div>
                            <?php silicon_tile_footer(); ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; wp_reset_postdata(); ?>

    </div>
</section>
<?php

unset( $_query, $_owl, $_posts, $_settings, $_intro_id );
