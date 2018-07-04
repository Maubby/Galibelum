<?php
/**
 * Core actions
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'silicon_cpt' ) ) :
	/**
	 * Load custom post types
	 */
	function silicon_cpt() {
		$path  = wp_normalize_path( SILICON_PLUGIN_ROOT . '/cpt' );
		$files = silicon_get_dir_contents( $path, 'silicon' );
		$files = array_diff_key( $files, array_flip( array( 'class-silicon-cpt' ) ) ); // TODO: fix this, temporary hack

		$loader = Silicon_Cpt_Loader::instance();
		$loader->init( $files );
	}
endif;

if ( ! function_exists( 'silicon_activation' ) ) :
	/**
	 * Initialize the CPT's and flushing the rewrite rules
	 * on plugin activation
	 *
	 * @see register_activation_hook()
	 */
	function silicon_activation() {
		$loader = Silicon_Cpt_Loader::instance();

		$path  = wp_normalize_path( SILICON_PLUGIN_ROOT . '/cpt' );
		$files = silicon_get_dir_contents( $path, 'silicon' );
		$files = array_diff_key( $files, array_flip( array( 'class-silicon-cpt' ) ) ); // TODO: fix this, temporary hack

		$loader->register( $files );
		flush_rewrite_rules();
	}
endif;

if ( ! function_exists( 'silicon_front_scripts' ) ) :
	/**
	 * Enqueue scripts and styles on front-end
	 *
	 * @hooked wp_enqueue_scripts
	 */
	function silicon_front_scripts() {
		// remove isotope, registered by VC
		if ( wp_script_is( 'isotope', 'registered' ) ) {
			wp_deregister_script( 'isotope' );
		}

		// remove waypoints, registered by VC
		if ( wp_script_is( 'waypoints', 'registered' ) ) {
			wp_deregister_script( 'waypoints' );
		}

		// deregister PhotoSwipe UI from WooCommerce
		if ( silicon_is_woocommerce() && wp_script_is( 'photoswipe-ui-default', 'registered' ) ) {
			wp_deregister_script( 'photoswipe-ui-default' );
		}

		wp_register_style( 'photoswipe', SILICON_PLUGIN_URI . '/photoswipe/photoswipe.min.css', array(), null );
		wp_register_style( 'magnific-popup', SILICON_PLUGIN_URI . '/css/vendor/magnific-popup.min.css', array(), null );

		wp_register_script( 'photoswipe', SILICON_PLUGIN_URI . '/photoswipe/photoswipe.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'counterup', SILICON_PLUGIN_URI . '/js/vendor/counterup.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'downcount', SILICON_PLUGIN_URI . '/js/vendor/jquery.downCount.min.js', array( 'jquery' ), null, true );
		wp_register_script( 'magnific-popup', SILICON_PLUGIN_URI . '/js/vendor/jquery.magnific-popup.min.js', array( 'jquery' ), null, true );

		$gmaps_key = silicon_get_option( 'advanced_gmaps_key' );
		if ( ! empty( $gmaps_key ) ) {
			$url = add_query_arg( 'key', urlencode( $gmaps_key ), '//maps.googleapis.com/maps/api/js' );
			wp_register_script( 'google-maps-api', esc_url( $url ), null, null );
			wp_register_script( 'gmap3', SILICON_PLUGIN_URI . '/js/vendor/gmap3.min.js', array( 'jquery', 'google-maps-api' ), null, true );
			unset( $url );
		}

		if ( silicon_is_animation() ) {
			wp_enqueue_style( 'aos', SILICON_PLUGIN_URI . '/css/vendor/aos.min.css', array(), null );
			wp_enqueue_script( 'aos', SILICON_PLUGIN_URI . '/js/vendor/aos.min.js', array(), null, true );
		}

		wp_enqueue_script( 'silicon-plugin', SILICON_PLUGIN_URI . '/js/theme-core.min.js', array( 'jquery' ), null, true );
	}
endif;

if ( ! function_exists( 'silicon_admin_scripts' ) ) :
	/**
	 * Enqueue scripts and styles on front-end
	 *
	 * @hooked admin_enqueue_scripts
	 */
	function silicon_admin_scripts() {
		wp_enqueue_style( 'silicon', SILICON_PLUGIN_URI . '/css/admin.css', array(), null );
		wp_localize_script( 'jquery', 'siliconPlugin', array(
			'nonce' => wp_create_nonce( 'silicon-plugin' ),
		) );
	}
endif;
