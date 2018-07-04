<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form method="get"
      action="<?php echo esc_url( home_url( '/' ) ); ?>"
      class="woocommerce-product-search search-box"
      role="search" autocomplete="off">
    <input type="text" name="s"
           id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"
           class="search-field"
           placeholder="<?php echo esc_attr__( 'Search products', 'silicon' ); ?>"
           value="<?php echo esc_attr( trim( get_search_query( false ) ) ); ?>">
    <input type="hidden" name="post_type" value="product">
    <button type="submit"><i class="si si-search"></i></button>
</form>
