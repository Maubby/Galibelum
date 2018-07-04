<?php
/**
 * Theme AJAX actions
 *
 * @author 8guild
 */

if ( ! function_exists( 'silicon_load_posts' ) ) :
	/**
	 * Load More posts in blog
	 *
	 * AJAX callback for action "silicon_posts_load_more"
	 */
	function silicon_load_posts() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'silicon-ajax' ) ) {
			wp_send_json_error( esc_html_x( 'Wrong nonce', 'ajax request', 'silicon' ) );
		}

		$per_page = (int) get_option( 'posts_per_page' );
		$paged    = (int) $_POST['page'];

		$query = new WP_Query( array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'paged'               => $paged,
			'posts_per_page'      => $per_page,
			'ignore_sticky_posts' => true,
		) );

		if ( ! $query->have_posts() ) {
			wp_send_json_error( esc_html_x( 'Posts not found', 'ajax request', 'silicon' ) );
		}

		$posts = array();
		while ( $query->have_posts() ) {
			$query->the_post();
			ob_start();
			echo '<div class="grid-item">';
			get_template_part( 'template-parts/tiles/post-tile' );
			echo '</div>';

			$posts[] = silicon_content_encode( ob_get_clean() );
		}
		wp_reset_postdata();
		wp_send_json_success( $posts );
	}
endif;

if ( is_admin() ) {
	add_action( 'wp_ajax_silicon_posts_load_more', 'silicon_load_posts' );
	add_action( 'wp_ajax_nopriv_silicon_posts_load_more', 'silicon_load_posts' );
}