<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) : ?>

	<div class="meta"><em class="woocommerce-review__awaiting-approval"><?php esc_attr_e( 'Your review is awaiting approval', 'silicon' ); ?></em></div>

<?php else : ?>

	<div class="meta">
		<h4 class="woocommerce-review__author" itemprop="author"><?php comment_author(); ?></h4>
        <?php
        if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) :
			echo '<em class="woocommerce-review__verified verified">(' . esc_html__( 'verified owner', 'silicon' ) . ')</em> ';
		endif; ?>
	</div>

<?php endif;
