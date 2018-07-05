<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
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
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * woocommerce_before_mini_cart hook.
 */
do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="si-wc-ajax-cart">

    <?php if ( ! WC()->cart->is_empty() ) : ?>

        <div class="woocommerce-mini-cart cart_list product_list_widget product-items <?php echo esc_attr( $args['list_class'] ); ?>">

            <?php

            /**
             * woocommerce_before_mini_cart_contents hook.
             */
            do_action( 'woocommerce_before_mini_cart_contents' );

            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists()
                     && $cart_item['quantity'] > 0
                     && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key )
                ) : ?>
                    <div class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'product-item', $cart_item, $cart_item_key ) ); ?>">
                        <h4 class="product-title">
                            <?php

                            /**
                             * woocommerce_widget_cart_item_quantity filter.
                             *
                             * @param string $quantity HTML formatted quantity
                             * @param array  $cart_item
                             * @param string $cart_item_key
                             */
                            echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span>' . sprintf( '%s x', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key );

                            $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

                            if ( ! $_product->is_visible() ) {
                                echo '<span class="navi-link-hover-color">', $product_name, '</span>';
                            } else {
                                echo sprintf( '<a href="%1$s" class="navi-link-hover-color">%2$s</a>', esc_url( $product_permalink ), $product_name );
                            }

                            ?>
                        </h4>
                        <?php
                        $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

                        echo '<span class="product-price font-family-headings">', $product_price, '</span>';

                        /**
                         * woocommerce_cart_item_remove_link filter
                         *
                         * @param string $remove
                         * @param string $cart_item_key
                         */
                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove-from-cart" data-product_id="%s" data-product_sku="%s"><i class="si si-cross"></i></a>',
                            esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                            esc_attr( $product_id ),
                            esc_attr( $_product->get_sku() )
                        ), $cart_item_key );

                        ?>
                    </div>
                    <?php
                endif;
            endforeach;

            /**
             * woocommerce_mini_cart_contents hook.
             */
            do_action( 'woocommerce_mini_cart_contents' );

            ?>

        </div>

        <footer class="cart-footer">
            <div class="cart-subtotal font-family-headings">
                <div class="column"><?php esc_html_e( 'Subtotal:', 'silicon' ); ?></div>
                <div class="column"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
            </div>

		    <?php

		    /**
		     * woocommerce_widget_shopping_cart_before_buttons hook.
		     */
		    do_action( 'woocommerce_widget_shopping_cart_before_buttons' );

		    /**
		     * woocommerce_widget_shopping_cart_buttons hook.
		     */
		    do_action( 'woocommerce_widget_shopping_cart_buttons' );

		    ?>
        </footer>

    <?php else : ?>

        <div class="padding-top-1x padding-bottom-1x text-center">
            <p class="text-white opacity-50"><?php esc_html_e( 'Your Cart is currently empty.', 'silicon' ); ?></p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
               class="btn btn-pill btn-ghost btn-white"
            ><?php esc_html_e( 'Fill Cart with Goods', 'silicon' ); ?></a>
        </div>

    <?php endif; ?>

</div>

<?php

/**
 * woocommerce_after_mini_cart hook.
 */
do_action( 'woocommerce_after_mini_cart' );
