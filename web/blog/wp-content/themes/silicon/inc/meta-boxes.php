<?php
/**
 * Theme Meta Boxes
 *
 * @author 8guild
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

/**
 * Add "Page Settings" meta box
 *
 * @param WP_Screen $screen Current screen
 */
function silicon_meta_box_page_settings( $screen ) {
	try {
		$layout = equip_create_meta_box_layout();

		//<editor-fold desc="Page Title Tab">
		$pt = $layout->add_tab( 'pt_tab', esc_html__( 'Page Title', 'silicon' ) );
		$pt
			->add_row()
			->add_column( 2 )
			->add_field( 'pt_visibility_label', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<h3>' . esc_html__( 'Visibility', 'silicon' ) . '</h3>',
				'attr'    => array( 'class' => 'equip-labeled' ),
			) )
			->add_column( 6 )
			->add_field( 'header_is_pt', 'select', array(
				'description' => esc_html__( 'Note: you can set this option globally in Theme Options. Check Header > Page Title settings section.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				),
			) )
			->add_row()
			->add_offset( 2 )
			->add_column( 6 )
			->add_field( 'header_pt_size', 'select', array(
				'label'    => esc_html__( 'Size', 'silicon' ),
				'default'  => 'default',
				'required' => array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
				'options'  => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'normal'  => esc_html__( 'Normal', 'silicon' ),
					'lg'      => esc_html__( 'Large', 'silicon' ),
					'xl'      => esc_html__( 'Extra Large', 'silicon' ),
				),
			) )
			->add_field( 'pt_skin', 'select', array(
				'label'    => esc_html__( 'Skin', 'silicon' ),
				'default'  => 'dark',
				'required' => array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
				'options'  => array(
					'dark'  => esc_html__( 'Dark', 'silicon' ),
					'light' => esc_html__( 'Light', 'silicon' ),
				),
			) )
			->add_row()
			->add_column( 12 )
			->add_field( 'pt_bg_sep', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<hr>',
				'required' => array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'pt_bg_label', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<h3>' . esc_html__( 'Background', 'silicon' ) . '</h3>',
				'attr'     => array( 'class' => 'equip-labeled' ),
				'required' => array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
			) )
			->add_column( 6 )
			->add_field( 'pt_bg_type', 'select', array(
				'default'  => 'none',
				'required' => array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
				'options'  => array(
					'none'     => esc_html__( 'None', 'silicon' ),
					'image'    => esc_html__( 'Image', 'silicon' ),
					'color'    => esc_html__( 'Solid Color', 'silicon' ),
					'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
				),
			) )
			->add_field( 'pt_bg_image', 'media', array(
				'description' => esc_html__( 'Uploading image will allow you to customize Parallax and Overlay settings. Please note if you plan to use parallax you have to upload large image at least 1920 x 1080 px in order for parallax work properly.', 'silicon' ),
				'media'       => array( 'title' => esc_html__( 'Choose a background image', 'silicon' ) ),
				'required'    => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
				),
			) )
			->add_field( 'pt_bg_color', 'color', array(
				'default'  => '#f5f5f5',
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'color' ),
				),
			) )
			->add_row()
			->add_column( 12 )
			->add_field( 'pt_parallax_sep', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<hr>',
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'pt_parallax_label', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<h3>' . esc_html__( 'Parallax', 'silicon' ) . '</h3>',
				'attr'     => array( 'class' => 'equip-labeled' ),
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_column( 6 )
			->add_field( 'pt_parallax', 'switch', array(
				'default'  => false,
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_field( 'pt_parallax_type', 'select', array(
				'label'       => esc_html__( 'Parallax Type', 'silicon' ),
				'description' => esc_html__( 'Choose the Type of the parallax effect applied to the Background of Cover Image.', 'silicon' ),
				'default'     => 'scroll',
				'required'    => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_parallax', '=', 1 ),
				),
				'options'     => array(
					'scroll'         => esc_html__( 'Scroll', 'silicon' ),
					'scale'          => esc_html__( 'Scale', 'silicon' ),
					'opacity'        => esc_html__( 'Opacity', 'silicon' ),
					'scroll-opacity' => esc_html__( 'Scroll & Opacity', 'silicon' ),
					'scale-opacity'  => esc_html__( 'Scale & Opacity', 'silicon' ),
				),
			) )
			->add_field( 'pt_parallax_speed', 'text', array(
				'label'       => esc_html__( 'Parallax Speed', 'silicon' ),
				'description' => esc_html__( 'Parallax effect speed. Provide numbers from -1.0 to 1.0', 'silicon' ),
				'default'     => 0.4,
				'sanitize'    => 'silicon_sanitize_float',
				'escape'      => 'silicon_sanitize_float',
				'required'    => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_parallax', '=', 1 ),
				),
			) )
			->add_field( 'pt_parallax_video', 'text', array(
				'label'       => esc_html__( 'Video Background', 'silicon' ),
				'description' => esc_html__( 'You can provide a link to YouTube or Vimeo to play video on background.', 'silicon' ),
				'sanitize'    => 'esc_url_raw',
				'escape'      => 'esc_url',
				'required'    => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_parallax', '=', 1 ),
				),
			) )
			->add_row()
			->add_column( 12 )
			->add_field( 'pt_overlay_sep', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<hr>',
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'pt_overlay_label', 'raw_text', array(
				'escape'   => 'trim',
				'default'  => '<h3>' . esc_html__( 'Overlay', 'silicon' ) . '</h3>',
				'attr'     => array( 'class' => 'equip-labeled' ),
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_column( 6 )
			->add_field( 'pt_overlay', 'switch', array(
				'default'  => false,
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
				),
			) )
			->add_field( 'pt_overlay_type', 'select', array(
				'label'    => esc_html__( 'Type', 'silicon' ),
				'default'  => 'color',
				'options'  => array(
					'color'    => esc_html__( 'Solid Color', 'silicon' ),
					'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
				),
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_overlay', '=', 1 ),
				),
			) )
			->add_field( 'pt_overlay_color', 'color', array(
				'label'    => esc_html__( 'Color', 'silicon' ),
				'default'  => '#000000',
				'required' => array(
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_overlay', '=', 1 ),
					array( 'pt_overlay_type', '=', 'color' ),
				),
			) )
			->add_field( 'pt_overlay_opacity', 'slider', array(
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
					array( 'header_is_pt', 'in_array', array( 'default', 1 ) ),
					array( 'pt_bg_type', '=', 'image' ),
					array( 'pt_bg_image', 'not_empty' ),
					array( 'pt_overlay', '=', 1 ),
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Header Tab">
		$header = $layout->add_tab( 'tab_header', esc_html__( 'Header', 'silicon' ) );
		$header
			->add_row()
			->add_column( 6 )
			->add_field( 'header_logo_description', 'raw_text', array(
				'default' => esc_html__(
					'Logo is optimized for retina displays, so the original image size should be twice
					as big as the final logo that appears on the website. For example, if you want logo to
					be 200x50 you should upload image 400x100 px.',
					'silicon'
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'custom_logo', 'media', array(
				'label'       => esc_html__( 'Custom Logo', 'silicon' ),
				'description' => esc_html__( 'Here you can upload a custom logo. This logo will be displayed only on a current page.', 'silicon' ),
				'media'       => array( 'title' => esc_html__( 'Choose a Custom Logo', 'silicon' ) ),
			) )
			->add_column( 2 )
			->add_field( 'header_stuck_logo', 'media', array(
				'label' => esc_html__( 'Stuck Header Logo', 'silicon' ),
				'media' => array( 'title' => esc_html__( 'Choose a Mobile Logo', 'silicon' ) ),
			) )
			->add_column( 2 )
			->add_field( 'header_mobile_logo', 'media', array(
				'label' => esc_html__( 'Mobile Logo', 'silicon' ),
				'media' => array( 'title' => esc_html__( 'Choose a Mobile Logo', 'silicon' ) ),
			) )
			->add_row()
			->add_column( 8 )
			->add_field( 'header_layout', 'image_select', array(
				'label'   => esc_html__( 'Type', 'silicon' ),
				'width'   => 250,
				'height'  => 200,
				'default' => 'default',
				'options' => silicon_options_variants_header( array(
					'default' => array(
						'src'   => SILICON_TEMPLATE_URI . '/img/options/blog/default.png',
						'label' => esc_html__( 'Default (Value taken from Theme Options)', 'silicon' ),
					),
				) )
			) )
			->parent( 'tab' )
			->add_field( 'header_navbar_settings_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'header_is_fullwidth', 'select', array(
				'label'       => esc_html__( 'Make Header Full Width?', 'silicon' ),
				'description' => esc_html__( 'If enabled Header will occupy the 100% of the page width.', 'silicon' ),
				'default'     => 'default',
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				)
			) )
			->add_column( 3 )
			->add_field( 'header_is_sticky', 'select', array(
				'label'       => esc_html__( 'Enable Sticky Navbar?', 'silicon' ),
				'description' => esc_html__( 'If enabled Navigation Bar will stick to the top of the page when scrolling.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				)
			) )
			->add_column( 3 )
			->add_field( 'header_is_floating', 'select', array(
				'label'       => esc_html__( 'Enable Floating Header?', 'silicon' ),
				'description' => esc_html__( 'This option makes header absolutely positioned, so it overlaps the content below.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				)
			) )
			->add_column( 3 )
			->add_field( 'header_is_topbar', 'select', array(
				'label'       => esc_html__( 'Enable Topbar?', 'silicon' ),
				'description' => esc_html__( 'If enabled Topbar with additional content options will appear right above Navigation Bar.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				)
			) )
			->parent( 'tab' )
			->add_field( 'header_navbar_utils_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'header_is_buttons', 'switch', array(
				'label'       => esc_html__( 'Enable Header Buttons?', 'silicon' ),
				'description' => esc_html__( 'This options allows you to disable Header Buttons for current page.', 'silicon' ),
				'default'     => true,
			) )
			->add_column( 3 )
			->add_field( 'header_utils_is_search', 'select', array(
				'label'       => esc_html__( 'Search', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable Search utility in the Navbar.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_utils_is_cart', 'select', array(
				'label'       => esc_html__( 'Shopping Cart', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable Shopping Cart dropdown in the Navbar. Please note this option works only if WooCommerce plugin installed.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'hidden'      => ( ! silicon_is_woocommerce() ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				),
			) )
			->parent( 'tab' )
			->add_field( 'header_menu_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
			) )
			->add_row()
			->add_column( 8 )
			->add_field( 'header_menu_variant', 'image_select', array(
				'label'    => esc_html__( 'Menu', 'silicon' ),
				'width'    => 250,
				'height'   => 200,
				'required' => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'  => 'default',
				'options'  => silicon_options_variants_menu( array(
					'default' => array(
						'src'   => SILICON_TEMPLATE_URI . '/img/options/blog/default.png',
						'label' => esc_html__( 'Default (Value taken from Theme Options)', 'silicon' ),
					),
				) ),
			) )
			->parent( 'tab' )
			->add_field( 'header_appearance_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_label_navbar', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<h4>' . esc_html__( 'Navbar', 'silicon' ) . '</h4>',
				'required' => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_bg', 'select', array(
				'label'       => esc_html__( 'Background', 'silicon' ),
				'description' => esc_html__( 'Background color of the Navigation Bar.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'solid'   => esc_html__( 'Solid Color', 'silicon' ),
					'ghost'   => esc_html__( 'Transparent', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_bg_custom', 'color', array(
				'label'       => esc_html__( 'Choose Color', 'silicon' ),
				'description' => esc_html__( 'Set custom color for your Topbar background.', 'silicon' ),
				'default'     => silicon_get_option( 'header_appearance_bg_custom', '#ffffff' ),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_appearance_bg', 'in_array', array( 'default', 'solid' ) ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_menu_skin', 'select', array(
				'label'       => esc_html__( 'Menu Skin', 'silicon' ),
				'description' => esc_html__( 'Whether the Menu Links appear in dark gray color or white color.', 'silicon' ),
				'required'    => array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'dark'    => esc_html__( 'Dark Text', 'silicon' ),
					'light'   => esc_html__( 'Light Text', 'silicon' ),
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_label_navbar_stuck', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<h4>' . esc_html__( 'Navbar Stuck', 'silicon' ) . '</h4>',
				'required' => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_sticky', 'in_array', array( 'default', 1 ) )
				),
			) )
			->parent( 'row' )
			->add_offset( 3 )
			->add_column( 3 )
			->add_field( 'header_appearance_stuck_bg_color', 'color', array(
				'label'       => esc_html__( 'Background Color', 'silicon' ),
				'description' => esc_html__( 'Set custom color for your Navbar background.', 'silicon' ),
				'default'     => silicon_get_option( 'header_appearance_stuck_bg_color', '#ffffff' ),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_sticky', 'in_array', array( 'default', 1 ) )
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_stuck_menu_skin', 'select', array(
				'label'       => esc_html__( 'Menu Skin', 'silicon' ),
				'description' => esc_html__( 'Whether the Menu Links appear in dark gray color or white color.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'dark'    => esc_html__( 'Dark Text', 'silicon' ),
					'light'   => esc_html__( 'Light Text', 'silicon' ),
				),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_sticky', 'in_array', array( 'default', 1 ) )
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_label_topbar', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<h4>' . esc_html__( 'Topbar', 'silicon' ) . '</h4>',
				'required' => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_topbar', 'in_array', array( 'default', 1 ) ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_bg', 'select', array(
				'label'       => esc_html__( 'Background', 'silicon' ),
				'description' => esc_html__( 'Background color of the Topbar section.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default'     => esc_html__( 'Default', 'silicon' ),
					'solid'       => esc_html__( 'Solid Color', 'silicon' ),
					'gradient'    => esc_html__( 'Gradient Color', 'silicon' ),
					'transparent' => esc_html__( 'Transparent', 'silicon' ),
				),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_topbar', 'in_array', array( 'default', 1 ) ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_bg_color', 'color', array(
				'label'       => esc_html__( 'Choose Color', 'silicon' ),
				'description' => esc_html__( 'Set color for the Topbar background.', 'silicon' ),
				'default'     => silicon_get_option( 'header_appearance_topbar_bg_color', '#f5f5f5' ),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_topbar', 'in_array', array( 'default', 1 ) ),
					array( 'header_appearance_topbar_bg', 'in_array', array( 'default', 'solid' ) ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_skin', 'select', array(
				'label'       => esc_html__( 'Topbar Content Skin', 'silicon' ),
				'description' => esc_html__( 'Choose Topbar elements skin to fit your Topbar background color.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'dark'    => esc_html__( 'Dark', 'silicon' ),
					'light'   => esc_html__( 'Light', 'silicon' ),
				),
				'required'    => array(
					array( 'header_layout', 'in_array', array( 'default', 'horizontal' ) ),
					array( 'header_is_topbar', 'in_array', array( 'default', 1 ) ),
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Footer Tab">
		$footer = $layout->add_tab( 'tab-ps-footer', esc_html__( 'Footer', 'silicon' ) );
		$footer
			->add_row()
			->add_column( 3 )
			->add_field( 'footer_background', 'select', array(
				'label'       => esc_html__( 'Background Option', 'silicon' ),
				'description' => esc_html__( 'Choose type of background you want to use on Footer', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default'  => esc_html__( 'Default', 'silicon' ),
					'solid'    => esc_html__( 'Solid Color', 'silicon' ),
					'image'    => esc_html__( 'Image', 'silicon' ),
					'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
				),
			) )
			->add_column( 2 )
			->add_field( 'footer_background_image', 'media', array(
				'label'    => esc_html__( 'Background Image', 'silicon' ),
				'media'    => array( 'title' => esc_html__( 'Choose a background', 'silicon' ) ),
				'required' => array( 'footer_background', '=', 'image' ),
				'default'  => silicon_get_option( 'footer_background_image' ),
			) )
			->add_column( 2 )
			->add_field( 'footer_background_color', 'color', array(
				'label'    => esc_html__( 'Background Color', 'silicon' ),
				'default'  => silicon_get_option( 'footer_background_color', '#222222' ),
				'required' => array( 'footer_background', 'in_array', array( 'default', 'solid' ) ),
			) )
			->add_column( 3 )
			->add_field( 'footer_overlay_option', 'select', array(
				'label'    => esc_html__( 'Overlay Color Option', 'silicon' ),
				'required' => array( 'footer_background', '=', 'image' ),
				'default'  => 'default',
				'options'  => array(
					'default'  => esc_html__( 'Default', 'silicon' ),
					'solid'    => esc_html__( 'Solid Color', 'silicon' ),
					'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
				),
			) )
			->add_field( 'footer_overlay_opacity', 'slider', array(
				'label'    => esc_html__( 'Overlay Opacity', 'silicon' ),
				'min'      => 0,
				'max'      => 100,
				'units'    => '%',
				'default'  => silicon_get_option( 'footer_overlay_opacity', 75 ),
				'required' => array( 'footer_background', '=', 'image' ),
			) )
			->add_column( 2 )
			->add_field( 'footer_overlay_color', 'color', array(
				'label'    => esc_html__( 'Overlay Color', 'silicon' ),
				'default'  => silicon_get_option( 'footer_overlay_color', '#000000' ),
				'required' => array(
					array( 'footer_background', '=', 'image' ),
					array( 'footer_overlay_option', 'in_array', array( 'default', 'solid' ) ),
				),
			) )
			->add_row()
			->add_column( 6 )
			->add_field( 'footer_skin', 'select', array(
				'label'       => esc_html__( 'Content Skin', 'silicon' ),
				'description' => esc_html__( 'This option let you control how Widgets inside Footer will look.', 'silicon' ),
				'default'     => 'light',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					'light'   => esc_html__( 'Light', 'silicon' ),
					'dark'    => esc_html__( 'Dark', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'footer_is_fullwidth', 'select', array(
				'label'       => esc_html__( 'Make Footer Full Width?', 'silicon' ),
				'description' => esc_html__( 'If enabled Footer content will occupy the 100% of the page width.', 'silicon' ),
				'default'     => 'default',
				'options'     => array(
					'default' => esc_html__( 'Default', 'silicon' ),
					1         => esc_html__( 'Enable', 'silicon' ),
					0         => esc_html__( 'Disable', 'silicon' ),
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Intros Tab">
		$intros = $layout->add_tab( 'tab-intros', esc_html__( 'Intros', 'silicon' ) );
		$intros
			->add_row()
			->add_column( 2 )
			->add_field( 'intro_label', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<h3>' . esc_html__( 'Intro', 'silicon' ) . '</h3>',
				'attr'    => array( 'class' => 'equip-labeled' ),
			) )
			->add_column( 6 )
			->add_field( 'intro', 'select', array(
				'description' => esc_html__(
					'This option allows you to enable Intro Section for current page.
					Make sure you have Intro Sections in your Dashboard > Intros.',
					'silicon'
				),
				'sanitize'    => 'absint',
				'escape'      => 'absint',
				'default'     => 0,
				'options'     => call_user_func( function () {
					$options    = array();
					$options[0] = esc_html__( 'None', 'silicon' );

					$posts = get_posts( array(
						'post_type'        => 'silicon_intro',
						'post_status'      => 'publish',
						'posts_per_page'   => - 1,
						'orderby'          => 'ID',
						'order'            => 'ASC',
						'suppress_filters' => true,
						'no_found_rows'    => true,
					) );

					if ( empty( $posts ) || is_wp_error( $posts ) ) {
						return $options;
					}

					/** @var WP_Post $post */
					foreach ( (array) $posts as $post ) {
						$options[ $post->ID ] = empty( $post->post_title ) ? esc_html__( '(no title)', 'silicon' ) : $post->post_title;
					}

					return $options;
				} ),
			) )
			->add_field( 'intros_disclaimer', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => wp_kses(
					__(
						'<strong>NOTE:</strong> Intro Section appears at the most top of the page and overrides your current Page Title',
						'silicon'
					),
					array( 'strong' => true )
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Appearance Tab for Posts">
		if ( 'post' === $screen->post_type ) {
			$appearance = $layout->add_tab( 'tab-appearance-post', esc_html__( 'Appearance', 'silicon' ) );
			$appearance
				->add_field( 'single_layout', 'image_select', array(
					'label'   => esc_html__( 'Layout', 'silicon' ),
					'default' => 'default',
					'width'   => 250,
					'height'  => 200,
					'options' => call_user_func( function () {
						$options = silicon_options_variants_single();
						$default = array(
							'default' => array(
								'src'   => SILICON_TEMPLATE_URI . '/img/options/blog/default.png',
								'label' => esc_html__( 'Default', 'silicon' ),
							),
						);

						return array_merge( $default, $options );
					} ),
				) )
				->add_row()
				->add_column( 3 )
				->add_field( 'single_is_tile_author', 'select', array(
					'label'   => esc_html__( 'Author in Post Tile', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'silicon' ),
						1         => esc_html__( 'Enable', 'silicon' ),
						0         => esc_html__( 'Disable', 'silicon' ),
					),
				) )
				->add_field( 'single_is_shares', 'select', array(
					'label'   => esc_html__( 'Sharing Buttons', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'silicon' ),
						1         => esc_html__( 'Enable', 'silicon' ),
						0         => esc_html__( 'Disable', 'silicon' ),
					),
				) )
				->add_column( 3 )
				->add_field( 'single_is_post_author', 'select', array(
					'label'   => esc_html__( 'Author in Single Post', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'silicon' ),
						1         => esc_html__( 'Enable', 'silicon' ),
						0         => esc_html__( 'Disable', 'silicon' ),
					),
				) )
				->add_field( 'single_is_featured_image', 'select', array(
					'label'   => esc_html__( 'Featured Image in Single Post', 'silicon' ),
					'default' => 'default',
					'options' => array(
						'default' => esc_html__( 'Default', 'silicon' ),
						1         => esc_html__( 'Enable', 'silicon' ),
						0         => esc_html__( 'Disable', 'silicon' ),
					),
				) );

			unset( $appearance );
		}
		//</editor-fold>

		//<editor-fold desc="Appearance Tab for Portfolio">
		if ( 'silicon_portfolio' === $screen->post_type ) {
			$appearance = $layout
				->add_tab( 'tab-appearance-portfolio', esc_html__( 'Appearance', 'silicon' ) )
				->add_row()
				->add_column( 8 );

			$appearance->add_field( 'portfolio_layout', 'select', array(
				'label'       => esc_html__( 'Layout', 'silicon' ),
				'description' => esc_html__(
					'This option changes the layout of single portfolio post, but doesn\'t affect
					the portfolio tile. For portfolio tiles this will enable the "Gallery" behaviour.',
					'silicon'
				),
				'default'     => 'blank',
				'options'     => array(
					'blank'        => esc_html__( 'Blank', 'silicon' ),
					'side-gallery' => esc_html__( 'Side Gallery', 'silicon' ),
					'slider'       => esc_html__( 'Slider', 'silicon' ),
					'wide-gallery' => esc_html__( 'Wide Gallery', 'silicon' ),
				),
			) );

			$appearance->add_field( 'portfolio_gallery', 'media', array(
				'label'    => esc_html__( 'Upload Images', 'silicon' ),
				'multiple' => true,
				'sortable' => true,
				'required' => array( 'portfolio_layout', '!=', 'blank' ),
			) );

			$appearance->add_field( 'portfolio_exclude_fi', 'switch', array(
				'label'       => esc_html__( 'Exclude Featured Image', 'silicon' ),
				'description' => esc_html__( 'Enabling this switch will remove the Featured Images from the Gallery.', 'silicon' ),
				'default'     => false,
				'required'    => array(
					array( 'portfolio_layout', '!=', 'blank' ),
					array( 'portfolio_gallery', 'not_empty' )
				)
			) );

			$appearance->add_field( 'portfolio_is_toolbar', 'switch', array(
				'label'       => esc_html__( 'Toolbar', 'silicon' ),
				'description' => esc_html__( 'Enable / Disable Toolbar', 'silicon' ),
				'default'     => false,
			) );

			$appearance->add_field( 'portfolio_button_text', 'text', array(
				'label'    => esc_html__( 'Project Button Text', 'silicon' ),
				'default'  => esc_html__( 'View Project', 'silicon' ),
				'required' => array( 'portfolio_is_toolbar', '=', 1 )
			) );

			$appearance->add_field( 'portfolio_button_url', 'text', array(
				'label'       => esc_html__( 'Project Button URL', 'silicon' ),
				'description' => esc_html__( 'A link to live project.', 'silicon' ),
				'sanitize'    => 'esc_url_raw',
				'escape'      => 'esc_url',
				'required'    => array( 'portfolio_is_toolbar', '=', 1 )
			) );

			$appearance->add_field( 'portfolio_is_share', 'switch', array(
				'label'       => esc_html__( 'Share Button', 'silicon' ),
				'description' => esc_html__( 'Enable / Disable Share', 'silicon' ),
				'default'     => true,
				'required'    => array( 'portfolio_is_toolbar', '=', 1 )
			) );
		}
		//</editor-fold>

		equip_add_meta_box( SILICON_PAGE_SETTINGS, $layout, array(
			'id'       => 'silicon-page-settings',
			'title'    => esc_html__( 'Page Settings', 'silicon' ),
			'screen'   => apply_filters( 'silicon_page_settings_screen', array( 'page', 'post' ) ),
			'context'  => 'normal',
			'priority' => 'default',
		) );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'current_screen', 'silicon_meta_box_page_settings' );

/**
 * Add meta box "Display Category" for post
 *
 * User can control
 *
 * @param WP_Screen $screen Current screen
 */
function silicon_meta_box_display_category( $screen ) {
	if ( 'post' !== $screen->post_type ) {
		return;
	}

	try {
		$layout = equip_create_meta_box_layout();
		$layout->add_field( 'c', 'select', array(
			'description' => esc_html__(
				'Here you can choose which category will be displayed on Post Preview Tile.
				By default all categories attached to this post will be displayed.',
				'silicon'
			),
			'default'     => 'all',
			'options'     => call_user_func( function () use ( $screen ) {
				$options         = array();
				$options['all']  = esc_html__( 'Show All', 'silicon' );
				$options['none'] = esc_html__( 'Hide All', 'silicon' );

				// add assigned categories to options list
				if ( isset( $_GET['post'] ) ) {
					$categories = get_the_terms( (int) $_GET['post'], 'category' );
					if ( ! empty( $categories ) ) {
						/** @var WP_Term $category */
						foreach ( $categories as $category ) {
							$options[ $category->term_id ] = $category->name;
						}
					}
				}

				return $options;
			} ),
		) );

		equip_add_meta_box( '_silicon_display_category', $layout, array(
			'id'       => 'silicon-display-category',
			'title'    => esc_html__( 'Display Category', 'silicon' ),
			'screen'   => 'post',
			'context'  => 'side',
			'priority' => 'default',
		) );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'current_screen', 'silicon_meta_box_display_category' );

/**
 * Add meta box "Related Posts"
 *
 * @param WP_Screen $screen Current screen
 */
function silicon_meta_box_related_posts( $screen ) {
	if ( 'post' !== $screen->post_type ) {
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
				'default' => '<h3>' . esc_html__( 'Enable / Disable', 'silicon' ) . '</h3>',
				'attr'    => array( 'class' => 'equip-labeled' ),
			) )
			->add_column( 6 )
			->add_field( 'is_enabled', 'switch', array(
				'default' => false,
			) )
			->add_field( 'label', 'text', array(
				'label'    => esc_html__( 'Title', 'silicon' ),
				'default'  => esc_html__( 'Related Posts', 'silicon' ),
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

					/**
					 * Filter the arguments passed to {@see get_posts()}
					 *
					 * May be useful if you want to show another posts in "Related Posts" block
					 *
					 * @param array $args Arguments
					 */
					$posts = get_posts( apply_filters( 'silicon_meta_box_related_posts_args', array(
						'post_type'           => 'post',
						'post_status'         => 'publish',
						'posts_per_page'      => - 1,
						'orderby'             => 'ID',
						'order'               => 'ASC',
						'exclude'             => empty( $_GET['post'] ) ? 0 : (int) $_GET['post'],
						// exclude current post
						'suppress_filters'    => true,
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					) ) );

					$result = array();
					foreach ( $posts as $post ) {
						$result[ $post->ID ] = empty( $post->post_title ) ? esc_html__( '(no title)', 'silicon' ) : $post->post_title;
					}

					return $result;
				} ),
			) );

		equip_add_meta_box( '_silicon_related', $layout, array(
			'id'     => 'silicon-related-posts',
			'title'  => esc_html__( 'Related Posts', 'silicon' ),
			'screen' => 'post',
		) );

	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() );
	}
}

add_action( 'current_screen', 'silicon_meta_box_related_posts' );
