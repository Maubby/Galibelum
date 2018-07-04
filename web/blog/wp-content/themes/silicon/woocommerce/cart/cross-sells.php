<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes, 8guild
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $cross_sells ) : ?>

	<section class="cross sells padding-bottom-3x">

		<h3 class="padding-bottom-1x"><?php esc_html_e( 'You may be interested in&hellip;', 'silicon' ) ?></h3>

		<?php
		/**
		 * Filter settings for Cross Sells carousel
		 *
		 * @param array $owl Carousel settings
		 */
		$owl = apply_filters( 'woocommerce_cross_sells_carousel_args', array(
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
		foreach ( $cross_sells as $cross_sell ) :
			$post_object = get_post( $cross_sell->get_id() );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			wc_get_template_part( 'content', 'product' );
		endforeach;
		echo '</div>';
		wp_reset_postdata();
		woocommerce_product_loop_end();
		unset( $owl );
        ?>

	</section>

<?php endif;
