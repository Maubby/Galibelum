<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
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
 * @version       2.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

/** @var WC_Product $product */
global $product;

?>
<div id="reviews" class="woocommerce-Reviews">
    <div id="comments">

		<?php if ( have_comments() ) : ?>

            <ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
            </ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                <nav class="post-navigation woocommerce-pagination comment-navigation border-default-top border-default-bottom" role="navigation">
                    <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'silicon' ); ?></h2>
                    <div class="post-nav-prev"><?php
						previous_comments_link( '<i class="si si-angle-left"></i><span class="hidden-xs">' . esc_html__( 'Prev', 'silicon' ) . '</span>' );
						?></div>
                    <div class="post-nav-next border-default-left"><?php
						next_comments_link( '<span class="hidden-xs">' . esc_html__( 'Next', 'silicon' ) . '</span><i class="si si-angle-right"></i>' );
						?></div>
                </nav>

			<?php endif; ?>

			<!--For Divider When Is No Comments Navigation-->
			<div class="shop-single-reviews-divider border-default-top"></div>

		<?php else : ?>

            <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'silicon' ); ?></p>

		<?php endif; ?>

    </div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
        <div id="review_form_wrapper">
            <div id="review_form">
				<?php
				$comment_form = array(
					'title_reply'    => '',
					'title_reply_to' => esc_html__( 'Leave a Reply to %s', 'silicon' ),
					'logged_in_as'   => '',
					'label_submit'   => esc_html__( 'Submit', 'silicon' ),
				);

				if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
					$comment_form['must_log_in'] = sprintf(
						wp_kses(
							'<p class="must-log-in">You must be <a href="%s">logged in</a> to post a review.</p>',
							array( 'p' => array( 'class' => true ), 'a' => array( 'href' => true ) )
						),
						esc_url( $account_page_url )
					);
				}

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
					$comment_form['comment_field'] = '
                        <div class="comment-form-rating">
                            <label>' . esc_html__( 'Your rating', 'silicon' ) . '</label>
                            <a href="#" data-si-rating="1" title="' . esc_html__( 'Very poor', 'silicon' ) . '">
                                <div class="star-rating star-1"></div>
                            </a>
                            <a href="#" data-si-rating="2" title="' . esc_html__( 'Not that bad', 'silicon' ) . '">
                                <div class="star-rating star-2"></div>
                            </a>
                            <a href="#" data-si-rating="3" title="' . esc_html__( 'Average', 'silicon' ) . '">
                                <div class="star-rating star-3"></div>
                            </a>
                            <a href="#" data-si-rating="4" title="' . esc_html__( 'Good', 'silicon' ) . '">
                                <div class="star-rating star-4"></div>
                            </a>
                            <a href="#" data-si-rating="5" title="' . esc_html__( 'Perfect', 'silicon' ) . '">
                                <div class="star-rating star-5"></div>
                            </a>
                            <input type="hidden" name="rating" value="">
						</div>';
				}

				$comment_form['comment_field'] .= sprintf(
					'<div class="comment-form-comment">
                        <label for="comment" class="sr-only">%1$s</label>
                        <textarea name="comment" id="comment" class="input-rounded" rows="6" aria-required="true" placeholder="%1$s" required></textarea>
                    </div>',
					esc_html__( 'Your review', 'silicon' )
				);

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
            </div>
        </div>

	<?php else : ?>

        <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'silicon' ); ?></p>

	<?php endif; ?>
</div>
