<?php
/**
 * Plugin Name:  Silicon Core
 * Plugin URI:   http://silicon.8guild.com/
 * Description:  Plugin that extends Silicon theme functionality.
 * Version:      1.2.0
 * Author:       8guild
 * Author URI:   http://8guild.com
 * License:      GNU General Public License v2
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  silicon
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	return;
}

/**#@+
 * Plugin constants
 *
 * @since 1.0.0
 */
define( 'SILICON_PLUGIN_VERSION', '1.2.0' );
define( 'SILICON_PLUGIN_FILE', __FILE__ );
define( 'SILICON_PLUGIN_ROOT', __DIR__ );
define( 'SILICON_PLUGIN_URI', plugins_url( '/assets', SILICON_PLUGIN_FILE ) );
/**#@-*/

/* Include plugin core files */

require SILICON_PLUGIN_ROOT . '/inc/helpers.php';
require SILICON_PLUGIN_ROOT . '/inc/icons.php';
require SILICON_PLUGIN_ROOT . '/inc/core.php';
require SILICON_PLUGIN_ROOT . '/classes/class-silicon-shortcodes.php';
require SILICON_PLUGIN_ROOT . '/classes/class-silicon-cpt-loader.php';
require SILICON_PLUGIN_ROOT . '/cpt/class-silicon-cpt.php';

/* Main plugin loading routine */

add_action( 'plugins_loaded', 'silicon_cpt' );
add_action( 'plugins_loaded', array( Silicon_Shortcodes::instance(), 'init' ) );
add_action( 'wp_enqueue_scripts', 'silicon_front_scripts' );
add_action( 'admin_enqueue_scripts', 'silicon_admin_scripts' );
register_activation_hook( SILICON_PLUGIN_FILE, 'silicon_activation' );

/* Include other options */

require SILICON_PLUGIN_ROOT . '/inc/actions.php';
require SILICON_PLUGIN_ROOT . '/inc/blog.php';
require SILICON_PLUGIN_ROOT . '/inc/admin-pages.php';
require SILICON_PLUGIN_ROOT . '/inc/preloader.php';

/* Vendor action */

require SILICON_PLUGIN_ROOT . '/vendor/equip/bootstrap.php';
require SILICON_PLUGIN_ROOT . '/vendor/woocommerce/bootstrap.php';
require SILICON_PLUGIN_ROOT . '/vendor/vc/bootstrap.php';
