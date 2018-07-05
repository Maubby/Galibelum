<?php
/**
 * Silicon Child
 *
 * @author 8guild
 */

/**
 * Enqueue child scripts and styles
 *
 * Note the priority: 20.
 * This function should be executed after the callback in the parent theme
 */
function silicon_child_assets() {
	wp_enqueue_style( 'silicon-child', get_stylesheet_directory_uri() . '/style.css', array(), null );
}

add_action( 'wp_enqueue_scripts', 'silicon_child_assets', 20 );

/**
 * Enable the Visual Composer's Frontend editor.
 */
add_filter( 'silicon_vc_disable_frontend_editor', '__return_false' );
