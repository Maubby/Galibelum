<?php
/**
 * Order tracking form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/form-tracking.php.
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
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

?>

<form action="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" method="post" class="track_order">

	<p><?php esc_html_e( 'To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.', 'silicon' ); ?></p>

	<div>
        <label for="orderid"><?php esc_html_e( 'Order ID', 'silicon' ); ?></label>
        <input class="input-text" type="text" name="orderid" id="orderid"
               placeholder="<?php esc_attr_e( 'Found in your order confirmation email.', 'silicon' ); ?>">
    </div>
	<div>
        <label for="order_email"><?php esc_html_e( 'Billing email', 'silicon' ); ?></label>
        <input class="input-text" type="text" name="order_email" id="order_email"
               placeholder="<?php esc_attr_e( 'Email you used during checkout.', 'silicon' ); ?>">
    </div>
	<div class="clear"></div>

	<div class="form-row">
        <button type="submit" name="track" class="btn btn-solid btn-pill btn-primary"><?php esc_html_e( 'Track', 'silicon' ); ?></button>
    </div>
	<?php wp_nonce_field( 'woocommerce-order_tracking' ); ?>

</form>
