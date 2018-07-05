<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes, 8guild
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Product */
global $product; ?>

<div class="product-item">
    <div class="widget-product-thumb">
		<?php printf( '<a href="%1$s">%2$s</a>', esc_url( $product->get_permalink() ), $product->get_image() ); ?>
    </div>
    <div class="widget-product-inner">
        <h4 class="product-title">
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="navi-link-color navi-link-hover-color">
				<?php echo esc_html( $product->get_name() ); ?>
            </a>
        </h4>
		<?php

		// rating
		if ( ! empty( $show_rating ) ) :
			echo wc_get_rating_html( $product->get_average_rating() );
		endif;

		// price
		echo '<div class="product-price text-gray">', $product->get_price_html(), '</div>';
		?>
    </div>
</div>
