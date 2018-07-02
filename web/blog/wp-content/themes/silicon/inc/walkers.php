<?php
/**
 * Theme custom Walkers autoloader
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloader for Walkers
 *
 * @param string $walker Walker class
 *
 * @return bool
 */
function silicon_walkers_loader( $walker ) {
	if ( false === stripos( $walker, 'Silicon_Walker' ) ) {
		return false;
	}

	// convert class name to file
	$chunks = array_filter( explode( '_', strtolower( $walker ) ) );

	/**
	 * Filter the walker file name
	 *
	 * @param string $file   File name according to WP coding standards
	 * @param string $walker Class name
	 */
	$class = apply_filters( 'silicon_walker_file', 'class-' . implode( '-', $chunks ) . '.php', $walker );

	/**
	 * Filter the directories where walkers class will be loaded
	 *
	 * @param array $paths Directories
	 */
	$paths = apply_filters( 'silicon_walker_paths', array(
		SILICON_STYLESHEET_DIR . '/walkers',
		SILICON_TEMPLATE_DIR . '/walkers',
	) );

	$located = false;
	foreach ( $paths as $path ) {
		if ( file_exists( $path . DIRECTORY_SEPARATOR . $class ) ) {
			$located = $path . DIRECTORY_SEPARATOR . $class;
			break;
		}
	}

	if ( false === $located ) {
		return false;
	}

	require $located;

	return true;
}

spl_autoload_register( 'silicon_walkers_loader' );
