<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CPT Loader
 *
 * @author 8guild
 */
class Silicon_Cpt_Loader {

	/**
	 * @var array List of CPTs objects
	 */
	private $instances = array();

	/**
	 * @var null|Silicon_Cpt_Loader Instance of class
	 */
	private static $instance;

	/**
	 * Returns the instance
	 *
	 * @return Silicon_Cpt_Loader
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
	 * Fully activate all CPT, with adding actions and filters.
	 *
	 * Load each file and gather actions and filters from CPT classes.
	 *
	 * @see Silicon_Cpt
	 *
	 * @param array $files A list of file names with path to them
	 */
	public function init( $files ) {
		if ( empty( $files ) ) {
			return;
		}

		foreach ( $files as $filename => $path ) {
			$cptInstance = $this->get_cpt( $filename, $path );
			$cptInstance->init();
		}
	}

	/**
	 * Just register the post types or taxonomies
	 *
	 * This method is used in {@see register_activation_hook}
	 * for registering CPTs before flushing the rewrite rules.
	 *
	 * @see register_post_type()
	 * @see register_taxonomy()
	 *
	 * @param array $files A list of file names with path to them
	 */
	public function register( $files ) {
		if ( empty( $files ) ) {
			return;
		}

		foreach ( $files as $filename => $path ) {
			$cptInstance = $this->get_cpt( $filename, $path );
			$cptInstance->register();
		}
	}

	/**
	 * Get the instance of Custom Post Type by given name
	 *
	 * @param string $filename File name which contains a class of CPT
	 * @param string $path     Absolute path to post type file
	 *
	 * @return bool|Silicon_CPT
	 */
	protected function get_cpt( $filename, $path ) {
		$class = $this->get_class_name( $filename );
		if ( ! array_key_exists( $class, $this->instances ) ) {
			require $path;

			$this->instances[ $class ] = new $class();
		}

		return $this->instances[ $class ];
	}

	/**
	 * Convert the file name into the class name according to
	 * WP Naming Conventions.
	 *
	 * @param string $filename Class file name
	 *
	 * @return string Class name
	 */
	public function get_class_name( $filename ) {
		$filename = str_replace( array( 'class-', '.php' ), '', $filename );
		$chunks   = explode( '-', $filename );
		$chunks   = array_map( 'ucfirst', $chunks );

		return implode( '_', $chunks );
	}
}