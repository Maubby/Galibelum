<?php

/**
 * Class Silicon_CPT_Intros
 */
class Silicon_CPT_Intros extends Silicon_CPT {
	/**
	 * Post Type Slug
	 *
	 * @var string
	 */
	protected $post_type = 'silicon_intro';

	/**#@+
	 * Cache variables
	 */
	private $cache_key_for_posts = 'silicon_intro_posts';
	private $cache_group = 'silicon_autocomplete';
	/**#@-*/

	/**#@+
	 * Meta box keys
	 */
	private $meta_box_type = '_silicon_intro_type';
	private $meta_box_app = '_silicon_intro_app';
	private $meta_box_personal = '_silicon_intro_personal';
	private $meta_box_comparison = '_silicon_intro_comparison';
	private $meta_box_posts = '_silicon_intro_posts';

	/**#@-*/

	public function init() {
		add_action( 'init', array( $this, 'register' ), 0 );

		// Meta Boxes: add fields to Page Settings and custom Intros "Settings" meta box
		// TODO: implement ability to dynamically add fields to Equip layouts
		// TODO: @see silicon_meta_box_page_settings() meta-boxes.php
		//add_filter( 'equip/engine/layout', array( $this, 'add_page_settings_fields' ) );
		add_filter( 'silicon_get_setting_defaults', array( $this, 'add_page_settings_defaults' ) );
		add_action( 'current_screen', array( $this, 'add_meta_box_type' ) );
		add_action( 'current_screen', array( $this, 'add_meta_box_app' ) );
		add_action( 'current_screen', array( $this, 'add_meta_box_personal' ) );
		add_action( 'current_screen', array( $this, 'add_meta_box_comparison' ) );
		add_action( 'current_screen', array( $this, 'add_meta_box_posts_slider' ) );

		// hide meta boxes
		add_filter( 'hidden_meta_boxes', array( $this, 'hide_meta_boxes' ), 10, 2 );

		// Clear cache on adding or deleting portfolio items
		add_action( "save_post_{$this->post_type}", array( $this, 'flush_posts_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_posts_cache' ) );
	}

	public function register() {
		$labels = array(
			'name'               => _x( 'Intros', 'post type general name', 'silicon' ),
			'singular_name'      => _x( 'Intro', 'post type singular name', 'silicon' ),
			'menu_name'          => __( 'Intros', 'silicon' ),
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

		$args = array(
			'label'               => __( 'Intros', 'silicon' ),
			'labels'              => $labels,
			'description'         => __( 'Hidden post type for implementing Intro Sections.', 'silicon' ),
			'public'              => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => '48.2',
			'menu_icon'           => 'dashicons-desktop',
			'capability_type'     => 'page',
			'supports'            => array( 'title' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'can_export'          => true,
		);

		register_post_type( $this->post_type, $args );
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
			'intro' => 0,
		) );
	}

	/**
	 * Flush object cache for posts
	 * Fires when posts creating, updating or deleting.
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
	 * Add "Type" meta box on Intro post screen
	 *
	 * @param WP_Screen $screen
	 */
	public function add_meta_box_type( $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return;
		}

		if ( ! defined( 'EQUIP_VERSION' ) ) {
			return;
		}

		/** @var string $path Path to Intros type previews */
		$path = SILICON_TEMPLATE_URI . '/img/intros';

		try {
			$layout = equip_create_meta_box_layout();
			$layout->add_field( 'type', 'image_select', array(
				'default' => 'none',
				'options' => array(
					'none'              => array( 'src' => $path . '/none.png', 'label' => esc_html__( 'None', 'silicon' ) ), // service
					'app-showcase'      => array( 'src' => $path . '/app_showcase.png', 'label' => esc_html__( 'Mobile App Showcase', 'silicon' ) ),
					'personal'          => array( 'src' => $path . '/personal.png', 'label' => esc_html__( 'Personal Intro', 'silicon' ) ),
					'comparison-slider' => array( 'src' => $path . '/comparison_slider.png', 'label' => esc_html__( 'Comparison Slider', 'silicon' ) ),
					'posts-slider'      => array( 'src' => $path . '/posts_slider.png', 'label' => esc_html__( 'Featured Posts Slider', 'silicon' ) ),
				),
			) );

			equip_add_meta_box( $this->meta_box_type, $layout, array(
				'id'       => 'silicon-intro-type',
				'title'    => esc_html__( 'Type', 'silicon' ),
				'screen'   => $this->post_type,
				'priority' => 'high',
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}

	/**
	 * Add settings meta box for "Mobile App Showcase" type
	 *
	 * @param WP_Screen $screen
	 */
	public function add_meta_box_app( $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return;
		}

		if ( ! defined( 'EQUIP_VERSION' ) ) {
			return;
		}

		try {
			$layout = equip_create_meta_box_layout();

			//<editor-fold desc="iOS Platform">
			$ios = $layout->add_tab( 'tab-ios-platform', esc_html__( 'iOS Platform', 'silicon' ), array( 'is_active' => true ) );
			$ios
				->add_row()
				->add_column( 8 )
				->add_field( 'ios_logo', 'media', array(
					'label'       => esc_html__( 'Upload App Icon', 'silicon' ),
					'description' => esc_html__(
						'Logo is optimized for retina displays, so the original image size should be twice as big as
						the final logo that appears on the website. For example, if you want logo to be 200x50 you
						should upload image 400x100 px.',
						'silicon'
					),
				) )
				->add_field( 'ios_tagline', 'text', array(
					'label'   => esc_html__( 'Your Tagline', 'silicon' ),
					'default' => esc_html__( 'Your brilliant iOS App.', 'silicon' ),
				) )
				->add_field( 'ios_screen', 'media', array(
					'label' => esc_html__( 'App Screen Image', 'silicon' ),
				) )
				->add_field( 'ios_bg_type', 'select', array(
					'label'   => esc_html__( 'Background Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid Color', 'silicon' ),
						'image' => esc_html__( 'Image', 'silicon' ),
					)
				) )
				->add_field( 'ios_bg_color', 'color', array(
					'label'    => esc_html__( 'Choose Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'ios_bg_type', '=', 'solid' ),
				) )
				->add_field( 'ios_bg_image', 'media', array(
					'label'    => esc_html__( 'Upload BG Image', 'silicon' ),
					'required' => array( 'ios_bg_type', '=', 'image' ),
				) )
				->add_field( 'ios_f_divider', 'raw_text', array(
					'default'  => '<hr>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'ios_f1_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 1', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'ios_f1_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'ios_f1_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'ios_f1_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'ios_f2_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 2', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'ios_f2_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'ios_f2_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'ios_f2_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'ios_f3_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 3', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'ios_f3_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'ios_f3_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'ios_f3_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) );
			//</editor-fold>

			//<editor-fold desc="Android Platform">
			$android = $layout->add_tab( 'tab-android-platform', esc_html__( 'Android Platform', 'silicon' ) );
			$android
				->add_row()
				->add_column( 8 )
				->add_field( 'android_logo', 'media', array(
					'label'       => esc_html__( 'Upload App Icon', 'silicon' ),
					'description' => esc_html__(
						'Logo is optimized for retina displays, so the original image size should be twice as big as
						the final logo that appears on the website. For example, if you want logo to be 200x50 you
						should upload image 400x100 px.',
						'silicon'
					),
				) )
				->add_field( 'android_tagline', 'text', array(
					'label'   => esc_html__( 'Your Tagline', 'silicon' ),
					'default' => esc_html__( 'Your brilliant Android App.', 'silicon' ),
				) )
				->add_field( 'android_screen', 'media', array(
					'label' => esc_html__( 'App Screen Image', 'silicon' ),
				) )
				->add_field( 'android_bg_type', 'select', array(
					'label'   => esc_html__( 'Background Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid Color', 'silicon' ),
						'image' => esc_html__( 'Image', 'silicon' ),
					)
				) )
				->add_field( 'android_bg_color', 'color', array(
					'label'    => esc_html__( 'Choose Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'android_bg_type', '=', 'solid' ),
				) )
				->add_field( 'android_bg_image', 'media', array(
					'label'    => esc_html__( 'Upload BG Image', 'silicon' ),
					'required' => array( 'android_bg_type', '=', 'image' ),
				) )
				->add_field( 'android_f_divider', 'raw_text', array(
					'default'  => '<hr>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'android_f1_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 1', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'android_f1_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'android_f1_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'android_f1_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'android_f2_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 2', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'android_f2_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'android_f2_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'android_f2_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'android_f3_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 3', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'android_f3_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'android_f3_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'android_f3_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) );
			//</editor-fold>

			//<editor-fold desc="Windows Platform">
			$windows = $layout->add_tab( 'tab-windows-platform', esc_html__( 'Windows Platform', 'silicon' ) );
			$windows
				->add_row()
				->add_column( 8 )
				->add_field( 'windows_logo', 'media', array(
					'label'       => esc_html__( 'Upload App Icon', 'silicon' ),
					'description' => esc_html__(
						'Logo is optimized for retina displays, so the original image size should be twice as big as
						the final logo that appears on the website. For example, if you want logo to be 200x50 you
						should upload image 400x100 px.',
						'silicon'
					),
				) )
				->add_field( 'windows_tagline', 'text', array(
					'label'   => esc_html__( 'Your Tagline', 'silicon' ),
					'default' => esc_html__( 'Our brilliant Windows App.', 'silicon' ),
				) )
				->add_field( 'windows_screen', 'media', array(
					'label' => esc_html__( 'App Screen Image', 'silicon' ),
				) )
				->add_field( 'windows_bg_type', 'select', array(
					'label'   => esc_html__( 'Background Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid Color', 'silicon' ),
						'image' => esc_html__( 'Image', 'silicon' ),
					)
				) )
				->add_field( 'windows_bg_color', 'color', array(
					'label'    => esc_html__( 'Choose Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'windows_bg_type', '=', 'solid' ),
				) )
				->add_field( 'windows_bg_image', 'media', array(
					'label'    => esc_html__( 'Upload BG Image', 'silicon' ),
					'required' => array( 'windows_bg_type', '=', 'image' ),
				) )
				->add_field( 'windows_f_divider', 'raw_text', array(
					'default'  => '<hr>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'windows_f1_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 1', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'windows_f1_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'windows_f1_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'windows_f1_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'windows_f2_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 2', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'windows_f2_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'windows_f2_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'windows_f2_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 2 )
				->add_field( 'windows_f3_label', 'raw_text', array(
					'default'  => '<h3>' . esc_html__( 'Feature 3', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_column( 2 )
				->add_field( 'windows_f3_icon', 'media', array(
					'label' => esc_html__( 'Icon', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'windows_f3_title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'windows_f3_desc', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) );
			//</editor-fold>

			$appearance = $layout->add_tab( 'tab-app-appearance', esc_html__( 'Appearance', 'silicon' ) );
			$appearance->add_row()->add_column( 8 )->add_field( 'skin', 'select', array(
				'label'   => esc_html__( 'Skin', 'silicon' ),
				'default' => 'dark',
				'options' => array(
					'dark'  => esc_html__( 'Dark', 'silicon' ),
					'light' => esc_html__( 'Light', 'silicon' ),
				),
			) );

			equip_add_meta_box( $this->meta_box_app, $layout, array(
				'id'     => 'silicon-intro-app-showcase',
				'title'  => esc_html__( 'Mobile App Showcase', 'silicon' ),
				'screen' => $this->post_type,
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}

	/**
	 * Add settings meta box for "Personal Intro" type
	 *
	 * @param WP_Screen $screen
	 */
	public function add_meta_box_personal( $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return;
		}

		if ( ! defined( 'EQUIP_VERSION' ) ) {
			return;
		}

		try {
			$layout = equip_create_meta_box_layout();

			//<editor-fold desc="About Me">
			$about = $layout->add_tab( 'tab-about', esc_html__( 'About Me', 'silicon' ), array( 'is_active' => true ) );
			$about
				->add_row()
				->add_column( 8 )
				->add_field( 'name', 'text', array(
					'label' => esc_html__( 'Name', 'silicon' ),
				) )
				->add_field( 'position', 'text', array(
					'label' => esc_html__( 'Position', 'silicon' ),
				) )
				->add_field( 'avatar', 'media', array(
					'label' => esc_html__( 'Upload Avatar', 'silicon' ),
				) );
			//</editor-fold>

			//<editor-fold desc="Cover">
			$cover = $layout->add_tab( 'tab-cover', esc_html__( 'Cover', 'silicon' ) );
			$cover
				->add_row()
				->add_column( 8 )
				->add_field( 'title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'subtitle', 'textarea', array(
					'label' => esc_html__( 'Subtitle', 'silicon' ),
				) )
				// button 1
				->add_row()
				->add_column( 8 )
				->add_field( 'button_1_label', 'raw_text', array(
					'default'  => '<hr><h3>' . esc_html__( 'Button 1', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 4 )
				->add_field( 'button_1_text', 'text', array(
					'label' => esc_html__( 'Text', 'silicon' ),
				) )
				->add_field( 'button_1_link', 'text', array(
					'label'    => esc_html__( 'Link', 'silicon' ),
					'escape'   => 'silicon_esc_url',
					'sanitize' => 'silicon_esc_url',
				) )
				->add_column( 2 )
				->add_field( 'button_1_type', 'select', array(
					'label'   => esc_html__( 'Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid', 'silicon' ),
						'ghost' => esc_html__( 'Ghost', 'silicon' ),
						'link'  => esc_html__( 'Link', 'silicon' ),
					)
				) )
				->add_field( 'button_1_color', 'select', array(
					'label'   => esc_html__( 'Color', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default'  => esc_html__( 'Default', 'silicon' ),
						'primary'  => esc_html__( 'Primary', 'silicon' ),
						'success'  => esc_html__( 'Success', 'silicon' ),
						'info'     => esc_html__( 'Info', 'silicon' ),
						'warning'  => esc_html__( 'Warning', 'silicon' ),
						'danger'   => esc_html__( 'Danger', 'silicon' ),
						'white'    => esc_html__( 'White', 'silicon' ),
						'gradient' => esc_html__( 'Gradient', 'silicon' ),
						'custom'   => esc_html__( 'Custom', 'silicon' ),
					)
				) )
				->add_column( 2 )
				->add_field( 'button_1_shape', 'select', array(
					'label'   => esc_html__( 'Shape', 'silicon' ),
					'default' => 'pill',
					'options' => array(
						'pill'    => esc_html__( 'Pill', 'silicon' ),
						'rounded' => esc_html__( 'Rounded', 'silicon' ),
						'square'  => esc_html__( 'Square', 'silicon' ),
					),
				) )
				->add_field( 'button_1_color_custom', 'color', array(
					'label'    => esc_html__( 'Custom Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'button_1_color', '=', 'custom' ),
				) )
				// button 2
				->add_row()
				->add_column( 8 )
				->add_field( 'button_2_label', 'raw_text', array(
					'default'  => '<hr><h3>' . esc_html__( 'Button 2', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 4 )
				->add_field( 'button_2_text', 'text', array(
					'label' => esc_html__( 'Text', 'silicon' ),
				) )
				->add_field( 'button_2_link', 'text', array(
					'label'    => esc_html__( 'Link', 'silicon' ),
					'escape'   => 'silicon_esc_url',
					'sanitize' => 'silicon_esc_url',
				) )
				->add_column( 2 )
				->add_field( 'button_2_type', 'select', array(
					'label'   => esc_html__( 'Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid', 'silicon' ),
						'ghost' => esc_html__( 'Ghost', 'silicon' ),
						'link'  => esc_html__( 'Link', 'silicon' ),
					)
				) )
				->add_field( 'button_2_color', 'select', array(
					'label'   => esc_html__( 'Color', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default'  => esc_html__( 'Default', 'silicon' ),
						'primary'  => esc_html__( 'Primary', 'silicon' ),
						'success'  => esc_html__( 'Success', 'silicon' ),
						'info'     => esc_html__( 'Info', 'silicon' ),
						'warning'  => esc_html__( 'Warning', 'silicon' ),
						'danger'   => esc_html__( 'Danger', 'silicon' ),
						'white'    => esc_html__( 'White', 'silicon' ),
						'gradient' => esc_html__( 'Gradient', 'silicon' ),
						'custom'   => esc_html__( 'Custom', 'silicon' ),
					)
				) )
				->add_column( 2 )
				->add_field( 'button_2_shape', 'select', array(
					'label'   => esc_html__( 'Shape', 'silicon' ),
					'default' => 'pill',
					'options' => array(
						'pill'    => esc_html__( 'Pill', 'silicon' ),
						'rounded' => esc_html__( 'Rounded', 'silicon' ),
						'square'  => esc_html__( 'Square', 'silicon' ),
					),
				) )
				->add_field( 'button_2_color_custom', 'color', array(
					'label'    => esc_html__( 'Custom Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'button_2_color', '=', 'custom' ),
				) )

				// appearance
				->add_row()
				->add_column( 8 )
				->add_field( 'appearance_label', 'raw_text', array(
					'default'  => '<hr><h3>' . esc_html__( 'Appearance', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_field( 'skin', 'select', array(
					'label'   => esc_html__( 'Skin', 'silicon' ),
					'default' => 'dark',
					'options' => array(
						'dark'  => esc_html__( 'Dark', 'silicon' ),
						'light' => esc_html__( 'Light', 'silicon' ),
					),
				) )
				->add_field( 'bg_type', 'select', array(
					'label'   => esc_html__( 'Background Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid'    => esc_html__( 'Solid Color', 'silicon' ),
						'image'    => esc_html__( 'Image', 'silicon' ),
						'gradient' => esc_html__( 'Gradient', 'silicon' ),
					)
				) )
				->add_field( 'bg_color', 'color', array(
					'label'    => esc_html__( 'Choose Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'bg_type', '=', 'solid' ),
				) )
				->add_field( 'bg_image', 'media', array(
					'label'    => esc_html__( 'Upload Image', 'silicon' ),
					'required' => array( 'bg_type', '=', 'image' ),
				) )
				->add_row()
				->add_column( 4 )
				->add_field( 'parallax', 'switch', array(
					'label'    => esc_html__( 'Parallax', 'silicon' ),
					'default'  => false,
					'required' => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
					),
				) )
				->add_field( 'parallax_type', 'select', array(
					'label'       => esc_html__( 'Parallax Type', 'silicon' ),
					'description' => esc_html__( 'Parallax effect applied to the Background of Cover Image.', 'silicon' ),
					'default'     => 'scroll',
					'options'     => array(
						'scroll'         => esc_html__( 'Scroll', 'silicon' ),
						'scale'          => esc_html__( 'Scale', 'silicon' ),
						'opacity'        => esc_html__( 'Opacity', 'silicon' ),
						'scroll-opacity' => esc_html__( 'Scroll & Opacity', 'silicon' ),
						'scale-opacity'  => esc_html__( 'Scale & Opacity', 'silicon' ),
					),
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_field( 'parallax_speed', 'text', array(
					'label'       => esc_html__( 'Parallax Speed', 'silicon' ),
					'description' => esc_html__( 'Parallax effect speed. Provide numbers from -1.0 to 1.0', 'silicon' ),
					'default'     => 0.4,
					'sanitize'    => 'silicon_sanitize_float',
					'escape'      => 'silicon_sanitize_float',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_field( 'parallax_video', 'text', array(
					'label'       => esc_html__( 'Video Background', 'silicon' ),
					'description' => esc_html__( 'You can provide a link to YouTube or Vimeo to play video on background.', 'silicon' ),
					'sanitize'    => 'esc_url_raw',
					'escape'      => 'esc_url',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_column( 4 )
				->add_field( 'overlay', 'switch', array(
					'label'    => esc_html__( 'Overlay', 'silicon' ),
					'default'  => false,
					'required' => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
					),
				) )
				->add_field( 'overlay_type', 'select', array(
					'label'       => esc_html__( 'Type', 'silicon' ),
					'description' => esc_html__( 'Choose overlay type.', 'silicon' ),
					'default'     => 'color',
					'options'     => array(
						'color'    => esc_html__( 'Solid Color', 'silicon' ),
						'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
					),
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
					),
				) )
				->add_field( 'overlay_color', 'color', array(
					'label'       => esc_html__( 'Color', 'silicon' ),
					'description' => esc_html__( 'Select overlay color.', 'silicon' ),
					'default'     => '#000000',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
						array( 'overlay_type', '=', 'color' ),
					),
				) )
				->add_field( 'overlay_opacity', 'slider', array(
					'label'       => esc_html__( 'Opacity', 'silicon' ),
					'description' => esc_html__( 'Set the overlay opacity, where 1% is almost visible and a value of 100% is completely opaque (solid).', 'silicon' ),
					'min'         => 1,
					'max'         => 100,
					'step'        => 1,
					'default'     => 60,
					'units'       => '%',
					'sanitize'    => 'absint',
					'escape'      => 'absint',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
					),
				) );

			equip_add_meta_box( $this->meta_box_personal, $layout, array(
				'id'     => 'silicon-intro-personal',
				'title'  => esc_html__( 'Personal', 'silicon' ),
				'screen' => $this->post_type,
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}

	/**
	 * Add settings meta box for "Comparison Slider" type
	 *
	 * @param WP_Screen $screen
	 */
	public function add_meta_box_comparison( $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return;
		}

		if ( ! defined( 'EQUIP_VERSION' ) ) {
			return;
		}

		try {
			$layout = equip_create_meta_box_layout();

			//<editor-fold desc="Content">
			$content = $layout->add_tab( 'tab-cs-content', esc_html__( 'Content', 'silicon' ), array( 'is_active' => true ) );
			$content
				->add_row()
				->add_column( 8 )
				->add_field( 'title', 'text', array(
					'label' => esc_html__( 'Title', 'silicon' ),
				) )
				->add_field( 'description', 'textarea', array(
					'label' => esc_html__( 'Description', 'silicon' ),
				) )
				->add_row()
				->add_column( 8 )
				->add_field( 'label_button', 'raw_text', array(
					'default'  => '<hr><h3>' . esc_html__( 'Button', 'silicon' ) . '</h3>',
					'escape'   => 'trim',
					'sanitize' => 'trim',
				) )
				->add_row()
				->add_column( 4 )
				->add_field( 'button_text', 'text', array(
					'label' => esc_html__( 'Text', 'silicon' ),
				) )
				->add_field( 'button_link', 'text', array(
					'label'    => esc_html__( 'Link', 'silicon' ),
					'escape'   => 'silicon_esc_url',
					'sanitize' => 'silicon_esc_url',
				) )
				->add_column( 2 )
				->add_field( 'button_type', 'select', array(
					'label'   => esc_html__( 'Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid' => esc_html__( 'Solid', 'silicon' ),
						'ghost' => esc_html__( 'Ghost', 'silicon' ),
						'link'  => esc_html__( 'Link', 'silicon' ),
					)
				) )
				->add_field( 'button_color', 'select', array(
					'label'   => esc_html__( 'Color', 'silicon' ),
					'default' => 'primary',
					'options' => array(
						'default'  => esc_html__( 'Default', 'silicon' ),
						'primary'  => esc_html__( 'Primary', 'silicon' ),
						'success'  => esc_html__( 'Success', 'silicon' ),
						'info'     => esc_html__( 'Info', 'silicon' ),
						'warning'  => esc_html__( 'Warning', 'silicon' ),
						'danger'   => esc_html__( 'Danger', 'silicon' ),
						'white'    => esc_html__( 'White', 'silicon' ),
						'gradient' => esc_html__( 'Gradient', 'silicon' ),
						'custom'   => esc_html__( 'Custom', 'silicon' ),
					)
				) )
				->add_column( 2 )
				->add_field( 'button_shape', 'select', array(
					'label'   => esc_html__( 'Shape', 'silicon' ),
					'default' => 'pill',
					'options' => array(
						'pill'    => esc_html__( 'Pill', 'silicon' ),
						'rounded' => esc_html__( 'Rounded', 'silicon' ),
						'square'  => esc_html__( 'Square', 'silicon' ),
					),
				) )
				->add_field( 'button_color_custom', 'color', array(
					'label'    => esc_html__( 'Custom Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'button_color', '=', 'custom' ),
				) );
			//</editor-fold>

			//<editor-fold desc="Comparison Slider">
			$slider = $layout->add_tab( 'tab-comparison-slider', esc_html__( 'Comparison Slider', 'silicon' ) );
			$slider
				->add_row()
				->add_column( 4 )
				->add_field( 'left_image', 'media', array( 'label' => esc_html__( 'Left Image', 'silicon' ) ) )
				->add_field( 'left_label', 'text', array(
					'label' => esc_html__( 'Left Label', 'silicon' ),
					'default' => esc_html__( 'Before', 'silicon' ),
				) )
				->add_column( 4 )
				->add_field( 'right_image', 'media', array( 'label' => esc_html__( 'Right Image', 'silicon' ) ) )
				->add_field( 'right_label', 'text', array(
					'label' => esc_html__( 'Right Label', 'silicon' ),
					'default' => esc_html__( 'After', 'silicon' ),
				) );
			//</editor-fold>

			//<editor-fold desc="Design">
			$design = $layout->add_tab('tab-design', esc_html__( 'Design', 'silicon' ) );
			$design
				->add_field( 'skin', 'select', array(
					'label'   => esc_html__( 'Skin', 'silicon' ),
					'default' => 'dark',
					'options' => array(
						'dark'  => esc_html__( 'Dark', 'silicon' ),
						'light' => esc_html__( 'Light', 'silicon' ),
					),
				) )
				->add_field( 'bg_type', 'select', array(
					'label'   => esc_html__( 'Background Type', 'silicon' ),
					'default' => 'solid',
					'options' => array(
						'solid'    => esc_html__( 'Solid Color', 'silicon' ),
						'image'    => esc_html__( 'Image', 'silicon' ),
						'gradient' => esc_html__( 'Gradient', 'silicon' ),
					)
				) )
				->add_field( 'bg_color', 'color', array(
					'label'    => esc_html__( 'Choose Color', 'silicon' ),
					'default'  => '#f5f5f5',
					'required' => array( 'bg_type', '=', 'solid' ),
				) )
				->add_field( 'bg_image', 'media', array(
					'label'    => esc_html__( 'Upload Image', 'silicon' ),
					'required' => array( 'bg_type', '=', 'image' ),
				) )
				->add_row()
				->add_column( 4 )
				->add_field( 'parallax', 'switch', array(
					'label'    => esc_html__( 'Parallax', 'silicon' ),
					'default'  => false,
					'required' => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
					),
				) )
				->add_field( 'parallax_type', 'select', array(
					'label'       => esc_html__( 'Parallax Type', 'silicon' ),
					'description' => esc_html__( 'Parallax effect applied to the Background of Cover Image.', 'silicon' ),
					'default'     => 'scroll',
					'options'     => array(
						'scroll'         => esc_html__( 'Scroll', 'silicon' ),
						'scale'          => esc_html__( 'Scale', 'silicon' ),
						'opacity'        => esc_html__( 'Opacity', 'silicon' ),
						'scroll-opacity' => esc_html__( 'Scroll & Opacity', 'silicon' ),
						'scale-opacity'  => esc_html__( 'Scale & Opacity', 'silicon' ),
					),
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_field( 'parallax_speed', 'text', array(
					'label'       => esc_html__( 'Parallax Speed', 'silicon' ),
					'description' => esc_html__( 'Parallax effect speed. Provide numbers from -1.0 to 1.0', 'silicon' ),
					'default'     => 0.4,
					'sanitize'    => 'silicon_sanitize_float',
					'escape'      => 'silicon_sanitize_float',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_field( 'parallax_video', 'text', array(
					'label'       => esc_html__( 'Video Background', 'silicon' ),
					'description' => esc_html__( 'You can provide a link to YouTube or Vimeo to play video on background.', 'silicon' ),
					'sanitize'    => 'esc_url_raw',
					'escape'      => 'esc_url',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'parallax', '=', 1 ),
					),
				) )
				->add_column( 4 )
				->add_field( 'overlay', 'switch', array(
					'label'    => esc_html__( 'Overlay', 'silicon' ),
					'default'  => false,
					'required' => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
					),
				) )
				->add_field( 'overlay_type', 'select', array(
					'label'       => esc_html__( 'Type', 'silicon' ),
					'description' => esc_html__( 'Choose overlay type.', 'silicon' ),
					'default'     => 'color',
					'options'     => array(
						'color'    => esc_html__( 'Solid Color', 'silicon' ),
						'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
					),
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
					),
				) )
				->add_field( 'overlay_color', 'color', array(
					'label'       => esc_html__( 'Color', 'silicon' ),
					'description' => esc_html__( 'Select overlay color.', 'silicon' ),
					'default'     => '#000000',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
						array( 'overlay_type', '=', 'color' ),
					),
				) )
				->add_field( 'overlay_opacity', 'slider', array(
					'label'       => esc_html__( 'Opacity', 'silicon' ),
					'description' => esc_html__( 'Set the overlay opacity, where 1% is almost visible and a value of 100% is completely opaque (solid).', 'silicon' ),
					'min'         => 1,
					'max'         => 100,
					'step'        => 1,
					'default'     => 60,
					'units'       => '%',
					'sanitize'    => 'absint',
					'escape'      => 'absint',
					'required'    => array(
						array( 'bg_type', '=', 'image' ),
						array( 'bg_image', 'not_empty' ),
						array( 'overlay', '=', 1 ),
					),
				) );
			//</editor-fold>

			equip_add_meta_box( $this->meta_box_comparison, $layout, array(
				'id'     => 'silicon-intro-comparison-slider',
				'title'  => esc_html__( 'Comparison Slider', 'silicon' ),
				'screen' => $this->post_type,
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}

	/**
	 * Add settings meta box for "Featured Posts Slider" type
	 *
	 * @param WP_Screen $screen
	 */
	public function add_meta_box_posts_slider( $screen ) {
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

			//<editor-fold desc="Content">
			$content = $layout->add_tab( 'tab-ps-content', esc_html__( 'Content', 'silicon' ), array( 'is_active' => true ) );
			$content->add_field( 'posts', 'combobox', array(
				'label'       => esc_html__( 'Posts', 'silicon' ),
				'description' => esc_html__( 'Choose one or more posts in field above', 'silicon' ),
				'attr'        => array( 'multiple' => true ),
				'sanitize'    => $sanitize_func,
				'escape'      => $sanitize_func,
				'options'     => call_user_func( function () {
					// ignore the posts without featured image
					$posts = get_posts( array(
						'post_type'           => 'post',
						'post_status'         => 'publish',
						'posts_per_page'      => - 1,
						'orderby'             => 'ID',
						'order'               => 'ASC',
						'suppress_filters'    => true,
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
						'meta_query'          => array(
							array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' )
						),
					) );

					$result = array();
					foreach ( $posts as $post ) {
						$result[ $post->ID ] = empty( $post->post_title ) ? esc_html__( '(no title)', 'silicon' ) : $post->post_title;
					}

					return $result;
				} ),
			) );
			//</editor-fold>

			//<editor-fold desc="Carousel">
			$carousel = $layout->add_tab( 'tab-ps-carousel', esc_html__( 'Carousel', 'silicon' ) );
			$carousel
				->add_row()
				->add_column( 2 )
				->add_field( 'is_arrows', 'switch', array(
					'label'   => esc_html__( 'Show arrows?', 'silicon' ),
					'default' => true,
				) )
				->add_column( 2 )
				->add_field( 'is_dots', 'switch', array(
					'label'   => esc_html__( 'Show dots?', 'silicon' ),
					'default' => false,
				) )
				->add_column( 2 )
				->add_field( 'is_loop', 'switch', array(
					'label'   => esc_html__( 'Loop', 'silicon' ),
					'default' => false,
				) )
				->add_column( 2 )
				->add_field( 'is_autoplay', 'switch', array(
					'label'   => esc_html__( 'Auto Play', 'silicon' ),
					'default' => false,
				) )
				->add_row()
				->add_column( 6 )
				->add_field( 'offset', 'text', array(
					'label'       => esc_html__( 'Top Offset', 'silicon' ),
					'description' => esc_html__( 'This value controls the content\'s offset from the top of the page (Header). Make sure to increase this value if you enable Floating Header feature.', 'silicon' ),
					'default'     => 115,
					'sanitize'    => 'absint',
					'escape'      => 'absint',
				) )
				->add_column( 2 )
				->add_field( 'autoplay_speed', 'text', array(
					'label'       => esc_html__( 'Auto Play Speed', 'silicon' ),
					'description' => esc_html__( 'Any positive integer number', 'silicon' ),
					'default'     => 4000,
					'sanitize'    => 'absint',
					'escape'      => 'absint',
					'required'    => array( 'is_autoplay', '=', 1 )
				) );
			//</editor-fold>


			equip_add_meta_box( $this->meta_box_posts, $layout, array(
				'id'     => 'silicon-intro-posts-slider',
				'title'  => esc_html__( 'Posts Slider', 'silicon' ),
				'screen' => $this->post_type,
			) );

		} catch ( Exception $e ) {
			trigger_error( $e->getMessage() );
		}
	}

	public function hide_meta_boxes( $hidden, $screen ) {
		if ( $this->post_type !== $screen->post_type ) {
			return $hidden;
		}

		$current    = isset( $_GET['post'] ) ? silicon_get_meta( (int) $_GET['post'], $this->meta_box_type, 'type', 'none' ) : 'none';
		$meta_boxes = array(
			'silicon-intro-app-showcase',
			'silicon-intro-personal',
			'silicon-intro-comparison-slider',
			'silicon-intro-posts-slider',
		);

		$hiddenMetaBoxes = array_filter( $meta_boxes, function ( $meta_box ) use ( $current ) {
			return ( false === strpos( $meta_box, $current ) );
		} );

		return array_merge( $hidden, $hiddenMetaBoxes );
	}
}