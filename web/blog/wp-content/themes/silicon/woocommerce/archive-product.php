<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version       2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();

/**
 * woocommerce_before_main_content hook.
 *
 * @see WC_Structured_Data::generate_website_data() - 30
 * @see silicon_wc_open_wrapper() - 5
 */
do_action( 'woocommerce_before_main_content' );

/**
 * woocommerce_archive_description hook.
 */
do_action( 'woocommerce_archive_description' );

if ( have_posts() ) :

	get_template_part( 'template-parts/shop/shop', silicon_wc_layout() );

elseif ( ! woocommerce_product_subcategories( array(
	'before' => woocommerce_product_loop_start( false ),
	'after'  => woocommerce_product_loop_end( false )
) ) ) :

	/**
	 * woocommerce_no_products_found hook.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );

endif;

/**
 * woocommerce_after_main_content hook.
 *
 * @see silicon_wc_close_wrapper() 5
 */
do_action( 'woocommerce_after_main_content' );

get_footer();
