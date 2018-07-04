<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Product $product */
global $product;

if ( isset( $class ) ) {
	$_classes = explode( ' ', $class );
	unset( $class );
} else {
	$_classes = array();
}

/**
 * Filter the "Add to Cart" button class
 *
 * @param array      $class   Button class
 * @param WC_Product $product Product object
 */
$_classes = apply_filters( 'woocommerce_loop_add_to_cart_class', array_merge( $_classes, array(
	'btn',
	'btn-sm',
	'btn-pill',
	'btn-ghost',
	'btn-primary',
) ), $product );

/**
 * Filter the "Add to Cart" button attributes
 *
 * @param array      $attr    Button attributes
 * @param WC_Product $product Product object
 */
$_attr = apply_filters( 'woocommerce_loop_add_to_cart_attr', array(
	'href'             => esc_url( $product->add_to_cart_url() ),
	'data-quantity'    => esc_attr( isset( $quantity ) ? $quantity : 1 ),
	'data-product_id'  => esc_attr( $product->get_id() ),
	'data-product_sku' => esc_attr( $product->get_sku() ),
	'class'            => silicon_get_classes( $_classes ),
	'rel'              => 'nofollow',
) );

$_content = '<i class="si si-cart"></i> ' . $product->add_to_cart_text();

/**
 * Filter the "Add to Cart" button HTML
 *
 * @param string     $button  Button HTML
 * @param WC_Product $product Product object
 */
echo apply_filters( 'woocommerce_loop_add_to_cart_link', silicon_get_tag( 'a', $_attr, $_content ), $product );

unset( $_classes, $_attr );
