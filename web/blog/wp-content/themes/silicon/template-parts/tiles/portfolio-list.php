<?php
/**
 * Template Part for displaying the Portfolio tile as list item.
 *
 * We call this type "List"
 *
 * NOTE: portfolio tiles don't work without featured image.
 *
 * @author 8guild
 */

$_post_id        = get_the_ID();
$_post_permalink = get_permalink();
$_post_settings  = silicon_get_setting( 'all', array(), $_post_id );

?>
<article <?php post_class( 'portfolio-post portfolio-post-list text-center' ); ?>>

    <?php
    // Display the carousel
    if ( isset( $_post_settings['portfolio_layout'] ) && 'blank' !== $_post_settings['portfolio_layout'] ) :

	    $gallery = array();

	    // Add featured image to Gallery
	    if ( isset( $_post_settings['portfolio_exclude_fi'] )
	         && false === (bool) $_post_settings['portfolio_exclude_fi']
	    ) {
		    $gallery[] = get_post_thumbnail_id();
	    }

	    // Add other images to Gallery
	    if ( ! empty( $_post_settings['portfolio_gallery'] ) ) {
		    $gallery = array_merge( $gallery,
			    wp_parse_id_list( $_post_settings['portfolio_gallery'] )
		    );
	    }

	    $attr = silicon_get_attr( array(
		    'class'            => 'owl-carousel portfolio-carousel-no-gap',
		    'data-si-carousel' => array( 'items' => 1, 'dots' => false, 'nav' => true, 'loop' => true ),
	    ) );

	    echo '<div ', $attr, '>';
	    foreach ( $gallery as $item ) :
		    echo silicon_get_tag( 'div', array(
			    'class' => 'portfolio-carousel-item',
			    'style' => silicon_css_background_image( (int) $item ),
		    ), '' );
	    endforeach;
	    echo '</div>';
	    unset( $item, $attr, $gallery );

    else :

        if ( has_post_thumbnail() ) :
            the_post_thumbnail();
        endif;

    endif;
    ?>

	<div class="portfolio-post-list-info">

		<?php
		the_title(
			sprintf( '<h3 class="portfolio-tile-title margin-top-1x"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( $_post_permalink ) ),
			'</a></h3>'
		);
        ?>

		<p class="text-gray"><?php the_excerpt(); ?></p>
		<a href="<?php echo esc_url( $_post_permalink ); ?>"
           class="btn btn-primary btn-pill btn-ghost"><?php esc_html_e( 'view project', 'silicon' ); ?></a>
	</div>
</article>
