<?php
/**
 * Theme functions and definitions
 *
 * @link   https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author 8guild
 */

define( 'SILICON_TEMPLATE_DIR', get_template_directory() );
define( 'SILICON_TEMPLATE_URI', get_template_directory_uri() . '/assets' );
define( 'SILICON_STYLESHEET_DIR', get_stylesheet_directory() );
define( 'SILICON_STYLESHEET_URI', get_stylesheet_directory_uri() );
define( 'SILICON_OPTIONS', 'silicon_options' );
define( 'SILICON_COMPILED', 'silicon_compiled' );
define( 'SILICON_PAGE_SETTINGS', '_silicon_page_settings' );

if ( ! isset( $content_width ) ) {
	/**
	 * Filter the template content width
	 *
	 * @param int $content_width Content width in pixels
	 */
	$content_width = apply_filters( 'silicon_content_width', 1170 );
}

/**
 * Theme functions
 */
require SILICON_TEMPLATE_DIR . '/inc/helpers.php';
require SILICON_TEMPLATE_DIR . '/inc/core.php';
require SILICON_TEMPLATE_DIR . '/inc/template-tags.php';
require SILICON_TEMPLATE_DIR . '/inc/icons.php';

/**
 * Theme hooks
 */
require SILICON_TEMPLATE_DIR . '/inc/hooks.php';
require SILICON_TEMPLATE_DIR . '/inc/ajax.php';
require SILICON_TEMPLATE_DIR . '/inc/options.php';
require SILICON_TEMPLATE_DIR . '/inc/meta-boxes.php';
require SILICON_TEMPLATE_DIR . '/inc/user.php';
require SILICON_TEMPLATE_DIR . '/inc/widgets.php';
require SILICON_TEMPLATE_DIR . '/inc/menus.php';
require SILICON_TEMPLATE_DIR . '/inc/categories.php';
require SILICON_TEMPLATE_DIR . '/inc/customizer.php';
require SILICON_TEMPLATE_DIR . '/inc/walkers.php';
require SILICON_TEMPLATE_DIR . '/inc/comments.php';

/**
 * Vendor, plugins, third-party
 */
require SILICON_TEMPLATE_DIR . '/vendor/tgm/class-tgm-plugin-activation.php';
require SILICON_TEMPLATE_DIR . '/vendor/tgm/init.php';
require SILICON_TEMPLATE_DIR . '/vendor/equip/bootstrap.php';
require SILICON_TEMPLATE_DIR . '/vendor/woocommerce/woocommerce.php';
require SILICON_TEMPLATE_DIR . '/vendor/polylang/polylang.php';
require SILICON_TEMPLATE_DIR . '/vendor/wpml/wpml.php';
require SILICON_TEMPLATE_DIR . '/vendor/bbpress/bootstrap.php';
require SILICON_TEMPLATE_DIR . '/vendor/buddypress/bootstrap.php';
require SILICON_TEMPLATE_DIR . '/vendor/importer/init.php';

/**
 * Note: Do not add any custom code here.
 * Please use a custom plugin or child theme so that your customizations aren't lost during updates.
 */
