<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
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

/** @var WC_Product $product */
global $product;
?>
<div class="product_meta border-default-top">

	<?php

	/**
	 * woocommerce_product_meta_start hook.
	 */
    do_action( 'woocommerce_product_meta_start' );

    // SKU
	if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) :
		$sku = $product->get_sku();
        ?>
        <div class="sku_wrapper">
            <?php esc_html_e( 'SKU:', 'silicon' ); ?>
            <span class="sku text-gray"> <?php echo ( $sku ) ? $sku : esc_html__( 'N/A', 'silicon' ); ?></span>
        </div>
        <?php
        unset( $sku );
	endif;

	// Categories
    $before = _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'silicon' );
    $before = '<div class="posted_in">' . $before . ' ';
	echo wc_get_product_category_list( $product->get_id(), ', ', $before, '</div>' );
	unset( $before );

	?>
    <div class="single-post-footer">
        <div class="container">
	        <?php
            // Tags
	        echo wc_get_product_tag_list( $product->get_id(), '', '<div class="tags-links">', '</div>' );

	        /**
	         * woocommerce_share hook.
	         *
	         * @see silicon_wc_shares() 10
	         */
	        do_action( 'woocommerce_share' ); // Sharing plugins can hook into here

	        ?>
        </div>
    </div>
    <?php

	/**
	 * woocommerce_product_meta_end hook.
	 */
    do_action( 'woocommerce_product_meta_end' );

    ?>

</div>
