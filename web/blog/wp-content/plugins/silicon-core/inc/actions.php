<?php
/**
 * Custom actions
 *
 * @author 8guild
 */

if ( ! function_exists( 'silicon_photoswipe' ) ) :
	/**
	 * Add PhotoSwipe (.pswp) element to DOM
	 *
	 * @hooked silicon_footer_after 1000
	 */
	function silicon_photoswipe() {
		echo file_get_contents( SILICON_PLUGIN_ROOT . '/assets/photoswipe/template.html' );
	}
endif;

add_action( 'silicon_footer_after', 'silicon_photoswipe', 999 );
