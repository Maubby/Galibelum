<?php
/**
 * Theme Options
 *
 * @author 8guild
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

if ( ! is_admin() ) {
	return;
}

/**
 * Add Theme Options
 *
 * @uses equip_add_options_page()
 */
function silicon_options() {
	try {
		// create a layout for options
		$layout = equip_create_options_layout();

		$layout = silicon_options_colors( $layout );
		$layout = silicon_options_typography( $layout );
		$layout = silicon_options_header( $layout );
		$layout = silicon_options_footer( $layout );
		$layout = silicon_options_blog( $layout );
		$layout = silicon_options_shop( $layout );
		$layout = silicon_options_404( $layout );
		$layout = silicon_options_general( $layout );
		$layout = silicon_options_advanced( $layout );

		// register options through Equip
		equip_add_options_page( SILICON_OPTIONS, $layout, array(
			'page_title'  => esc_html__( 'Silicon Options', 'silicon' ),
			'menu_title'  => esc_html__( 'Theme Options', 'silicon' ),
			'capability'  => 'edit_theme_options',
			'menu_slug'   => 'silicon-options',
			'parent_slug' => 'silicon',
			'icon_url'    => '',
			'position'    => '3.33',
			'extensions'  => array(
				array(
					'name'     => 'css',
					'callback' => array( '\\Equip\\Extension\\CssExtension', 'setup' ),
					'settings' => array(
						'option'      => SILICON_COMPILED,
						'option_copy' => SILICON_COMPILED . '_copy',
					),
				)
			),
		) );

	} catch ( Exception $e ) {
		trigger_error( 'Theme Options: ' . $e->getMessage() );
	}
}

add_action( 'equip/register', 'silicon_options' );

/**
 * Add Colors options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_colors( $layout ) {

	try {
		$colors = $layout->add_section( 'colors', esc_html__( 'Colors', 'silicon' ), array(
			'icon' => 'dashicons dashicons-admin-customizer',
		) );

		//<editor-fold desc="Accent Colors Anchor in Global Colors Options">
		$accent = $colors->add_anchor( 'colors_accent', esc_html__( 'Accent Colors', 'silicon' ) );
		$accent
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_accent_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Accent colors are used across the website for various shortcodes and elements like links, navigation, buttons, etc. Here you can change them globally. Some colors like headings, body, navigation, etc. can be individually adjusted in the options below.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_primary', 'color', array(
				'label'   => esc_html__( 'Primary', 'silicon' ),
				'default' => '#3d59f9',
				'css'     => array(
					'vars' => '$brand-primary',
					'code' => '
						.text-primary { color: $brand-primary !important; }
						.background-primary { background-color: $brand-primary; }
						.bg-primary { background-color: rgba($brand-primary, .25); }
						.border-color-primary { border-color: $brand-primary; }
						.widget_tag_cloud,
						.widget_product_tag_cloud,
						.bbp-page-title-tags,
						.tags-links {
						  a:hover { background-color: $brand-primary; }
						}
						#bbp-user-navigation .current a { color: $brand-primary !important; }
						.pagination .nav-links .page-numbers.current  {
						  background-color: $brand-primary;
						}
						.site-footer.footer-light {
						  .widget_tag_cloud,
						  .widget_product_tag_cloud,
						  .tags-links {
						    a:hover { background-color: $brand-primary; }
						  }
						}
						.cart-toggle .product-count {
						  border-color: $brand-primary;
						  color: $brand-primary;
						}
						.intro-section.intro-comparison .cd-handle { background-color: $brand-primary; }
						.woocommerce-MyAccount-navigation ul li.is-active a { color: $brand-primary !important; }
						.woocommerce div.product div.images .flex-control-thumbs li:after { background-color: $brand-primary; }
						.woocommerce .widget_price_filter .ui-slider .ui-slider-range { background-color: $brand-primary; }
						.btn-solid.btn-primary { background-color: $brand-primary; }
						.btn-solid.btn-primary:hover {
						  background-color: darken($brand-primary, 8%);
						  box-shadow: 0 14px 25px -8px rgba($brand-primary, .55);
						}
						.btn-ghost.btn-primary {
						  border-color: $brand-primary;
						  color: $brand-primary;
						}
						.btn-ghost.btn-primary::before { background-color: $brand-primary; }
						.btn-ghost.btn-primary:hover {
						  color: #fff;
						  box-shadow: 0 14px 25px -8px rgba($brand-primary, .55);
						}
						.btn-link.btn-primary { color: $brand-primary; }
						.btn-link.btn-primary:hover {
						  background-color: #fff;
						  color: $brand-primary;
						  box-shadow: 0 14px 25px -8px rgba($brand-primary, .45);
						}
						.counter.counter-iconed:hover {
						  .counter-icon-box {
						    border-color: $brand-primary;
						    box-shadow: 0 12px 30px -2px rgba($brand-primary, .3);
						  }
						}
						.hotspots-container .hotspot {
						  background-color: rgba($brand-primary, .5);
						  &::before { background-color: rgba($brand-primary, .5); }
						  &::after { background-color: $brand-primary; }
						}
						.sb-mail { color: $brand-primary; }
						.social-button.sb-monochrome.sb-mail {
						  .hvrd { color: $brand-primary; }
						}
						.nav-tabs,
						.wc-tabs,
						.nav-filters > ul > li {
						  &.active > a,
						  &.active > a:hover,
						  &.active > a:focus { background-color: $brand-primary; }
						}
					'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_info', 'color', array(
				'label'   => esc_html__( 'Info', 'silicon' ),
				'default' => '#5695fe',
				'css'     => array(
					'vars' => '$brand-info',
					'code' => '
						.text-info { color: $brand-info !important; }
						.background-info { background-color: $brand-info; }
						.bg-info { background-color: rgba($brand-info, .25); }
						.border-color-info { border-color: $brand-info; }
						.woocommerce-info::before { color: $brand-info; }
						.btn-solid.btn-info { background-color: $brand-info; }
						.btn-solid.btn-info:hover {
						  background-color: darken($brand-info, 8%);
						  box-shadow: 0 14px 25px -8px rgba($brand-info, .6);
						}
						.btn-ghost.btn-info {
						  border-color: $brand-info;
						  color: $brand-info;
						}
						.btn-ghost.btn-info::before { background-color: $brand-info; }
						.btn-ghost.btn-info:hover {
						  color: #fff;
						  box-shadow: 0 14px 25px -8px rgba($brand-info, .6);
						}
						.btn-link.btn-info { color: $brand-info; }
						.btn-link.btn-info:hover {
						  background-color: #fff;
						  color: $brand-info;
						  box-shadow: 0 14px 25px -8px rgba($brand-info, .45);
						}
					'
				),
			) )
			->add_column( 2 )
			->add_field( 'colors_success', 'color', array(
				'label'   => esc_html__( 'Success', 'silicon' ),
				'default' => '#00e676',
				'css'     => array(
					'vars' => '$brand-success',
					'code' => '
						.text-success { color: $brand-success !important; }
						.background-success { background-color: $brand-success; }
						.bg-success { background-color: rgba($brand-success, .25); }
						.border-color-success { border-color: $brand-success; }
						.woocommerce-message::before { color: $brand-success; }
						.wpcf7-response-output.wpcf7-mail-sent-ok {
						  border-color: $brand-success !important;
						  background-color: rgba($brand-success, .15);
						  color: darken($brand-success, 5%);
						}
						.btn-solid.btn-success { background-color: $brand-success; }
						.btn-solid.btn-success:hover {
						  background-color: darken($brand-success, 8%);
						  box-shadow: 0 14px 25px -8px rgba($brand-success, .6);
						}
						.btn-ghost.btn-success {
						  border-color: $brand-success;
						  color: $brand-success;
						}
						.btn-ghost.btn-success::before { background-color: $brand-success; }
						.btn-ghost.btn-success:hover {
						  color: #fff;
						  box-shadow: 0 14px 25px -8px rgba($brand-success, .6);
						}
						.btn-link.btn-success { color: $brand-success; }
						.btn-link.btn-success:hover {
						  background-color: #fff;
						  color: $brand-success;
						  box-shadow: 0 14px 25px -8px rgba($brand-success, .45);
						}
					'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_warning', 'color', array(
				'label'   => esc_html__( 'Warning', 'silicon' ),
				'default' => '#ff5f2c',
				'css'     => array(
					'vars' => '$brand-warning',
					'code' => '
						.text-warning { color: $brand-warning !important; }
						.background-warning { background-color: $brand-warning; }
						.bg-warning { background-color: rgba($brand-warning, .25); }
						.border-color-warning { border-color: $brand-warning; }
						.woocommerce-error::before { color: $brand-warning; }
						.comment-form-rating .star-rating::before { color: $brand-warning; }
						.wpcf7-response-output.wpcf7-mail-sent-ng {
						  border-color: $brand-warning !important;
						  background-color: rgba($brand-warning, .15);
						  color: $brand-warning;
						}
						.btn-solid.btn-warning { background-color: $brand-warning; }
						.btn-solid.btn-warning:hover {
						  background-color: darken($brand-warning, 8%);
						  box-shadow: 0 14px 25px -8px rgba($brand-warning, .6);
						}
						.btn-ghost.btn-warning {
						  border-color: $brand-warning;
						  color: $brand-warning;
						}
						.btn-ghost.btn-warning::before { background-color: $brand-warning; }
						.btn-ghost.btn-warning:hover {
						  color: #fff;
						  box-shadow: 0 14px 25px -8px rgba($brand-warning, .6);
						}
						.btn-link.btn-warning { color: $brand-warning; }
						.btn-link.btn-warning:hover {
						  background-color: #fff;
						  color: $brand-warning;
						  box-shadow: 0 14px 25px -8px rgba($brand-warning, .45);
						}
					'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_danger', 'color', array(
				'label'   => esc_html__( 'Danger', 'silicon' ),
				'default' => '#ff5252',
				'css'     => array(
					'vars' => '$brand-danger',
					'code' => '
						.text-danger { color: $brand-danger !important; }
						.background-danger { background-color: $brand-danger; }
						.bg-danger { background-color: rgba($brand-danger, .25); }
						.border-color-danger { border-color: $brand-danger; }
						.woocommerce span.onsale { background-color: $brand-danger; }
						.widget_shopping_cart .product-item .remove-from-cart:hover { background-color: $brand-danger; }
						.wpcf7-not-valid-tip, .nf-error-required-error { color: $brand-danger !important; }
						.nf-error-required-error { padding-top: 5px; }
						.wpcf7-not-valid,
						.nf-error textarea,
						.nf-error input[type]:not([type=\'submit\']):not([type=\'button\']):not([type=\'hidden\']):not([type=\'checkbox\']):not([type=\'radio\']):not([type=\'file\']) {
						  border-color: $brand-danger !important;
						}
						.wpcf7-response-output.wpcf7-validation-errors {
						  border-color: $brand-danger !important;
						  background-color: rgba($brand-danger, .15);
						  color: $brand-danger;
						}
						.offcanvas-container.offcanvas-cart .product-item .remove-from-cart:hover { color: $brand-danger; }
						.btn-solid.btn-danger { background-color: $brand-danger; }
						.btn-solid.btn-danger:hover {
						  background-color: darken($brand-danger, 8%);
						  box-shadow: 0 14px 25px -8px rgba($brand-danger, .6);
						}
						.btn-ghost.btn-danger {
						  border-color: $brand-danger;
						  color: $brand-danger;
						}
						.btn-ghost.btn-danger::before { background-color: $brand-danger; }
						.btn-ghost.btn-danger:hover {
						  color: #fff;
						  box-shadow: 0 14px 25px -8px rgba($brand-danger, .6);
						}
						.btn-link.btn-danger { color: $brand-danger; }
						.btn-link.btn-danger:hover {
						  background-color: #fff;
						  color: $brand-danger;
						  box-shadow: 0 14px 25px -8px rgba($brand-danger, .45);
						}
					'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Theme Gradient Anchor in Global Colors Options">
		$gradient = $colors->add_anchor( 'colors_gradient', esc_html__( 'Theme Gradient', 'silicon' ) );
		$gradient
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_gradient_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Here you can set the start and end colors fo main Gradient used across website inside elements like buttons, backgrounds, etc.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_gradient', 'gradient', array(
				'default' => array( 'from' => '#8e54e9', 'to' => '#3d59f9' ),
				'css'     => array(
					'vars' => array( '$gradient-color-1', '$gradient-color-2' ),
					'code' => '
						.bg-gradient {
						  background: $gradient-color-2;
						  background: linear-gradient(to right, $gradient-color-1 0%, $gradient-color-1 20%, $gradient-color-2 100%);
						  color: #fff !important;
						}
						.background-gradient {
						  background: $gradient-color-2;
						  background: linear-gradient(to right, $gradient-color-1 0%, $gradient-color-1 20%, $gradient-color-2 100%);
						}
						.btn-solid.btn-gradient {
						  background: $gradient-color-2;
						  background: linear-gradient(to right, $gradient-color-1 0%, $gradient-color-1 20%, $gradient-color-2 100%);
						  color: #fff;
						  &:hover {
						    background: $gradient-color-2;
						    background: linear-gradient(to right, $gradient-color-1 0%, $gradient-color-1 20%, $gradient-color-2 100%);
						    color: #fff;
						    box-shadow: 0 14px 25px -8px rgba($gradient-color-2, .55);
						  }
						}
						.btn-link.btn-gradient:hover {
						  box-shadow: 0 14px 25px -8px rgba($gradient-color-2, .55);
						}
						.btn-link.btn-gradient::before {
						  background: linear-gradient(to right, $gradient-color-1, $gradient-color-2);
						}
					'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Body Colors Anchor in Global Colors Options">
		$body = $colors->add_anchor( 'colors_body', esc_html__( 'Body', 'silicon' ) );
		$body
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_body_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Here you can set the body background color and body text color like default paragraph color.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_body_bg', 'color', array(
				'label'   => esc_html__( 'Body Background', 'silicon' ),
				'default' => '#ffffff',
				'css'     => array(
					'vars' => '$body-bg',
					'code' => '
						body,.intro-section + * { background-color: $body-bg; }
						.pagination{background-color: $body-bg;}
					'
				),
			) )
			->add_column( 2 )
			->add_field( 'colors_body_text', 'color', array(
				'label'   => esc_html__( 'Body Text', 'silicon' ),
				'default' => '#404040',
				'css'     => array(
					'vars' => '$text-color',
					'code' => '
						body,
						.comments-area .logged-in-as > a,
						.topbar .additional-info a,
						.topbar .topbar-menu ul > li > a,
						.topbar .login-link,
						.caret,
						.portfolio-post-tile .portfolio-post-info .portfolio-tile-title a,
						.woocommerce div.product p.price,
						.woocommerce div.product span.price,
						.si-logos-item .si-logos-info { color: $text-color; }
						.topbar.topbar-light-skin {
						  color: #fff;
						  .additional-info > *,
						  .topbar-menu ul > li > a,
						  .login-link,
						  .lang-switcher .caret { color: #fff; }
						}
						
						.comments-area .logged-in-as > a {
						  color: $text-color;
						  &:hover { color: $navi-link-color; }
						}
						.tabs-light,
						.filters-light {
						  .nav-tabs li,
						  &.nav-filters li {
						    a {
						      color: #fff;
						      &:hover {
						        color: $text-color;
						      }
						    }
						    &.active a { color: #fff; }
						  }
						}
					'
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Headings Color Anchor in Global Colors Options">
		$headings = $colors->add_anchor( 'colors_headings', esc_html__( 'Headings', 'silicon' ) );
		$headings
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_headings_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Here you can adjust individually the color of each heading from H1 through H6.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_headings_h1', 'color', array(
				'label'   => esc_html__( 'Heading 1', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$h1-color',
					'code' => 'h1, .h1 { color: $h1-color; }',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_headings_h2', 'color', array(
				'label'   => esc_html__( 'Heading 2', 'silicon' ),
				'default' => '#222222',
				array(
					'vars' => '$h2-color',
					'code' => 'h2, .h2 { color: $h2-color; }',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_headings_h3', 'color', array(
				'label'   => esc_html__( 'Heading 3', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$h3-color',
					'code' => 'h3, .h3 { color: $h3-color; }',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_headings_h4', 'color', array(
				'label'   => esc_html__( 'Heading 4', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$h4-color',
					'code' => 'h4, .h4 { color: $h4-color; }'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_headings_h5', 'color', array(
				'label'   => esc_html__( 'Heading 5', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$h5-color',
					'code' => 'h5, .h5 { color: $h5-color; }',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_headings_h6', 'color', array(
				'label'   => esc_html__( 'Heading 6', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$h6-color',
					'code' => 'h6, .h6 { color: $h6-color; }',
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Text Link Color Anchor in Global Colors Options">
		$link = $colors->add_anchor( 'colors_link', esc_html__( 'Text Link', 'silicon' ) );
		$link
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_links_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'These are color options for inline (text) link normal and hover state. Default value is the same as Primary accent color.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_link', 'color', array(
				'label'   => esc_html__( 'Link', 'silicon' ),
				'default' => '#3d59f9',
				'master'  => array( 'colors_primary' ),
				'css'     => array(
					'vars' => '$link-color',
					'code' => 'a { color: $link-color; }'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_link_hover', 'color', array(
				'label'   => esc_html__( 'Link Hover', 'silicon' ),
				'default' => '#3d59f9',
				'master'  => array( 'colors_primary' ),
				'css'     => array(
					'vars' => '$link-hover-color',
					'code' => 'a:hover { color: $link-hover-color; }'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Blockquote Color Anchor in Global Colors Options">
		$quote = $colors->add_anchor( 'colors_quote', esc_html__( 'Quotation', 'silicon' ) );
		$quote
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_quote_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Blockquote color options. You can set blockquote body text color, quotation mark color and author name color. DO NOT confuse <blockquote> with Testimonials element.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_quote_text', 'color', array(
				'label'   => esc_html__( 'Quotation Text', 'silicon' ),
				'default' => '#404040',
				'master'  => array( 'colors_body_text' ),
				'css'     => array(
					'vars' => '$quote-text-color',
					'code' => 'blockquote { color: $quote-text-color; }',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_quote_mark', 'color', array(
				'label'   => esc_html__( 'Quotation Mark', 'silicon' ),
				'default' => '#e7e7e7',
				'css'     => array(
					'vars' => '$quote-mark-color',
					'code' => 'blockquote::before { color: $quote-mark-color; }',
				),
			) )
			->add_column( 2 )
			->add_field( 'colors_quote_author', 'color', array(
				'label'   => esc_html__( 'Quotation Author', 'silicon' ),
				'default' => '#999999',
				'css'     => array(
					'vars' => '$quote-author-color',
					'code' => 'blockquote cite { color: $quote-author-color; }',
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Navigation Colors Anchor in Global Colors Options">
		$navi = $colors->add_anchor( 'colors_navi', esc_html__( 'Navigation', 'silicon' ) );
		$navi
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_navi_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'This section includes color options for navigation group of elements which include but not limited to: Menu Links, Submenu Links, Pagination, Post Navigation, Tabs & Filters, Pagelinks, Linked Titles, Tags, Breadcrumbs, etc. We combined them in one group to keep website colors consistent. If you need to change styling of individual element use WordPress Customizer which is found under Appearance -> Customize -> Additional CSS.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_navi_link_normal', 'color', array(
				'label'   => esc_html__( 'Normal State', 'silicon' ),
				'default' => '#222222',
				'css'     => array(
					'vars' => '$navi-link-color',
					'code' => '
						.navi-link-color { color: $navi-link-color !important; }
						.pagination .nav-links .page-numbers {
						  color: $navi-link-color;
						  &.current { color: #fff; }
						}
						.widget {
						  div > ul,
						  > ul > li {
						    a {
						      color: $navi-link-color;
						      &:hover { color: $navi-link-hover-color; }
						    }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.widget_tag_cloud,
						.widget_product_tag_cloud,
						.bbp-page-title-tags,
						.tags-links {
						  a {
						    color: $navi-link-color;
						    &:hover { color: #fff; }
						  }
						}
						.widget_calendar a {
						  color: $navi-link-color;
						  &:hover { color: $navi-link-hover-color; }
						}
						.widget_rss  .widget-title > a {
						  color: $navi-link-color;
						  &:hover { color: $navi-link-hover-color; }
						}
						.site-header .sub-menu {
						  > li {
						    > a {
						      color: $navi-link-color;
						      &:hover { color: $navi-link-hover-color; }
						    }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.navbar-horizontal .menu-wrap .main-navigation {
						  > ul  > li {
						    > a {
						      color: $navi-link-color;
						      &:hover { color: $navi-link-hover-color; }
						    }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a {
						      color: $navi-link-active-color;
						    }
						  }
						}
						.site-search-toggle,
						.cart-toggle,
						.offcanvas-menu-toggle {
						  color: $navi-link-color;
						  &:hover { color: $navi-link-hover-color; }
						  &.active { color: $navi-link-active-color; }
						}
						.menu-skin-light {
						  .site-search-toggle,
						  .cart-toggle,
						  .offcanvas-menu-toggle {
						    color: #fff;
						    &:hover,
						    &.active { color: rgba(255, 255, 255, .6); }
						  }
						  .mobile-menu-toggle { color: #fff; }
						}
						.menu-skin-light {
						  .cart-toggle .product-count { color: #fff !important; }
						  .menu-wrap .main-navigation {
						    > ul > li {
						      > a {
						        color: #fff !important;
						        &::before { background-color: #fff !important; }
						        &:hover { color: rgba(255, 255, 255, .6) !important; }
						      }
						      &.current-menu-item > a,
						      &.current-menu-ancestor > a { color: #fff !important; }
						    }
						  }
						}
						.header-lateral .main-navigation > ul {
						  > li {
						    > a {
						      color: $navi-link-color;
						      &:hover { color: $navi-link-hover-color; }
						    }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a {
						      color: $navi-link-active-color;
						    }
						  }
						}
						.panel-title > a { color: $navi-link-color; }
						.panel-group-light .panel-title > a { color: #fff; }
					'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_navi_link_hover', 'color', array(
				'label'   => esc_html__( 'Hover State', 'silicon' ),
				'default' => '#3d59f9',
				'master'  => array( 'colors_primary' ),
				'css'     => array(
					'vars' => '$navi-link-hover-color',
					'code' => '
						.navi-link-hover-color:hover { color: $navi-link-hover-color !important; }
						.widget {
						  div > ul,
						  > ul > li {
						    a :hover { color: $navi-link-hover-color; }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.widget_calendar a:hover,
						.widget_rss .widget-title > a:hover { color: $navi-link-hover-color; }
						.site-header .sub-menu {
						  > li {
						    > a:hover { color: $navi-link-hover-color; }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.navbar-horizontal .menu-wrap .main-navigation {
						  > ul  > li {
						    > a:hover { color: $navi-link-hover-color; }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.site-search-toggle,
						.cart-toggle,
						.offcanvas-menu-toggle {
						  &:hover { color: $navi-link-hover-color; }
						  &.active { color: $navi-link-active-color; }
						}
						.menu-skin-light {
						  .site-search-toggle,
						  .cart-toggle,
						  .offcanvas-menu-toggle {
						    &:hover,
						    &.active { color: rgba(255, 255, 255, .6); }
						  }
						}
						.menu-skin-light {
						  .cart-toggle .product-count { color: #fff !important; }
						  .menu-wrap .main-navigation {
						    > ul > li {
						      > a {
						        &::before { background-color: #fff !important; }
						        &:hover { color: rgba(255, 255, 255, .6) !important; }
						      }
						      &.current-menu-item > a,
						      &.current-menu-ancestor > a { color: #fff !important; }
						    }
						  }
						}
						.header-lateral .main-navigation > ul {
						  > li {
						    > a:hover { color: $navi-link-hover-color; }
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.breadcrumbs a:hover { color: $navi-link-hover-color; }
						.post-tile:not(.has-post-thumbnail),
						.post-horizontal:not(.has-post-thumbnail) {
						  .post-header .post-categories > a:hover { color: $navi-link-hover-color !important; }
						}
					',
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_navi_link_active', 'color', array(
				'label'   => esc_html__( 'Active State', 'silicon' ),
				'default' => '#3d59f9',
				'master'  => array( 'colors_primary' ),
				'css'     => array(
					'vars' => '$navi-link-active-color',
					'code' => '
						.widget {
						  div > ul,
						  > ul > li {
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
						.site-header .sub-menu > li {
						  &.current-menu-item > a,
						  &.current-menu-ancestor > a { color: $navi-link-active-color; }
						}
						.navbar-horizontal .menu-wrap .main-navigation {
						  > ul  > li {
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a {
						      color: $navi-link-active-color;
						    }
						  }
						}
						.navbar-horizontal .menu-wrap .main-navigation>ul>li>a:before {
						  background-color: $navi-link-active-color;
						}
						.site-search-toggle,
						.cart-toggle,
						.offcanvas-menu-toggle {
						  &.active { color: $navi-link-active-color; }
						}
						.menu-skin-light {
						  .site-search-toggle,
						  .cart-toggle,
						  .offcanvas-menu-toggle {
						    &.active { color: rgba(255, 255, 255, .6); }
						  }
						}
						.menu-skin-light {
						  .cart-toggle .product-count { color: #fff !important; }
						  .menu-wrap .main-navigation {
						    > ul > li {
						      > a {
						        &::before { background-color: #fff !important; }
						      }
						      &.current-menu-item > a,
						      &.current-menu-ancestor > a { color: #fff !important; }
						    }
						  }
						}
						.header-lateral .main-navigation > ul {
						  > li {
						    &.current-menu-item > a,
						    &.current-menu-ancestor > a { color: $navi-link-active-color; }
						  }
						}
					'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Forms Anchor in Global Colors Options">
		$forms = $colors->add_anchor( 'colors_forms', esc_html__( 'Forms', 'silicon' ) );
		$forms
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_forms_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'These color options globally apply to all form elements like input, selects, textareas, checkboxes and radios.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_input_label', 'color', array(
				'label'   => esc_html__( 'Label Color', 'silicon' ),
				'default' => '#999999',
				'css'     => array(
					'vars' => '$form-label-color',
					'code' => 'label,.nf-field-label > label { color: $form-label-color; }'
				),
			) )
			->add_column( 2 )
			->add_field( 'colors_input_text', 'color', array(
				'label'   => esc_html__( 'Input Text Color', 'silicon' ),
				'default' => '#404040',
				'css'     => array(
					'vars' => '$form-text-color',
					'code' => '
						textarea,
						select,
						input[type]:not([type=\'submit\']):not([type=\'button\']):not([type=\'hidden\']):not([type=\'checkbox\']):not([type=\'radio\']):not([type=\'file\']) {
						  color: $form-text-color;
						}
					'
				),
			) )
			->add_column( 3 )
			->add_field( 'colors_input_placeholder', 'color', array(
				'label'   => esc_html__( 'Input Placeholder Color', 'silicon' ),
				'default' => '#999999',
				'css'     => array(
					'vars' => '$form-placeholder-color',
					'code' => '
						textarea,
						select,
						input[type]:not([type=\'submit\']):not([type=\'button\']):not([type=\'hidden\']):not([type=\'checkbox\']):not([type=\'radio\']):not([type=\'file\']) {
						  &::-moz-placeholder {
						    color: $form-placeholder-color;
						    opacity: 1;
						  }
						  &:-ms-input-placeholder { color: $form-placeholder-color; }
						  &::-webkit-input-placeholder  { color: $form-placeholder-color; }
						}
					'
				)
			) )
			->add_column( 2 )
			->add_field( 'colors_input_icon', 'color', array(
				'label'   => esc_html__( 'Input Icon Color', 'silicon' ),
				'default' => '#999999',
				'css'     => array(
					'vars' => '$form-icon-color',
					'code' => '.search-box button[type=\'submit\'],.input-group i { color: $form-icon-color; }'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Widgets Anchor in Global Colors Options">
		$widgets = $colors->add_anchor( 'colors_widgets', esc_html__( 'Widgets', 'silicon' ) );
		$widgets
			->add_row()
			->add_column( 5 )
			->add_field( 'colors_widgets_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'Here you can set the color of widget title.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'colors_widgets_title', 'color', array(
				'label'   => esc_html__( 'Widget Title Color', 'silicon' ),
				'default' => '#999999',
				'css'     => array(
					'vars' => '$widget-title-color',
					'code' => '.widget-title,.widgettitle { color: $widget-title-color; }'
				),
			) );
		//</editor-fold>

	} catch ( Exception $e ) {
		trigger_error( 'Colors Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Typography options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_typography( $layout ) {

	$translated = array(
		'font_size'      => esc_html__( 'Font Size', 'silicon' ),
		'font_weight'    => esc_html__( 'Font Weight', 'silicon' ),
		'text_transform' => esc_html__( 'Text Transform', 'silicon' ),
		'font_style'     => esc_html__( 'Font Style', 'silicon' ),
	);

	$options_font_weight = array(
		'lighter' => 'Lighter',
		'normal'  => 'Normal',
		'bold'    => 'Bold',
		'bolder'  => 'Bolder',
		'100'     => '100',
		'200'     => '200',
		'300'     => '300',
		'400'     => '400',
		'500'     => '500',
		'600'     => '600',
		'700'     => '700',
		'800'     => '800',
		'900'     => '900',
	);

	$options_text_transform = array(
		'none'       => 'None',
		'capitalize' => 'Capitalize',
		'lowercase'  => 'Lowercase',
		'uppercase'  => 'Uppercase'
	);

	$options_font_style = array(
		'normal'  => 'Normal',
		'italic'  => 'Italic',
		'oblique' => 'Oblique',
	);

	try {
		$typography = $layout->add_section( 'typography', esc_html__( 'Typography', 'silicon' ), array(
			'icon' => 'dashicons dashicons-editor-textcolor',
		) );

		//<editor-fold desc="Font Family Anchor in Typography Options">
		$ff = $typography->add_anchor( 'typography_font_families', esc_html__( 'Font Families', 'silicon' ) );
		$ff
			->add_row()
			->add_column( 8 )
			->add_field( 'typography_font_for_body', 'google_fonts', array(
				'label'       => esc_html__( 'Body Font Family', 'silicon' ),
				'description' => esc_html__( 'Any paragraph of text you add will be displayed in this font.', 'silicon' ),
				'default'     => array(
					'link' => '//fonts.googleapis.com/css?family=Roboto+Slab:300,400,700',
					'ff'   => '"Roboto Slab", serif'
				),
				'css'         => array(
					'vars'   => '$font-family-body',
					'single' => 'ff', // key of the $value array
					'code'   => 'body,.font-family-body { font-family: $font-family-body; }'
				),
			) )
			->add_field( 'typography_font_for_headings', 'google_fonts', array(
				'label'       => esc_html__( 'Headings Font Family', 'silicon' ),
				'description' => esc_html__( 'This font will apply to all Headings from H1 trhough H6.', 'silicon' ),
				'default'     => array(
					'link' => 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900',
					'ff'   => '"Roboto", sans-serif'
				),
				'css'         => array(
					'vars'   => '$font-family-headings',
					'single' => 'ff',
					'code'   => '
						.font-family-headings,
						.tooltip,
						h1, h2, h3, h4, h5, h6,
						.h1, .h2, .h3, .h4, .h5, .h6,
						blockquote cite,
						.intro-section.intro-comparison .cs-label,
						.si-cta .digit { font-family: $font-family-headings; }
					'
				),
			) )
			->add_field( 'typography_font_for_navigation', 'google_fonts', array(
				'label'       => esc_html__( 'Navigation Font Family', 'silicon' ),
				'description' => esc_html__( 'Navigation group includes but not limited to: Menu Links, Submenu Links, Pagination, Post Navigation, Tabs & Filters, Pagelinks, Linked Titles, Tags, Breadcrumbs, etc. It will be displayed with this font.', 'silicon' ),
				'default'     => array(
					'link' => 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900',
					'ff'   => '"Roboto", sans-serif'
				),
				'css'         => array(
					'vars'   => '$font-family-navs',
					'single' => 'ff',
					'code'   => '
						.font-family-nav,
						textarea,
						select,
						input[type]:not([type=\'submit\']):not([type=\'button\']):not([type=\'hidden\']):not([type=\'checkbox\']):not([type=\'radio\']),
						label, .nf-field-label > label,
						.wpcf7-not-valid-tip,
						.nf-error-required-error,
						.nf-field-description,
						.wpcf7-list-item-label,
						.checkbox-radio-label,
						.wpcf7-response-output,
						.widget_calendar,
						.breadcrumbs,
						.btn,
						input[type=\'submit\'],
						input[type=\'button\'],
						.nav-filters > ul > li > a,
						.nav-tabs > li > a,
						.wc-tabs > li > a,
						.market-btn { font-family: $font-family-navs; }
						.widget {
						  ul, dd, dt { font-family: $font-family-navs; }
						}
						.widget_tag_cloud,
						.widget_product_tag_cloud,
						.bbp-page-title-tags,
						.tags-links {
						  a { font-family: $font-family-navs; }
						}
					'
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Font Size Anchor in Typography Options">
		$fs = $typography->add_anchor( 'typography_font_size', esc_html__( 'Font Size', 'silicon' ) );
		$fs
			->add_row()
			->add_column( 4 )
			->add_field( 'typography_fs_text', 'raw_text', array(
				'default' => esc_html__( 'Set the global font sizes for body and formats. NOTE: Body Text font size is basis for all other elements font-sizes across the theme. If you change this value other values will change automatically to keep pre-designed proportion. You can still adjust font-size of each element individually using options below.', 'silicon' ),
				'attr'    => array(
					'style' => 'padding-top:20px;',
					'class' => 'text-gray'
				),
			) )
			->add_column( 4 )
			->add_field( 'typography_fs_body', 'slider', array(
				'label'   => esc_html__( 'Body Text', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 14,
				'css'     => array(
					'vars'   => '$font-size-base',
					'append' => 'px',
					'code'   => '
						body,
						textarea,
						select,
						input[type]:not([type=\'submit\']):not([type=\'button\']):not([type=\'hidden\']):not([type=\'checkbox\']):not([type=\'radio\']):not([type=\'file\']),
						.wpcf7-list-item-label,
						.checkbox-radio-label,
						.widget_recent_comments ul > li > a,
						.offcanvas-container.offcanvas-cart .cart-header .cart-title,
						.woocommerce-cart .cart-collaterals .carttotals table td p,
						.widget_shopping_cart .product-item .product-title,
						.widget_shopping_cart .product-item .product-price,
						.widget_shopping_cart .cart-subtotal .column:first-child,
						.widget .owl-carousel .product-item .product-title,
						.widget .owl-carousel .product-item .product-title a,
						.panel-title > a,
						.progress .progress-bar-label,
						.testimonial .testimonial-author-name { font-size: $font-size-base; }
						.wpcf7-not-valid-tip,
						.nf-error-required-error { font-size: $font-size-base !important; }
						.widget_silicon_recent_posts,
						.widget_silicon_recent_posts_carousel,
						.popover {
						  .post-item .post-title { font-size: $font-size-base; }
						}
					',
				)
			) )
			->add_column( 4 )
			->add_field( 'typography_fs_lead', 'slider', array(
				'label'   => esc_html__( 'Lead', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 24,
				'master'  => array( 'typography_fs_body', '*', 1.7, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-lead',
					'append' => 'px',
					'code'   => '.lead { font-size: $font-size-lead; }',
				),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'typography_fs_xl', 'slider', array(
				'label'   => esc_html__( 'Extra Large', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 18,
				'master'  => array( 'typography_fs_body', '*', 1.285, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-xl',
					'append' => 'px',
					'code'   => '.text-xl { font-size: $font-size-xl; }'
				),
			) )
			->add_column( 4 )
			->add_field( 'typography_fs_lg', 'slider', array(
				'label'   => esc_html__( 'Large', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 16,
				'master'  => array( 'typography_fs_body', '*', 1.14, 'ceil' ),
				'cass'    => array(
					'vars'   => '$font-size-lg',
					'append' => 'px',
					'code'   => '.text-lg { font-size: $font-size-lg; }',
				),
			) )
			->add_column( 4 )
			->add_field( 'typography_fs_sm', 'slider', array(
				'label'   => esc_html__( 'Small', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 12,
				'master'  => array( 'typography_fs_body', '*', 0.86, 'floor' ),
				'css'     => array(
					'vars'   => '$font-size-sm',
					'append' => 'px',
					'code'   => '.text-sm { font-size: $font-size-sm; }',
				),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'typography_fs_xs', 'slider', array(
				'label'   => esc_html__( 'Extra Small', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 10,
				'master'  => array( 'typography_fs_body', '/', 1.4, 'floor' ),
				'css'     => array(
					'vars'   => '$font-size-xs',
					'append' => 'px',
					'code'   => '.text-xs { font-size: $font-size-xs; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 1 (H1) Anchor in Typography Options">
		$heading1 = $typography->add_anchor( 'typography_h1', esc_html__( 'Heading 1 (H1)', 'silicon' ) );
		$heading1
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h1_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 36,
				'master'  => array( 'typography_fs_body', '*', 2.57, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-h1',
					'append' => 'px',
					'code'   => '
						h1, .h1 {
						  font-size: $font-size-h1;
						  @media (max-width: 768px) {
						    font-size: floor($font-size-h1 * .95);
						  }
						}
						.page-title h1 {
						  font-size: floor($font-size-h1 * 1.39);
						  @media (max-width: 991px) {
						    font-size: floor($font-size-h1 * 1.2);
						  }
						  @media (max-width: 768px) {
						    font-size: $font-size-h1;
						  }
						}
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h1_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h1',
					'code' => 'h1, .h1 { font-weight: $font-weight-h1; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h1_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h1',
					'code' => 'h1, .h1 { text-transform: $text-transform-h1; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h1_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h1',
					'code' => 'h1, .h1 { font-style: $font-style-h1; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 2 (H2) Anchor in Typography Options">
		$heading2 = $typography->add_anchor( 'typography_h2', esc_html__( 'Heading 2 (H2)', 'silicon' ) );
		$heading2
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h2_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 30,
				'master'  => array( 'typography_fs_body', '*', 2.14, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-h2',
					'append' => 'px',
					'code'   => '
						h2, .h2 {
						  font-size: $font-size-h2;
						  @media (max-width: 768px) {
						    font-size: floor($font-size-h2 * .95);
						  }
						}
					'
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h2_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h2',
					'code' => 'h2, .h2 { font-weight: $font-weight-h2; }'
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h2_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h2',
					'code' => 'h2, .h2 { text-transform: $text-transform-h2; }'
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h2_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h2',
					'code' => 'h2, .h2 { font-style: $font-style-h2; }'
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 3 (H3) Anchor in Typography Options">
		$heading3 = $typography->add_anchor( 'typography_h3', esc_html__( 'Heading 3 (H3)', 'silicon' ) );
		$heading3
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h3_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 24,
				'master'  => array( 'typography_fs_body', '*', 1.7, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-h3',
					'append' => 'px',
					'code'   => '
						h3, .h3 {
						  font-size: $font-size-h3;
						  @media (max-width: 768px) {
						    font-size: floor($font-size-h3 * .95);
						  }
						}
						.woocommerce div.product p.price,
						.woocommerce div.product span.price,
						.woocommerce-cart .cart-collaterals .carttotals table td {
						  font-size: $font-size-h3;
						}
						.woocommerce-cart table.cart {
						  .product-name a,
						  .product-price .amount,
						  .product-subtotal .amount { font-size: $font-size-h3; }
						}
						.step {
						  &.step-hover,
						  &.step-image {
						    .step-digit { font-size: $font-size-h3; }
						  }
						}
					',
				)
			) )
			->add_column( 3 )
			->add_field( 'typography_h3_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h3',
					'code' => 'h3, .h3 { font-weight: $font-weight-h3; }'
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h3_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h3',
					'code' => 'h3, .h3 { text-transform: $text-transform-h3; }'
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h3_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h3',
					'code' => 'h3, .h3 { font-style: $font-style-h3; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 4 (H4) Anchor in Typography Options">
		$heading4 = $typography->add_anchor( 'typography_h4', esc_html__( 'Heading 4 (H4)', 'silicon' ) );
		$heading4
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h4_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 20,
				'master'  => array( 'typography_fs_body', '*', 1.428, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-h4',
					'append' => 'px',
					'code'   => '
						h4, .h4,
						.portfolio-post .portfolio-tile-title a,
						.product-tile .product-tile-body .product-title a,
						.woocommerce-cart .cart-collaterals .carttotals table th { font-size: $font-size-h4; }
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h4_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h4',
					'code' => 'h4, .h4 { font-weight: $font-weight-h4; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h4_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h4',
					'code' => 'h4, .h4 { text-transform: $text-transform-h4; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h4_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h4',
					'code' => 'h4, .h4 { font-style: $font-style-h4; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 5 (H5) Anchor in Typography Options">
		$heading5 = $typography->add_anchor( 'typography_h5', esc_html__( 'Heading 5 (H5)', 'silicon' ) );
		$heading5
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h5_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 18,
				'master'  => array( 'typography_fs_body', '*', 1.29, 'floor' ),
				'css'     => array(
					'vars'   => '$font-size-h5',
					'append' => 'px',
					'code'   => 'h5, .h5, .intro-section.intro-personal .person-name { font-size: $font-size-h5; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h5_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h5',
					'code' => 'h5, .h5 { font-weight: $font-weight-h5; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h5_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h5',
					'code' => 'h5, .h5 { text-transform: $text-transform-h5; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h5_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h5',
					'code' => 'h5, .h5 { font-style: $font-style-h5; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Heading 6 (H6) Anchor in Typography Options">
		$heading6 = $typography->add_anchor( 'typography_h6', esc_html__( 'Heading 6 (H6)', 'silicon' ) );
		$heading6
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_h6_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 18,
				'master'  => array( 'typography_fs_body', '*', 1.14, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-h6',
					'append' => 'px',
					'code'   => 'h6, .h6, .comment .author-name { font-size: $font-size-h6; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h6_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '900',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-h6',
					'code' => 'h6, .h6 { font-weight: $font-weight-h6; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h6_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-h6',
					'code' => 'h6, .h6 { text-transform: $text-transform-h6; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_h6_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-h6',
					'code' => 'h6, .h6 { font-style: $font-style-h6; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Line Heights Anchor in Typography Options">
		$line_height = $typography->add_anchor( 'typography_line_height', esc_html__( 'Line Heights', 'silicon' ) );
		$line_height
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_lh_text', 'raw_text', array(
				'default' => esc_html__( 'Line height inputs accepts any positive number. Please note these are not pixel values. They work as multiplier: font size * line height.', 'silicon' ),
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_base', 'text', array(
				'label'    => esc_html__( 'Line Height Base', 'silicon' ),
				'default'  => 1.5,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-base',
					'code' => '
						body,
						.widget_recent_comments ul,
						.intro-section.intro-personal .person-name,
						.woocommerce-cart .cart-collaterals .carttotals table td p,
						.hotspots-container .hotspot .hotspot-tooltip { line-height: $line-height-base; }
					',
				)
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_h1', 'text', array(
				'label'    => esc_html__( 'Heading 1 (H1)', 'silicon' ),
				'default'  => 1.15,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h1',
					'code' => '
						h1, .h1,
						.text-huge,
						.intro-section.intro-featured-posts .post-title { line-height: $line-height-h1; }
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_h2', 'text', array(
				'label'    => esc_html__( 'Heading 2 (H2)', 'silicon' ),
				'default'  => 1.2,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h2',
					'code' => 'h2, .h2 { line-height: $line-height-h2; }',
				),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_lh_h3', 'text', array(
				'label'    => esc_html__( 'Heading 3 (H3)', 'silicon' ),
				'default'  => 1.25,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h3',
					'code' => 'h3, .h3 { line-height: $line-height-h3; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_h4', 'text', array(
				'label'    => esc_html__( 'Heading 4 (H4)', 'silicon' ),
				'default'  => 1.3,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h4',
					'code' => 'h4, .h4 { line-height: $line-height-h4; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_h5', 'text', array(
				'label'    => esc_html__( 'Heading 5 (H5)', 'silicon' ),
				'default'  => 1.35,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h5',
					'code' => 'h5, .h5 { line-height: $line-height-h5; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_lh_h6', 'text', array(
				'label'    => esc_html__( 'Heading 6 (H6)', 'silicon' ),
				'default'  => 1.4,
				'sanitize' => 'silicon_sanitize_float',
				'escape'   => 'silicon_sanitize_float',
				'css'      => array(
					'vars' => '$line-height-h6',
					'code' => 'h6, .h6 { line-height: $line-height-h6; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Quotation Anchor in Typography Options">
		$quote = $typography->add_anchor( 'typography_quote', esc_html__( 'Quotation', 'silicon' ) );
		$quote
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_quote_font_size', 'slider', array(
				'label'   => $translated['font_size'],
				'min'     => 0,
				'max'     => 80,
				'default' => 18,
				'master'  => array( 'typography_fs_body', '*', 1.285, 'ceil' ),
				'css'     => array(
					'vars'   => '$font-size-quote',
					'append' => 'px',
					'code'   => '
						blockquote {
						  font-size: $font-size-quote;
						  &::before { font-size: $quote-mark-size; }
						  cite { font-size: $quote-author-size; }
						}
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_quote_font_weight', 'select', array(
				'label'   => $translated['font_weight'],
				'default' => '300',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-quote',
					'code' => '
						blockquote {
						  font-weight: $font-weight-quote;
						  cite { font-weight: normal; }
						}
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_quote_text_transform', 'select', array(
				'label'   => $translated['text_transform'],
				'default' => 'none',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-quote',
					'code' => '
						blockquote {
						  text-transform: $text-transform-quote;
						  cite { text-transform: none; }
						}
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_quote_font_style', 'select', array(
				'label'   => $translated['font_style'],
				'default' => 'normal',
				'options' => $options_font_style,
				'css'     => array(
					'vars' => '$font-style-quote',
					'code' => '
						blockquote {
						  font-style: $font-style-quote;
						  cite { font-style: normal; }
						}
					',
				),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_quote_mark_font_size', 'slider', array(
				'label'   => esc_html__( 'Mark Font Size', 'silicon' ),
				'min'     => 0,
				'max'     => 200,
				'default' => 36,
				'css'     => array(
					'vars'   => '$quote-mark-size',
					'append' => 'px',
					'code'   => 'blockquote::before { font-size: $quote-mark-size; }',
				)
			) )
			->add_column( 3 )
			->add_field( 'typography_quote_author_font_size', 'slider', array(
				'label'   => esc_html__( 'Author Font Size', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 14,
				'master'  => array( 'typography_fs_body' ),
				'css'     => array(
					'vars'   => '$quote-author-size',
					'append' => 'px',
					'code'   => 'blockquote cite { font-size: $quote-author-size; }',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Navigation Anchor in Typography Options">
		$navi = $typography->add_anchor( 'typography_navi', esc_html__( 'Navigation', 'silicon' ) );
		$navi
			->add_row()
			->add_column( 5 )
			->add_field( 'typography_navi_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'This section includes typography options for navigation group of elements which include: Menu Links, Pagination, Post Navigation, Tabs & Filters.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_navi_fs', 'slider', array(
				'label'   => esc_html__( 'Font Size', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 12,
				'master'  => array( 'typography_fs_body', '*', 0.86, 'floor' ),
				'css'     => array(
					'vars'   => '$font-size-navi',
					'append' => 'px',
					'code'   => '
						.navbar-horizontal .menu-wrap .main-navigation > ul > li > a,
						.btn,
						input[type=\'submit\'],
						input[type=\'button\'], .nav-filters>ul>li>a, .nav-tabs>li>a, .wc-tabs>li>a, { font-size: $font-size-navi; }
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_navi_fw', 'select', array(
				'label'   => esc_html__( 'Font Weight', 'silicon' ),
				'default' => 'bold',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-navi',
					'code' => '
						.navbar-horizontal .menu-wrap .main-navigation > ul > li > a,
						.btn,
						input[type=\'submit\'],
						input[type=\'button\'], .nav-filters>ul>li>a, .nav-tabs>li>a, .wc-tabs>li>a, { font-weight: $font-weight-navi; }
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_navi_tt', 'select', array(
				'label'   => esc_html__( 'Text Transform', 'silicon' ),
				'default' => 'uppercase',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-navi',
					'code' => '
						.navbar-horizontal .menu-wrap .main-navigation > ul > li > a,
						.btn,
						input[type=\'submit\'],
						input[type=\'button\'], .nav-filters>ul>li>a, .nav-tabs>li>a, .wc-tabs>li>a, { text-transform: $text-transform-navi; }"
					',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_navi_font_style', 'select', array(
				'label'   => esc_html__( 'Font Style', 'silicon' ),
				'default' => 'normal',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$font-style-navi',
					'code' => '
						.navbar-horizontal .menu-wrap .main-navigation > ul > li > a,
						.btn,
						input[type=\'submit\'],
						input[type=\'button\'], .nav-filters>ul>li>a, .nav-tabs>li>a, .wc-tabs>li>a, { font-style: $font-style-navi; }"
					',
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Widgets Anchor in Typography Options">
		$widgets = $typography->add_anchor( 'typography_widgets', esc_html__( 'Widgets', 'silicon' ) );
		$widgets
			->add_row()
			->add_column( 5 )
			->add_field( 'typography_widgets_description', 'raw_text', array(
				'escape'  => 'trim',
				'default' => '<p>' . esc_html__( 'These styles apply to widget titles.', 'silicon' ) . '</p>',
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'typography_widgets_fs', 'slider', array(
				'label'   => esc_html__( 'Font Size', 'silicon' ),
				'min'     => 0,
				'max'     => 80,
				'default' => 14,
				'master'  => array( 'typography_fs_body' ),
				'css'     => array(
					'vars'   => '$font-size-widget',
					'append' => 'px',
					'code'   => '.widget-title, .widgettitle { font-size: $font-size-widget; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_widgets_fw', 'select', array(
				'label'   => esc_html__( 'Font Weight', 'silicon' ),
				'default' => '500',
				'options' => $options_font_weight,
				'css'     => array(
					'vars' => '$font-weight-widget',
					'code' => '.widget-title,.widgettitle { font-weight: $font-weight-widget; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_widgets_tt', 'select', array(
				'label'   => esc_html__( 'Text Transform', 'silicon' ),
				'default' => 'uppercase',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$text-transform-widget',
					'code' => '.widget-title,.widgettitle { text-transform: $text-transform-widget; }',
				),
			) )
			->add_column( 3 )
			->add_field( 'typography_widgets_font_style', 'select', array(
				'label'   => esc_html__( 'Font Style', 'silicon' ),
				'default' => 'normal',
				'options' => $options_text_transform,
				'css'     => array(
					'vars' => '$font-style-widget',
					'code' => '.widget-title,.widgettitle { font-style: $font-style-widget; }',
				),
			) );
		//</editor-fold>

	} catch ( Exception $e ) {
		trigger_error( 'Typography Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Header options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_header( $layout ) {
	try {
		$header = $layout->add_section( 'header', esc_html__( 'Header', 'silicon' ), array(
			'icon' => 'dashicons dashicons-schedule',
		) );

		//<editor-fold desc="Logo Anchor in Header Options">
		$general = $header->add_anchor( 'header-logo-anchor', esc_html__( 'Logo', 'silicon' ) );
		$general
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
			->add_field( 'header_logo_text', 'raw_text', array(
				'label'   => esc_html__( 'Main Logo', 'silicon' ),
				'default' => esc_html__( 'Since WordPress 4.5 you can upload your logo in Appearance > Customize > Site Identity > Logo.', 'silicon' ),
			) )
			->add_column( 2 )
			->add_field( 'header_stuck_logo', 'media', array(
				'label'       => esc_html__( 'Stuck Header Logo', 'silicon' ),
				'description' => esc_html__( 'Upload a custom logo in case when original logo does not look good inside the Stuck header.', 'silicon' ),
				'media'       => array( 'title' => esc_html__( 'Choose a Mobile Logo', 'silicon' ) ),
			) )
			->add_column( 2 )
			->add_field( 'header_mobile_logo', 'media', array(
				'label'       => esc_html__( 'Mobile Logo', 'silicon' ),
				'description' => esc_html__( 'Upload a logo that will appear on mobile devices. Theme will use original logo if this field is empty.', 'silicon' ),
				'media'       => array( 'title' => esc_html__( 'Choose a Mobile Logo', 'silicon' ) ),
			) );
		//</editor-fold>

		//<editor-fold desc="Type Anchor in Header Options">
		$type = $header->add_anchor( 'header-type-anchor', esc_html__( 'Type', 'silicon' ) );
		$type
			->add_field( 'header_layout', 'image_select', array(
				'width'   => 250,
				'height'  => 200,
				'default' => 'horizontal',
				'options' => silicon_options_variants_header(),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'header_is_fullwidth', 'switch', array(
				'label'       => esc_html__( 'Make Header Full Width?', 'silicon' ),
				'description' => esc_html__( 'If enabled Header will occupy the 100% of the page width.', 'silicon' ),
				'default'     => true,
				'required'    => array( 'header_layout', '=', 'horizontal' ),
			) )
			->add_column( 3 )
			->add_field( 'header_is_sticky', 'switch', array(
				'label'       => esc_html__( 'Enable Sticky Navbar?', 'silicon' ),
				'description' => esc_html__( 'If enabled Navigation Bar will stick to the top of the page when scrolling.', 'silicon' ),
				'default'     => false,
				'required'    => array( 'header_layout', '=', 'horizontal' ),
			) )
			->add_column( 3 )
			->add_field( 'header_is_floating', 'switch', array(
				'label'       => esc_html__( 'Enable Floating Header?', 'silicon' ),
				'description' => esc_html__( 'This option makes header absolutely positioned, so it overlaps the content below.', 'silicon' ),
				'default'     => false,
				'required'    => array( 'header_layout', '=', 'horizontal' ),
			) )
			->add_column( 3 )
			->add_field( 'header_is_topbar', 'switch', array(
				'label'       => esc_html__( 'Enable Topbar?', 'silicon' ),
				'description' => esc_html__( 'If enabled Topbar with additional content options will appear right above Navigation Bar.', 'silicon' ),
				'default'     => false,
				'required'    => array( 'header_layout', '=', 'horizontal' ),
			) );
		//</editor-fold>

		//<editor-fold desc="Menu Anchor in Header Options">
		$menu = $header->add_anchor( 'header-menu-anchor', esc_html__( 'Menu', 'silicon' ) );
		$menu
			->add_field( 'header_menu_variant', 'image_select', array(
				'width'    => 320,
				'height'   => 256,
				'default'  => 'horizontal',
				'options'  => silicon_options_variants_menu(),
				'required' => array( 'header_layout', '=', 'horizontal' ),
			) )
			->add_row()
			->add_column( 5 )
			->add_field( 'header_menu_collapse', 'slider', array(
				'label'       => esc_html__( 'Menu Collapse Breakpoint', 'silicon' ),
				'description' => esc_html__( 'Screen width at which Main Site Menu will turn to compact mobile-friendly view.', 'silicon' ),
				'min'         => 320,
				'max'         => 1200,
				'default'     => 991,
			) );
		//</editor-fold>

		//<editor-fold desc="Utils Anchor in Header Options">
		$utils = $header->add_anchor( 'header-utils-anchor', esc_html__( 'Navbar Utilities', 'silicon' ) );
		$utils
			->add_row()
			->add_column( 4 )
			->add_field( 'header_utils_is_search', 'switch', array(
				'label'       => esc_html__( 'Search', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable Search utility in the Navbar.', 'silicon' ),
				'default'     => true,
			) )
			->add_column( 4 )
			->add_field( 'header_utils_is_cart', 'switch', array(
				'label'       => esc_html__( 'Shopping Cart', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable Shopping Cart dropdown in the Navbar. Please note this option works only if WooCommerce plugin installed.', 'silicon' ),
				'default'     => true,
				'required'    => array( 'header_layout', '=', 'horizontal' ),
				'hidden'      => ( ! silicon_is_woocommerce() ),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'header_utils_is_socials', 'switch', array(
				'label'       => esc_html__( 'Social Networks', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable the Social Networks in Navigation Bar.', 'silicon' ),
				'hidden'      => ( ! defined( 'SILICON_PLUGIN_VERSION' ) ), // hide if silicon plugin not installed
				'default'     => false,
				'required'    => array( 'header_layout', '=', 'vertical' ),
			) )
			->add_column( 4 )
			->add_field( 'header_utils_socials_shape', 'select', array(
				'label'    => esc_html__( 'Networks Shape', 'silicon' ),
				'hidden'   => ( ! defined( 'SILICON_PLUGIN_VERSION' ) ), // hide if silicon plugin not installed
				'default'  => 'circle',
				'required' => array(
					array( 'header_layout', '=', 'vertical' ),
					array( 'header_utils_is_socials', '=', 1 )
				),
				'options'  => array(
					'no'      => esc_html__( 'No shape', 'silicon' ),
					'circle'  => esc_html__( 'Circle', 'silicon' ),
					'rounded' => esc_html__( 'Rounded', 'silicon' ),
					'square'  => esc_html__( 'Square', 'silicon' ),
					'polygon' => esc_html__( 'Polygon', 'silicon' ),
				),
			) )
			->add_row()
			->add_column( 8 )
			->add_field( 'header_utils_socials', 'socials', array(
				'hidden'   => ( ! defined( 'SILICON_PLUGIN_VERSION' ) ), // hide if silicon plugin not installed
				'required' => array(
					array( 'header_layout', '=', 'vertical' ),
					array( 'header_utils_is_socials', '=', 1 )
				),
			) );
		//</editor-fold>

		//<editor-fold desc="Topbar Anchor in Header Options">
		$topbar = $header->add_anchor( 'header-topbar-anchor', esc_html__( 'Topbar', 'silicon' ) );
		$topbar
			->add_field( 'header_topbar_not_work', 'raw_text', array(
				'required' => array( 'header_layout', '=', 'vertical' ),
				'default'  => wp_kses(
					__( 'Topbar doesn\'t work with <strong>Vertical (Lateral) Header</strong> version.', 'silicon' ),
					array( 'strong' => true )
				),
			) )
			->add_field( 'header_topbar_disabled', 'raw_text', array(
				'default'  => wp_kses(
					__(
						'Topbar is disabled. To enable Topbar go to <a href="#equip_header-type-anchor">Header Type</a>
						section and hit <strong>Enable Topbar</strong> switch.',
						'silicon'
					),
					array( 'strong' => true, 'a' => array( 'href' => true ) )
				),
				'escape'   => 'trim',
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 0 ),
				),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'header_topbar_is_login', 'switch', array(
				'label'       => esc_html__( 'Login / Register Link', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable the Topbar Login / register Link.', 'silicon' ),
				'default'     => false,
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				)
			) )
			->add_column( 4 )
			->add_field( 'header_topbar_login_title', 'text', array(
				'label'    => esc_html__( 'Login Link Title', 'silicon' ),
				'default'  => esc_html__( 'Login or Create account', 'silicon' ),
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
					array( 'header_topbar_is_login', '=', 1 ),
				),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'header_topbar_is_socials', 'switch', array(
				'label'       => esc_html__( 'Social Networks', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable the Social Networks in Topbar.', 'silicon' ),
				'hidden'      => ( ! defined( 'SILICON_PLUGIN_VERSION' ) ), // hide if silicon plugin not installed
				'default'     => false,
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				)
			) )
			->add_row()
			->add_column( 8 )
			->add_field( 'header_topbar_socials', 'socials', array(
				'hidden'   => ( ! defined( 'SILICON_PLUGIN_VERSION' ) ), // hide if silicon plugin not installed
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
					array( 'header_topbar_is_socials', '=', 1 )
				)
			) )
			->add_row()
			->add_column( 5 )
			->add_field( 'header_topbar_info', 'textarea', array(
				'label'       => esc_html__( 'Additional Info', 'silicon' ),
				'description' => esc_html__( 'Custom text inside Topbar You can use HTML here. Allowed tags are: a, span, i, em, strong', 'silicon' ),
				'sanitize'    => 'silicon_sanitize_text',
				'escape'      => 'esc_textarea',
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				)
			) );
		//</editor-fold>

		//<editor-fold desc="Appearance Anchor in Header Options">
		$appear = $header->add_anchor( 'header-appearance', esc_html__( 'Appearance', 'silicon' ) );
		$appear
			->add_field( 'header_appearance_not_work', 'raw_text', array(
				'required' => array( 'header_layout', '=', 'vertical' ),
				'default'  => wp_kses(
					__( 'Appearance section doesn\'t work with <strong>Vertical (Lateral) Header</strong> version.', 'silicon' ),
					array( 'strong' => true )
				),
			) )
			->add_field( 'header_appearance_navbar_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array( 'header_layout', '=', 'horizontal' ),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_navbar_label', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'required' => array( 'header_layout', '=', 'horizontal' ),
				'default'  => '<h4><strong>' . esc_html__( 'Navbar', 'silicon' ) . '</strong></h4>',
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_bg', 'select', array(
				'label'       => esc_html__( 'Background', 'silicon' ),
				'description' => esc_html__( 'Background color of the Navigation Bar.', 'silicon' ),
				'required'    => array( 'header_layout', '=', 'horizontal' ),
				'default'     => 'solid',
				'options'     => array(
					'solid' => esc_html__( 'Solid Color', 'silicon' ),
					'ghost' => esc_html__( 'Transparent', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_bg_custom', 'color', array(
				'label'       => esc_html__( 'Choose Color', 'silicon' ),
				'description' => esc_html__( 'Set custom color for your Navbar background.', 'silicon' ),
				'default'     => '#ffffff',
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_appearance_bg', '=', 'solid' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_menu_skin', 'select', array(
				'label'       => esc_html__( 'Menu Skin', 'silicon' ),
				'description' => esc_html__( 'Whether the Menu Links appear in dark gray color or white color.', 'silicon' ),
				'default'     => 'dark',
				'required'    => array( 'header_layout', '=', 'horizontal' ),
				'options'     => array(
					'dark'  => esc_html__( 'Dark Text', 'silicon' ),
					'light' => esc_html__( 'Light Text', 'silicon' ),
				),
			) )
			->parent( 'anchor' )
			->add_field( 'header_appearance_navbar_stuck_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_sticky', '=', 1 ),
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_navbar_stuck_label', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<h4><strong>' . esc_html__( 'Navbar Stuck', 'silicon' ) . '</strong></h4>',
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_sticky', '=', 1 ),
				),
			) )
			->parent( 'row' )
			->add_offset( 3 )
			->add_column( 3 )
			->add_field( 'header_appearance_stuck_bg_color', 'color', array(
				'label'       => esc_html__( 'Background Color', 'silicon' ),
				'description' => esc_html__( 'Set custom color for your Navbar Stuck background.', 'silicon' ),
				'default'     => '#ffffff',
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_sticky', '=', 1 ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_stuck_menu_skin', 'select', array(
				'label'       => esc_html__( 'Menu Skin', 'silicon' ),
				'description' => esc_html__( 'Whether the Menu Links appear in dark gray color or white color.', 'silicon' ),
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_sticky', '=', 1 ),
				),
				'default'     => 'dark',
				'options'     => array(
					'dark'  => esc_html__( 'Dark Text', 'silicon' ),
					'light' => esc_html__( 'Light Text', 'silicon' ),
				),
			) )
			->parent( 'anchor' )
			->add_field( 'header_appearance_topbar_divider', 'raw_text', array(
				'escape'   => 'trim',
				'sanitize' => 'trim',
				'default'  => '<hr>',
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				),
			) )
			->add_row()
			->add_column( 2 )
			->add_field( 'header_appearance_topbar_label', 'raw_text', array(
				'default'  => '<h4><strong>' . esc_html__( 'Topbar', 'silicon' ) . '</strong></h4>',
				'required' => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_bg', 'select', array(
				'label'       => esc_html__( 'Background', 'silicon' ),
				'description' => esc_html__( 'Background color of the Topbar section.', 'silicon' ),
				'default'     => 'solid',
				'options'     => array(
					'solid'       => esc_html__( 'Solid Color', 'silicon' ),
					'gradient'    => esc_html__( 'Gradient Color', 'silicon' ),
					'transparent' => esc_html__( 'Transparent', 'silicon' ),
				),
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_bg_color', 'color', array(
				'label'       => esc_html__( 'Choose Color', 'silicon' ),
				'description' => esc_html__( 'Set color for the Topbar background.', 'silicon' ),
				'default'     => '#f5f5f5',
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', 1 ),
					array( 'header_appearance_topbar_bg', '=', 'solid' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'header_appearance_topbar_skin', 'select', array(
				'label'       => esc_html__( 'Topbar Content Skin', 'silicon' ),
				'description' => esc_html__( 'Choose Topbar elements skin to fit your Topbar background color.', 'silicon' ),
				'default'     => 'dark',
				'options'     => array(
					'dark'  => esc_html__( 'Dark', 'silicon' ),
					'light' => esc_html__( 'Light', 'silicon' ),
				),
				'required'    => array(
					array( 'header_layout', '=', 'horizontal' ),
					array( 'header_is_topbar', '=', true ),
				),
			) );
		//</editor-fold>
 
		//<editor-fold desc="Page Title Anchor in Header Options">
		$page_title = $header->add_anchor('header-page-title-anchor', esc_html__( 'Page Title', 'silicon' ));
		$page_title
			->add_row()
			->add_column( 4 )
			->add_field( 'header_is_pt', 'switch', array(
				'label'       => esc_html__( 'Enable / Disable Page Title', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable the page title globally including Breadcrumbs. Please note, these settings used for default WordPress templates like: Archive, Search Results, 404.', 'silicon' ),
				'default'     => true,
			) )
			->add_column( 4 )
			->add_field( 'header_pt_size', 'select', array(
				'label'    => esc_html__( 'Size', 'silicon' ),
				'default'  => 'normal',
				'required' => array( 'header_is_pt', '=', 1 ),
				'options'  => array(
					'normal' => esc_html__( 'Normal', 'silicon' ),
					'lg'     => esc_html__( 'Large', 'silicon' ),
					'xl'     => esc_html__( 'Extra Large', 'silicon' ),
				),
			) );
		//</editor-fold>

	} catch ( Exception $e ) {
		trigger_error( 'Header Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Footer options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_footer( $layout ) {

	try {
		$footer = $layout->add_section( 'footer', esc_html__( 'Footer', 'silicon' ), array(
			'icon' => 'dashicons dashicons-flag',
		) );

		$footer
			->add_row()
			->add_column( 3 )
			->add_field( 'footer_background', 'select', array(
				'label'       => esc_html__( 'Background Option', 'silicon' ),
				'description' => esc_html__( 'Choose type of background you want to use on Footer', 'silicon' ),
				'default'     => 'solid',
				'options'     => array(
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
			) )
			->add_column( 2 )
			->add_field( 'footer_background_color', 'color', array(
				'label'    => esc_html__( 'Background Color', 'silicon' ),
				'default'  => '#222222',
				'required' => array( 'footer_background', '=', 'solid' ),
			) )
			->add_column( 3 )
			->add_field( 'footer_overlay_option', 'select', array(
				'label'    => esc_html__( 'Overlay Color Option', 'silicon' ),
				'default'  => 'solid',
				'options'  => array(
					'solid'    => esc_html__( 'Solid Color', 'silicon' ),
					'gradient' => esc_html__( 'Gradient Color', 'silicon' ),
				),
				'required' => array( 'footer_background', '=', 'image' ),
			) )
			->add_field( 'footer_overlay_opacity', 'slider', array(
				'label'    => esc_html__( 'Overlay Opacity', 'silicon' ),
				'min'      => 0,
				'max'      => 100,
				'default'  => 75,
				'units'    => '%',
				'required' => array( 'footer_background', '=', 'image' ),
			) )
			->add_column( 2 )
			->add_field( 'footer_overlay_color', 'color', array(
				'label'    => esc_html__( 'Overlay Color', 'silicon' ),
				'default'  => '#000000',
				'required' => array(
					array( 'footer_background', '=', 'image' ),
					array( 'footer_overlay_option', '=', 'solid' ),
				),
			) )
			->add_row()
			->add_column( 6 )
			->add_field( 'footer_skin', 'select', array(
				'label'       => esc_html__( 'Content Skin', 'silicon' ),
				'description' => esc_html__( 'This option let you control how Widgets inside Footer will look.', 'silicon' ),
				'default'     => 'light',
				'options'     => array(
					'light' => esc_html__( 'Light', 'silicon' ),
					'dark'  => esc_html__( 'Dark', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'footer_is_fullwidth', 'switch', array(
				'label'       => esc_html__( 'Make Footer Full Width?', 'silicon' ),
				'description' => esc_html__( 'If enabled Footer content will occupy the 100% of the page width.', 'silicon' ),
				'default'     => false,
			) )
			->add_row()
			->add_column( 12 )
			->add_field( 'footer_layout', 'image_select', array(
				'label'   => esc_html__( 'Layout', 'silicon' ),
				'helper'  => esc_html__( 'Depends on chosen layout Footer Column sidebars are generated. You can add widgets to them in Appearance > Widgets.', 'silicon' ),
				'default' => 'none',
				'width'   => 250,
				'height'  => 200,
				'options' => silicon_options_variants_footer(),
			) );

	} catch ( Exception $e ) {
		trigger_error( 'Footer Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Blog options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_blog( $layout ) {
	try {
		$blog = $layout->add_section( 'blog', esc_html__( 'Blog', 'silicon' ), array(
			'icon' => 'dashicons dashicons-edit',
		) );

		$blog
			->add_anchor( 'blog-general-anchor', esc_html__( 'General', 'silicon' ) )
			->add_row()
			->add_column( 9 )
			->add_field( 'blog_layout', 'image_select', array(
				'label'   => esc_html__( 'Layout', 'silicon' ),
				'default' => 'list-right',
				'width'   => 250,
				'height'  => 200,
				'options' => silicon_options_variants_blog(),
			) )
			->add_anchor( 'blog-pagination-anchor', esc_html__( 'Pagination', 'silicon' ) )
			->add_field( 'blog_pagination_description', 'raw_text', array(
				'default' => esc_html__( 'These options allows you to customize the pagination in blog.', 'silicon' ),
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'blog_pagination_type', 'select', array(
				'label'   => esc_html__( 'Type', 'silicon' ),
				'default' => 'links',
				'options' => array(
					'links'           => esc_html__( 'Page Links', 'silicon' ),
					'load-more'       => esc_html__( 'Load More', 'silicon' ),
					'infinite-scroll' => esc_html__( 'Infinite Scroll', 'silicon' ),
				),
			) )
			->add_anchor( 'blog-single-anchor', esc_html__( 'Single Post', 'silicon' ) )
			->add_field( 'blog_single_description', 'raw_text', array(
				'default' => esc_html__( 'These options apply globally to all blog posts. You can adjust them individually for each single post in Page Settings.', 'silicon' ),
				'attr'    => array( 'class' => 'text-gray' ),
			) )
			->add_field( 'single_layout', 'image_select', array(
				'label'   => esc_html__( 'Layout', 'silicon' ),
				'default' => 'right',
				'width'   => 250,
				'height'  => 200,
				'options' => silicon_options_variants_single(),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'single_is_tile_author', 'switch', array(
				'label'   => esc_html__( 'Author in Post Tile', 'silicon' ),
				'default' => true,
			) )
			->add_field( 'single_is_post_author', 'switch', array(
				'label'   => esc_html__( 'Author in Single Post', 'silicon' ),
				'default' => false,
			) )
			->add_column( 4 )
			->add_field( 'single_is_shares', 'switch', array(
				'label'   => esc_html__( 'Sharing Buttons', 'silicon' ),
				'default' => true,
			) )
			->add_field( 'single_is_featured_image', 'switch', array(
				'label'   => esc_html__( 'Featured Image in Single Post', 'silicon' ),
				'default' => true,
			) );

	} catch ( Exception $e ) {
		trigger_error( 'Blog Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Shop options section
 *
 * @uses silicon_is_woocommerce()
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_shop( $layout ) {
	if ( ! silicon_is_woocommerce() ) {
		return $layout;
	}

	try {
		$shop = $layout->add_section( 'shop', esc_html__( 'Shop', 'silicon' ), array(
			'icon' => 'dashicons dashicons-cart',
		) );

		$shop
			->add_row()
			->add_column( 8 )
			->add_field( 'shop_layout', 'image_select', array(
				'label'   => esc_html__( 'Layout', 'silicon' ),
				'default' => 'ls-3',
				'width'   => 250,
				'height'  => 200,
				'options' => silicon_options_variants_shop(),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( 'shop_products_per_page', 'text', array(
				'label'   => esc_html__( 'Products per page', 'silicon' ),
				'default' => 9,
			) )
			->add_column( 4 )
			->add_field( 'shop_is_single_share', 'switch', array(
				'label'       => esc_html__( 'Enable / Disable Shares', 'silicon' ),
				'description' => esc_html__( 'This option allows you to enable / disable sharing buttons on Single Product page.', 'silicon' ),
				'default'     => true,
			) );;

	} catch ( Exception $e ) {
		trigger_error( 'Shop Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add 404 options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_404( $layout ) {

	try {
		$not_found = $layout->add_section( '404', esc_html__( '404', 'silicon' ), array(
			'icon' => 'dashicons dashicons-warning',
		) );

		$not_found
			->add_row()
			->add_column( 4 )
			->add_field( '404_image', 'media', array(
				'label' => esc_html__( 'Upload Image', 'silicon' ),
				'media' => array( 'title' => esc_html__( 'Image to dispaly in 404 page', 'silicon' ) ),
			) )
			->add_column( 4 )
			->add_field( '404_title', 'text', array(
				'label'   => esc_html__( 'Main Title', 'silicon' ),
				'default' => esc_html__( 'Looks like SiliBot broke...', 'silicon' ),
			) )
			->add_column( 4 )
			->add_field( '404_subtitle_1', 'text', array(
				'label'   => esc_html__( 'Subtitle 1', 'silicon' ),
				'default' => esc_html__( 'We couldn\'t find that page', 'silicon' ),
			) )
			->add_row()
			->add_column( 4 )
			->add_field( '404_button_text', 'text', array(
				'label'   => esc_html__( 'Home Button Text', 'silicon' ),
				'default' => esc_html__( 'Go To Homepage', 'silicon' ),
			) )
			->add_column( 4 )
			->add_field( '404_subtitle_2', 'text', array(
				'label'   => esc_html__( 'Subtitle 2', 'silicon' ),
				'default' => esc_html__( 'Or try search', 'silicon' ),
			) );
	} catch ( Exception $e ) {
		trigger_error( '404 Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add General options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_general( $layout ) {

	try {
		$general = $layout->add_section( 'general', esc_html__( 'General', 'silicon' ), array(
			'icon' => 'dashicons dashicons-admin-generic',
		) );

		$general
			->add_row()
			->add_column( 4 )
			->add_field( 'general_is_scroll_to_top', 'switch', array(
				'label'       => esc_html__( 'Scroll to Top', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable the "Scroll to Top" button.', 'silicon' ),
				'default'     => true,
			) )
			->add_column( 3 )
			->add_field( 'general_backdrop', 'color', array(
				'label'   => esc_html__( 'Backdrop Color', 'silicon' ),
				'default' => '#000000',
				'sass'    => 'backdrop-color',
			) )
			->add_column( 5 )
			->add_field( 'general_backdrop_opacity', 'slider', array(
				'label'   => esc_html__( 'Backdrop Opacity', 'silicon' ),
				'min'     => 0,
				'max'     => 100,
				'default' => 70,
				'sass'    => 'backdrop-opacity',
			) )
			->parent( 'section' )
			->add_field( 'cover_sep_after', 'raw_text', array(
				'default' => '<hr>',
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'general_is_preloader', 'switch', array(
				'label'       => esc_html__( 'Page Preloader', 'silicon' ),
				'description' => esc_html__( 'Enable or Disable Page preloading animation.', 'silicon' ),
				'default'     => false,
			) )
			->add_column( 3 )
			->add_field( 'general_preloader_type', 'select', array(
				'label'    => esc_html__( 'Preloader Type', 'silicon' ),
				'required' => array( 'general_is_preloader', '=', 1 ),
				'default'  => 'progress',
				'options'  => array(
					'progress' => esc_html__( 'Progress Bar', 'silicon' ),
					'spinner' => esc_html__( 'Spinner', 'silicon' ),
				),
			) )
			->add_column( 3 )
			->add_field( 'general_preloader_screen_color', 'color', array(
				'label'    => esc_html__( 'Preloading Screen Color', 'silicon' ),
				'default'  => '#ffffff',
				'required' => array( 'general_is_preloader', '=', 1 ),
			) )
			->add_column( 3 )
			->add_field( 'general_preloader_color', 'color', array(
				'label'    => esc_html__( 'Preloader Color', 'silicon' ),
				'default'  => '#3d59f9',
				'required' => array( 'general_is_preloader', '=', 1 ),
				'master'   => array( 'colors_primary' ),
			) )
			->add_row()
			->add_column( 3 )
			->add_field( 'general_preloader_logo', 'media', array(
				'label'  => esc_html__( 'Preloader Logo', 'silicon' ),
				'media'  => array( 'title' => esc_html__( 'Choose a Logo', 'silicon' ) ),
				'required' => array( 'general_is_preloader', '=', 1 ),
			) )
			->add_column( 5 )
			->add_field( 'general_preloader_logo_width', 'slider', array(
				'label'       => esc_html__( 'Logo Width', 'silicon' ),
				'description' => esc_html__( 'For High Resolution screens is recommended to upload image twice as big as this value.', 'silicon' ),
				'min'         => 30,
				'max'         => 300,
				'default'     => 150,
				'required' => array( 'general_is_preloader', '=', 1 ),
			) );
	} catch ( Exception $e ) {
		trigger_error( 'General Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Add Advanced options section
 *
 * @param \Equip\Layout\OptionsLayout $layout Layout
 *
 * @return \Equip\Layout\OptionsLayout
 */
function silicon_options_advanced( $layout ) {

	/**
	 * Sanitize the Custom Font Icon links options
	 *
	 * @param string $u
	 *
	 * @return string
	 */
	$sanitize_func = function( $u ) {
		if ( empty( $u ) ) {
			return '';
		}

		$d = "\r\n";

		return implode( $d, array_map( 'esc_url', explode( $d, $u ) ) );
	};

	try {
		$advanced = $layout->add_section( 'advanced', esc_html__( 'Advanced', 'silicon' ), array(
			'icon' => 'dashicons dashicons-admin-settings',
		) );

		$advanced
			->add_row()
			->add_column( 4 )
			->add_field( 'cache_is_shortcodes', 'switch', array(
				'label'       => esc_html__( 'Caching in shortcodes', 'silicon' ),
				'description' => esc_html__( 'Disabling this option will not flush the cache. Caching will not be used.', 'silicon' ),
				'default'     => true,
			) )
			->add_column( 4 )
			->add_field( 'advanced_widgetised_sidebars_num', 'text', array(
				'label'       => esc_html__( 'Widgetised Areas', 'silicon' ),
				'description' => esc_html__( 'This field accepts any positive integer number. It will generate the set number of widgetized areas to use inside the Visual Composer via shortcode Widgetized Sidebar. You can further fill them within Appearance > Widgets.', 'silicon' ),
				'default'     => 4,
				'sanitize'    => 'absint',
				'escape'      => 'absint',
			) )
			->add_row()
			->add_column( 8 )
			->add_field( 'advanced_custom_font_icons', 'textarea', array(
				'label'       => esc_html__( 'Custom Font Icons', 'silicon' ),
				'description' => esc_html__( 'Here you can provide links to CSS files of icons font hosted somewhere on your server or third-party CDN. Note: you can add as many links as you wish, every link on new line.', 'silicon' ),
				'sanitize'    => $sanitize_func,
				'escape'      => $sanitize_func,
			) )
			->add_field( 'advanced_gmaps_key', 'text', array(
				'label'       => esc_html__( 'Google Maps API Key', 'silicon' ),
				'escape'      => 'esc_attr',
				'sanitize'    => 'sanitize_text_field',
				'description' => wp_kses(
					__(
						'You can manage your keys in <a href="https://console.developers.google.com/" target="_blank">Developers Console</a>.
						Note, this key is required for Google Maps and Contacts Card shortcodes. 
						', 'silicon'
					),
					array( 'a' => array( 'href' => true, 'target' => true ) )
				),
			) );

	} catch ( Exception $e ) {
		trigger_error( 'Advanced Options: ' . $e->getMessage() );
	}

	return $layout;
}

/**
 * Returns the options for Header image_select field
 *
 * @param array $variants Extra variants
 *
 * @return array
 */
function silicon_options_variants_header( $variants = array() ) {
	/** @var string $path Path to header layout previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/header';

	return array_merge( $variants, array(
		'horizontal' => array( 'src' => $path . '/horizontal.png', 'label' => esc_html__( 'Horizontal Header', 'silicon' ) ),
		'vertical'   => array( 'src' => $path . '/vertical.png', 'label' => esc_html__( 'Vertical (Lateral) Header', 'silicon' ) ),
	) );
}

/**
 * Returns the options for Menu image_select field
 *
 * @param array $variants
 *
 * @return array
 */
function silicon_options_variants_menu( $variants = array() ) {
	/** @var string $path Path to menu layout previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/menu';

	return array_merge( $variants, array(
		'horizontal' => array( 'src' => $path . '/horizontal.png', 'label' => esc_html__( 'Horizontal Menu', 'silicon' ) ),
		'offcanvas'  => array( 'src' => $path . '/offcanvas.png', 'label' => esc_html__( 'Off-Canvas (Burger) Menu', 'silicon' ) ),
	) );
}

/**
 * Returns the options for Footer image_select field
 *
 * @return array
 */
function silicon_options_variants_footer() {
	/** @var string $path Path to footer layout previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/footer';

	return array(
		'none'        => array( 'src' => $path . '/0-0.png', 'label' => esc_html__( 'No Footer', 'silicon' ) ),
		'one'         => array( 'src' => $path . '/1.png', 'label' => esc_html__( '1 Column', 'silicon' ) ),
		'two'         => array( 'src' => $path . '/2.png', 'label' => esc_html__( '2 Columns', 'silicon' ) ),
		'three'       => array( 'src' => $path . '/3.png', 'label' => esc_html__( '3 Columns', 'silicon' ) ),
		'four'        => array( 'src' => $path . '/4.png', 'label' => esc_html__( '4 Columns', 'silicon' ) ),
		'one-one'     => array( 'src' => $path . '/1-1.png', 'label' => esc_html__( '1 + 1 Columns', 'silicon' ) ),
		'two-one'     => array( 'src' => $path . '/2-1.png', 'label' => esc_html__( '2 + 1 Columns', 'silicon' ) ),
		'three-one'   => array( 'src' => $path . '/3-1.png', 'label' => esc_html__( '3 + 1 Columns', 'silicon' ) ),
		'four-one'    => array( 'src' => $path . '/4-1.png', 'label' => esc_html__( '4 + 1 Columns', 'silicon' ) ),
		'one-two'     => array( 'src' => $path . '/1-2.png', 'label' => esc_html__( '1 + 2 Columns', 'silicon' ) ),
		'two-two'     => array( 'src' => $path . '/2-2.png', 'label' => esc_html__( '2 + 2 Columns', 'silicon' ) ),
		'three-two'   => array( 'src' => $path . '/3-2.png', 'label' => esc_html__( '3 + 2 Columns', 'silicon' ) ),
		'four-two'    => array( 'src' => $path . '/4-2.png', 'label' => esc_html__( '4 + 2 Columns', 'silicon' ) ),
		'one-three'   => array( 'src' => $path . '/1-3.png', 'label' => esc_html__( '1 + 3 Columns', 'silicon' ) ),
		'two-three'   => array( 'src' => $path . '/2-3.png', 'label' => esc_html__( '2 + 3 Columns', 'silicon' ) ),
		'three-three' => array( 'src' => $path . '/3-3.png', 'label' => esc_html__( '3 + 3 Columns', 'silicon' ) ),
		'four-three'  => array( 'src' => $path . '/4-3.png', 'label' => esc_html__( '4 + 3 Columns', 'silicon' ) ),
		'one-four'    => array( 'src' => $path . '/1-4.png', 'label' => esc_html__( '1 + 4 Columns', 'silicon' ) ),
		'two-four'    => array( 'src' => $path . '/2-4.png', 'label' => esc_html__( '2 + 4 Columns', 'silicon' ) ),
		'three-four'  => array( 'src' => $path . '/3-4.png', 'label' => esc_html__( '3 + 4 Columns', 'silicon' ) ),
		'four-four'   => array( 'src' => $path . '/4-4.png', 'label' => esc_html__( '4 + 4 Columns', 'silicon' ) ),
	);
}

/**
 * Returns the options for "blog_layout" image_select field
 *
 * @return array
 */
function silicon_options_variants_blog() {
	/** @var string $path Path to footer layout previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/blog';

	return array(
		'list-left'    => array( 'src' => $path . '/list-left.png', 'label' => esc_html__( 'Sidebar Left List', 'silicon' ) ),
		'list-right'   => array( 'src' => $path . '/list-right.png', 'label' => esc_html__( 'Sidebar Right List', 'silicon' ) ),
		'list-no'      => array( 'src' => $path . '/list-no.png', 'label' => esc_html__( 'No Sidebar List', 'silicon' ) ),
		'grid-left'    => array( 'src' => $path . '/grid-left.png', 'label' => esc_html__( 'Sidebar Left Grid', 'silicon' ) ),
		'grid-right'   => array( 'src' => $path . '/grid-right.png', 'label' => esc_html__( 'Sidebar Right Grid', 'silicon' ) ),
		'grid-no'      => array( 'src' => $path . '/grid-no.png', 'label' => esc_html__( 'No Sidebar Grid', 'silicon' ) ),
		'grid-no-wide' => array( 'src' => $path . '/grid-no-wide.png', 'label' => esc_html__( 'No Sidebar Grid Wide', 'silicon' ) ),
	);
}

/**
 * Returns the options for "single_layout" image_select field
 *
 * @return array
 */
function silicon_options_variants_single() {
	/** @var string $path Path to previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/blog';

	return array(
		'left'  => array( 'src' => $path . '/left.png', 'label' => esc_html__( 'Left Sidebar', 'silicon' ) ),
		'right' => array( 'src' => $path . '/right.png', 'label' => esc_html__( 'Right Sidebar', 'silicon' ) ),
		'no'    => array( 'src' => $path . '/no.png', 'label' => esc_html__( 'No Sidebar', 'silicon' ) ),
	);
}

/**
 * Returns the options for "shop_layout" image_select field
 *
 * @return array
 */
function silicon_options_variants_shop() {
	/** @var string $path Path to previews */
	$path = SILICON_TEMPLATE_URI . '/img/options/shop';

	return array(
		'ls-3' => array( 'src' => $path . '/ls-3.png', 'label' => esc_html__( 'Left Sidebar 3 Columns', 'silicon' ) ),
		'ls-2' => array( 'src' => $path . '/ls-2.png', 'label' => esc_html__( 'Left Sidebar 2 Columns', 'silicon' ) ),
		'rs-3' => array( 'src' => $path . '/rs-3.png', 'label' => esc_html__( 'Right Sidebar 3 Columns', 'silicon' ) ),
		'rs-2' => array( 'src' => $path . '/rs-2.png', 'label' => esc_html__( 'Right Sidebar 2 Columns', 'silicon' ) ),
		'ns-3' => array( 'src' => $path . '/ns-3.png', 'label' => esc_html__( 'No Sidebar 3 Columns', 'silicon' ) ),
		'ns-4' => array( 'src' => $path . '/ns-4.png', 'label' => esc_html__( 'No Sidebar 4 Columns', 'silicon' ) ),
	);
}

/**
 * Flush the Theme Options cache on save or reset action
 *
 * @see silicon_get_option()
 *
 * @param string $slug Theme Options slug
 */
function silicon_options_flush( $slug ) {
	/** This filter is documented in {@see silicon_get_option()} */
	$slug = apply_filters( 'silicon_get_option_slug', '' );

	$cache_key   = is_multisite() ? $slug . '_' . get_current_blog_id() : $slug;
	$cache_group = $slug . '_group';

	wp_cache_delete( $cache_key, $cache_group );
}

add_action( 'equip/options/saved', 'silicon_options_flush' );
add_action( 'equip/options/reseted', 'silicon_options_flush' );
