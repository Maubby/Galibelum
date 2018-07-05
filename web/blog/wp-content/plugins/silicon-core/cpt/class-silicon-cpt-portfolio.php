<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CPT "Portfolio"
 * 
 * @author 8guild
 */
class Silicon_CPT_Portfolio extends Silicon_CPT {
	/**
	 * Custom Post Type
	 *
	 * @var string
	 */
	protected $post_type = 'silicon_portfolio';

	/**
	 * Custom taxonomy
	 *
	 * @var string
	 */
	private $taxonomy = 'silicon_portfolio_category';

	/**#@+
	 * Cache variables
	 *
	 * @see flush_cats_cache
	 * @see flush_posts_cache
	 */
	private $cache_key_for_posts = 'silicon_portfolio_posts';
	private $cache_key_for_cats = 'silicon_portfolio_cats';
	private $cache_group = 'silicon_autocomplete';
	/**#@-*/

	/**
	 * Constructor
	 */
	public function __construct() {}

	public function init() {
		add_action( 'init', array( $this, 'register' ), 0 );

		// add Page Settings meta box to current post type and append appearance tab
		add_filter( 'silicon_page_settings_screen', array( $this, 'enable_page_settings' ) );
		//add_filter( 'equip/engine/layout', array( $this, 'add_page_settings_fields' ) ); // TODO: correct equip filter
		add_filter( 'silicon_get_setting_defaults', array( $this, 'add_page_settings_defaults' ) );

		// add "Portfolio" to "default_editor_post_types" for VC
		add_filter( 'silicon_vc_default_editor_post_types', array( $this, 'enable_vc_editor' ) );

		// add "Portfolio" to optional container wrapping
		add_filter( 'silicon_entry_container_types', array( $this, 'container_wrapping' ) );

		// AJAX Load More
		if ( is_admin() ) {
			add_action( 'wp_ajax_silicon_portfolio_load_more', array( $this, 'load_posts' ) );
			add_action( 'wp_ajax_nopriv_silicon_portfolio_load_more', array( $this, 'load_posts' ) );
		}

		// Display Featured Image in entries list
		add_filter( "manage_{$this->post_type}_posts_columns", array( $this, 'additional_posts_screen_columns' ) );
		add_action( "manage_{$this->post_type}_posts_custom_column", array( $this, 'additional_posts_screen_content' ), 10, 2 );

		// Clear cache on adding or deleting portfolio items
		add_action( "save_post_{$this->post_type}", array( $this, 'flush_posts_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_posts_cache' ) );

		// and categories
		add_action( "create_{$this->taxonomy}", array( $this, 'flush_cats_cache' ) );
		add_action( "delete_{$this->taxonomy}", array( $this, 'flush_cats_cache' ) );
		// fires for both situations when term is edited and term post count changes
		// @see taxonomy.php :: 3440 wp_update_term()
		// @see taxonomy.php :: 4152 _update_post_term_count
		add_action( 'edit_term_taxonomy', array( $this, 'flush_cats_cache' ), 10, 2 );

		// autocomplete, @see silicon_portfolio, silicon_portfolio_carousel, silicon_portfolio_item shortcodes
		add_filter( 'silicon_portfolio_posts_autocomplete', array( $this, 'get_autocomplete_posts' ), 1 );
		add_filter( 'silicon_portfolio_categories_autocomplete', array( $this, 'get_autocomplete_categories' ), 1 );

		// add Related Projects meta box
		add_action( 'current_screen', array( $this, 'add_related_projects_meta_box' ) );
	}

	public function register() {
		$this->register_post_type();
		$this->register_taxonomy();
	}

	private function register_post_type() {
		$labels = array(
			'name'               => _x( 'Portfolio', 'post type general name', 'silicon' ),
			'singular_name'      => _x( 'Portfolio', 'post type singular name', 'silicon' ),
			'menu_name'          => __( 'Portfolio', 'silicon' ),
			'all_items'          => __( 'All Items', 'silicon' ),
			'view_item'          => __( 'View', 'silicon' ),
			'add_new_item'       => __( 'Add New Item', 'silicon' ),
			'add_new'            => __( 'Add New', 'silicon' ),
			'edit_item'          => __( 'Edit', 'silicon' ),
			'update_item'        => __( 'Update', 'silicon' ),
			'search_items'       => __( 'Search', 'silicon' ),
			'not_found'          => __( 'Not found', 'silicon' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'silicon' )
		);

		$rewrite = array(
			'slug'       => 'portfolio-post',
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => __( 'Portfolio', 'silicon' ),
			'labels'              => $labels,
			'description'         => __( 'A fancy portfolio with filters.', 'silicon' ),
			'public'              => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => '48.1',
			'menu_icon'           => 'dashicons-portfolio',
			'capability_type'     => 'page',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'thumbnail', 'editor', 'excerpt', 'comments' ),
			'taxonomies'          => array( $this->taxonomy ),
			'has_archive'         => false,
			'rewrite'             => $rewrite,
			'query_var'           => true,
			'can_export'          => true,
		);

		register_post_type( $this->post_type, $args );
	}

	private function register_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Categories', 'taxonomy general name', 'silicon' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'silicon' ),
			'menu_name'                  => __( 'Categories', 'silicon' ),
			'all_items'                  => __( 'All Items', 'silicon' ),
			'parent_item'                => __( 'Parent Item', 'silicon' ),
			'parent_item_colon'          => __( 'Parent Item:', 'silicon' ),
			'new_item_name'              => __( 'New Item Name', 'silicon' ),
			'add_new_item'               => __( 'Add New', 'silicon' ),
			'edit_item'                  => __( 'Edit', 'silicon' ),
			'update_item'                => __( 'Update', 'silicon' ),
			'separate_items_with_commas' => __( 'Separate with commas', 'silicon' ),
			'search_items'               => __( 'Search', 'silicon' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'silicon' ),
			'choose_from_most_used'      => __( 'Choose from the most used items', 'silicon' ),
			'not_found'                  => __( 'Not Found', 'silicon' )
		);

		$rewrite = array(
			'slug'       => 'portfolio-category',
			'with_front' => true,
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'For filtration and building queries', 'silicon' ),
			'public'             => true,
			'show_ui'            => true,
			'show_in_nav_menus'  => true,
			'show_tagcloud'      => false,
			'show_in_quick_edit' => true,
			'show_admin_column'  => true,
			'hierarchical'       => true,
			'rewrite'            => $rewrite,
		);

		register_taxonomy( $this->taxonomy, array( $this->post_type ), $args );
	}

	/**
	 * Add "Page Settings" meta box for current post type
	 *
	 * @see silicon_meta_box_page_settings()
	 *
	 * @param array $screens Screens where Page Settings meta box should apply
	 *
	 * @return array
	 */
	public function enable_page_settings( $screens ) {
		$screens[] = $this->post_type;

		return $screens;
	}

	/**
	 * Add fields to Page Settings meta box for current post type
	 *
	 * @param \Equip\Layout\MetaboxLayout $layout
	 *
	 * @return \Equip\Layout\Layout
	 */
	public function add_page_settings_fields( $layout ) {
		return $layout;
	}

	/**
	 * Add default values to Page Settings to make sure
	 * everything will work fine if for some reasons page settings
	 * meta box will be empty or missing.
	 *
	 * Keys and default values MUST be similar to keys and default
	 * values in Page Settings {@see add_page_settings_fields}
	 *
	 * @param array $defaults
	 *
	 * @return array
	 */
	public function add_page_settings_defaults( $defaults ) {
		return array_merge( $defaults, array(
			'portfolio_layout'      => 'blank',
			'portfolio_gallery'     => '',
			'portfolio_exclude_fi'  => false,
			'portfolio_is_toolbar'  => false,
			'portfolio_button_text' => esc_html__( 'View Project', 'silicon' ),
			'portfolio_button_url'  => '',
			'portfolio_is_share'    => true,
		) );
	}

	/**
	 * Enable the Visual Composer editor for current post type
	 *
	 * @see silicon_vc_before_init()
	 * @see vc_set_default_editor_post_types()
	 *
	 * @param array $post_types Post types
	 *
	 * @return array
	 */
	public function enable_vc_editor( $post_types ) {
		$post_types[] = $this->post_type;

		return $post_types;
	}

	/**
	 * Enable container wrapping
	 *
	 * @see silicon_entry_container()
	 *
	 * @param array $post_types
	 *
	 * @return array
	 */
	public function container_wrapping( $post_types ) {
		$post_types[] = $this->post_type;

		return $post_types;
	}

	/**
	 * AJAX handler for portfolio "Load More" button
	 *
	 * Outputs HTML
	 */
	public function load_posts() {
		// Check nonce.
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'silicon-ajax' ) ) {
			wp_send_json_error( _x( 'Wrong nonce', 'ajax request', 'silicon' ) );
		}

		if ( empty( $_POST['query'] ) ) {
			wp_send_json_error( _x( 'Param "query" required to load posts', 'ajax request', 'silicon' ) );
		}

		$query_args = silicon_query_decode( $_POST['query'] );
		if ( null === $query_args ) {
			wp_send_json_error( _x( 'Invalid "query" param', 'ajax request', 'silicon' ) );
		}

		$query_args['paged'] = (int) $_POST['page'];

		$query = new WP_Query( $query_args );
		if ( ! $query->have_posts() ) {
			wp_send_json_error( _x( 'Posts not found', 'ajax request', 'silicon' ) );
		}

		$posts = array();
		while ( $query->have_posts() ) {
			$query->the_post();

			// service + terms classes for filtration
			$classes = array_merge( array( 'grid-item' ), silicon_get_post_terms( get_the_ID(), $this->taxonomy ) );
			$classes = silicon_get_classes( $classes );

			ob_start();

			echo '<div class="', esc_attr( $classes ), '">';
			get_template_part( 'template-parts/tiles/portfolio', esc_attr( $_POST['type'] ) );
			echo '</div>';

			$posts[] = silicon_content_encode( ob_get_clean() );
			unset( $classes );
		}
		wp_reset_postdata();

		if ( count( $posts ) > 0 ) {
			wp_send_json_success( $posts );
		} else {
			wp_send_json_error( _x( 'Posts not found', 'ajax request', 'silicon' ) );
		}
	}

	/**
	 * Add extra columns to a post type screen
	 *
	 * @param array $columns Current Posts Screen columns
	 *
	 * @return array New Posts Screen columns.
	 */
	public function additional_posts_screen_columns( $columns ) {
		return array_merge( array(
			'cb'     => '<input type="checkbox" />',
			'image'  => __( 'Featured Image', 'silicon' ),
			'title'  => __( 'Title', 'silicon' ),
		), $columns );
	}

	/**
	 * Show data in extra columns
	 *
	 * @param string $column  Column slug
	 * @param int    $post_id Post ID
	 */
	public function additional_posts_screen_content( $column, $post_id ) {
		switch ( $column ) {
			case 'image':
				$image_id = get_post_thumbnail_id( $post_id );
				echo wp_get_attachment_image( $image_id, array( 75, 75 ) );
				break;
		}
	}

	/**
	 * Flush object cache for posts.
	 * Fires when portfolio posts creating, updating or deleting.
	 *
	 * @param int $post_id Post ID
	 */
	public function flush_posts_cache( $post_id ) {
		$type = get_post_type( $post_id );
		if ( $this->post_type !== $type ) {
			return;
		}

		wp_cache_delete( $this->cache_key_for_posts, $this->cache_group );
	}

	/**
	 * Flush object cache for categories.
	 * Fires when created, edited, deleted or updated a category.
	 *
	 * @param int    $term_id  Term ID or Term Taxonomy ID
	 * @param string $taxonomy Taxonomy name, exists only for "edit_term_taxonomy"
	 */
	public function flush_cats_cache( $term_id, $taxonomy = null ) {
		if ( null === $taxonomy || $this->taxonomy === $taxonomy ) {
			wp_cache_delete( $this->cache_key_for_cats, $this->cache_group );
		}
	}

	/**
	 * Fetch all portfolio posts for autocomplete field.
	 *
	 * It is safe to use IDs for import, because
	 * WP Importer does not change IDs for posts.
	 *
	 * @see shortcodes/mapping/silicon_portfolio.php
	 *
	 * @return array
	 */
	public function get_autocomplete_posts() {
		$posts = wp_cache_get( $this->cache_key_for_posts, $this->cache_group );
		if ( false === $posts ) {
			$posts = array();
			$data  = get_posts( array(
				'post_type'      => $this->post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => - 1,
				'no_found_rows'    => true,
				'nopaging'         => true,
				'suppress_filters' => true,
				'meta_query'       => array(
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS'
					),
				)
			) );

			if ( ! empty( $data ) && ! is_wp_error( $data ) ) {
				foreach ( $data as $item ) {
					$posts[] = array(
						'value' => (int) $item->ID,
						'label' => $title = $item->post_title ? esc_html( $item->post_title ) : __( '(no-title)', 'silicon' ),
					);
				}

				// cache for 1 day
				wp_cache_set( $this->cache_key_for_posts, $posts, $this->cache_group, 86400 );
			}
		}

		return $posts;
	}

	/**
	 * Fetch the portfolio categories for autocomplete field
	 *
	 * The taxonomy slug used as autocomplete value because
	 * of export/import issues. WP Importer creates new
	 * categories, tags, taxonomies based on import information
	 * with NEW IDs!
	 *
	 * @see shortcodes/mapping/silicon_portfolio.php
	 *
	 * @return array
	 */
	public function get_autocomplete_categories() {
		$data = wp_cache_get( $this->cache_key_for_cats, $this->cache_group );
		if ( false === $data ) {
			$categories = get_terms( array(
				'taxonomy'     => $this->taxonomy,
				'hierarchical' => false,
			) );

			if ( is_wp_error( $categories ) || empty( $categories ) ) {
				return array();
			}

			$data = array();
			foreach ( $categories as $category ) {
				$data[] = array(
					'value' => $category->slug,
					'label' => $category->name,
				);
			}

			// cache for 1 day
			wp_cache_set( $this->cache_key_for_cats, $data, $this->cache_group, 86400 );
		}

		return $data;
	}

	/**
	 * Add Related Projects meta box for Portfolio post type
	 *
	 * @param WP_Screen $screen
	 */
	public function add_related_projects_meta_box( $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return;
		}

		if ( ! defined( 'EQUIP_VERSION' ) ) {
			return;
		}

		$sanitize_func = function ( $value ) {
			if ( empty( $value ) ) {
				return array();
			}

			if ( ! is_array( $value ) ) {
				$value = (array) $value;
			}

			$value = array_map( 'intval', $value );
			$value = array_unique( $value );
			$value = array_filter( $value );

			return $value;
		};

		try {
			$layout = equip_create_meta_box_layout();
			$layout
				->add_row()
				->add_column( 2 )
				->add_field( 'rp_switch_label', 'raw_text', array(
					'escape'  => 'trim',
					'default' => '<h4>' . esc_html__( 'Enable / Disable', 'silicon' ) . '</h4>',
					'attr'    => array( 'class' => 'equip-labeled' ),
				) )
				->add_column( 6 )
				->add_field( 'is_enabled', 'switch', array(
					'default' => false,
				) )
				->add_field( 'label', 'text', array(
					'label'    => esc_html__( 'Title', 'silicon' ),
					'default'  => esc_html__( 'Related Projects', 'silicon' ),
					'required' => array( 'is_enabled', '=', 1 ),
				) )
				->add_field( 'posts', 'combobox', array(
					'label'       => esc_html__( 'Posts', 'silicon' ),
					'description' => esc_html__( 'Choose one or more posts in field above', 'silicon' ),
					'attr'        => array( 'multiple' => true ),
					'sanitize'    => $sanitize_func,
					'escape'      => $sanitize_func,
					'required'    => array( 'is_enabled', '=', 1 ),
					'options'     => call_user_func( function () {

						$posts = get_posts( array(
							'post_type'           => $this->post_type,
							'post_status'         => 'publish',
							'posts_per_page'      => - 1,
							'orderby'             => 'ID',
							'order'               => 'ASC',
							'exclude'             => empty( $_GET['post'] ) ? 0 : (int) $_GET['post'],
							// exclude current post
							'suppress_filters'    => true,
							'ignore_sticky_posts' => true,
							'no_found_rows'       => true,
							'meta_query'          => array(
								array(
									'key'     => '_thumbnail_id',
									'compare' => 'EXISTS'
								),
							)
						) );

						$result = array();
						foreach ( $posts as $post ) {
							$result[ $post->ID ] = empty( $post->post_title )
								? esc_html__( '(no title)', 'silicon' )
								: $post->post_title;
						}

						return $result;
					} ),
				) );

			equip_add_meta_box( '_silicon_portfolio_related', $layout, array(
				'id'       => 'silicon-portfolio-related-projects',
				'title'    => esc_html__( 'Related Projects', 'silicon' ),
				'screen'   => $this->post_type,
				'priority' => 'low',
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}
}