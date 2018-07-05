<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcodes
 *
 * @author 8guild
 */
class Silicon_Shortcodes {
	/**
	 * Instance of class
	 *
	 * @var null|Silicon_Shortcodes
	 */
	private static $instance;

	/**
	 * List of shortcodes
	 *
	 * @var array
	 */
	protected $shortcodes = array();

	/**
	 * Create an instance
	 *
	 * @return Silicon_Shortcodes
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {}

	/**
	 * Initialize a module
	 */
	public function init() {
		add_action( 'init', array( $this, 'load' ) );
		add_filter( 'silicon_shortcode_is_cache', array( $this, 'disable_cache' ), 10, 2 );
		add_action( 'silicon_shortcode_render_before', array( $this, 'enqueue_scripts' ) );
		add_action( 'silicon_shortcode_render_before', array( $this, 'enqueue_fonts' ), 10, 2 );
	}

	/**
	 * Add shortcodes to WordPress
	 */
	public function load() {
		/**
		 * This filter allows to change the directory, where shortcodes stored
		 *
		 * @param string $path Absolute path to shortcodes' directory
		 */
		$path  = apply_filters( 'silicon_shortcodes_dir', SILICON_PLUGIN_ROOT . '/shortcodes' );
		$files = silicon_get_dir_contents( wp_normalize_path( $path ), 'silicon' );

		/**
		 * Filter the shortcodes list. The best place to add or remove shortcode(s).
		 *
		 * @param array $shortcodes Shortcodes list
		 */
		$this->shortcodes = apply_filters( 'silicon_shortcodes_list', array_keys( $files ) );

		// add shortcodes
		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, 'render' ) );
		}
	}

	/**
	 * Get shortcode output
	 *
	 * @param array       $atts      Shortcode attributes
	 * @param string|null $content   Shortcode content
	 * @param string      $shortcode Shortcode tag
	 *
	 * @return string Shortcode HTML
	 */
	public function render( $atts = array(), $content = null, $shortcode = '' ) {
		/**
		 * Fires before the shortcode content will be rendered
		 *
		 * @param string $shortcode Shortcode tag
		 * @param array  $atts      Shortcode attributes
		 * @param mixed  $content   Shortcode content
		 */
		do_action( 'silicon_shortcode_render_before', $shortcode, $atts, $content );

		/**
		 * Whether to use a cache?
		 *
		 * This filter allows you to disable shortcode caching
		 *
		 * For example you can completely disable cache for all shortcodes
		 *
		 * @example
		 * add_filter( 'silicon_shortcode_is_cache', '__return_false' )
		 *
		 * Or you can disable cache for a specific shortcode
		 *
		 * @example
		 * add_filter( 'silicon_shortcode_is_cache', function ( $is_cache, $shortcode ) {
		 *   return 'silicon_button' === $shortcode ? false : true;
		 * }, 10, 2 );
		 *
		 * @param bool   $is_cache  By default caching in enabled
		 * @param string $shortcode Shortcode tag
		 */
		if ( apply_filters( 'silicon_shortcode_is_cache', true, $shortcode )
		     && (bool) absint( silicon_get_option( 'cache_is_shortcodes', 1 ) )
		) {
			$is_cache = true;
		} else {
			$is_cache = false;
		}

		if ( $is_cache ) {
			$key = silicon_get_cache_key( array(
				'post'      => get_queried_object_id(),
				'shortcode' => $shortcode,
				'atts'      => $atts,
				'content'   => $content,
			), "{$shortcode}_" );

			$cached = get_transient( $key );
			if ( false === $cached ) {
				$template = $this->locate_template( $shortcode );
				$output   = $this->load_template( $template, $atts, $content, $shortcode );

				/**
				 * Filter the expiration for shortcode cache in seconds.
				 *
				 * Default is 1 day.
				 *
				 * @param int    $expiration Time until expiration in seconds.
				 * @param string $shortcode  Shortcode name
				 */
				$expiration = apply_filters( 'silicon_shortcode_cache_expiration', 86400, $shortcode );
				$value      = silicon_content_encode( $output );
				set_transient( $key, $value, $expiration );

				unset( $template, $expiration, $value );
			} else {
				$output = silicon_content_decode( $cached );
			}

			unset( $key, $cached );
		} else {
			$template = $this->locate_template( $shortcode );
			$output   = $this->load_template( $template, $atts, $content, $shortcode );
			unset( $template );
		}

		/**
		 * Fires when output is ready
		 *
		 * @param string $shortcode Shortcode tag
		 * @param array  $atts      Shortcode attributes
		 * @param mixed  $content   Shortcode content
		 */
		do_action( 'silicon_shortcode_render_after', $shortcode, $atts, $content );

		return $output;
	}

	/**
	 * Disable cache for some shortcodes
	 *
	 * @param bool   $is_cache  Whether to enable or disable cache
	 * @param string $shortcode Shortcode tag
	 *
	 * @return bool
	 */
	public function disable_cache( $is_cache, $shortcode ) {
		// disable cache for this shortcodes
		$shortcodes = array(
			'silicon_button',
		);

		return ( ! in_array( $shortcode, $shortcodes ) );
	}

	/**
	 * Enqueue the shortcode scripts on demand
	 *
	 * This function will cache the recently loaded shortcodes.
	 * This will guarantee that each shortcode load their assets only once
	 *
	 * @param string $shortcode Shortcode tag
	 */
	function enqueue_scripts( $shortcode ) {
		$key   = 'loaded_shortcodes';
		$group = 'silicon_shortcodes';

		// check if shortcode is already loaded
		$loaded = wp_cache_get( $key, $group );
		if ( false !== $loaded && is_array( $loaded ) && in_array( $shortcode, $loaded ) ) {
			return;
		}

		switch ( $shortcode ) {
			case 'silicon_counter':
				wp_enqueue_script( 'counterup' );
				break;

			case 'silicon_map':
			case 'silicon_contacts_card':
				if ( wp_script_is( 'gmap3', 'registered' ) ) {
					wp_enqueue_script( 'gmap3' );
				}
				break;

			case 'silicon_gallery':
			case 'silicon_portfolio_grid':
				wp_enqueue_style( 'photoswipe' );
				wp_enqueue_script( 'photoswipe' );
				break;

			case 'silicon_video_button':
				wp_enqueue_style( 'magnific-popup' );
				wp_enqueue_script( 'magnific-popup' );
				break;

			case 'silicon_cta':
				wp_enqueue_script( 'downcount' );
				break;
		}

		if ( ! is_array( $loaded ) ) {
			$loaded = array();
		}

		// add recently loaded shortcode to list
		$loaded[] = $shortcode;

		// cache for -1 seconds in case if some persistent storage used
		// (like memcached or redis), in other cases cache will live only
		// during the single request
		wp_cache_set( $key, $loaded, $group, - 1 );
	}

	/**
	 * Enqueue the custom fonts, previously registered in Visual Composer
	 *
	 * @param string $shortcode Shortcode tag
	 * @param array  $atts      Shortcode attributes
	 */
	public function enqueue_fonts( $shortcode, $atts ) {
		if ( empty( $atts ) ) {
			return;
		}

		/*
		 * this is required because the shortcode
		 * may require more than one icon pack
		 *
		 * $library will contain the values of "icon_libraries"
		 */
		$libraries = array();
		foreach( (array) $atts as $k => $v ) {
			if ( preg_match( '/icon_library/', $k ) ) {
				$libraries[] = $v;
			}
		}
		unset( $k, $v );

		if ( empty( $libraries ) ) {
			return;
		}

		$key    = 'loaded_fonts';
		$group  = 'silicon_shortcodes';
		$loaded = wp_cache_get( $key, $group );

		if ( ! is_array( $loaded ) ) {
			$loaded = array();
		}

		foreach ( array_unique( $libraries ) as $library ) {
			if ( in_array( $library, $loaded ) ) {
				continue;
			}

			silicon_vc_enqueue_icon_font( $library );
			$loaded[] = $library;
		}

		// this cache should be accessible only during the single request
		wp_cache_set( $key, $loaded, $group, -1 );
	}

	/**
	 * Locate the shortcode template
	 *
	 * @param string $shortcode Shortcode name
	 *
	 * @return string
	 */
	protected function locate_template( $shortcode ) {
		/**
		 * Filter the list of directories with shortcode templates
		 *
		 * @param array $dirs Directories list
		 */
		$dirs = apply_filters( 'silicon_shortcode_template_dirs', array(
			get_stylesheet_directory() . '/shortcodes',
			get_template_directory() . '/shortcodes',
			SILICON_PLUGIN_ROOT . '/shortcodes', // TODO: maybe use \Silicon\Core::path($path) or use concatenation
		) );

		$located = '';
		foreach ( $dirs as $dir ) {
			$dir      = rtrim( $dir, '/\\' );
			$template = "{$dir}/{$shortcode}.php";
			if ( file_exists( $template ) ) {
				$located = $template;
				// break loop after first found template
				break;
			}
		}

		return $located;
	}

	/**
	 * Load the shortcode template
	 *
	 * @param string      $template  Path to shortcode template
	 * @param array       $atts      Shortcode attributes
	 * @param string|null $content   Shortcode content
	 * @param string      $shortcode Shortcode tag
	 *
	 * @return string
	 */
	protected function load_template( $template, $atts = array(), $content = null, $shortcode = '' ) {
		ob_start();
		require $template;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
