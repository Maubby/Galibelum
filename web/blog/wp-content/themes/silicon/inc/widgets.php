<?php
/**
 * Theme widgets
 *
 * @author 8guild
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register widget area(s)
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function silicon_widgets_init() {

	/* Register Sidebars */

	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'silicon' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Add widgets here.', 'silicon' ),
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header Buttons', 'silicon' ),
		'id'            => 'sidebar-header-buttons',
		'description'   => esc_html__( 'This sidebar supports only Silicon Button widgets.', 'silicon' ),
		'before_widget' => '<section class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	if ( silicon_is_woocommerce() ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'silicon' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Add WooCommerce widgets here.', 'silicon' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}

	for ( $i = 1, $n = silicon_widgets_footer_sidebars(); $i <= $n; $i ++ ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column ', 'silicon' ) . $i, // whitespace at the end
			'id'            => 'footer-column-' . $i,
			'description'   => esc_html__( 'For use inside Footer', 'silicon' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	unset( $i, $n );

	for ( $i = 1, $n = silicon_widgets_widgetised_sidebars(); $i <= $n; $i ++ ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Widgetized Sidebar ', 'silicon' ) . $i, // whitespace at the end
			'id'            => 'widgetized-sidebar-' . $i,
			'description'   => esc_html__( 'For use inside Widgetized Area', 'silicon' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	unset( $i, $n );

	if ( silicon_is_bbp() ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Forum Sidebar', 'silicon' ),
			'id'            => 'sidebar-forum',
			'description'   => esc_html__( 'For use on forum pages.', 'silicon' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}


	/* Register Widgets */

	register_widget( 'Silicon_Widget_Subscription' );
	register_widget( 'Silicon_Widget_Recent_Posts' );
	register_widget( 'Silicon_Widget_Recent_Posts_Carousel' );
	register_widget( 'Silicon_Widget_Contacts' );

	// Install Silicon plugin to unlock more widgets
	if ( defined( 'SILICON_PLUGIN_VERSION' ) ) {
		register_widget( 'Silicon_Widget_Gallery' );
		register_widget( 'Silicon_Widget_Button' );
		register_widget( 'Silicon_Widget_Socials' );
		register_widget( 'Silicon_Widget_Map' );
		register_widget( 'Silicon_Widget_Author' );
	}

	if ( silicon_is_woocommerce() ) {
		register_widget( 'Silicon_Widget_WC_Price_Filter' );
		register_widget( 'Silicon_Widget_WC_Recent_Reviews' );
	}

	if ( silicon_is_bbp() ) {
		register_widget( 'Silicon_Widget_BBP_Login' );
	}
}

add_action( 'widgets_init', 'silicon_widgets_init' );

/**
 * Autoloader for Widgets
 *
 * @param string $widget Widget class
 *
 * @return bool
 */
function silicon_widgets_loader( $widget ) {
	if ( false === stripos( $widget, 'Silicon_Widget' ) ) {
		return true;
	}

	// convert class name to file
	$chunks = array_filter( explode( '_', strtolower( $widget ) ) );

	/**
	 * Filter the widget file name
	 *
	 * @param string $file   File name according to WP coding standards
	 * @param string $widget Class name
	 */
	$class = apply_filters( 'silicon_widget_file', 'class-' . implode( '-', $chunks ) . '.php', $widget );

	/**
	 * Filter the directories where widgets class will be loaded
	 *
	 * @param array $targets Directories
	 */
	$targets = apply_filters( 'silicon_widget_directories', array(
		SILICON_STYLESHEET_DIR . '/widgets',
		SILICON_TEMPLATE_DIR . '/widgets',
	) );

	foreach ( $targets as $target ) {
		if ( file_exists( $target . '/' . $class ) ) {
			require $target . '/' . $class;
			break;
		}
	}

	return true;
}

spl_autoload_register( 'silicon_widgets_loader' );

/**
 * Get footer sidebars
 *
 * Based on Theme Options > Footer > Layout
 *
 * @see inc/options.php
 * @see silicon_widgets_init()
 *
 * @return int
 */
function silicon_widgets_footer_sidebars() {
	$layout = esc_attr( silicon_get_option( 'footer_layout', 'four-two' ) );
	$map    = array(
		'copyright'   => 0,
		'one'         => 1,
		'two'         => 2,
		'three'       => 3,
		'four'        => 4,
		'one-one'     => 2,
		'two-one'     => 3,
		'three-one'   => 4,
		'four-one'    => 5,
		'one-two'     => 3,
		'two-two'     => 4,
		'three-two'   => 5,
		'four-two'    => 6,
		'one-three'   => 4,
		'two-three'   => 5,
		'three-three' => 6,
		'four-three'  => 7,
		'one-four'    => 5,
		'two-four'    => 6,
		'three-four'  => 7,
		'four-four'   => 8,
	);

	$num = array_key_exists( $layout, $map ) ? $map[ $layout ] : 6;

	/**
	 * Filter the number of sidebars appears in Footer
	 *
	 * @param int    $num    Number of sidebars
	 * @param string $layout Layout from Theme Options
	 */
	return (int) apply_filters( 'silicon_footer_sidebars', $num, $layout );
}

/**
 * Get widgetised sidebars number
 *
 * @see silicon_widgets_init()
 *
 * @return int
 */
function silicon_widgets_widgetised_sidebars() {
	$num = silicon_get_option( 'advanced_widgetised_sidebars_num', 4 );

	/**
	 * Filter the number of Widgetized sidebars
	 *
	 * @param int $num Number of sidebars
	 */
	return absint( apply_filters( 'silicon_widgetized_sidebars', $num ) );
}

/**
 * Remove all widgets except Silicon Button from the Navbar Buttons sidebar
 *
 * On both admin and frontend
 *
 * @param array $sidebars_widgets A list of sidebars and their widgets
 *
 * @return array
 */
function silicon_widgets_buttons_sidebar( $sidebars_widgets ) {
	$sidebar = 'sidebar-navbar-buttons';
	if ( empty( $sidebars_widgets[ $sidebar ] ) ) {
		return $sidebars_widgets;
	}

	foreach ( (array) $sidebars_widgets[ $sidebar ] as $k => $widget ) {
		if ( false === stripos( $widget, 'silicon_button' ) ) {
			unset( $sidebars_widgets[ $sidebar ][ $k ] );
		}

		continue;
	}

	return $sidebars_widgets;
}

add_filter( 'sidebars_widgets', 'silicon_widgets_buttons_sidebar' );
