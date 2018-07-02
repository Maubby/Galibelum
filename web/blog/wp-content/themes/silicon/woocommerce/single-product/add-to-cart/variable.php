<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes, 8guild
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Product $product */
global $product;

$attribute_keys = array_keys( $attributes );

/**
 * woocommerce_before_add_to_cart_form hook.
 */
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data'
      data-product_id="<?php echo absint( $product->get_id() ); ?>"
      data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ) ?>"
>

    <?php

    /**
     * woocommerce_before_variations_form hook.
     */
    do_action( 'woocommerce_before_variations_form' );

    ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'silicon' ); ?></p>
	<?php else : ?>
		<div class="variations">
            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                <div class="variation-inner">
                    <div class="label">
                        <label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label>
                    </div>
                    <div class="value">
                        <?php
                        $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
                        wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
                        echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations text-danger" href="#">' . esc_html__( 'Clear', 'silicon' ) . '</a>' ) : '';
                        ?>
                    </div>
                </div>
            <?php endforeach;?>
		</div>

		<?php

		/**
		 * woocommerce_before_add_to_cart_button hook.
		 */
        do_action( 'woocommerce_before_add_to_cart_button' );

        ?>

        <div class="single_variation_wrap">
			<?php
			/**
			 * woocommerce_before_single_variation Hook.
			 */
			do_action( 'woocommerce_before_single_variation' );

			/**
			 * woocommerce_single_variation hook.
			 *
			 * Used to output the cart button and placeholder for variation data.
			 *
			 * @since  2.4.0
			 * @see    woocommerce_single_variation() 10 Empty div for variation data.
			 * @see    woocommerce_single_variation_add_to_cart_button() 20 Qty and cart button.
			 */
			do_action( 'woocommerce_single_variation' );

			/**
			 * woocommerce_after_single_variation Hook.
			 */
			do_action( 'woocommerce_after_single_variation' );
			?>
        </div>

		<?php

		/**
		 * woocommerce_after_add_to_cart_button hook.
		 */
        do_action( 'woocommerce_after_add_to_cart_button' );

	endif; ?>

	<?php

	/**
	 * woocommerce_after_variations_form hook.
	 */
    do_action( 'woocommerce_after_variations_form' );

    ?>

</form>

<?php

/**
 * woocommerce_after_add_to_cart_form hook.
 */
do_action( 'woocommerce_after_add_to_cart_form' );
