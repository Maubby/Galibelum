<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes, 8guild
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

    <section class="up-sells upsells products padding-top-2x">
        <h3><?php esc_html_e( 'You may also like&hellip;', 'silicon' ) ?></h3>

		<?php
		/**
		 * Filter settings for Up-Sells products carousel
		 *
		 * @param array $owl Carousel settings
		 */
		$owl = apply_filters( 'woocommerce_product_upsells_carousel', array(
			'nav'        => false,
			'dots'       => true,
			'loop'       => false,
			'margin'     => 30,
			'responsive' => array(
				0    => array( 'items' => 1 ),
				480  => array( 'items' => 2 ),
				768  => array( 'items' => 3 ),
				991  => array( 'items' => 3 ),
				1200 => array( 'items' => 4 ),
			)
		) );

		woocommerce_product_loop_start();
		echo '<div ', silicon_get_attr( array( 'class' => 'owl-carousel', 'data-si-carousel' => $owl ) ), '>';
		/** @var WC_Product $upsell */
		foreach ( $upsells as $upsell ) :
			$post_object = get_post( $upsell->get_id() );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			wc_get_template_part( 'content', 'product' );
		endforeach;
		echo '</div>';
		unset( $owl );
		wp_reset_postdata();
		woocommerce_product_loop_end();
		?>

    </section>
	<?php
endif;
