<?php
/**
 * Template part for displaying the Shop "No Sidebar 3 Columns"
 *
 * @author 8guild
 */

/**
 * woocommerce_before_shop_loop hook.
 *
 * @see woocommerce_catalog_ordering() 30
 */
do_action( 'woocommerce_before_shop_loop' );

woocommerce_product_loop_start();
woocommerce_product_subcategories();

?>
<div class="masonry-grid isotope-grid col-3 padding-bottom-2x">
	<div class="gutter-sizer"></div>
	<div class="grid-sizer"></div>

	<?php
	while ( have_posts() ) : the_post();

		/**
		 * woocommerce_shop_loop hook.
		 *
		 * @hooked WC_Structured_Data::generate_product_data() - 10
		 */
		do_action( 'woocommerce_shop_loop' );

		echo '<div class="grid-item">';
		wc_get_template_part( 'content', 'product' );
		echo '</div>';
	endwhile;
	?>

</div>
<?php

woocommerce_product_loop_end();

/**
 * woocommerce_after_shop_loop hook.
 *
 * @see woocommerce_pagination() 10
 */
do_action( 'woocommerce_after_shop_loop' );
