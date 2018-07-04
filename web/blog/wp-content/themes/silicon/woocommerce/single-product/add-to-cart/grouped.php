<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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
 * @version       3.0.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Product $product */
/** @var WP_Post $post */
global $product, $post;

/**
 * woocommerce_before_add_to_cart_form hook.
 */
do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
    <div class="group_table products-group">
        <?php
        $quantities_required     = false;
        /** @var WC_Product $grouped_product */
        foreach ( $grouped_products as $grouped_product ) :
            $post_object = get_post( $grouped_product->get_id() );
            $quantities_required = $quantities_required || ( $grouped_product->is_purchasable() && ! $grouped_product->has_options() );
            setup_postdata( $GLOBALS['post'] =& $post_object );
            ?>
            <div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="product-quantity-wrapper">
                    <?php
                    if ( ! $grouped_product->is_purchasable() || $grouped_product->has_options() ) :
                        woocommerce_template_loop_add_to_cart();
                    elseif ( $grouped_product->is_sold_individually() ) : ?>
                        <input type="checkbox"
                               name="<?php echo esc_attr( 'quantity[' . $grouped_product->get_id() . ']' ); ?>"
                               value="1" class="wc-silicon-grouped-product-add-to-cart-checkbox">
                        <?php
                    else :
                        /**
                         * woocommerce_before_add_to_cart_quantity hook.
                         *
                         * @since 3.0.0.
                         */
                        do_action( 'woocommerce_before_add_to_cart_quantity' );

                        woocommerce_quantity_input( array(
                            'input_name'  => 'quantity[' . $grouped_product->get_id() . ']',
                            'input_value' => isset( $_POST['quantity'][ $grouped_product->get_id() ] ) ? wc_stock_amount( $_POST['quantity'][ $grouped_product->get_id() ] ) : 0,
                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product ),
                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product->get_max_purchase_quantity(), $grouped_product ),
                        ) );

                        /**
                         * woocommerce_after_add_to_cart_quantity hook.
                         *
                         * @since 3.0.0.
                         */
                        do_action( 'woocommerce_after_add_to_cart_quantity' );

                    endif; ?>
                </div>
                <div class="label">
                    <label for="product-<?php echo esc_attr( $grouped_product->get_id() ); ?>">
                        <?php
                        if ( $grouped_product->is_visible() ) {
                            echo sprintf( '<a href="%1$s" class="link-color link-hover-color">%2$s</a>',
                                esc_url( apply_filters( 'woocommerce_grouped_product_list_link', get_permalink(), $grouped_product->get_id() ) ),
                                get_the_title()
                            );
                        } else {
                            echo get_the_title();
                        }
                        ?>
                    </label>
                </div>
                <?php

                /**
                 * woocommerce_grouped_product_list_before_price hook.
                 *
                 * @param WC_Product $grouped_product
                 */
                do_action( 'woocommerce_grouped_product_list_before_price', $grouped_product );

                ?>
                <div class="price">
                    <?php
                    echo trim( $grouped_product->get_price_html() );
                    echo wc_get_stock_html( $grouped_product );
                    ?>
                </div>
            </div>
            <?php
        endforeach;
        wp_reset_postdata();
        ?>
    </div>

    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"/>

    <?php
    if ( $quantities_required ) :

        /**
         * woocommerce_before_add_to_cart_button hook.
         */
        do_action( 'woocommerce_before_add_to_cart_button' );

        ?>

        <button type="submit"
                class="btn btn-pill btn-solid btn-primary single_add_to_cart_button margin-top-none"
        ><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

        <?php

        /**
         * woocommerce_after_add_to_cart_button hook.
         */
        do_action( 'woocommerce_after_add_to_cart_button' );

    endif;
    ?>

</form>

<?php

/**
 * woocommerce_after_add_to_cart_form hook.
 */
do_action( 'woocommerce_after_add_to_cart_form' );
