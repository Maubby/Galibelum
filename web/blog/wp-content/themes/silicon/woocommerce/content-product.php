<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
/** @var WC_Product $product */
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<div <?php post_class( 'product-tile' ); ?>>
	<?php

	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @see silicon_wc_item_thumbnail() - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	?>
    <div class="product-tile-body border-default">
	    <?php
        
	    /**
	     * woocommerce_before_shop_loop_item_title hook.
	     */
	    do_action( 'woocommerce_before_shop_loop_item_title' );

	    /**
	     * woocommerce_shop_loop_item_title hook.
	     *
	     * @see silicon_wc_item_title() - 10
	     */
	    do_action( 'woocommerce_shop_loop_item_title' );

	    /**
	     * woocommerce_after_shop_loop_item_title hook.
	     *
	     * @see silicon_wc_item_rating() - 15
	     * @see silicon_wc_item_price() - 20
         * @see woocommerce_template_loop_add_to_cart() - 30
	     */
	    do_action( 'woocommerce_after_shop_loop_item_title' );

	    ?>
    </div>
    <?php

    /**
     * woocommerce_after_shop_loop_item hook.
     */
    do_action( 'woocommerce_after_shop_loop_item' );

    ?>
</div>
