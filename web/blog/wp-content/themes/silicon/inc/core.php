<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function silicon_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'silicon', SILICON_TEMPLATE_DIR . '/languages' );

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Enable the custom logo for WP4.5+
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo' );

	/**
	 * Enable WooCommerce support
	 *
	 * @link https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	 */
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
	 * Register the nav menu locations
	 */
	register_nav_menus( array(
		'topbar'    => esc_html__( 'Topbar', 'silicon' ),
		'primary'   => esc_html__( 'Primary', 'silicon' ),
		// 'secondary' => esc_html__( 'Secondary', 'silicon' ),
	) );

	/*
	 * Switch default core markup for search form, comment form
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats
	 *
	 * @link https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'image',
		'gallery',
		'video',
		'audio',
		'quote',
		'link',
		'chat',
	) );
}

if ( ! function_exists( 'silicon_assets_front' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function silicon_assets_front() {
		// Fonts
		silicon_custom_fonts();

		// Icons
		wp_enqueue_style( 'silicon-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/silicon-icons.min.css', array(), null, 'screen' );
		wp_enqueue_style( 'socicon', SILICON_TEMPLATE_URI . '/stylesheets/vendor/socicon.min.css', array(), null, 'screen' );
		silicon_custom_font_icons(); // maybe enqueue custom icon fonts, @see silicon_options_advanced()

		// Styles
		wp_enqueue_style( 'bootstrap', SILICON_TEMPLATE_URI . '/stylesheets/vendor/bootstrap.min.css', array(), null, 'screen' );
		wp_enqueue_style( 'silicon', silicon_get_theme_file_uri( '/assets/stylesheets/theme.min.css' ), array(), null, 'screen' );
		wp_add_inline_style( 'silicon', silicon_compiled_css() );


		// Scripts
		wp_enqueue_script( 'silicon-plugins', SILICON_TEMPLATE_URI . '/js/vendor/plugins.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'silicon', silicon_get_theme_file_uri( '/assets/js/theme.min.js' ), array(), null, true );
		wp_localize_script( 'silicon', 'silicon', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );

		// Shortcode animations
		if ( ! wp_script_is( 'aos' ) && silicon_is_animation() ) {
			wp_enqueue_style( 'aos', SILICON_TEMPLATE_URI . '/stylesheets/vendor/aos.min.css', array(), null );
			wp_enqueue_script( 'aos', SILICON_TEMPLATE_URI . '/js/vendor/aos.min.js', array(), null, true );
		}

		// WooCommerce add-to-cart, etc
		if ( silicon_is_woocommerce() ) {
			wp_enqueue_script( 'silicon-wc', SILICON_TEMPLATE_URI . '/js/wc.js', array( 'jquery' ), null, true );
		}

		// Intro sections
		if ( silicon_is_intro() ) {
			wp_enqueue_style( 'silicon-intro', SILICON_TEMPLATE_URI . '/stylesheets/intros.css', array(), null );
			wp_enqueue_script( 'silicon-intro', SILICON_TEMPLATE_URI . '/js/intros.js', array( 'jquery' ), null, true );
		}

		// WordPress comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;

if ( ! function_exists( 'silicon_compiled_css' ) ) :
	/**
	 * Get compiled CSS
	 *
	 * @return string
	 */
	function silicon_compiled_css() {
		$css = get_option( SILICON_COMPILED, false );
		if ( empty( $css ) ) {
			return '';
		}

		return wp_strip_all_tags( stripslashes( trim( $css ) ), true );
	}
endif;

if ( ! function_exists( 'silicon_custom_font_icons' ) ) :
	/**
	 * Enqueue the custom font icon links provided in Theme Options > Advanced section
	 *
	 * @see silicon_options_advanced()
	 * @see silicon_assets_front()
	 */
	function silicon_custom_font_icons() {
		$links = silicon_get_option( 'advanced_custom_font_icons', array() );
		if ( empty( $links ) ) {
			return;
		}

		$links = explode( "\r\n", $links );
		$links = array_filter( $links );

		foreach ( (array) $links  as $i => $link ) {
			wp_enqueue_style( "silicon-custom-icon-{$i}", esc_url( trim( $link ) ), array(), null );
		}
	}
endif;

if ( ! function_exists( 'silicon_custom_fonts' ) ) :
	/**
	 * Enqueue the Google Fonts from Theme Options
	 *
	 * @see silicon_options_typography()
	 * @see silicon_assets_front()
	 */
	function silicon_custom_fonts() {
		/**
		 * Filter the theme fonts
		 *
		 * @param array $fonts Key is a slug for {@see wp_enqueue_style()}
		 */
		$fonts = apply_filters( 'silicon_fonts', array(
			'silicon-body-font'       => silicon_get_option( 'typography_font_for_body' ),
			'silicon-headings-font'   => silicon_get_option( 'typography_font_for_headings' ),
			'silicon-navigation-font' => silicon_get_option( 'typography_font_for_navigation' ),
		) );

		foreach ( $fonts as $slug => $font ) {
			if ( empty( $font ) || ( ! is_array( $font ) || ! array_key_exists( 'link', $font ) ) ) {
				continue;
			}

			wp_enqueue_style( $slug, silicon_google_font_url( $font['link'] ), array(), null, 'screen' );
		}
	}
endif;

if ( ! function_exists( 'silicon_assets_admin' ) ) :
	/**
	 * Enqueue scripts in the WordPress Dashboard
	 *
	 * @param string $page The current admin page.
	 */
	function silicon_assets_admin( $page ) {
		wp_enqueue_style( 'silicon-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/silicon-icons.min.css', array(), null, 'screen' );
		wp_enqueue_style( 'socicon', SILICON_TEMPLATE_URI . '/stylesheets/vendor/socicon.min.css', array(), null, 'screen' );
		wp_enqueue_style( 'silicon-admin', SILICON_TEMPLATE_URI . '/stylesheets/admin.css', array(), null );

		wp_enqueue_script( 'silicon-admin', SILICON_TEMPLATE_URI . '/js/admin.js', array(), null, true );
		if ( 'widgets.php' === $page && defined( 'SILICON_PLUGIN_VERSION' ) ) {
			wp_enqueue_script( 'silicon-widgets', SILICON_TEMPLATE_URI . '/js/widgets.js', array( 'jquery' ), null, true );
		}
	}
endif;

/**
 * Modify TinyMCE. Add "style_formats"
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles#Using_style_formats
 *
 * @param array $init_array
 *
 * @return mixed
 */
function silicon_editor_formats( $init_array ) {
	$style_formats = array(
		array(
			'title'    => esc_html__( 'Lead text', 'silicon' ),
			'selector' => 'p, ul, ol',
			'classes'  => 'lead'
		),
		array(
			'title'   => esc_html__( 'Huge text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-huge'
		),
		array(
			'title'    => esc_html__( 'Extra Large text', 'silicon' ),
			'selector' => 'p, ul, ol',
			'classes'  => 'text-xl'
		),
		array(
			'title'    => esc_html__( 'Large text', 'silicon' ),
			'selector' => 'p, ul, ol',
			'classes'  => 'text-lg'
		),
		array(
			'title'    => esc_html__( 'Small text', 'silicon' ),
			'selector' => 'p, ul, ol',
			'classes'  => 'text-sm'
		),
		array(
			'title'    => esc_html__( 'Extra Small text', 'silicon' ),
			'selector' => 'p, ul, ol',
			'classes'  => 'text-xs'
		),
		array(
			'title'    => esc_html__( 'Drop Cap', 'silicon' ),
			'selector' => 'p',
			'classes'  => 'drop-cap'
		),
		array(
			'title'   => esc_html__( 'UPPERCASE text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-uppercase'
		),
		array(
			'title'   => esc_html__( 'Thin text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-thin'
		),
		array(
			'title'   => esc_html__( 'Extra thin text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-feather'
		),
		array(
			'title'   => esc_html__( 'Normal text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-normal'
		),
		array(
			'title'   => esc_html__( 'Bold text', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-bold'
		),
		array(
			'title'   => esc_html__( 'Text Primary', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-primary'
		),
		array(
			'title'   => esc_html__( 'Text Success', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-success'
		),
		array(
			'title'   => esc_html__( 'Text Info', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-info'
		),
		array(
			'title'   => esc_html__( 'Text Warning', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-warning'
		),
		array(
			'title'   => esc_html__( 'Text Danger', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-danger'
		),
		array(
			'title'   => esc_html__( 'Text Gray', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-gray'
		),
		array(
			'title'   => esc_html__( 'Text Light', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'text-light'
		),
		array(
			'title'   => esc_html__( 'Bg Primary', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-primary'
		),
		array(
			'title'   => esc_html__( 'Background Success', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-success'
		),
		array(
			'title'   => esc_html__( 'Background Info', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-info'
		),
		array(
			'title'   => esc_html__( 'Background Warning', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-warning'
		),
		array(
			'title'   => esc_html__( 'Background Danger', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-danger'
		),
		array(
			'title'   => esc_html__( 'Background Gray', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-gray'
		),
		array(
			'title'   => esc_html__( 'Background Gradient', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'bg-gradient'
		),
		array(
			'title'   => esc_html__( 'Opacity 75', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'opacity-75'
		),
		array(
			'title'   => esc_html__( 'Opacity 50', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'opacity-50'
		),
		array(
			'title'   => esc_html__( 'Opacity 25', 'silicon' ),
			'inline'  => 'span',
			'classes' => 'opacity-25'
		),
		array(
			'title'    => esc_html__( 'Unstyled List', 'silicon' ),
			'selector' => 'ul, ol',
			'classes'  => 'list-unstyled',
		),
		array(
			'title'    => esc_html__( 'Quotation Center', 'silicon' ),
			'selector' => 'blockquote',
			'classes'  => 'text-center',
		),
		array(
			'title'    => esc_html__( 'Quotation Right', 'silicon' ),
			'selector' => 'blockquote',
			'classes'  => 'text-right',
		),
		array(
			'title'  => esc_html__( 'Code', 'silicon' ),
			'inline' => 'code'
		),
	);

	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;
}

/**
 * Add "styleselect" button to TinyMCE second row
 *
 * @param array $buttons TinyMCE Buttons
 *
 * @return mixed
 */
function silicon_editor_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );

	return $buttons;
}

/**
 * Add styles to TinyMCE
 */
function silicon_editor_styles() {
	add_editor_style();
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function silicon_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	$classes[] = 'body-' . silicon_header_layout();

	if ( is_singular() ) {
		$post      = get_post();
		$classes[] = empty( $post->post_title ) ? 'without-title' : 'with-title';
		unset( $post );
	}

	return $classes;
}

/**
 * Remove the Featured Image meta box from pages
 *
 * This theme does not use the featured images on pages
 *
 * @see silicon_page_title()
 */
function silicon_remove_featured_image_on_pages() {
	remove_meta_box( 'postimagediv', 'page', 'side' );
}

if ( ! function_exists( 'silicon_login_css' ) ) :
	/**
	 * Display the custom logo on the login page
	 *
	 * @uses silicon_css_rules()
	 */
	function silicon_login_css() {
		if ( has_custom_logo() ) {
			$logo_id = (int) get_theme_mod( 'custom_logo' );
			$logo    = silicon_get_image_src( $logo_id );
			$meta    = wp_get_attachment_metadata( $logo_id );
			$width   = empty( $meta['width'] ) ? 240 : (int) $meta['width'];
			$height  = empty( $meta['height'] ) ? 80 : (int) $meta['height'];
		} else {
			$logo   = apply_filters( 'silicon_logo_fallback', SILICON_TEMPLATE_URI . '/img/logo.png' );
			$width  = 240;
			$height = 80;
		}

		$width  = $width / 2;
		$height = $height / 2;

		$css = silicon_css_rules( '.login h1 a', array(
			'background-image' => sprintf( 'url(%s)', esc_url( $logo ) ),
			'background-size'  => 'cover',
			'width'            => absint( $width ) . 'px !important',
			'height'           => absint( $height ) . 'px',
		) );

		echo '<style type="text/css">' . $css . '</style>';
	}
endif;

if ( ! function_exists( 'silicon_no_irritating_updates' ) ) :
	/**
	 * Disable the premium plugins update notifications
	 *
	 * @param object $value
	 *
	 * @return mixed
	 */
	function silicon_no_irritating_updates( $value ) {
		if ( empty( $value->response ) ) {
			return $value;
		}

		$blocked = array(
			'js_composer/js_composer.php',
			'revslider/revslider.php'
		);

		$value->response = array_diff_key( $value->response, array_flip( $blocked ) );

		return $value;
	}
endif;

/**
 * Returns the slug name for Theme Options
 *
 * @see silicon_get_option()
 *
 * @return string
 */
function silicon_options_slug() {
	return SILICON_OPTIONS;
}

/**
 * Returns the slug name for Page Settings meta box
 *
 * @see silicon_get_setting()
 *
 * @return string
 */
function silicon_page_settings_slug() {
	return SILICON_PAGE_SETTINGS;
}

/**
 * Returns the all Page Settings keys and their default values
 *
 * @see silicon_get_setting()
 *
 * @param array $defaults Default settings
 *
 * @return array
 */
function silicon_page_settings_defaults( $defaults ) {
	return array_merge( $defaults, array(
		// page title
		'header_is_pt'                      => 'default',
		'header_pt_size'                    => 'default',
		'pt_skin'                           => 'dark',
		'pt_bg_type'                        => 'none',
		'pt_bg_image'                       => 0,
		'pt_bg_color'                       => '#f5f5f5',
		'pt_parallax'                       => 0,
		'pt_parallax_type'                  => 'scroll',
		'pt_parallax_speed'                 => 0.4,
		'pt_parallax_video'                 => '',
		'pt_overlay'                        => 0,
		'pt_overlay_type'                   => 'color',
		'pt_overlay_color'                  => '#000000',
		'pt_overlay_opacity'                => 60,

		// header
		'custom_logo'                       => 0,
		'header_stuck_logo'                 => 0,
		'header_mobile_logo'                => 0,
		'header_layout'                     => 'default',
		'header_is_fullwidth'               => 'default',
		'header_is_sticky'                  => 'default',
		'header_is_floating'                => 'default',
		'header_is_topbar'                  => 'default',
		'header_is_buttons'                 => true,
		'header_utils_is_search'            => 'default',
		'header_utils_is_cart'              => 'default',
		'header_menu_variant'               => 'default',
		'header_appearance_bg'              => 'default',
		'header_appearance_bg_custom'       => 'default', // fallback to Theme Options
		'header_appearance_menu_skin'       => 'default',
		'header_appearance_stuck_bg_color'  => 'default', // fallback to Theme Options
		'header_appearance_stuck_menu_skin' => 'default',
		'header_appearance_topbar_bg'       => 'default',
		'header_appearance_topbar_bg_color' => 'default',

		// footer
		'footer_background'                 => 'default',
		'footer_background_image'           => 'default', // fallback to Theme Options
		'footer_background_color'           => 'default', // fallback to Theme Options
		'footer_overlay_option'             => 'default',
		'footer_overlay_opacity'            => 'default', // fallback to Theme Options
		'footer_overlay_color'              => 'default', // fallback to Theme Options
		'footer_skin'                       => 'default',
		'footer_is_fullwidth'               => 'default',

		// appearance for posts
		'single_layout'                     => 'default',
		'single_is_tile_author'             => 'default',
		'single_is_post_author'             => 'default',
		'single_is_shares'                  => 'default',
		'single_is_featured_image'          => 'default',
	) );
}
