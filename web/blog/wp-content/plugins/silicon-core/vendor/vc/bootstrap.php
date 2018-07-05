<?php
/**
 * Mapping all custom shortcodes in Visual Composer interface
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

/**
 * Let users optionally disable VC integration, but keep the plugin installed.
 * You can add a following code to wp-config.php file.
 *
 * @example
 *
 *   define('SILICON_VC_DISABLE', true);
 *
 */
if ( defined( 'SILICON_VC_DISABLE' ) && SILICON_VC_DISABLE ) {
	return;
}


/* Theme Compatibility */

/**
 * Setup Visual Composer for theme.
 *
 * @see vc_set_as_theme()
 * @see vc_disable_frontend()
 * @see vc_set_default_editor_post_types()
 */
function silicon_vc_before_init() {
	/**
	 * This filter allows to enable the VC's frontend editor.
	 * Please note, Silicon theme is not fully support frontend editor!
	 *
	 * @example
	 *
	 *   add_filter( 'silicon_vc_disable_frontend_editor', '__return_false' );
	 *
	 * @param bool $disable TRUE is disable, FALSE is enable
	 */
	if ( apply_filters( 'silicon_vc_disable_frontend_editor', true ) ) {
		vc_disable_frontend();
	}

	/**
	 * Filter the default post types for Visual Composer
	 *
	 * This means VC should be enabled for this post types by default
	 *
	 * @param array $post_types Post types list
	 */
	$post_types = apply_filters( 'silicon_vc_default_editor_post_types', array(
		'page',
		'post',
	) );

	vc_set_as_theme();
	vc_set_default_editor_post_types( $post_types );

	/**
	 * Code below is responsible for "overriding" feature.
	 * By default VC allows to override their built-in shortcode templates only withing (child-)theme.
	 * But I find a way how to achieve this.
	 *
	 * @see WPBakeryShortCode::findShortcodeTemplate()
	 * @see WPBakeryShortCode::setTemplate()
	 *
	 * Also, the filter below allows to manipulate with the shortcodes list.
	 * For example, returning the empty array will always load default shortcodes.
	 *
	 * @param array $shortcodes
	 */
	$shortcodes = apply_filters( 'silicon_vc_overridden_shortcodes', array(
		'vc_column',
		'vc_column_inner',
		'vc_column_text',
		'vc_icon',
		'vc_row',
		'vc_row_inner',
		'vc_single_image',
		'vc_tta_accordion',
		'vc_tta_section',
		'vc_tta_tabs',
		'vc_tta_tour',
	) );

	foreach ( (array) $shortcodes as $shortcode ) {
		add_filter( 'vc_shortcode_set_template_' . $shortcode, 'silicon_vc_shortcode_template_loader' );
	}
}

add_action( 'vc_before_init', 'silicon_vc_before_init' );

if ( ! function_exists( 'silicon_vc_default_shortcode_template' ) ) :
	/**
	 * Override the default visual composer templates for built-in shortcodes.
	 * This will allow users to copy shortcodes to /vc_templates/ directory within
	 * their parent- or child-themes.
	 *
	 * @param string $template
	 *
	 * @return string
	 */
	function silicon_vc_shortcode_template_loader( $template ) {
		/**
		 * This filter allows to add new locations to search for default VC templates
		 *
		 * @param array $dirs A list of directories
		 */
		$dirs = apply_filters( 'silicon_vc_shortcode_template_dirs', array(
			get_stylesheet_directory() . '/vc_templates',
			get_template_directory() . '/vc_templates',
			__DIR__ . '/vc_templates'
		) );

		$shortcode = basename( $template );

		foreach ( $dirs as $dir ) {
			$dir  = rtrim( $dir, '/\\' );
			$path = $dir . DIRECTORY_SEPARATOR . $shortcode;
			if ( file_exists( $path ) ) {
				$template = $path;
				// break loop after first found template
				break;
			}
		}
		unset( $dir, $path, $shortcode );

		return $template;
	}
endif;


/* Remove VC Welcome Page */

remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
remove_action( 'admin_init', 'vc_page_welcome_redirect' );


/* Frontend part and icons */

/**
 * Remove all VC assets from the Front
 */
function silicon_vc_deregister_front_assets() {
	wp_deregister_style( 'js_composer_front' );
	wp_deregister_style( 'js_composer_custom_css' );
	wp_deregister_style( 'font-awesome' );

	wp_deregister_script( 'wpb_composer_front_js' );
	wp_deregister_script( 'waypoints' );
}

add_action( 'wp_enqueue_scripts', 'silicon_vc_deregister_front_assets', 9 );

/**
 * Register all the styles for VC Iconpicker to be enqueue later
 *
 * @see vc_base_register_front_css
 * @see vc_base_register_admin_css
 */
function silicon_vc_icons_register_css() {
	// remove vc's styles, we do not need them in our theme
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'vc_typicons' );
	wp_deregister_style( 'vc_openiconic' );
	wp_deregister_style( 'vc_linecons' );
	wp_deregister_style( 'vc_entypo' );
	wp_deregister_style( 'vc_monosocialiconsfont' );
	wp_deregister_style( 'vc_material' );

	// do not proceed if theme is deactivated
	if ( ! defined( 'SILICON_TEMPLATE_URI' ) ) {
		return;
	}

	wp_register_style( 'silicon-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/silicon-icons.min.css', array(), null, 'screen' );
	wp_register_style( 'socicon', SILICON_TEMPLATE_URI . '/stylesheets/vendor/socicon.min.css', array(), null, 'screen' );
	wp_register_style( 'material-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/material-icons.min.css', array(), null );
	wp_register_style( 'font-awesome', SILICON_TEMPLATE_URI . '/stylesheets/vendor/font-awesome.min.css', array(), null );
}

add_action( 'vc_base_register_front_css', 'silicon_vc_icons_register_css', 15 );
add_action( 'vc_base_register_admin_css', 'silicon_vc_icons_register_css', 15 );

/**
 * Used to enqueue all needed files when VC editor is rendering
 *
 * @see vc_backend_editor_enqueue_js_css
 * @see vc_frontend_editor_enqueue_js_css
 */
function silicon_vc_icons_enqueue_css() {
	// do not proceed if theme is deactivated
	if ( ! defined( 'SILICON_TEMPLATE_URI' ) ) {
		return;
	}

	wp_enqueue_style( 'silicon-icons' );
	wp_enqueue_style( 'socicon' );
	wp_enqueue_style( 'material-icons' );
	wp_enqueue_style( 'font-awesome' );
}

add_action( 'vc_backend_editor_enqueue_js_css', 'silicon_vc_icons_enqueue_css', 15 );
add_action( 'vc_frontend_editor_enqueue_js_css', 'silicon_vc_icons_enqueue_css', 15 );

/**
 * Enqueue the CSS for the Frontend site,
 * when one of the fonts is selected in the shortcode.
 *
 * @see vc_icon_element_fonts_enqueue
 * @see icons.php
 * @see vc_iconpicker-type-{$type} the dynamic part of the filter refers to $font
 *
 * @param string $font Library name
 */
function silicon_vc_icons_front_css( $font ) {
	// do not proceed if theme is deactivated
	if ( ! defined( 'SILICON_TEMPLATE_URI' ) ) {
		return;
	}

	switch ( $font ) {
		case 'silicon':
			wp_enqueue_style( 'silicon-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/silicon-icons.min.css', array(), null, 'screen' );
			break;

		case 'socicon':
			wp_enqueue_style( 'socicon', SILICON_TEMPLATE_URI . '/stylesheets/vendor/socicon.min.css', array(), null, 'screen' );
			break;

		case 'material':
			wp_enqueue_style( 'material-icons', SILICON_TEMPLATE_URI . '/stylesheets/vendor/material-icons.min.css', array(), null, 'screen' );
			break;

		case 'fontawesome':
			wp_enqueue_style( 'font-awesome', SILICON_TEMPLATE_URI . '/stylesheets/vendor/font-awesome.min.css', array(), null, 'screen' );
			break;
	}
}

add_action( 'vc_enqueue_font_icon_element', 'silicon_vc_icons_front_css' );

/**
 * Register the Silicon icons for using in VC's icon picker.
 *
 * @see silicon_get_si_icons()
 *
 * @param array $icons
 *
 * @return array
 */
function silicon_vc_icons_register_silicon( $icons ) {
	$si = array();
	foreach ( (array) silicon_get_si_icons() as $icon ) {
		$name = ucwords( str_replace( '-', ' ', str_replace( 'si si-', '', $icon ) ) );
		$si[] = array( $icon => $name );
		unset( $name );
	}
	unset( $icon );

	return $si;
}

add_filter( 'vc_iconpicker-type-silicon', 'silicon_vc_icons_register_silicon', 20 );

/**
 * Register the Socicon icons for using in VC's icon picker.
 *
 * @see silicon_get_social_icons()
 *
 * @param array $icons
 *
 * @return array
 */
function silicon_vc_icons_register_socicon( $icons ) {
	$soc = array();
	foreach ( (array) silicon_get_social_icons() as $icon ) {
		$name = ucwords( str_replace( '-', ' ', str_replace( 'socicon-', '', $icon ) ) );
		$soc[] = array( $icon => $name );
		unset( $name );
	}
	unset( $icon );

	return $soc;
}

add_filter( 'vc_iconpicker-type-socicon', 'silicon_vc_icons_register_socicon', 20 );

/**
 * Returns Material Icons for VC icon picker
 *
 * @param array $icons
 *
 * @return array Icons for icon picker, can be categorized, or not.
 */
function silicon_vc_icons_register_material( $icons ) {
	$material = array();
	foreach ( (array) silicon_get_material_icons() as $icon ) {
		$name       = trim( str_replace( 'material-icons', '', $icon ) );
		$name       = str_replace( '_', ' ', $name );
		$name       = ucwords( $name );
		$material[] = array( $icon => $name );
		unset( $name );
	}

	return $material;
}

add_filter( 'vc_iconpicker-type-material', 'silicon_vc_icons_register_material', 20 );

/**
 * Returns FontAwesome icons for VC's icon picker
 *
 * @see silicon_get_fa_icons()
 *
 * @param array $icons
 *
 * @return array
 */
function silicon_vc_icons_register_fontawesome( $icons ) {
	$fa = array();
	foreach ( (array) silicon_get_fa_icons() as $icon ) {
		$name = ucwords( str_replace( '-', ' ', str_replace( 'fa fa-', '', $icon ) ) );
		$fa[] = array( $icon => $name );
		unset( $name );
	}

	return $fa;
}

add_filter( 'vc_iconpicker-type-fontawesome', 'silicon_vc_icons_register_fontawesome', 20 );


/* Admin part */

if ( ! is_admin() ) {
	return;
}

/**
 * Autoloader for VC shortcodes classes
 *
 * @param string $shortcode Widget class
 *
 * @return bool
 */
function silicon_vc_integration_classes_loader( $shortcode ) {
	if ( false === stripos( $shortcode, 'Silicon_Shortcode' ) ) {
		return true;
	}

	// convert class name to file
	$chunks = array_filter( explode( '_', strtolower( $shortcode ) ) );
	$class  = 'class-' . implode( '-', $chunks ) . '.php';

	if ( file_exists( __DIR__ . '/classes/' . $class ) ) {
		require __DIR__ . '/classes/' . $class;
	}

	return true;
}

spl_autoload_register( 'silicon_vc_integration_classes_loader' );

/**
 * Integrate custom shortcodes into the VC
 *
 * @uses vc_map
 */
function silicon_vc_mapping() {
	// overload the mapping of some VC shortcodes
	// disabling our plugin will restore the original shortcode and settings
	vc_lean_map( 'vc_row', null, __DIR__ . '/vc_mapping/vc_row.php' );
	vc_lean_map( 'vc_row_inner', null, __DIR__ . '/vc_mapping/vc_row_inner.php' );
	vc_lean_map( 'vc_column', null, __DIR__ . '/vc_mapping/vc_column.php' );
	vc_lean_map( 'vc_column_inner', null, __DIR__ . '/vc_mapping/vc_column_inner.php' );
	vc_lean_map( 'vc_column_text', null, __DIR__ . '/vc_mapping/vc_column_text.php' );
	vc_lean_map( 'vc_icon', null, __DIR__ . '/vc_mapping/vc_icon.php' );
	vc_lean_map( 'vc_tta_accordion', null, __DIR__ . '/vc_mapping/vc_tta_accordion.php' );
	vc_lean_map( 'vc_tta_tabs', null, __DIR__ . '/vc_mapping/vc_tta_tabs.php' );
	vc_lean_map( 'vc_tta_tour', null, __DIR__ . '/vc_mapping/vc_tta_tour.php' );
	vc_lean_map( 'vc_tta_section', null, __DIR__ . '/vc_mapping/vc_tta_section.php' );
	vc_lean_map( 'vc_single_image', null, __DIR__ . '/vc_mapping/vc_single_image.php' );

	// Simple
	vc_lean_map( 'silicon_button', null, __DIR__ . '/mapping/silicon_button.php' );
	vc_lean_map( 'silicon_socials', null, __DIR__ . '/mapping/silicon_socials.php' );

	// Market Buttons
	vc_lean_map( 'silicon_app_store', null, __DIR__ . '/mapping/silicon_app_store.php' );
	vc_lean_map( 'silicon_google_play', null, __DIR__ . '/mapping/silicon_google_play.php' );
	vc_lean_map( 'silicon_windows_store', null, __DIR__ . '/mapping/silicon_windows_store.php' );
	vc_lean_map( 'silicon_amazon', null, __DIR__ . '/mapping/silicon_amazon.php' );
	vc_lean_map( 'silicon_blackberry', null, __DIR__ . '/mapping/silicon_blackberry.php' );

	// Content
	vc_lean_map( 'silicon_map', null, __DIR__ . '/mapping/silicon_map.php' );
	vc_lean_map( 'silicon_testimonial', null, __DIR__ . '/mapping/silicon_testimonial.php' );
	vc_lean_map( 'silicon_testimonials_carousel', null, __DIR__ . '/mapping/silicon_testimonials_carousel.php' );
	vc_lean_map( 'silicon_progress_bar', null, __DIR__ . '/mapping/silicon_progress_bar.php' );
	vc_lean_map( 'silicon_content_box', null, __DIR__ . '/mapping/silicon_content_box.php' );
	vc_lean_map( 'silicon_step', null, __DIR__ . '/mapping/silicon_step.php' );
	vc_lean_map( 'silicon_counter', null, __DIR__ . '/mapping/silicon_counter.php' );
	vc_lean_map( 'silicon_gallery', null, __DIR__ . '/mapping/silicon_gallery.php' );
	vc_lean_map( 'silicon_description_list', null, __DIR__ . '/mapping/silicon_description_list.php' );
	vc_lean_map( 'silicon_pricing_plan', null, __DIR__ . '/mapping/silicon_pricing_plan.php' );
	vc_lean_map( 'silicon_pricings', null, __DIR__ . '/mapping/silicon_pricings.php' );
	vc_lean_map( 'silicon_video_button', null, __DIR__ . '/mapping/silicon_video_button.php' );
	vc_lean_map( 'silicon_image_carousel', null, __DIR__ . '/mapping/silicon_image_carousel.php' );
	vc_lean_map( 'silicon_portfolio_post', null, __DIR__ . '/mapping/silicon_portfolio_post.php' );
	vc_lean_map( 'silicon_portfolio_grid', null, __DIR__ . '/mapping/silicon_portfolio_grid.php' );
	vc_lean_map( 'silicon_portfolio_carousel', null, __DIR__ . '/mapping/silicon_portfolio_carousel.php' );
	vc_lean_map( 'silicon_cta', null, __DIR__ . '/mapping/silicon_cta.php' );
	vc_lean_map( 'silicon_contacts_card', null, __DIR__ . '/mapping/silicon_contacts_card.php' );
	vc_lean_map( 'silicon_partner_logos_grid', null, __DIR__ . '/mapping/silicon_partner_logos_grid.php' );
	vc_lean_map( 'silicon_partner_logos_carousel', null, __DIR__ . '/mapping/silicon_partner_logos_carousel.php' );
	vc_lean_map( 'silicon_team_grid', null, __DIR__ . '/mapping/silicon_team_grid.php' );
	vc_lean_map( 'silicon_team_member_light', null, __DIR__ . '/mapping/silicon_team_member_light.php' );
	vc_lean_map( 'silicon_team_member', null, __DIR__ . '/mapping/silicon_team_member.php' );
	vc_lean_map( 'silicon_blog_post', null, __DIR__ . '/mapping/silicon_blog_post.php' );
	vc_lean_map( 'silicon_blog_grid', null, __DIR__ . '/mapping/silicon_blog_grid.php' );
	vc_lean_map( 'silicon_blog_carousel', null, __DIR__ . '/mapping/silicon_blog_carousel.php' );
	vc_lean_map( 'silicon_hot_spots', null, __DIR__ . '/mapping/silicon_hot_spots.php' );

	if ( silicon_is_woocommerce() ) {
		vc_lean_map( 'silicon_product', null, __DIR__ . '/mapping/silicon_product.php' );
		vc_lean_map( 'silicon_products', null, __DIR__ . '/mapping/silicon_products.php' );
	}
}

add_action( 'vc_mapper_init_after', 'silicon_vc_mapping' );

/**
 * Add mandatory params to each shortcode
 *
 * @param array $params Shortcode params
 *
 * @return array
 */
function silicon_vc_mandatory_shortcode_params( $params ) {
	if ( empty( $params ) || ! is_array( $params ) ) {
		$params = array();
	}

	$mandatory = array(
		array(
			'param_name'  => 'animation',
			'type'        => 'dropdown',
			'heading'     => __( 'Animation', 'silicon' ),
			'description' => __( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'silicon' ),
			'save_always' => true,
			'weight'      => - 1,
			'value'       => silicon_get_animations(),
		),
		array(
			'param_name'  => 'class',
			'type'        => 'textfield',
			'weight'      => - 2,
			'heading'     => __( 'Extra class name', 'silicon' ),
			'description' => sprintf(
				wp_kses(
					__(
						'Add extra classes, divided by whitespace, if you wish to style particular content element
						differently. We added set of predefined extra classes to use inside this field. You can see
						the complete list of classes in <a href="%s" target="_blank">Quick Help</a> page.',
						'silicon'
					),
					array( 'a' => array( 'href' => true, 'target' => true ) )
				),
				get_admin_url( null, 'admin.php?page=silicon-help' )
			),
		),
	);

	return array_merge( $params, $mandatory );
}

add_filter( 'silicon_shortcode_params', 'silicon_vc_mandatory_shortcode_params', 999 );

/**
 * Remove unsupported shortcodes
 *
 * @hooked vc_after_init 10
 */
function silicon_vc_remove_unsupported_shortcodes() {
	/**
	 * This filter allows to enable the unsupported shortcodes
	 *
	 * @example
	 * return array_diff($shortcodes, [a, b, c]);
	 *
	 * Where [a, b, c] is a list of shortcodes
	 * which you want to enable.
	 *
	 * @param array $shortcodes Shortcodes list
	 */
	$shortcodes = apply_filters( 'silicon_vc_unsupported_shortcodes', array(
		'vc_section',
		'vc_toggle',
		'vc_text_separator',
		'vc_posts_slider',
		'vc_gallery',
		'vc_images_carousel',
		'vc_basic_grid',
		'vc_media_grid',
		'vc_gmaps',
		'vc_btn',
		'vc_button',
		'vc_button2',
		'vc_cta_button',
		'vc_cta_button2',
		'vc_masonry_grid',
		'vc_masonry_media_grid',
		'vc_message',
		'vc_cta',
		'vc_tabs',
		'vc_tour',
		'vc_accordion',
		'vc_tta_pageable',
		'vc_custom_heading',
		'vc_progress_bar',
		'vc_pie',
		'vc_round_chart',
		'vc_line_chart',
		'vc_flickr',
		'vc_separator',
		'product',
		'products',
		'recent_products',
		'featured_products',
		'sale_products',
		'best_selling_products',
		'top_rated_products',
		'product_category',
		'product_categories',
		'product_attribute',
		'woocommerce_cart',
		'woocommerce_checkout',
		'woocommerce_my_account',
		'add_to_cart',
		'add_to_cart_url',
		'product_page',
	) );

	if ( empty( $shortcodes ) ) {
		return;
	}

	foreach ( (array) $shortcodes as $shortcode ) {
		vc_remove_element( $shortcode );
	}
}

add_action( 'vc_after_init', 'silicon_vc_remove_unsupported_shortcodes' );

/**
 * Remove the built-in VC Default Templates
 *
 * @link https://wpbakery.atlassian.net/wiki/pages/viewpage.action?pageId=524300
 *
 * @param array $templates Default templates
 *
 * @return array
 */
function silicon_vc_remove_templates( $templates ) {
	return array();
}

add_filter( 'vc_load_default_templates', 'silicon_vc_remove_templates', 11 );

/**
 * Deregister the VC's "not_responsive_css" option.
 *
 * This option is not supported by our theme.
 */
function silicon_vc_deregister_settings() {
	unregister_setting( 'wpb_js_composer_settings_general', 'wpb_js_not_responsive_css' );
}

add_action( 'admin_init', 'silicon_vc_deregister_settings' );

/**
 * Remove the "not_responsive_css" options from VC Settings
 *
 * Use carefully, because I modify the global variable directly
 */
function silicon_vc_remove_settings() {
	global $wp_settings_fields;

	$page    = 'vc_settings_general';
	$section = 'wpb_js_composer_settings_general';
	$option  = 'wpb_js_not_responsive_css';

	if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
		return;
	}

	if ( ! array_key_exists( $option, $wp_settings_fields[ $page ][ $section ] ) ) {
		return;
	}

	unset( $wp_settings_fields[ $page ][ $section ][ $option ] );

	return;
}

add_action( 'vc_page_settings_render-vc-general', 'silicon_vc_remove_settings' );
