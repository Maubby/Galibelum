<?php

/**
 * Overrides the WooCommerce Recent Reviews widget
 *
 * @see    WC_Widget_Recent_Reviews
 * @author 8guild
 */
class Silicon_Widget_WC_Recent_Reviews extends WC_Widget_Recent_Reviews {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $comments, $comment;

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			$this->widget_start( $args, $instance );

			echo apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget">' );

			foreach ( (array) $comments as $comment ) {
				$product = wc_get_product( $comment->comment_post_ID );
				$rating  = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				wc_get_template( 'content-widget-review.php', array(
					'product' => $product,
					'comment' => $comment,
					'rating'  => $rating,
				) );
			}

			echo apply_filters( 'woocommerce_after_widget_product_list', '</ul>' );

			$this->widget_end( $args );
		}

		echo silicon_content_decode( $this->cache_widget( $args, ob_get_clean() ) );
	}
}
