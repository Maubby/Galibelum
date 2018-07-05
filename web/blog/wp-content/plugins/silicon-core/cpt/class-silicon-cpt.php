<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Abstract class each CPT should inherit
 *
 * @author 8guild
 */
abstract class Silicon_CPT {
	/**
	 * Custom Post Type slug
	 *
	 * @var string
	 */
	protected $post_type = null;

	/**
	 * Add actions and filter for new CPT.
	 *
	 * You should add actions and filters in this method.
	 *
	 * This method called during the "plugins_loaded" hook.
	 *
	 * @see silicon_cpt()
	 */
	abstract public function init();

	/**
	 * Register post type (and/or) custom taxonomy
	 *
	 * You should call register_post_type() or register_taxonomy() in this method.
	 *
	 * This method called during the "init" hook to register the post type or/and
	 * taxonomy, which should be added inside init() method and during the plugin
	 * activation to flush the rewrite rules.
	 *
	 * @see  register_post_type()
	 * @see  register_taxonomy()
	 * @see  Silicon_CPT::init()
	 * @see  silicon_activation()
	 *
	 * @link https://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 */
	abstract public function register();

	/**
	 * Change Featured Image position for current post type
	 * 
	 * Move it under the Editor
	 *
	 * @example add_action( 'do_meta_boxes', array( $this, 'change_featured_image_context' ) );
	 *
	 * @author Bill Erickson, 8guild
	 * @link   http://www.billerickson.net/code/move-featured-image-metabox
	 *
	 * @param string $post_type Current post type
	 */
	public function change_featured_image_context( $post_type ) {
		if ( $this->post_type !== $post_type ) {
			return;
		}

		remove_meta_box( 'postimagediv', $this->post_type, 'side' );
		add_meta_box(
			'postimagediv',
			esc_html__( 'Featured Image' ),
			'post_thumbnail_meta_box',
			$this->post_type,
			'normal',
			'high'
		);
	}
}