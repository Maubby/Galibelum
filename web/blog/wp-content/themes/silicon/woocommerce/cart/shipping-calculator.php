<?php
/**
 * Shipping Calculator
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/shipping-calculator.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes, 8Guild
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( 'no' === get_option( 'woocommerce_enable_shipping_calc' ) || ! WC()->cart->needs_shipping() ) {
	return;
}

do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

	<p><a href="#" class="shipping-calculator-button btn btn-default btn-solid btn-pill"><?php esc_html_e( 'Calculate shipping', 'silicon' ); ?></a></p>

	<section class="shipping-calculator-form" style="display:none;">

        <p class="form-row form-row-wide" id="calc_shipping_country_field">
            <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state"
                    rel="calc_shipping_state">
                <option value=""><?php esc_html_e( 'Select a country&hellip;', 'silicon' ); ?></option>
				<?php
				foreach ( WC()->countries->get_shipping_countries() as $key => $value ) :
					echo sprintf( '<option value="%1$s" %3$s>%2$s</option>',
						esc_attr( $key ),
						esc_html( $value ),
						selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false )
					);
				endforeach;
				?>
            </select>
        </p>

        <p class="form-row form-row-wide" id="calc_shipping_state_field">
			<?php
			$current_cc = WC()->customer->get_shipping_country();
			$current_r  = WC()->customer->get_shipping_state();
			$states     = WC()->countries->get_states( $current_cc );

			if ( is_array( $states ) && empty( $states ) ) : ?>
                <input type="hidden" name="calc_shipping_state" id="calc_shipping_state"
                       placeholder="<?php esc_attr_e( 'State / County', 'silicon' ); ?>"/>
			<?php elseif ( is_array( $states ) ) : ?>
                <span>
                    <select name="calc_shipping_state" id="calc_shipping_state"
                            placeholder="<?php esc_attr_e( 'State / County', 'silicon' ); ?>">
                        <option value=""><?php esc_html_e( 'Select a state&hellip;', 'silicon' ); ?></option>
                        <?php
                        foreach ( $states as $ckey => $cvalue ) :
                            echo sprintf( '<option value="%1$s" %3$s>%2$s</option>',
                                esc_attr( $ckey ),
                                esc_html( $cvalue ),
                                selected( $current_r, $ckey, false )
                            );
                        endforeach;
                        ?>
                    </select>
                </span>
			<?php else : ?>
                <input type="text" name="calc_shipping_state"
                       id="calc_shipping_state" class="input-text"
                       value="<?php echo esc_attr( $current_r ); ?>"
                       placeholder="<?php esc_attr_e( 'State / County', 'silicon' ); ?>">
			<?php endif; ?>
        </p>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_city_field">
				<input type="text" class="input-text"
                       name="calc_shipping_city" id="calc_shipping_city"
                       value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>"
                       placeholder="<?php esc_attr_e( 'City', 'silicon' ); ?>">
			</p>

		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
				<input type="text" class="input-text"
                       name="calc_shipping_postcode" id="calc_shipping_postcode"
                       value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>"
                       placeholder="<?php esc_attr_e( 'Postcode / ZIP', 'silicon' ); ?>">
			</p>

		<?php endif; ?>

        <p>
            <button type="submit" name="calc_shipping" class="btn btn-default btn-solid btn-pill"
                    value="1"><?php esc_html_e( 'Update totals', 'silicon' ); ?></button>
        </p>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php

do_action( 'woocommerce_after_shipping_calculator' );
