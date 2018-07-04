<?php
/**
 * The template for displaying review widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-review.php.
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** @var WC_Product $product */
/** @var WP_Comment $comment */
/** @var float $rating */

?>
<div class="product-item">
	<div class="widget-product-thumb">
		<?php printf( '<a href="%1$s">%2$s</a>', esc_url( get_comment_link( $comment ) ), $product->get_image() ); ?>
	</div>
	<div class="widget-product-inner">
		<h4 class="product-title">
			<a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>" class="navi-link-color navi-link-hover-color">
				<?php echo wp_kses_post( $product->get_name() ); ?>
			</a>
		</h4>
		<?php

		// rating
		echo wc_get_rating_html( $rating );

		// author
		echo '<div class="product-reviewer">' . sprintf( esc_html__( 'by %s', 'silicon' ), get_comment_author( $comment ) ) . '</div>';
		?>
	</div>
</div>
