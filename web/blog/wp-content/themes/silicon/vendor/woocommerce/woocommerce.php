<?php
/**
 * Filters and actions related to WooCommerce plugin
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// skip if WooCommerce is disabled
if ( ! silicon_is_woocommerce() ) {
	return;
}

/**
 * Remove the content wrappers
 *
 * @see woocommerce/archive-product.php
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Remove the built-in breadcrumbs
 *
 * @see woocommerce/archive-product.php
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Remove the built-in Archive and Product description
 *
 * @see woocommerce/archive-product.php
 */
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

/**
 * Remove the badge and product thumbnail
 *
 * @see woocommerce/content-product.php
 * @see silicon_wc_item_thumbnail()
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

if ( ! function_exists( 'silicon_wc_layout' ) ) :
	/**
	 * Returns the template part for Shop
	 *
	 * Based on Theme Options
	 *
	 * @see silicon_options_shop()
	 * @see woocommerce/archive-product.php
	 * @see template-parts/shop/shop-*.php
	 *
	 * @return string
	 */
	function silicon_wc_layout() {
		$layout = silicon_get_setting( 'shop_layout', 'ls-3' );

		/**
		 * Filter the layout type for Shop
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the Child Theme you have to follow the file name convention.
		 * Your file should be named shop-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/shop/shop-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_wc_layout', $layout ) );
	}
endif;


if ( ! function_exists( 'silicon_wc_open_wrapper' ) ) :
	/**
	 * Open the global div.container to wrap the shop page
	 *
	 * @see silicon_wc_close_wrapper()
	 * @see woocommerce/archive-product.php
	 */
	function silicon_wc_open_wrapper() {
		echo '<div class="container">';
	}
endif;

add_action( 'woocommerce_before_main_content', 'silicon_wc_open_wrapper', 5 );

if ( ! function_exists( 'silicon_wc_close_wrapper' ) ) :
	/**
	 * Close the global div.container to wrap the shop page
	 *
	 * @see silicon_wc_open_wrapper()
	 * @see woocommerce/archive-product.php
	 */
	function silicon_wc_close_wrapper() {
		echo '</div>';
	}
endif;

add_action( 'woocommerce_after_main_content', 'silicon_wc_close_wrapper', 5 );

if ( ! function_exists( 'silicon_wc_page_title' ) ) :
	/**
	 * Returns the custom Page Title for WooCommerce Pages
	 *
	 * @param string $title Page Title
	 *
	 * @return string
	 */
	function silicon_wc_page_title( $title ) {
		if ( ! silicon_is_woocommerce() ) {
			return $title;
		}

		if ( is_shop() && apply_filters( 'woocommerce_show_page_title', true ) ) {
			$title = woocommerce_page_title( false );
		}

		return $title;
	}
endif;

add_filter( 'silicon_page_title', 'silicon_wc_page_title' );

if ( ! function_exists( 'silicon_wc_page_title_settings' ) ) :
	/**
	 * Override the Page Settings for shop page
	 *
	 * @param array $settings Page Settings
	 *
	 * @return array
	 */
	function silicon_wc_page_title_settings( $settings ) {
		if ( is_shop() ) {
			$page_id  = wc_get_page_id( 'shop' );
			$slug     = apply_filters( 'silicon_get_setting_slug', '' );
			$settings = silicon_get_meta( $page_id, $slug );
		}

		return $settings;
	}
endif;

add_filter( 'silicon_get_setting_all', 'silicon_wc_page_title_settings' );

/**
 * Remove the opening product link
 *
 * @see woocommerce/content-product.php
 */
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

if ( ! function_exists( 'silicon_wc_item_thumbnail' ) ) :
	/**
	 * Display link to product, the flash and product thumbnail
	 *
	 * @hooked woocommerce_before_shop_loop_item 10
	 * @see    woocommerce/content-product.php
	 */
	function silicon_wc_item_thumbnail() {
		echo '<div class="product-thumb-wrapper">';
		echo '<a href="' . esc_url( get_the_permalink() ) . '" class="product-thumb">';
		wc_get_template( 'loop/sale-flash.php' );
		echo woocommerce_get_product_thumbnail( 'large' );
		echo '</a>';
		echo '</div>';
	}
endif;

add_action( 'woocommerce_before_shop_loop_item', 'silicon_wc_item_thumbnail' );

if ( ! function_exists( 'silicon_wc_item_title' ) ) :
	/**
	 * Show the product title in the product loop
	 *
	 * @hooked woocommerce_shop_loop_item_title 10
	 * @see    woocommerce/content-product.php
	 */
	function silicon_wc_item_title() {
		$before = sprintf( '<h3 class="product-title"><a href="%s" class="navi-link-color navi-link-hover-color">', esc_url( get_the_permalink() ) );
		$after  = '</a></h3>';

		echo silicon_get_text( get_the_title(), $before, $after );
	}
endif;

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'silicon_wc_item_title' );

/**
 * Remove the item rating and price. Change the hook priority
 *
 * @see woocommerce/content-product.php
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

if ( ! function_exists( 'silicon_wc_item_rating' ) ) :
	/**
	 * Show the product item rating
	 *
	 * @hooked woocommerce_after_shop_loop_item_title 15
	 * @see    woocommerce/content-product.php
	 */
	function silicon_wc_item_rating() {
		wc_get_template( 'loop/rating.php' );
	}
endif;

add_action( 'woocommerce_after_shop_loop_item_title', 'silicon_wc_item_rating', 15 );

if ( ! function_exists( 'silicon_wc_item_price' ) ) :
	/**
	 * Show the product item price
	 *
	 * @hooked woocommerce_after_shop_loop_item_title 20
	 * @see    woocommerce/content-product.php
	 */
	function silicon_wc_item_price() {
		wc_get_template( 'loop/price.php' );
	}
endif;

add_action( 'woocommerce_after_shop_loop_item_title', 'silicon_wc_item_price', 20 );

/**
 * Re-assign "Add to cart" button to another hook
 *
 * @see woocommerce_template_loop_add_to_cart()
 * @see woocommerce/content-product.php
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 30 );

/**
 * Remove the closing product link tag
 *
 * @see woocommerce/content-product.php
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if ( ! function_exists( 'silicon_wc_add_to_cart_class' ) ) :
	/**
	 * Remove the .button class from "Add to Cart" link
	 *
	 * @param array $classes Add to cart button classes
	 *
	 * @return array
	 */
	function silicon_wc_add_to_cart_class( $classes ) {
		if ( false !== ( $key = array_search( 'button', $classes ) ) ) {
			unset( $classes[ $key ] );
		}

		return $classes;
	}
endif;

add_filter( 'woocommerce_loop_add_to_cart_class', 'silicon_wc_add_to_cart_class' );

/**
 * Remove the "Result Count" from Shop Catalog
 *
 * @see woocommerce/archive-product.php
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/**
 * Cross Sells
 *
 * Move cross sells under the div.cart-collaterals
 *
 * @see woocommerce/cart/cart.php
 */
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

if ( ! function_exists( 'silicon_wc_cross_sells_num' ) ) :
	/**
	 * Returns the max. number of cross sells products
	 *
	 * @return int
	 */
	function silicon_wc_cross_sells_num() {
		return -1; // do not limit
	}
endif;

add_filter( 'woocommerce_cross_sells_total', 'silicon_wc_cross_sells_num', 50, 0 );

/**
 * Move the "Sale Flash" label inside the .summary
 *
 * @see woocommerce/content-single-product.php
 */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 5 );

/**
 * Remove the product title from summary in favor of Page Title
 *
 * @see woocommerce/content-single-product.php
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

/**
 * Move product rating under the price on single product page
 *
 * @see woocommerce/content-single-product.php
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

/**
 * Remove the separate template for share button
 *
 * Now you can find share button in
 * @see woocommerce/single-product/meta.php
 * @see woocommerce/content-single-product.php
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

if ( ! function_exists( 'silicon_wc_enable_page_settings' ) ) :
	/**
	 * Enable Page Settings for Product
	 *
	 * @param array $screens Post types
	 *
	 * @return array
	 */
	function silicon_wc_enable_page_settings( $screens ) {
		$screens[] = 'product';

		return $screens;
	}
endif;

add_filter( 'silicon_page_settings_screen', 'silicon_wc_enable_page_settings' );

if ( ! function_exists( 'silicon_wc_shares' ) ) :
	/**
	 * Display the sharing buttons in Single Product
	 *
	 * @uses silicon_the_shares()
	 */
	function silicon_wc_shares() {
		if ( false === (bool) silicon_get_option( 'shop_is_single_share', true ) ) {
			return;
		}

		silicon_the_shares();
	}
endif;

add_action( 'woocommerce_share', 'silicon_wc_shares' );

if ( ! function_exists( 'silicon_wc_products_per_page' ) ) :
	/**
	 * Returns the number of posts per shop page, based on Theme Options
	 *
	 * @param int $per_page Number of posts per page
	 *
	 * @return int
	 */
	function silicon_wc_products_per_page( $per_page ) {
		return absint( silicon_get_option( 'shop_products_per_page', 9 ) );
	}
endif;

add_filter( 'loop_shop_per_page', 'silicon_wc_products_per_page', 20 );

if ( ! function_exists( 'silicon_wc_review_after_comment_text' ) ) :
	/**
	 * Display the comment date after the comment text
	 *
	 * @see woocommerce/single-product/review.php
	 */
	function silicon_wc_review_after_comment_text() {
		?>
        <time class="woocommerce-review__published-date text-gray" itemprop="datePublished"
              datetime="<?php echo get_comment_date( 'c' ); ?>"
        ><?php echo get_comment_date( wc_date_format() ); ?></time>
		<?php
	}
endif;

add_action( 'woocommerce_review_after_comment_text', 'silicon_wc_review_after_comment_text' );

if ( ! function_exists( 'silicon_wc_product_cat_links' ) ) :
	/**
	 * Add class .text-gray to each Product Category link
	 *
	 * @param array $links
	 *
	 * @return array
	 */
	function silicon_wc_product_cat_links( $links ) {
		return array_map( function ( $link ) {
			return str_replace( '<a ', '<a class="text-gray" ', $link );
		}, $links );
	}
endif;

add_filter( 'term_links-product_cat', 'silicon_wc_product_cat_links' );

if ( ! function_exists( 'silicon_wc_cart_fragments' ) ) :
	/**
	 * Add cart fragments
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 *
	 * @return array
	 */
	function silicon_wc_cart_fragments( $fragments ) {
		ob_start();
		woocommerce_mini_cart();

		$fragments['div.si-wc-ajax-cart'] = ob_get_clean();

		return $fragments;
	}
endif;

add_filter( 'woocommerce_add_to_cart_fragments', 'silicon_wc_cart_fragments' );

/**
 * Remove the "View Cart" button from the Cart widget
 *
 * @see woocommerce/includes/wc-template-hooks.php
 * @see woocommerce/templates/cart/mini-cart.php
 * @see woocommerce_widget_shopping_cart_button_view_cart()
 */
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

/**
 * Output the proceed to checkout button inside the Cart widget
 *
 * Changes: updated the button classes
 *
 * @see woocommerce/includes/wc-template-hooks.php
 * @see woocommerce/templates/cart/mini-cart.php
 */
function woocommerce_widget_shopping_cart_proceed_to_checkout() {
	echo sprintf( '<a href="%1$s" class="btn btn-pill btn-ghost btn-success btn-block">%2$s</a>',
		esc_url( wc_get_checkout_url() ),
		esc_html__( 'Checkout', 'silicon' )
	);
}

if ( ! function_exists( 'silicon_wc_widget_product_list_before' ) ) :
	/**
	 * Override the "WooCommerce products" widget.
	 * Wrap items into the carousel.
	 *
	 * Affects "WooCommerce products", "WooCommerce top rated products",
	 * "WooCommerce recently viewed", "WooCommerce recent reviews" widgets.
	 *
	 * @see WC_Widget_Products::widget()
	 *
	 * @param string $before HTML markup
	 *
	 * @return string
	 */
	function silicon_wc_widget_product_list_before( $before ) {
		/**
		 * Filter the carousel settings. See owl-carousel.
		 *
		 * @param array $owl Carousel settings
		 */
		$owl = apply_filters( 'silicon_widget_products_carousel', array(
			'nav'   => false,
			'dots'  => true,
			'loop'  => false,
			'items' => 1,
		) );

		$attr = silicon_get_attr( array(
			'class'            => 'owl-carousel products-carousel',
			'data-si-carousel' => $owl,
		) );


		return '<div ' . $attr . '>';
	}
endif;

add_filter( 'woocommerce_before_widget_product_list', 'silicon_wc_widget_product_list_before' );

if ( ! function_exists( 'silicon_wc_widget_product_list_after' ) ) :
	/**
	 * Override the "WooCommerce products" widget.
	 * Close the carousel tag.
	 *
	 * Affects "WooCommerce products", "WooCommerce top rated products",
	 * "WooCommerce recently viewed", "WooCommerce recent reviews" widgets.
	 *
	 * @see WC_Widget_Products::widget()
	 *
	 * @param string $after HTML markup
	 *
	 * @return string
	 */
	function silicon_wc_widget_product_list_after( $after ) {
		return '</div>';
	}
endif;

add_filter( 'woocommerce_after_widget_product_list', 'silicon_wc_widget_product_list_after' );

if ( ! function_exists( 'silicon_wc_order_button' ) ) :
	/**
	 * Modify the classes on WC Order button
	 *
	 * @see    payment.php Template
	 * @hooked woocommerce_order_button_html 10
	 *
	 * @param string $html
	 *
	 * @return mixed
	 */
	function silicon_wc_order_button( $html ) {
		return str_replace(
			'class="button',
			'class="btn btn-solid btn-pill btn-primary',
			$html
		);
	}
endif;

add_filter( 'woocommerce_order_button_html', 'silicon_wc_order_button' );

if ( ! function_exists( 'silicon_wc_after_checkout_form' ) ) :
	/**
	 * Add a space after WC checkout form (right before the footer)
	 *
	 * @param $checkout
	 */
	function silicon_wc_after_checkout_form( $checkout ) {
		echo '<div class="margin-bottom-3x"></div>';
	}
endif;

add_action( 'woocommerce_after_checkout_form', 'silicon_wc_after_checkout_form' );
