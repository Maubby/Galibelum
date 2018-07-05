<?php
/**
 * Importer
 *
 * Requires "Importer by 8Guild" plugin
 *
 * @author 8guild
 */

/**
 * Register variant for "One click demo import"
 *
 * @uses gi_register()
 */
function silicon_importer_init() {
	if ( ! function_exists( 'gi_register' ) ) {
		return;
	}

	$dir  = SILICON_TEMPLATE_DIR . '/demo';
	$vars = array(
		array(
			'key'     => 'mobile-app',
			'title'   => esc_html__( 'Mobile App Showcase', 'silicon' ),
			'link'    => esc_url( 'http://mobile-app.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/mobile_app_showcase.jpg',
			'import'  => array(
				'xml'   => $dir . '/mobile-app/demo.xml',
				'extra' => $dir . '/mobile-app/extra.json',
			),
		),
		array(
			'key'     => 'web-app',
			'title'   => esc_html__( 'Web App Presentation', 'silicon' ),
			'link'    => esc_url( 'http://web-app.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/web_app_presentation.jpg',
			'import'  => array(
				'xml'   => $dir . '/web-app/demo.xml',
				'extra' => $dir . '/web-app/extra.json',
			),
		),
		array(
			'key'     => 'product-landing',
			'title'   => esc_html__( 'Product Landing Page', 'silicon' ),
			'link'    => esc_url( 'http://product-landing.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/product_promo.jpg',
			'import'  => array(
				'xml'   => $dir . '/product-landing/demo.xml',
				'extra' => $dir . '/product-landing/extra.json',
			),
		),
		array(
			'key'     => 'freelancer-cv',
			'title'   => esc_html__( 'Freelancer CV/Portfolio', 'silicon' ),
			'link'    => esc_url( 'http://freelancer-cv.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/freelancer_portfolio.jpg',
			'import'  => array(
				'xml'   => $dir . '/freelancer-cv/demo.xml',
				'extra' => $dir . '/freelancer-cv/extra.json',
			),
		),
		array(
			'key'     => 'digital-agency',
			'title'   => esc_html__( 'Digital Agency', 'silicon' ),
			'link'    => esc_url( 'http://digital-agency.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/digital_agency.jpg',
			'import'  => array(
				'xml'       => $dir . '/digital-agency/demo.xml',
				'extra'     => $dir . '/digital-agency/extra.json',
				'revslider' => array( $dir . '/digital-agency/revslider/dagency-home.zip' ),
			),
		),
		array(
			'key'     => 'online-shop',
			'title'   => esc_html__( 'Online Shop', 'silicon' ),
			'link'    => esc_url( 'http://online-shop.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/online_shop.jpg',
			'import'  => array(
				'xml'       => $dir . '/online-shop/demo.xml',
				'extra'     => $dir . '/online-shop/extra.json',
				'revslider' => array( $dir . '/online-shop/revslider/shopHome.zip' ),
			),
		),
		array(
			'key'     => 'venture',
			'title'   => esc_html__( 'Venture Capital Investments', 'silicon' ),
			'link'    => esc_url( 'http://venture.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/venture.jpg',
			'import'  => array(
				'xml'   => $dir . '/venture/demo.xml',
				'extra' => $dir . '/venture/extra.json',
			),
		),
		array(
			'key'     => 'crowdfunding',
			'title'   => esc_html__( 'Startup Crowdfunding', 'silicon' ),
			'link'    => esc_url( 'http://crowdfunding.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/startup.jpg',
			'import'  => array(
				'xml'   => $dir . '/crowdfunding/demo.xml',
				'extra' => $dir . '/crowdfunding/extra.json',
			),
		),
		array(
			'key'     => 'corporate-blog',
			'title'   => esc_html__( 'Corporate Blog Frontpage', 'silicon' ),
			'link'    => esc_url( 'http://corporate-blog.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/business_blog.jpg',
			'import'  => array(
				'xml'   => $dir . '/corporate-blog/demo.xml',
				'extra' => $dir . '/corporate-blog/extra.json',
			),
		),
		array(
			'key'     => 'personal-blog',
			'title'   => esc_html__( 'Personal Blog Frontpage', 'silicon' ),
			'link'    => esc_url( 'http://personal-blog.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/personal_blog.jpg',
			'import'  => array(
				'xml'   => $dir . '/personal-blog/demo.xml',
				'extra' => $dir . '/personal-blog/extra.json',
			),
		),
		array(
			'key'     => 'conference',
			'title'   => esc_html__( 'Conference Landing', 'silicon' ),
			'link'    => esc_url( 'http://conference.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/conference.jpg',
			'import'  => array(
				'xml'   => $dir . '/conference/demo.xml',
				'extra' => $dir . '/conference/extra.json',
			),
		),
		array(
			'key'     => 'coworking',
			'title'   => esc_html__( 'Coworking Space Promo Page', 'silicon' ),
			'link'    => esc_url( 'http://coworking.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/coworking.jpg',
			'import'  => array(
				'xml'   => $dir . '/coworking/demo.xml',
				'extra' => $dir . '/coworking/extra.json',
			),
		),
		array(
			'key'     => 'enterprise',
			'title'   => esc_html__( 'Enterprise Software Development', 'silicon' ),
			'link'    => esc_url( 'http://enterprise.silicon.8guild.com/' ),
			'preview' => SILICON_TEMPLATE_URI . '/img/import/enterprise.jpg',
			'import'  => array(
				'xml'   => $dir . '/enterprise/demo.xml',
				'extra' => $dir . '/enterprise/extra.json',
			),
		)
	);

	gi_register( $vars, array(
		'parent_slug' => 'silicon',
		'page_title'  => esc_html__( 'Demo Import', 'silicon' ),
		'menu_title'  => esc_html__( 'Demo Import', 'silicon' ),
		'menu_slug'   => 'silicon-import',
		'nonce'       => 'silicon_import',
		'nonce_field' => 'silicon_import_nonce',
	) );
}

add_action( 'guild/importer/register', 'silicon_importer_init' );
