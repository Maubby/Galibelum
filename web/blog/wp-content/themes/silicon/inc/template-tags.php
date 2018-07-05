<?php
/**
 * Custom Template Tags
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'silicon_is_topbar' ) ) :
	/**
	 * Check if Topbar is enabled in Theme Options
	 *
	 * @see silicon_options_header()
	 *
	 * @return bool
	 */
	function silicon_is_topbar() {
		return apply_filters( 'silicon_is_topbar', (bool) silicon_get_setting( 'header_is_topbar', 0 ) );
	}
endif;

if ( ! function_exists( 'silicon_is_offcanvas' ) ) :
	/**
	 * Check if offcanvas menu enabled in Theme Options
	 *
	 * @see silicon_options_header() "header_menu_variant" option
	 * @return bool
	 */
	function silicon_is_offcanvas() {
		return apply_filters( 'silicon_is_offcanvas', 'offcanvas' === (string) silicon_get_setting( 'header_menu_variant', 'horizontal' ) );
	}
endif;

if ( ! function_exists( 'silicon_is_search' ) ) :
	/**
	 * Check if "Search" button enabled in Theme Options
	 *
	 * Displayed in Navbar
	 *
	 * @see silicon_options_header()
	 * @see silicon_navbar_utils()
	 * @see /template-parts/headers/header-*.php
	 *
	 * @return bool
	 */
	function silicon_is_search() {
		return apply_filters( 'silicon_is_search', (bool) silicon_get_setting( 'header_utils_is_search', 1 ) );
	}
endif;

if ( ! function_exists( 'silicon_is_cart' ) ) :
	/**
	 * Check if "Cart" is enabled in Theme Options > Header > Navbar Utilities > Shopping Cart
	 *
	 * @see silicon_options_header()
	 *
	 * @return bool
	 */
	function silicon_is_cart() {
		$is_cart = silicon_is_woocommerce()
		           && (bool) silicon_get_setting( 'header_utils_is_cart', 1 ) // check page settings first
		           && ( ! is_cart() && ! is_checkout() ); // disable on cart and checkout pages

		return apply_filters( 'silicon_is_cart', $is_cart );
	}
endif;

if ( ! function_exists( 'silicon_is_intro' ) ) :
	/**
	 * Check if Intro section is enabled for current page.
	 * Based on Page Settings.
	 *
	 * NOTE: as Intro section is based on plugin we also check plugin availability
	 *
	 * @return bool
	 */
	function silicon_is_intro() {
		$is_intro = ( defined( 'SILICON_PLUGIN_VERSION' ) && (int) silicon_get_setting( 'intro', 0 ) > 0 );

		return apply_filters( 'silicon_is_intro', $is_intro );
	}
endif;

if ( ! function_exists( 'silicon_the_breadcrumbs' ) ) :
	/**
	 * Display the Breadcrumbs
	 *
	 * @see silicon_page_title()
	 */
	function silicon_the_breadcrumbs() {
		if ( ! function_exists( 'bcn_display' ) || is_search() || is_404() ) {
			return;
		}

		echo '<div class="breadcrumbs">';
		bcn_display();
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_the_excerpt' ) ) :
	/**
	 * Remove all HTML tags from the excerpt
	 *
	 * @hooked the_excerpt 20
	 *
	 * @param string $output The excerpt
	 *
	 * @return string
	 */
	function silicon_the_excerpt( $output ) {
		return strip_tags( $output );
	}
endif;

if ( ! function_exists( 'silicon_get_shares' ) ) :
	/**
	 * Returns the Sharing Buttons markup
	 *
	 * You MUST used this template tag within the Loop.
	 *
	 * @return string
	 */
	function silicon_get_shares() {
		// collect data about the post
		$data = array(
			'data-si-share' => 'true', // share trigger
			'data-text'     => esc_html( get_the_title() ),
			'data-url'      => esc_url( get_the_permalink() ),
			'data-thumb'    => has_post_thumbnail() ? silicon_get_image_src( get_post_thumbnail_id() ) : '',
		);

		/**
		 * Filter the set of Share Buttons
		 *
		 * This filters allows you to add your own networks or remove
		 * existing ones. Your callback should return the array with
		 * keys of the network and text on the button.
		 *
		 * NOTE: the key of network should be valid and
		 * be similar with data in networks.ini file.
		 * @see silicon_get_networks()
		 *
		 * Also note we use the Socicon to display Social Icons,
		 * so you can see the valid keys here {@link http://www.socicon.com/chart.php}
		 *
		 * @param array $shares A list of share buttons
		 */
		$shares = apply_filters( 'silicon_entry_shares', array(
			'twitter',
			'facebook',
			'gplus',
			'pinterest',
		) );

		$networks = silicon_get_networks();
		$networks = array_intersect_key( $networks, array_flip( $shares ) );

		if ( empty( $shares ) ) {
			return '';
		}

		$markup = array();
		array_walk( $shares, function ( $network ) use ( &$markup, $networks, $data ) {
			$attr     = array_merge( $data, array( 'data-network' => esc_attr( $network ) ) );
			$markup[] = sprintf(
				'<a href="#" class="social-button %2$s sb-shape-circle sb-monochrome sb-light border-default" %3$s>
                    <i class="%1$s unhvrd"></i>
                    <i class="%1$s hvrd"></i>
                </a>',
				isset( $networks[ $network ]['icon'] ) ? esc_attr( $networks[ $network ]['icon'] ) : '',
				isset( $networks[ $network ]['helper'] ) ? esc_attr( $networks[ $network ]['helper'] ) : '',
				silicon_get_attr( $attr )
			);
		} );

		/**
		 * Filter the outputted HTML for share buttons only
		 *
		 * @param string $markup HTML output
		 */
		$markup = apply_filters( 'silicon_entry_shares_markup', implode( '', $markup ) );

		/**
		 * Filter the share button template
		 *
		 * NOTE: first parameter is share label, has it's own filter. Default is "Share".
		 * Second parameter is share buttons markup with required data-attributes.
		 * Have their own filters, too.
		 *
		 * @param string $template
		 */
		$template = apply_filters( 'silicon_entry_shares_template',
			'<div class="entry-share">
		        <a href="#" class="btn btn-link btn-pill btn-default" data-si-popover="true">
			        %1$s
			        <i class="si si-share"></i>
                </a>
                <div class="popover text-center" tabindex="-1">%2$s</div>
            </div>'
		);

		return sprintf( $template,
			apply_filters( 'silicon_entry_shares_label', esc_html__( 'Share', 'silicon' ) ),
			$markup
		);
	}
endif;

if ( ! function_exists( 'silicon_the_shares' ) ) :
	/**
	 * Display the Sharing Buttons
	 *
	 * You MUST used this template tag within the Loop.
	 *
	 * @uses silicon_get_shares()
	 */
	function silicon_the_shares() {
		echo silicon_get_shares();
	}
endif;

if ( ! function_exists( 'silicon_logo' ) ) :
	/**
	 * Display the logo
	 *
	 * Logo priority:
	 * 1. Custom Logo per specific page from Page Settings
	 * 2. Site Logo from the Customizer
	 * 3. Silicon Fallback Logo
	 *
	 * Optional display the mobile logo
	 *
	 * @uses the_custom_logo()
	 */
	function silicon_logo() {
		$home   = esc_url( home_url( '/' ) );
		$custom = (int) silicon_get_setting( 'custom_logo', 0 );

		if ( $custom ) {
			$logo = wp_get_attachment_image( $custom, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) );

			// Get the image width from image metadata
			// and divide the value by two
			$metadata = wp_get_attachment_metadata( $custom );
			$width    = empty( $metadata['width'] ) ? 240 : (int) $metadata['width'];
			unset( $metadata );
		} elseif ( has_custom_logo() ) {
			$logo_id = (int) get_theme_mod( 'custom_logo' );
			$logo    = wp_get_attachment_image( $logo_id, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) );

			$metadata = wp_get_attachment_metadata( $logo_id );
			$width    = empty( $metadata['width'] ) ? 240 : (int) $metadata['width'];
			unset( $metadata, $logo_id );
		} else {
			/**
			 * Filter the URI to logo fallback
			 *
			 * This logo will be loaded if user does not specify the logo
			 * neither through customizer (WP 4.5+), nor in Theme Options
			 *
			 * This filter may be useful if you want to change the default fallback logo
			 *
			 * @param string $uri Logo URI
			 */
			$logo_src = apply_filters( 'silicon_logo_fallback', SILICON_TEMPLATE_URI . '/img/logo.png' );

			/**
			 * Filter the fallback logo attributes
			 *
			 * This filter allows you to add, remove or change attributes
			 * for <img> tag, containing the logo
			 *
			 * @param array $attributes Fallback logo attributes
			 */
			$logo = silicon_get_tag( 'img', apply_filters( 'silicon_logo_fallback_atts', array(
				'src'      => esc_url( $logo_src ),
				'alt'      => esc_attr( get_bloginfo( 'name', 'display' ) ),
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) ) );

			/**
			 * This filter will be useful in case you override the fallback logo via the filter.
			 * Note, the image value should be as twice as big then required logo size.
			 *
			 * @param int $width
			 */
			$width = apply_filters( 'silicon_logo_fallback_width', 240 );
		}

		// output
		printf( '<a href="%1$s" class="site-logo" rel="home" itemprop="url" style="width: %3$dpx;">%2$s</a>',
			$home,
			$logo,
			(float) $width / 2
		);

		// mobile logo. optional
		// first check the page settings, second - theme options
		// if mobile logo not specified show desktop logo
		$mobile = silicon_get_setting( 'header_mobile_logo' );
		if ( 0 === (int) $mobile ) {
			$mobile = silicon_get_option( 'header_mobile_logo' );
		}

		if ( $mobile ) {
			$mobile_logo  = wp_get_attachment_image( (int) $mobile, 'full' );
			$mobile_meta  = wp_get_attachment_metadata( (int) $mobile );
			$mobile_width = empty( $mobile_meta['width'] ) ? 240 : (int) $mobile_meta['width'];
			unset( $mobile_meta );
		} else {
			// if mobile logo not provided, use the desktop logo
			$mobile_logo  = $logo;
			$mobile_width = $width;
		}

		printf( '<a href="%1$s" class="mobile-logo" style="width: %3$dpx;">%2$s</a>',
			$home,
			$mobile_logo,
			(float) $mobile_width / 2
		);
	}
endif;

if ( ! function_exists( 'silicon_logo_stuck' ) ) :
	/**
	 * Display the logo in the stuck header
     *
     * Stuck logo priority:
	 * 1. Stuck Logo from Page Settings (can be specific per page)
     * 2. Stuck Logo from Theme Options
	 * 3. Site Logo from the Customizer
	 * 4. Silicon Fallback Logo
	 */
	function silicon_logo_stuck() {
		$stuck = silicon_get_setting( 'header_stuck_logo' );
		if ( 0 === (int) $stuck ) {
			$stuck = silicon_get_option( 'header_stuck_logo', 0 );
        }

		if ( $stuck ) {
			$logo = wp_get_attachment_image( $stuck, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) );

			// Get the image width from image metadata
			// and divide the value by two
			$metadata = wp_get_attachment_metadata( $stuck );
			$width    = empty( $metadata['width'] ) ? 240 : (int) $metadata['width'];
			unset( $metadata );
		} elseif ( has_custom_logo() ) {
			$logo_id = (int) get_theme_mod( 'custom_logo' );
			$logo    = wp_get_attachment_image( $logo_id, 'full', false, array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) );

			$metadata = wp_get_attachment_metadata( $logo_id );
			$width    = empty( $metadata['width'] ) ? 240 : (int) $metadata['width'];
			unset( $metadata, $logo_id );
		} else {
			/**
			 * Filter the URI to logo fallback
			 *
			 * This logo will be loaded if user does not specify the logo
			 * neither through customizer (WP 4.5+), nor in Theme Options
			 *
			 * This filter may be useful if you want to change the default fallback logo
			 *
			 * @param string $uri Logo URI
			 */
			$logo_src = apply_filters( 'silicon_logo_fallback', SILICON_TEMPLATE_URI . '/img/logo.png' );

			/**
			 * Filter the fallback logo attributes
			 *
			 * This filter allows you to add, remove or change attributes
			 * for <img> tag, containing the logo
			 *
			 * @param array $attributes Fallback logo attributes
			 */
			$logo = silicon_get_tag( 'img', apply_filters( 'silicon_logo_fallback_atts', array(
				'src'      => esc_url( $logo_src ),
				'alt'      => esc_attr( get_bloginfo( 'name', 'display' ) ),
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			) ) );

			/**
			 * This filter will be useful in case you override the fallback logo via the filter.
			 * Note, the image value should be as twice as big then required logo size.
			 *
			 * @param int $width
			 */
			$width = apply_filters( 'silicon_logo_fallback_width', 240 );
		}

		printf( '<a href="%1$s" class="site-logo" rel="home" itemprop="url" style="width: %3$dpx;">%2$s</a>',
			esc_url( home_url( '/' ) ),
			$logo,
			(float) $width / 2
		);
	}
endif;

if ( ! function_exists( 'silicon_offcanvas_cart' ) ):
	/**
	 * Display the Off-Canvas Shopping Cart
	 *
	 * @uses woocommerce_mini_cart()
	 */
	function silicon_offcanvas_cart() {
		if ( ! silicon_is_cart() ) {
			return;
		}

		?>
        <div class="offcanvas-container offcanvas-cart">
            <header class="cart-header">
                <div class="column">
                    <h3 class="cart-title"><?php esc_html_e( 'Cart', 'silicon' ); ?></h3>
                </div>
                <div class="column">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="view-cart-link font-family-nav navi-link-hover-color">
                        <?php esc_html_e( 'View Cart', 'silicon' ); ?>
                        <i class="si si-angle-right"></i>
                    </a>
                </div>
            </header>
            <?php woocommerce_mini_cart(); ?>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_offcanvas_menu' ) ):
	/**
	 * Display the Off-Canvas Menu
	 *
	 * @hooked silicon_header_before 5
	 */
	function silicon_offcanvas_menu() {
		if ( ! silicon_is_offcanvas() ) {
			return;
		}

		?>
        <div class="offcanvas-container offcanvas-menu">
			<?php
            silicon_menu_primary();
			silicon_navbar_buttons();
            ?>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_header_layout' ) ):
	/**
	 * Returns the template part name for header
	 *
	 * Based on Page Settings and Theme Options
	 *
	 * @see silicon_meta_box_page_settings()
	 * @see silicon_options_header()
	 * @see header.php
	 * @see template-parts/headers/header-*.php
	 *
	 * @return string
	 */
	function silicon_header_layout() {
		$layout = silicon_get_setting( 'header_layout', 'horizontal' );

		/**
		 * Filter the layout type
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named header-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/headers/header-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_header_layout', $layout ) );
	}
endif;

if ( ! function_exists( 'silicon_header_class' ) ) :
	/**
	 * Echoes the Site Header class
	 *
	 * @param string $class Custom classes, e.g. "my custom class"
	 *
	 * @see template-parts/headers/header-{$layout}.php
	 */
	function silicon_header_class( $class = '' ) {
		$classes   = array();
		$classes[] = 'site-header';

		if ( (bool) silicon_get_setting( 'header_is_fullwidth', 1 ) ) {
			$classes[] = 'header-fullwidth';
		}

		if ( (bool) silicon_get_setting( 'header_is_floating', 0 ) ) {
			$classes[] = 'header-floating';
		}

		if ( ! empty( $class ) ) {
			$classes[] = $class;
		}

		/**
		 * Filter the Header classes
		 *
		 * This filter allows you to easily add (or remove)
		 * custom classes to the .site-header
		 *
		 * @param array $classes A list of classes
		 */
		$classes = apply_filters( 'silicon_header_class', $classes );

		echo esc_attr( silicon_get_classes( $classes ) );
	}
endif;

if ( ! function_exists( 'silicon_menu_primary' ) ) :
	/**
	 * Show the main navigation
     *
     * @hooked silicon_navbar_center 10
	 */
	function silicon_menu_primary() {
		if ( ! has_nav_menu( 'primary' ) ) {
			return;
		}

		/**
		 * Filter the main menu arguments
		 *
		 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 *
		 * @param array $args Arguments
		 */
		$args = apply_filters( 'silicon_primary_menu_args', array(
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'container_class' => 'main-navigation font-family-nav',
			'container_id'    => false,
			'fallback_cb'     => false,
			'depth'           => 3,
			'walker'          => new Silicon_Walker_Menu_Additions(),
		) );

		wp_nav_menu( $args );
	}
endif;

if ( ! function_exists( 'silicon_menu_mobile' ) ) :
	/**
	 * Display the Mobile Menu
	 *
	 * @hooked silicon_header_before 5
	 */
	function silicon_menu_mobile() {
		?>
        <div class="offcanvas-container mobile-menu">
			<?php
            if ( silicon_is_search() ) :
                get_search_form();
            endif;

            silicon_menu_primary();

            if ( 'vertical' === silicon_header_layout() ) {
	            silicon_navbar_socials( array( 'alignment' => 'center', 'skin' => 'light' ) );
            }

			silicon_navbar_buttons();
            ?>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_menu_secondary' ) ) :
	/**
	 * Display the secondary menu in the Navbar
	 *
	 * @hooked silicon_navbar_left 10
	 */
	function silicon_menu_secondary() {
		if ( ! has_nav_menu( 'secondary' ) ) {
			return;
		}

		/**
		 * Filter the menu arguments
		 *
		 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 *
		 * @param array $args Arguments
		 */
		$args = apply_filters( 'silicon_secondary_menu_args', array(
			'theme_location'  => 'secondary',
			'container'       => 'nav',
			'container_class' => 'secondary-menu',
			'container_id'    => false,
			'fallback_cb'     => false,
			'depth'           => 3,
		) );

		wp_nav_menu( $args );
	}
endif;

if ( ! function_exists( 'silicon_topbar_class' ) ) :
	/**
	 * Display the Topbar classes
	 *
	 * @see template-parts/headers/
	 */
	function silicon_topbar_class() {
		$class = array();

		$background = esc_attr( silicon_get_setting( 'header_appearance_topbar_bg', 'solid' ) );
		$skin       = esc_attr( silicon_get_setting( 'header_appearance_topbar_skin', 'dark' ) );

		$class[] = 'topbar';
		$class[] = 'font-family-nav';
		$class[] = 'background-' . $background;
		$class[] = 'topbar-' . $skin . '-skin';

		if ( 'transparent' === $background ) {
			$class[] = 'topbar-ghost';
			$class[] = 'border-default-bottom';
			$class[] = ( 'light' === $skin ) ? 'border-light' : '';
		}

		/**
		 * Filter the topbar class
		 *
		 * @param array $classes A list of topbar classes
		 */
		$class = apply_filters( 'silicon_topbar_class', array_filter( $class ) );

		echo esc_attr( silicon_get_classes( $class ) );
	}
endif;

if ( ! function_exists( 'silicon_topbar_style' ) ) :
	/**
	 * Display the Topbar inline styles
	 *
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_css_declarations()
	 */
	function silicon_topbar_style() {
		$style = array();

		if ( 'solid' === silicon_get_setting( 'header_appearance_topbar_bg', 'solid' ) ) {
			$color = silicon_get_setting( 'header_appearance_topbar_bg_color', '#f5f5f5' );
			$style['background-color'] = sanitize_hex_color( $color );
			unset( $color );
		}

		/**
		 * Filter the navbar attributes
		 *
		 * NOTE: you have to use a valid CSS property as a key.
		 *
		 * @param array $style A list of key-values with navbar styles
		 */
		$style = apply_filters( 'silicon_topbar_style', $style );

		echo esc_attr( silicon_css_declarations( $style ) );
	}
endif;

if ( ! function_exists( 'silicon_topbar_attr' ) ) :
	/**
	 * Display the other Topbar attributes
	 *
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_get_attr()
	 */
	function silicon_topbar_attr() {
		/**
		 * Filter the navbar attributes
		 *
		 * NOTE: use a valid HTML attribute as a key
		 * NOTE: class and style attributes not allowed
		 *
		 * @param array $attr A list of key-values with topbar attributes
		 */
		$attr = apply_filters( 'silicon_topbar_attr', array() );

		// class and style not allowed
		// use "silicon_navbar_class" instead
		// use "silicon_navbar_style" instead
		$attr = array_diff_key( $attr, array_flip( array( 'class', 'style' ) ) );

		echo silicon_get_attr( $attr );
	}
endif;

if ( ! function_exists( 'silicon_topbar_info' ) ) :
	/**
	 * Display the Additional Info in the Topbar
	 *
	 * @hooked silicon_topbar_left 10
	 * @see    silicon_options_header()
	 * @see    /template-parts/headers/header-horizontal.php
	 */
	function silicon_topbar_info() {
		$info = silicon_get_option( 'header_topbar_info' );
		$info = silicon_sanitize_text( $info );

		echo silicon_get_text( $info, '<div class="additional-info hidden-sm hidden-xs">', '</div>' );
	}
endif;

if ( ! function_exists( 'silicon_topbar_socials' ) ) :
	/**
	 * Display the Socials Networks in the Topbar
	 *
	 * NOTE: user can disable Socials in Theme Options
	 * NOTE: Social Networks require Silicon Plugin to work
	 *
	 * @hooked silicon_topbar_left 20
	 * @see    silicon_options_header()
	 * @see    /template-parts/headers/header-horizontal.php
	 */
	function silicon_topbar_socials() {
		if ( false === (bool) silicon_get_option( 'header_topbar_is_socials', 0 )
		     || ! defined( 'SILICON_PLUGIN_VERSION' )
		) {
			return;
		}

		$socials_raw = silicon_get_option( 'header_topbar_socials' );
		if ( empty( $socials_raw ) ) {
			return;
		}

		$socials = array();
		foreach ( (array) $socials_raw as $network => $url ) {
			$socials[] = array( 'network' => $network, 'url' => $url );
		}
		unset( $network, $url );

		$socials   = urlencode( json_encode( $socials ) );
		$shortcode = silicon_shortcode_build( 'silicon_socials', array(
			'socials'   => $socials,
			'shape'     => 'no',
			'alignment' => 'no',
			'skin'      => esc_attr( silicon_get_setting( 'header_appearance_topbar_skin', 'dark' ) ),
		) );

		echo silicon_do_shortcode( $shortcode );
	}
endif;

if ( ! function_exists( 'silicon_topbar_menu' ) ) :
	/**
	 * Show the Topbar navigation
	 *
	 * @hooked silicon_topbar_right 10
	 * @see    /template-parts/headers/header-horizontal.php
	 */
	function silicon_topbar_menu() {
		if ( ! has_nav_menu( 'topbar' ) ) {
			return;
		}

		/**
		 * Filter the menu arguments
		 *
		 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 *
		 * @param array $args Arguments
		 */
		$args = apply_filters( 'silicon_topbar_menu_args', array(
			'theme_location'  => 'topbar',
			'container'       => 'nav',
			'container_class' => 'topbar-menu hidden-sm hidden-xs',
			'container_id'    => false,
			'fallback_cb'     => false,
			'depth'           => 1,
		) );

		wp_nav_menu( $args );
	}
endif;

if ( ! function_exists( 'silicon_topbar_login' ) ) :
	/**
	 * Display the login button in the Topbar
	 *
	 * @hooked silicon_topbar_right 20
	 * @see    /template-parts/headers/header-horizontal.php
	 */
	function silicon_topbar_login() {
		if ( false === (bool) silicon_get_option( 'header_topbar_is_login', 0 ) ) {
			return;
		}

		if ( is_user_logged_in() && current_user_can( 'read' ) ) {
			$user = wp_get_current_user();

			echo sprintf(
				'<a href="%1$s" class="login-link">
                    <i class="si si-person"></i>
                    <span>&nbsp;%2$s</span>
                </a>',
				esc_url( admin_url() ),
				$user->display_name
			);
		} else {
			$default = esc_html__( 'Login or Create account', 'silicon' );
			$label   = (string) silicon_get_option( 'header_topbar_login_title', $default );

			echo sprintf(
				'<a href="%1$s" class="login-link">
                    <i class="si si-person"></i>
                    <span>&nbsp;%2$s</span>
                </a>',
				esc_url( wp_login_url() ),
				$label
			);
		}
	}
endif;

if ( ! function_exists( 'silicon_navbar_class' ) ) :
	/**
	 * Display the Navbar classes
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 *
	 * @see  silicon_options_header()
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_get_classes()
	 */
	function silicon_navbar_class() {
		$class = array();

		$class[] = 'navbar-horizontal';
		$class[] = 'navbar-' . silicon_get_setting( 'header_appearance_bg', 'solid' );
		$class[] = 'menu-skin-' . silicon_get_setting( 'header_appearance_menu_skin', 'dark' );
		$class[] = 'border-default-bottom';

		/**
		 * Filter the Navbar classes.
		 * This filter allows you to easily add (or remove) custom classes.
		 *
		 * @param array $class A list of classes
		 */
		$class = apply_filters( 'silicon_navbar_class', $class );

		echo esc_attr( silicon_get_classes( $class ) );
	}
endif;

if ( ! function_exists( 'silicon_navbar_style' ) ) :
	/**
	 * Display the Navbar inline styles
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 *
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_css_declarations()
	 */
	function silicon_navbar_style() {
		$style = array();

		if ( 'solid' === silicon_get_setting( 'header_appearance_bg', 'solid' ) ) {
			$color = silicon_get_setting( 'header_appearance_bg_custom', '#ffffff' );
			$style['background-color'] = sanitize_hex_color( $color );
			unset( $color );
		}

		/**
		 * Filter the navbar attributes
		 *
		 * NOTE: you have to use a valid CSS property as a key.
		 *
		 * @param array $style A list of key-values with navbar styles
		 */
		$style = apply_filters( 'silicon_navbar_style', $style );

		echo esc_attr( silicon_css_declarations( $style ) );
	}
endif;

if ( ! function_exists( 'silicon_navbar_attr' ) ) :
	/**
	 * Display the other Navbar attributes
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 *
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_get_attr()
	 */
	function silicon_navbar_attr() {
		/**
		 * Filter the navbar attributes
         *
         * NOTE: use a valid HTML attribute as a key
         * NOTE: class and style attributes not allowed
		 *
		 * @param array $attr A list of key-values with navbar attributes
		 */
		$attr = apply_filters( 'silicon_navbar_attr', array() );

		// class and style not allowed
        // use "silicon_navbar_class" instead
        // use "silicon_navbar_style" instead
		$attr = array_diff_key( $attr, array_flip( array( 'class', 'style' ) ) );

		echo silicon_get_attr( $attr );
	}
endif;

if ( ! function_exists( 'silicon_navbar_utils' ) ) :
	/**
	 * Display the Utilities in Navbar section
	 *
	 * NOTE: you can enable/disable tools in Theme Options
	 * NOTE: this template tag designed only for Horizontal navbar
	 *
	 * @see silicon_options_header()
	 */
	function silicon_navbar_utils() {

		// search button
		if ( silicon_is_search() ) {
			echo '
            <div class="util site-search-toggle">
                <i class="si si-search"></i>
            </div>';
		}

		// woocommerce cart
		if ( silicon_is_cart() ) {
			echo sprintf( '
                <div class="util cart-toggle">
                    <span class="text-lg">%1$s</span>
                    <span class="product-count text-xs" data-si-product-count="%2$d">%2$d</span>
                </div>',
				esc_html__( 'Cart', 'silicon' ),
				absint( WC()->cart->get_cart_contents_count() )
			);
		}

		// buttons
		if ( ! silicon_is_offcanvas() ) {
			silicon_navbar_buttons();
		}

		// off-canvas button
		if ( silicon_is_offcanvas() ) {
			echo sprintf( '
                <div class="util offcanvas-menu-toggle">
                    <span>%s</span>
                    <i class="si si-menu"></i>
                </div>',
				esc_html__( 'Menu', 'silicon' )
			);
		}
	}
endif;

if ( ! function_exists( 'silicon_navbar_buttons' ) ) :
	/**
	 * Display the Button Widgets inside Header > Navbar
	 *
	 * NOTE: header buttons are build with widgets, check Appearance > Widgets > Header Buttons sidebar
	 * NOTE: header buttons may be disabled via Page Settings
	 *
	 * @see  silicon_widgets_init()
	 * @see  silicon_widgets_buttons_sidebar()
	 * @uses Silicon_Widget_Button
	 */
	function silicon_navbar_buttons() {
		if ( ! is_active_sidebar( 'sidebar-header-buttons' )
		     || false === (bool) silicon_get_setting( 'header_is_buttons', 1 )
		) {
			return;
		}

		echo '<div class="util site-button">';
		dynamic_sidebar( 'sidebar-header-buttons' );
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_navbar_socials' ) ) :
	/**
	 * Display the Navbar socials
	 *
	 * NOTE: this template tag designed for Vertical (Lateral) Header
	 * NOTE: socials may be disabled in Theme Options > Header > Navbar Utilities > Socials Networks
	 * NOTE: social networks based on Socials shortcode and requires plugin
	 *
	 * @see silicon_menu_mobile()
	 * @see template-parts/headers/header-vertical.php
	 *
	 * @param array $settings Shortcode settings
	 */
	function silicon_navbar_socials( $settings = array() ) {
		if ( ! defined( 'SILICON_PLUGIN_VERSION' )
		     || false === (bool) silicon_get_option( 'header_utils_is_socials', 0 )
		) {
			return;
		}

		$raw = silicon_get_option( 'header_utils_socials' );
		if ( empty( $raw ) ) {
			return;
		}

		$socials = array();
		array_walk( $raw, function ( $url, $network ) use ( &$socials ) {
			$socials[] = array( 'network' => $network, 'url' => $url );
		} );

		$socials  = urlencode( json_encode( $socials ) );
		$settings = wp_parse_args( $settings, array(
			'socials'   => $socials,
			'shape'     => silicon_get_option( 'header_utils_socials_shape', 'circle' ),
			'color'     => 'monochrome',
			'alignment' => 'no',
			'skin'      => 'dark',
		) );

		echo silicon_do_shortcode( silicon_shortcode_build( 'silicon_socials', $settings ) );
	}
endif;

if ( ! function_exists( 'silicon_navbar_stuck_class' ) ) :
	/**
	 * Display the Navbar Stuck class
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 * NOTE: controlled both in Page Settings and Theme Options, see "header_is_sticky"
	 *
	 * @see silicon_options_header()
	 * @see silicon_meta_box_page_settings()
	 * @see template-parts/headers/header-horizontal.php
	 */
	function silicon_navbar_stuck_class() {
		$class = array();

		$class[] = 'navbar-horizontal';
		$class[] = 'navbar-sticky';
		$class[] = 'menu-skin-' . silicon_get_setting( 'header_appearance_stuck_menu_skin', 'dark' );
		$class[] = 'border-default-bottom';

		/**
		 * Filter the Navbar Stuck classes.
		 * This filter allows you to easily add (or remove) custom classes.
		 *
		 * @param array $class A list of classes
		 */
		$class = apply_filters( 'silicon_navbar_stuck_class', $class );

		echo esc_attr( silicon_get_classes( $class ) );
	}
endif;

if ( ! function_exists( 'silicon_navbar_stuck_style' ) ) :
	/**
	 * Display the sticky Navbar inline styles
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 *
	 * @see  template-parts/headers/header-horizontal.php
	 * @uses silicon_css_declarations()
	 */
	function silicon_navbar_stuck_style() {
		$style = array();

		$color = silicon_get_setting( 'header_appearance_stuck_bg_color', '#ffffff' );
		$style['background-color'] = sanitize_hex_color( $color );
		unset( $color );

		/**
		 * Filter the navbar attributes
		 *
		 * NOTE: you have to use a valid CSS property as a key.
		 *
		 * @param array $style A list of key-values with navbar styles
		 */
		$style = apply_filters( 'silicon_navbar_stuck_style', $style );

		echo esc_attr( silicon_css_declarations( $style ) );
	}
endif;

if ( ! function_exists( 'silicon_navbar_stuck_attr' ) ) :
	/**
	 * Display the other Navbar Stuck attributes
	 *
	 * NOTE: applicable only for Horizontal Navbar type
	 *
	 * @see template-parts/headers/header-horizontal.php
	 */
	function silicon_navbar_stuck_attr() {
		/**
		 * Filter the sticky navbar attributes
		 *
		 * NOTE: use a valid HTML attribute as a key
		 * NOTE: class and style attributes not allowed
		 *
		 * @param array $attr A list of key-values with navbar attributes
		 */
		$attr = apply_filters( 'silicon_navbar_stuck_attr', array() );

		// class and style not allowed
		// use "silicon_navbar_stuck_class" instead
		// use "silicon_navbar_stuck_style" instead
		$attr = array_diff_key( $attr, array_flip( array( 'class', 'style' ) ) );

		echo silicon_get_attr( $attr );
	}
endif;

if ( ! function_exists( 'silicon_blog_layout' ) ) :
	/**
	 * Returns the template part for blog
	 *
	 * Based on Theme Options
	 *
	 * @see index.php
	 * @see inc/options.php
	 * @see template-parts/blog/blog-*.php
	 *
	 * @return string
	 */
	function silicon_blog_layout() {
		$layout = silicon_get_option( 'blog_layout', 'grid-right' );

		/**
		 * Filter the layout type for a Blog
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named blog-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/blog/blog-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_blog_layout', $layout ) );
	}
endif;

if ( ! function_exists( 'silicon_blog_pagination' ) ) :
	/**
	 * Prints the markup for blog posts pagination
	 *
	 * Depends on Theme Options
     * TODO: split into three different functions
     * TODO: rename to silicon_pagination()
	 *
	 * @hooked silicon_loop_after 10
	 * @see    silicon_options_blog()
	 * @see    template-parts/blog/*
	 */
	function silicon_blog_pagination() {
		global $wp_query;

		$max_pages = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
		if ( $max_pages < 2 ) {
			return;
		}

		$paged    = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$total    = (int) wp_count_posts()->publish;
		$per_page = (int) get_option( 'posts_per_page' );

		// Archive supports only paginate links
		$type = is_archive() ? 'links' : silicon_get_option( 'blog_pagination_type', 'links' );

		switch ( $type ) {
			case 'load-more':

				// Detect how many posts left to load to show on the button.
				// This number should tells user how many posts will be loaded
				// when he click on the button.
				$number = $total - ( $paged * $per_page );

				// If number of posts greater, than per_page option - show per_page value
				// This is required for situation when number of posts less, that per_page options
				$number  = ( $number > $per_page ) ? $per_page : $number;
				$content = sprintf( '<i class="si si-load-more"></i> %1$s (<span data-load-more-counter="%2$s">%2$s</span>)',
					esc_html__( 'Load More', 'silicon' ),
					$number
				);

				// load more attributes
				$more = array(
					'action'  => 'silicon_posts_load_more',
					'nonce'   => wp_create_nonce( 'silicon-ajax' ),
					'page'    => $paged + 1,
					'total'   => $total,
					'perPage' => $per_page,
				);

				/**
				 * Filter the Load More button markup
				 *
				 * @param string $el HTML-formatted string
				 */
				$nav = apply_filters( 'silicon_blog_pagination_load_more', silicon_get_tag( 'a', array(
					'href'              => '#',
					'class'             => 'btn btn-link btn-pill btn-sm btn-default',
					'rel'               => 'nofollow',
					'data-si-load-more' => $more,
				), $content ) );

				unset( $number, $content, $more );
				break;

			case 'infinite-scroll':

				// data for infinite scroll
				$infinite = array(
					'action'   => 'silicon_posts_load_more',
					'nonce'    => wp_create_nonce( 'silicon-ajax' ),
					'page'     => $paged + 1,
					'maxPages' => $max_pages,
					'noMore'   => apply_filters( 'silicon_blog_pagination_no_more', esc_html__( 'No more posts', 'silicon' ) ),
				);

				/**
				 * Filter the Infinite Scroll element markup
				 *
				 * @param string $el HTML-formatted string
				 */
				$nav = apply_filters( 'silicon_blog_pagination_infinite_scroll', silicon_get_tag( 'a', array(
					'href'                    => '#',
					'class'                   => 'infinite-scroll',
					'rel'                     => 'nofollow',
					'data-si-infinite-scroll' => $infinite,
				), '' ) );

				unset( $infinite );
				break;

			case 'links':
			default:

				if ( $paged && 1 < $paged ) {
					/**
					 * Filter the previous posts link in blog pagination markup
					 *
					 * Callback MUST return an HTML-formatted string
					 * or nothing if you want to disable prev link
					 *
					 * @param string $prev
					 */
					$prev = apply_filters( 'silicon_blog_pagination_prev', sprintf(
						'<div class="prev-button hidden-xs">
                            <a href="%1$s" class="btn btn-link btn-pill btn-default btn-sm">
                                <i class="si si-angle-left"></i> %2$s
                            </a>
                        </div>',
						esc_url( get_previous_posts_page_link() ),
						esc_html__( 'Prev', 'silicon' )
					) );
				} else {
					$prev = '';
				}

				/**
				 * Filter the arguments passed to {@see paginate_links}
				 *
				 * @param array $args Arguments for {@see paginate_links}
				 */
				$links = paginate_links( apply_filters( 'silicon_blog_pagination_args', array(
					'type'      => 'plain',
					'mid_size'  => 2,
					'prev_next' => false,
				) ) );

				if ( $paged && $paged < $max_pages ) {
					/**
					 * Filter the next posts link in blog pagination markup
					 *
					 * Callback MUST return an HTML-formatted string
					 * or nothing if you want to disable prev link
					 *
					 * @param string $next
					 */
					$next = apply_filters( 'silicon_blog_pagination_next', sprintf(
						'<div class="next-button hidden-xs">
                            <a href="%1$s" class="btn btn-link btn-pill btn-default btn-sm">
                                %2$s <i class="si si-angle-right"></i>
                            </a>
                        </div>',
						esc_url( get_next_posts_page_link() ),
						esc_html__( 'Next', 'silicon' )
					) );
				} else {
					$next = '';
				}

				$nav = '<div class="pagination-links">' . $prev . '<nav class="nav-links">' . $links . '</nav>' . $next . '</div>';
				unset( $prev, $links, $next );

				break;
		}

		$classes = array();

		$classes[] = 'pagination';
		$classes[] = 'font-family-nav';
		$classes[] = 'border-default-top';
		$classes[] = 'border-default-bottom';
		$classes[] = 'text-center';
		$classes[] = $type === 'infinite-scroll' ? 'pagination-infinite' : '';

		/**
		 * Filter the classes for posts pagination.
		 *
		 * @param array $classes A list of extra classes
		 */
		$classes = apply_filters( 'silicon_blog_pagination_class', $classes );
		$classes = esc_attr( silicon_get_classes( $classes ) );

		echo "
		<section class=\"{$classes}\">
			<div class=\"spinner-wrap\">
				<div class=\"spinner-layer border-color-primary\">
					<div class=\"circle-clipper left\">
						<div class=\"circle\"></div>
					</div>
					<div class=\"gap-patch\">
						<div class=\"circle\"></div>
					</div>
					<div class=\"circle-clipper right\">
						<div class=\"circle\"></div>
					</div>
				</div>
			</div>
			{$nav}
		</section>";
	}
endif;

if ( ! function_exists( 'silicon_get_entry_meta' ) ) :
	/**
	 * Prints the entry comments counter, publication date and edit link
	 *
	 * This template tag is used within the Loop.
	 * Designed to use in template parts, widgets, etc
	 *
	 * @return string
	 */
	function silicon_get_entry_meta() {
		// post comments link
		if ( ! post_password_required()
		     && ( comments_open() || get_comments_number() )
		) {
			$comments = sprintf( '<a href="%1$s" class="post-comments navi-link-hover-color"><i class="si si-comment"></i> %2$s</a>',
				esc_url( get_comments_link() ),
				esc_html( get_comments_number() )
			);
		} else {
			$comments = '';
		}

		// publish date (linked to a post)
		$date = sprintf( '<a href="%1$s" class="post-date navi-link-hover-color"><i class="si si-time"></i> %2$s</a>',
			esc_url( get_permalink() ),
			esc_html( get_the_date() )
		);

		// edit post link
		$edit = sprintf( '<a href="%s" class="edit-link navi-link-hover-color"><i class="si si-edit"></i></a>',
			esc_url( get_edit_post_link() )
		);

		/**
		 * Filter entry meta data. Expects HTML string
		 *
		 * @param string $meta Entry meta HTML
		 */
		return apply_filters( 'silicon_get_entry_meta', '<div class="post-meta font-family-nav">' . $comments . $date . $edit . '</div>' );
	}
endif;

if ( ! function_exists( 'silicon_get_entry_category' ) ) :
	/**
	 * This function display the category on post tile
	 * based on "Display Category" meta box settings.
	 *
	 * This may be all assigned categories, single category
	 * or do not display categories at all.
	 *
	 * This function works inside the Loop
	 *
	 * @see silicon_meta_box_display_category()
	 *
	 * @return string
	 */
	function silicon_get_entry_category() {
		$post_id     = get_the_ID();
		$display_cat = silicon_get_meta( $post_id, '_silicon_display_category', 'c', 'all' );
		$categories  = get_the_terms( $post_id, 'category' );

		// if user select "Hide categories" option
		// or no one category assigned to current post
		// it makes no sense to continue
		if ( 'none' === $display_cat || empty( $categories ) ) {
			return '';
		}

		// by default all categories will display
		// but if user specify a category to display filter
		// the $categories array to find a required category object
		// TODO: check the slug, not term_id. Term ID change after import process. Also update meta box code.
		if ( is_numeric( $display_cat ) ) {
			$categories = array_filter( $categories, function ( $cat ) use ( $display_cat ) {
				/** @var WP_Term $cat */
				return $cat->term_id === (int) $display_cat;
			} );
		}

		$list = array();

		/** @var WP_Term $category */
		foreach ( (array) $categories as $category ) {
			$meta = get_term_meta( $category->term_id, 'silicon_additions', true );
			$meta = wp_parse_args( (array) $meta, array(
				'background-color' => '#3d59f9',
				'color'            => '#ffffff',
			) );

			$list[] = sprintf( '<a href="%1$s" style="%3$s">%2$s</a>',
				esc_url( get_category_link( $category->term_id ) ),
				$category->name,
				silicon_css_declarations( $meta )
			);

			unset( $meta );
		}
		unset( $category );

		$output = '';
		if ( ! empty( $list ) ) {
			$output .= '<div class="post-categories font-family-nav">';
			$output .= '<span class="text-gray">' . esc_html__( 'In', 'silicon' ) . '</span>';
			$output .= implode( '', $list );
			$output .= '</div>';
		}

		return $output;
	}
endif;

if ( ! function_exists( 'silicon_entry_meta' ) ) :
	/**
	 * Echoes the entry meta
	 *
	 * @uses silicon_get_entry_meta()
	 */
	function silicon_entry_meta() {
		echo silicon_get_entry_meta();
	}
endif;

if ( ! function_exists( 'silicon_entry_category' ) ) :
	/**
	 * Echoes the category on post tile
	 *
	 * @uses silicon_get_entry_category()
	 */
	function silicon_entry_category() {
		echo silicon_get_entry_category();
	}
endif;

if ( ! function_exists( 'silicon_entry_categories' ) ) :
	/**
	 * Display entry categories in our brand bubble
	 *
	 * Used in the Page Title
	 *
	 * Use this template tag within the Loop. Applicable
	 * for both single posts and single portfolio.
	 */
	function silicon_entry_categories() {
		$post_type  = get_post_type();
		$taxonomy   = 'silicon_portfolio' === $post_type ? 'silicon_portfolio_category' : 'category';
		$categories = get_the_terms( get_the_ID(), $taxonomy );
		if ( empty( $categories ) || is_wp_error( $categories ) ) {
			return;
		}

		$list = array();
		/** @var WP_Term $category */
		foreach ( $categories as $category ) {
			$meta = get_term_meta( $category->term_id, 'silicon_additions', true );
			$meta = wp_parse_args( (array) $meta, array(
				'background-color' => '#3d59f9',
				'color'            => '#ffffff',
			) );

			$list[] = sprintf( '<a href="%1$s" style="%3$s">%2$s</a>',
				esc_url( get_category_link( $category->term_id ) ),
				$category->name,
				silicon_css_declarations( $meta )
			);
		}

		echo '<div class="post-categories font-family-nav">', implode( '', $list ), '</div>';
	}
endif;

if ( ! function_exists( 'silicon_entry_comments' ) ) :
	/**
	 * Display the comments template
	 *
	 * Should be used within the loop
	 *
	 * @hooked silicon_single_after 20
     * @hooked silicon_page_after 20
	 *
	 * @uses   comments_template()
	 */
	function silicon_entry_comments() {
		// If comments are open or we have at least one comment
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	}
endif;

if ( ! function_exists( 'silicon_entry_container' ) ) :
	/**
	 * Wrap the content to div.container if vc_row shortcode not used.
	 *
	 * For pages, where user can use the Visual Composer we do not add
	 * any containers. This allows users to make the full width sections.
	 * But for pages, where VC is not used .container is preferred.
	 *
	 * @param string $content Content
	 *
	 * @return string
	 */
	function silicon_entry_container( $content ) {
		/**
		 * Filter the post types for container wrapping
		 *
		 * @param array $post_types
		 */
		$types = apply_filters( 'silicon_entry_container_types', array( 'post', 'page', 'silicon_portfolio' ) );

		if ( is_singular( $types ) && false === strpos( $content, 'fw-section' ) ) {
			return '<div class="container">' . $content . '</div>';
		}

		return $content;
	}
endif;

if ( ! function_exists( 'silicon_tile_header' ) ) :
	/**
	 * Prints the entry thumbnail, post format icon and single category
	 *
	 * This template tag is used within the Loop.
	 *
	 * @hooked silicon_tile_header 10
	 * @uses   silicon_get_entry_category()
	 */
	function silicon_tile_header() {
		// post thumbnail
		if ( has_post_thumbnail() ) {
			$thumb = sprintf( '<a href="%s" class="post-thumb">%s</a>',
				esc_url( get_the_permalink() ),
				get_the_post_thumbnail( null, 'large' )
			);
		} else {
			$thumb = '';
		}

		// category
		$category = silicon_get_entry_category();

		// post format, only for posts
		$format = 'post' === (string) get_post_type() ? '<span class="post-format"></span>' : '';

		$svg = '
        <div class="svg-bg border-default-right">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="m 0 100 l 100 -100, 0 100, -100 0 z" fill="white"></path>
            </svg>
        </div>';

		echo '<header class="post-header">', $thumb, $category, $format, $svg, '</header>';
	}
endif;

if ( ! function_exists( 'silicon_tile_footer' ) ) :
	/**
	 * Prints information about the post author, comments and post date.
	 *
	 * @hooked silicon_tile_footer 20
	 * @uses   silicon_get_entry_meta()
	 */
	function silicon_tile_footer() {
		// author
		if ( true === (bool) silicon_get_setting( 'single_is_tile_author', 1, get_the_ID() ) ) {
			$author_id   = get_the_author_meta( 'ID' );
			$author_meta = wp_parse_args( get_user_meta( $author_id, 'silicon_additions', true ), array(
				'avatar' => 0,
			) );

			if ( ! empty( $author_meta['avatar'] ) ) {
				$author_ava = wp_get_attachment_image( (int) $author_meta['avatar'] );
				$author_ava = '<span class="post-author-ava">' . $author_ava . '</span>';
			} else {
				$author_ava = '';
			}

			$author = sprintf(
				'<a href="%s" class="post-author navi-link-hover-color">
                    %s
                    <span class="post-author-name">%s</span>
                </a>',
				esc_url( get_author_posts_url( $author_id ) ),
				$author_ava,
				esc_html( get_the_author() )
			);

			unset( $author_id, $author_meta, $author_ava );
		} else {
			$author = '';
		}

		// meta
		$meta = silicon_get_entry_meta();

		echo '<footer class="post-footer font-family-nav">', $author, $meta, '</footer>';
	}
endif;

if ( ! function_exists( 'silicon_portfolio_layout' ) ) :
	/**
	 * Returns the template part for Portfolio single post
	 *
	 * Based on Page Settings
	 *
	 * @ses silicon_meta_box_page_settings()
	 * @see single-silicon_portfolio.php
	 * @see template-parts/single/portfolio-*.php
	 *
	 * @return string
	 */
	function silicon_portfolio_layout() {
		$layout = silicon_get_setting( 'portfolio_layout', 'blank' );

		/**
		 * Filter the layout type for Single Post
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the Child Theme you have to follow the file name convention.
		 * Your file should be named portfolio-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/single/portfolio-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_portfolio_layout', $layout ) );
	}
endif;

if ( ! function_exists( 'silicon_portfolio_toolbar' ) ) :
	/**
	 * Display the portfolio toolbar
	 *
	 * Here user can customize the live project button and shares.
	 * Based on Page Settings for Portfolio
	 *
	 * @see silicon_meta_box_page_settings()
	 */
	function silicon_portfolio_toolbar() {
		$s = silicon_get_setting( 'all', array() );
		$s = wp_parse_args( $s, array(
			'portfolio_is_toolbar'  => false,
			'portfolio_button_text' => esc_html__( 'View Project', 'silicon' ),
			'portfolio_button_url'  => '',
			'portfolio_is_share'    => true,
		) );

		if ( false === (bool) $s['portfolio_is_toolbar'] ) {
			return;
		}

		$items = array();

		// Button
		if ( ! empty( $s['portfolio_button_url'] ) && ! empty( $s['portfolio_button_text'] ) ) {
			$items[] = sprintf(
				'<div class="portfolio-live-button">
                    <a href="%1$s" class="btn btn-ghost btn-pill btn-primary btn-nl">%2$s</a>
                </div>',
				esc_url( $s['portfolio_button_url'] ),
				esc_html( $s['portfolio_button_text'] )
			);
		}

		// Shares
		if ( true === (bool) $s['portfolio_is_share'] ) {
			$items[] = silicon_get_shares();
		}

		echo '<div class="portfolio-toolbar">', implode( '', $items ), '</div>';
	}
endif;

if ( ! function_exists( 'silicon_portfolio_gallery' ) ) :
	/**
	 * Display the gallery inside Portfolio post
	 *
	 * This template tag used within the loop
	 *
	 * @see template-parts/single/portfolio-*.php
	 */
	function silicon_portfolio_gallery() {
		$s = silicon_get_setting( 'all', array() );
		$s = wp_parse_args( $s, array(
			'portfolio_layout'     => 'blank',
			'portfolio_gallery'    => '',
			'portfolio_exclude_fi' => false,
		) );

		// whaaat?.. just in case
		if ( 'blank' === $s['portfolio_layout'] ) {
			return;
		}

		if ( empty( $s['portfolio_gallery'] ) ) {
			return;
		}

		$gallery = wp_parse_id_list( $s['portfolio_gallery'] );
		if ( false === (bool) $s['portfolio_exclude_fi'] ) {
			array_unshift( $gallery, (int) get_post_thumbnail_id() );
		}

		switch ( $s['portfolio_layout'] ) {
			case 'side-gallery':
				/**
				 * Filter the shortcode attributes for portfolio "Wide Gallery".
				 *
				 * Based on Gallery shortcode. Check shortcode template for more available options.
				 * @see /silicon-core/shortcodes/silicon_gallery.php
				 *
				 * @param array $atts
				 */
				$atts = apply_filters( 'silicon_portfolio_side_gallery_atts', array(
					'images'  => implode( ',', $gallery ),
					'columns' => 1,
				) );

				$sh = silicon_shortcode_build( 'silicon_gallery', $atts );
				unset( $atts );
				break;

			case 'slider':
				/**
				 * Filter the shortcode attributes for portfolio "Slider".
				 *
				 * Based on Image Carousel shortcode. Check shortcode template for more available options.
				 * @see /silicon-core/shortcodes/silicon_image_carousel.php
				 *
				 * @param array $atts
				 */
				$atts = apply_filters( 'silicon_portfolio_slider_atts', array(
					'images'    => implode( ',', $gallery ),
					'is_loop'   => 'enable',
					'is_height' => 'enable',
				) );

				$sh = silicon_shortcode_build( 'silicon_image_carousel', $atts );
				unset( $atts );
				break;

			case 'wide-gallery':
				/**
				 * Filter the shortcode attributes for portfolio "Wide Gallery".
				 *
				 * Based on Gallery shortcode. Check shortcode template for more available options.
				 * @see /silicon-core/shortcodes/silicon_gallery.php
				 *
				 * @param array $atts
				 */
				$atts = apply_filters( 'silicon_portfolio_wide_gallery_atts', array(
					'images'  => implode( ',', $gallery ),
					'columns' => 3,
				) );

				$sh = silicon_shortcode_build( 'silicon_gallery', $atts );
				unset( $atts );
				break;

			default:
				$sh = '';
				break;
		}

		echo '<div class="portfolio-gallery">', silicon_do_shortcode( $sh ), '</div>';
	}
endif;

if ( ! function_exists( 'silicon_portfolio_navigation' ) ) :
	/**
	 * Show navigation (prev / next buttons) between portfolio posts
	 *
	 * @hooked silicon_portfolio_after 10
	 */
	function silicon_portfolio_navigation() {
		/**
		 * This filter allows to disable navigation between portfolio posts globally
		 *
		 * @example add_filter( 'silicon_is_portfolio_navigation', '__return_false' );
		 *
		 * @param bool $is_nav True is enable, false - disable
		 */
		if ( false === apply_filters( 'silicon_is_portfolio_navigation', true ) ) {
			return;
		}

		$links = array(
			'prev' => get_previous_post_link( '%link', '<i class="si si-angle-left"></i><span class="hidden-xs">' . esc_html__( 'Prev', 'silicon' ) . '</span>' ),
			'next' => get_next_post_link( '%link', '<span class="hidden-xs">' . esc_html__( 'Next', 'silicon' ) . '</span><i class="si si-angle-right"></i>' ),
		);

		// only one post published
		if ( empty( $links['prev'] ) && empty( $links['next'] ) ) {
			return;
		}

		// append required classes to each link
		$links = array_map( function ( $link ) {
			return str_replace(
				'<a ',
				'<a class="btn btn-link btn-pill btn-sm btn-default" ',
				$link
			);
		}, $links );

		$prev = $next = '';

		// previous button
		if ( ! empty( $links['prev'] ) ) {
			$prev_post = get_previous_post();
			$template  = '
		    <div class="post-nav-prev">
		        {link}
		        <div class="popover">
                    <article class="post-item">
                        {thumb}
                        <div class="post-info">{title}</div>
                    </article>
                </div>
            </div>
		    ';

			$r = array(
				'{link}'  => $links['prev'],
				'{thumb}' => silicon_get_text( get_the_post_thumbnail( $prev_post, 'thumbnail' ), '<div class="post-thumb">', '</div>' ),
				'{title}' => silicon_get_text( get_the_title( $prev_post ), '<h4 class="post-title">', '</h4>' ),
			);

			$prev = str_replace( array_keys( $r ), array_values( $r ), $template );
			unset( $prev_post, $template, $r );
		}

		// next button
		if ( ! empty( $links['next'] ) ) {
			$next_post = get_next_post();
			$template  = '
		    <div class="post-nav-next border-default-left">
		        {link}
		        <div class="popover">
		            <article class="post-item">
		                {thumb}
		                <div class="post-info">{title}</div>
                    </article>
                </div>
            </div>
		    ';

			$r = array(
				'{link}'  => $links['next'],
				'{thumb}' => silicon_get_text( get_the_post_thumbnail( $next_post, 'thumbnail' ), '<div class="post-thumb">', '</div>' ),
				'{title}' => silicon_get_text( get_the_title( $next_post ), '<h4 class="post-title">', '</h4>' ),
			);

			$next = str_replace( array_keys( $r ), array_values( $r ), $template );
			unset( $next_post, $template, $r );
		}

		echo '
        <div class="container padding-bottom-3x">
            <nav class="post-navigation border-default-top border-default-bottom" role="navigation">
            ' . $prev . $next . '
            </nav>
        </div>';
	}
endif;

if ( ! function_exists( 'silicon_single_layout' ) ) :
	/**
	 * Returns the template part for Single Post
	 *
	 * Based on Page Settings to control the layout per each post
	 * and Theme Options to control the layout globally.
	 *
	 * @see single.php
	 * @see inc/meta-boxes.php
	 * @see inc/options.php
	 * @see template-parts/single/single-*.php
	 *
	 * @return string
	 */
	function silicon_single_layout() {
		$layout = silicon_get_setting( 'single_layout', 'right' );

		/**
		 * Filter the layout type for Single Post
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the Child Theme you have to follow the file name convention.
		 * Your file should be named single-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/single/single-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_single_layout', $layout ) );
	}
endif;

if ( ! function_exists( 'silicon_post_header' ) ) :
	/**
	 * Echoes the Featured Image on a single post page
	 */
	function silicon_post_header() {
		$output = array();

		// post thumbnail
		if ( has_post_thumbnail()
		     && true === (bool) silicon_get_setting( 'single_is_featured_image', true )
		) {
			$thumb    = get_the_post_thumbnail( null, 'full', array( 'class' => 'block-center' ) );
			$output[] = '<div class="featured-image padding-bottom-1x">' . $thumb . '</div>';
			unset( $thumb );
		}

		echo '
        <header class="single-post-header">
            <div class="container">' . implode( "\n\r", $output ) . '</div>
        </header>';
	}
endif;

if ( ! function_exists( 'silicon_post_footer' ) ) :
	/**
	 * Echoes an entry tags and sharing buttons
	 */
	function silicon_post_footer() {
		$output = array();

		// tags
		$output[] = get_the_tag_list( '<div class="tags-links">', '', '</div>' );

		// shares
		if ( true === (bool) silicon_get_setting( 'single_is_shares', true ) ) {
			$output[] = silicon_get_shares();
		}

		echo '
        <footer class="single-post-footer border-default-top">
            <div class="container">' . implode( "\n\r", $output ) . '</div>
        </footer>';
	}
endif;

if ( ! function_exists( 'silicon_post_author' ) ) :
	/**
	 * Display the Author widget in Single Post
	 *
	 * This widget can be disabled in Page Settings on
	 * a specific page. Or completely disabled on every
	 * page in Theme Options.
	 *
	 * This template tag should be used within the Loop
	 *
	 * @hooked silicon_post_after 15
	 */
	function silicon_post_author() {
		// Check if post author widget is enabled
		if ( false === (bool) silicon_get_setting( 'single_is_post_author', false ) ) {
			return;
		}

		$instance = array( 'author' => get_the_author_meta( 'ID' ) );
		$args     = array(
			'before_widget' => '<section class="widget %s">',
			'after_widget'  => '</section>',
		);

		add_filter( 'silicon_widget_author_is_cache', '__return_false' ); // prevent showing cached widget
		echo '<div class="container"><div class="single-post-author">';
		the_widget( 'Silicon_Widget_Author', $instance, $args );
		echo '</div></div>';
		remove_filter( 'silicon_widget_author_is_cache', '__return_false' );
	}
endif;

if ( ! function_exists( 'silicon_post_navigation' ) ) :
	/**
	 * Show prev / all / next button in single entry
	 *
	 * @hooked silicon_post_after 20
	 */
	function silicon_post_navigation() {
		/**
		 * This filter allows to disable post navigation globally
		 *
		 * @example add_filter('silicon_is_post_navigation', '__return_false');
		 *
		 * @param bool $is_nav True is enable, false - disable
		 */
		if ( false === apply_filters( 'silicon_is_post_navigation', true ) ) {
			return;
		}

		/* Detect the home page url */

		if ( 'page' == get_option( 'show_on_front' ) ) {
			$page_for_posts = get_option( 'page_for_posts' );
			if ( ! empty( $page_for_posts ) ) {
				$posts_url = get_permalink( $page_for_posts );
			} else {
				$posts_url = site_url();
			}
			unset( $page_for_posts );
		} else {
			$posts_url = home_url( '/' );
		}

		/* Prepare links to prev, next, all posts */

		$links         = array();
		$links['prev'] = get_previous_post_link( '%link', '<i class="si si-angle-left"></i><span class="hidden-xs">' . esc_html__( 'Prev', 'silicon' ) . '</span>' );
		$links['next'] = get_next_post_link( '%link', '<span class="hidden-xs">' . esc_html__( 'Next', 'silicon' ) . '</span><i class="si si-angle-right"></i>' );
		$links['all']  = sprintf( '<a href="%1$s" rel="home">%3$s <span class="hidden-xs">%2$s</span></a>',
			esc_url( $posts_url ),
			esc_html__( 'All', 'silicon' ),
			false === strpos( silicon_blog_layout(), 'list' ) ? '<i class="si si-grid"></i>' : '<i class="si si-list"></i>'
		);

		// append required classes to each link
		$links = array_map( function ( $link ) {
			return str_replace(
				'<a ',
				'<a class="btn btn-link btn-pill btn-sm btn-default" ',
				$link
			);
		}, $links );

		/* Prepare prev / next links markup + popover */

		$prev = '';
		$next = '';

		$prev_post = get_previous_post();
		if ( ! empty( $links['prev'] ) && ! empty( $prev_post ) && ! empty( $prev_post->post_title ) ) {
			$template = '
		    <div class="post-nav-prev">
		        {link}
		        <div class="popover">
                    <article class="post-item">
                        {thumb}
                        <div class="post-info">{title}</div>
                    </article>
                </div>
            </div>
		    ';

			$r = array(
				'{link}'  => $links['prev'],
				'{thumb}' => silicon_get_text( get_the_post_thumbnail( $prev_post, 'thumbnail' ), '<div class="post-thumb">', '</div>' ),
				'{title}' => silicon_get_text( get_the_title( $prev_post ), '<h4 class="post-title">', '</h4>' ),
			);

			$prev = str_replace( array_keys( $r ), array_values( $r ), $template );
			unset( $template, $r );
		}
		unset( $prev_post );

		$next_post = get_next_post();
		if ( ! empty( $links['next'] ) && ! empty( $next_post ) && ! empty( $next_post->post_title ) ) {
			$template = '
		    <div class="post-nav-next border-default-left">
		        {link}
		        <div class="popover">
		            <article class="post-item">
		                {thumb}
		                <div class="post-info">{title}</div>
                    </article>
                </div>
            </div>
		    ';

			$r = array(
				'{link}'  => $links['next'],
				'{thumb}' => silicon_get_text( get_the_post_thumbnail( $next_post, 'thumbnail' ), '<div class="post-thumb">', '</div>' ),
				'{title}' => silicon_get_text( get_the_title( $next_post ), '<h4 class="post-title">', '</h4>' ),
			);

			$next = str_replace( array_keys( $r ), array_values( $r ), $template );
			unset( $template, $r );
		}
		unset( $next_post );

		// output
		echo '
        <div class="container"> 
            <nav class="post-navigation border-default-top border-default-bottom" role="navigation">
                ' . $prev . '
                <div class="post-nav-all border-default-left"> ' . $links['all'] . ' </div>
                ' . $next . '
            </nav>
        </div>
        ';

		unset( $posts_url, $links, $prev, $next );
	}
endif;

if ( ! function_exists( 'silicon_search_pagination' ) ) :
	/**
	 * Display the pagination on the search page
	 *
	 * @see  template-parts/search.php
	 * @uses get_preview_posts_link()
	 * @uses get_next_posts_link()
	 */
	function silicon_search_pagination() {
		global $wp_query;

		$max_pages = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
		if ( $max_pages < 2 ) {
			return;
		}

		$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$prev  = '';
		$next  = '';

		if ( $paged && 1 < $paged ) {
			/**
			 * Filter the previous posts link in blog pagination markup
			 *
			 * Callback MUST return an HTML-formatted string
			 * or nothing if you want to disable prev link
			 *
			 * @param string $prev
			 */
			$prev = apply_filters( 'silicon_search_pagination_prev', sprintf(
				'<div class="prev-button hidden-xs">
                    <a href="%1$s" class="btn btn-link btn-pill btn-default btn-sm">
                        <i class="si si-angle-left"></i> %2$s
                    </a>
                </div>',
				esc_url( get_previous_posts_page_link() ),
				esc_html__( 'Prev', 'silicon' )
			) );
		}

		/**
		 * Filter the arguments passed to {@see paginate_links}
		 *
		 * @param array $args Arguments for {@see paginate_links}
		 */
		$links = paginate_links( apply_filters( 'silicon_search_pagination_args', array(
			'type'      => 'plain',
			'mid_size'  => 2,
			'prev_next' => false,
		) ) );

		if ( $paged && $paged < $max_pages ) {
			/**
			 * Filter the next posts link in blog pagination markup
			 *
			 * Callback MUST return an HTML-formatted string
			 * or nothing if you want to disable prev link
			 *
			 * @param string $next
			 */
			$next = apply_filters( 'silicon_search_pagination_next', sprintf(
				'<div class="next-button hidden-xs">
                    <a href="%1$s" class="btn btn-link btn-pill btn-default btn-sm">
                        %2$s <i class="si si-angle-right"></i>
                    </a>
                </div>',
				esc_url( get_next_posts_page_link() ),
				esc_html__( 'Next', 'silicon' )
			) );
		}

		$nav = '<div class="pagination-links">' . $prev . '<nav class="nav-links">' . $links . '</nav>' . $next . '</div>';
		unset( $prev, $links, $next );

		$classes = array();

		$classes[] = 'pagination';
		$classes[] = 'font-family-nav';
		$classes[] = 'border-default-top';
		$classes[] = 'border-default-bottom';
		$classes[] = 'text-center';
		$classes[] = 'margin-bottom-3x';

		/**
		 * Filter the classes for posts pagination.
		 *
		 * @param array $classes A list of extra classes
		 */
		$classes = apply_filters( 'silicon_search_pagination_class', $classes );
		$classes = esc_attr( silicon_get_classes( $classes ) );

		echo "
		<section class=\"{$classes}\">
			{$nav}
		</section>";
	}
endif;

if ( ! function_exists( 'silicon_search_open_wrapper' ) ) :
	/**
	 * Wrap the Search page to section.container. Open tag.
	 *
	 * @hooked silicon_search_before 5
	 * @see    silicon_search_close_wrapper()
	 * @see    search.php
	 */
	function silicon_search_open_wrapper() {
		echo '<section class="container search-results">';
	}
endif;

if ( ! function_exists( 'silicon_search_close_wrapper' ) ) :
	/**
	 * Wrap the Search page to section.container. Close tag.
	 *
	 * @hooked silicon_search_after 5
	 * @see    silicon_search_open_wrapper()
	 * @see    search.php
	 */
	function silicon_search_close_wrapper() {
		echo '</section>';
	}
endif;

if ( ! function_exists( 'silicon_search_highlight_title' ) ) :
	/**
	 * Highlight the search results in title
	 *
	 * @param string $title Title
	 *
	 * @return mixed
	 */
	function silicon_search_highlight_title( $title ) {
		if ( ! empty( $title ) && is_search() && in_the_loop() ) {
			$keys  = implode( '|', explode( ' ', get_search_query() ) );
			$title = preg_replace( '/(' . $keys . ')/iu', '<span class="search-highlight">$0</span>', $title );
		}

		return $title;
	}
endif;

if ( ! function_exists( 'silicon_search_highlight_snippet' ) ) :
	/**
	 * Highlight the search results
	 *
	 * Center and highlight the matching results and trim the string.
	 *
	 * @link http://stackoverflow.com/questions/1292121/how-to-generate-the-snippet-like-generated-by-google-with-php-and-mysql
	 *
	 * @param string $content Excerpt
	 *
	 * @return string
	 */
	function silicon_search_highlight_snippet( $content ) {
		if ( ! empty( $content ) && is_search() && in_the_loop() ) {
			$content = strip_tags( $content );
			$search  = trim( get_search_query() );
			$radius  = 100;
			$ending  = '...';

			if ( empty( $search ) ) {
				$excerpt_length = apply_filters( 'excerpt_length', 55 );
				$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

				return wp_trim_words( $content, $excerpt_length, $excerpt_more );
			}

			$s_length = strlen( $search );
			$e_length = strlen( $content );

			if ( $radius < $s_length ) {
				$radius = $s_length;
			}

			$pos = 0;

			$phrases = array_filter( explode( ' ', $search ) );
			foreach ( (array) $phrases as $phrase ) {
				$pos = strpos( strtolower( $content ), strtolower( $phrase ) );
				if ( $pos > - 1 ) {
					break;
				}
			}
			unset( $phrase, $phrases );

			$start = 0;
			if ( $pos > $radius ) {
				$start = $pos - $radius;
			}

			$end = $pos + $s_length + $radius;
			if ( $end >= $e_length ) {
				$end = $e_length;
			}

			$snippet = substr( $content, $start, $end - $start );
			if ( $start != 0 ) {
				$snippet = substr_replace( $snippet, $ending, 0, $s_length );
			}

			if ( $end != $e_length ) {
				$snippet = substr_replace( $snippet, $ending, - $s_length );
			}

			$keys    = implode( '|', explode( ' ', $search ) );
			$snippet = preg_replace( '/(' . $keys . ')/iu', '<span class="search-highlight">$0</span>', $snippet );
			$snippet = '<p class="post-excerpt">' . $snippet . '</p>';

			$content = $snippet;

			unset( $snippet, $s_length, $e_length, $start, $end );
		}

		return $content;
	}
endif;

if ( ! function_exists( 'silicon_search_prevent_empty' ) ) :
	/**
	 * Fix the empty search
	 *
	 * @param array $query_vars
	 *
	 * @return mixed
	 */
	function silicon_search_prevent_empty( $query_vars ) {
		if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
			$query_vars['s'] = " ";
		}

		return $query_vars;
	}
endif;

if ( ! function_exists( 'silicon_footer_layout' ) ):
	/**
	 * Returns the template part name for footer
	 *
	 * Based on Theme Options
	 *
	 * @see footer.php
	 * @see inc/options.php
	 * @see template-parts/footers/footer-*.php
	 *
	 * @return string
	 */
	function silicon_footer_layout() {
		$layout = silicon_get_option( 'footer_layout', 'none' );

		/**
		 * Filter the layout type
		 *
		 * NOTE: this is a part of the file name, so if you want to add a custom
		 * layout in the child theme you have to follow the file name convention.
		 * Your file should be named footer-{$layout}.php
		 *
		 * You can add your custom template part to
		 * /theme-child/template-parts/footers/footer-{$layout}.php
		 *
		 * @param string $layout Layout
		 */
		return esc_attr( apply_filters( 'silicon_footer_layout', $layout ) );
	}
endif;

if ( ! function_exists( 'silicon_footer_class' ) ) :
	/**
	 * Echoes the footer class
	 *
	 * NOTE: user can edit Footer appearance via the Page Settings
	 *
	 * @see  footer.php
	 * @see  silicon_meta_box_page_settings()
	 * @uses silicon_get_classes()
	 */
	function silicon_footer_class() {
		$classes = array();

		$classes[] = 'site-footer';
		$classes[] = 'footer-' . sanitize_key( silicon_get_setting( 'footer_skin', 'light' ) );
		$classes[] = 'gradient' === silicon_get_setting( 'footer_background', 'solid' ) ? 'background-gradient' : '';

		/**
		 * Filter the footer class
		 *
		 * @param array $classes A list of footer classes
		 */
		$classes = apply_filters( 'silicon_footer_class', $classes );

		echo esc_attr( silicon_get_classes( $classes ) );
	}
endif;

if ( ! function_exists( 'silicon_footer_style' ) ) :
	/**
	 * Display the Footer inline styles
	 *
	 * NOTE: user can edit Footer appearance via the Page Settings
	 *
	 * @see  footer.php
	 * @see  silicon_meta_box_page_settings()
	 * @uses silicon_css_declarations()
	 */
	function silicon_footer_style() {
		$style = array();

		// background type
		$type = silicon_get_setting( 'footer_background', 'solid' );

		if ( 'solid' === $type ) {
			$color                     = silicon_get_setting( 'footer_background_color', '#222222' );
			$style['background-color'] = sanitize_hex_color( $color );
			unset( $color );
		}

		$bg_id = (int) silicon_get_setting( 'footer_background_image', 0 );
		if ( 'image' === $type && ! empty( $bg_id ) ) {
			$style['background-image'] = sprintf( 'url(%s)', esc_url( silicon_get_image_src( $bg_id ) ) );
		}

		/**
		 * Filter the Footer style attribute
		 *
		 * Callback MUST return an array, where key is a css property,
		 * and "value" is a valid value of this property. For example:
		 *
		 * ```
		 * return array_merge($style, [
		 *   'max-height' => '250px',
		 *   'background-color' => 'red',
		 * ])
		 * ```
		 *
		 * NOTE: don't use semicolon at the end of property value
		 *
		 * @param array $style List of styles
		 */
		$style = apply_filters( 'silicon_footer_style', $style );

		echo esc_attr( silicon_css_declarations( $style ) );
	}
endif;

if ( ! function_exists( 'silicon_footer_attr' ) ) :
	/**
	 * Echoes the footer attributes
	 *
	 * @see  footer.php
	 * @uses silicon_get_attr()
	 */
	function silicon_footer_attr() {
		/**
		 * Filter the Footer attributes
		 *
		 * NOTE: use a valid HTML attribute as a key
		 * NOTE: class and style attributes not allowed
		 *
		 * @param array $attr Footer attributes
		 */
		$attr = apply_filters( 'silicon_footer_attr', array() );

		// class and style not allowed
		// use "silicon_footer_class" instead
		// use "silicon_footer_style" instead
		$attr = array_diff_key( $attr, array_flip( array( 'class', 'style' ) ) );

		echo silicon_get_attr( $attr );
	}
endif;

if ( ! function_exists( 'silicon_footer_overlay' ) ) :
	/**
	 * Echoes the footer overlay
	 *
	 * @see footer.php
	 */
	function silicon_footer_overlay() {
		if ( 'image' !== silicon_get_setting( 'footer_background', 'solid' ) ) {
			return;
		}

		$style = array();
		$type = silicon_get_setting( 'footer_overlay_option', 'solid' );

		if ( 'solid' === $type ) {
			$style['background-color'] = sanitize_hex_color( silicon_get_setting( 'footer_overlay_color', '#000000' ) );
		}

		$style['opacity'] = silicon_get_opacity_value( silicon_get_setting( 'footer_overlay_opacity', '75' ) );

		$attr = array(
			'class' => 'gradient' === $type ? 'overlay background-gradient' : 'overlay',
			'style' => silicon_css_declarations( $style ),
		);

		echo '<span ', silicon_get_attr( $attr ), '></span>';
	}
endif;

if ( ! function_exists( 'silicon_page_wrapper_open' ) ) :
	/**
	 * Open the main.page-wrapper
	 *
	 * This tag wraps every page. Should be opened right after the header
	 * and closed after the footer (yes, footer should be inside the .page-wrapper)
	 *
	 * @hooked silicon_header_before 7
	 * @see    silicon_page_wrapper_close()
	 */
	function silicon_page_wrapper_open() {
		echo '<main class="page-wrapper">';
	}
endif;

if ( ! function_exists( 'silicon_page_wrapper_close' ) ) :
	/**
	 * Close the main.page-wrapper tag
	 *
	 * @hooked silicon_footer_after 7
	 * @see    silicon_page_wrapper_open()
	 */
	function silicon_page_wrapper_close() {
		echo '</main>';
	}
endif;

if ( ! function_exists( 'silicon_content_wrapper_open' ) ) :
	/**
	 * Open the div.content-wrapper
	 *
	 * @hooked silicon_header_after 5
	 * @see    silicon_content_wrapper_close()
	 */
	function silicon_content_wrapper_open() {
		echo '<div class="content-wrapper">';
	}
endif;

if ( ! function_exists( 'silicon_content_wrapper_close' ) ) :
	/**
	 * Close tne div.content-wrapper
	 *
	 * @hooked silicon_footer_after 5
	 * @see    silicon_content_wrapper_open()
	 */
	function silicon_content_wrapper_close() {
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_page_title' ) ) :
	/**
	 * Display the Page Title
	 *
	 * Page Title visibility is based on Page Settings > Theme Options
	 * Page Title can be disabled on specific page.
	 *
	 * @hooked silicon_header_after 10
	 * @see    silicon_options_header()
	 * @see    silicon_meta_box_page_settings()
	 */
	function silicon_page_title() {
		/**
		 * This filter allows to control Page Title visibility
		 *
		 * You can completely disable page title, e.g.
		 * @example add_filter('silicon_is_page_title', '__return_false');
		 *
		 * @param bool $is_page_title
		 */
		if ( ! apply_filters( 'silicon_is_page_title', (bool) silicon_get_setting( 'header_is_pt', true ) ) ) {
			return;
		}

		// Define the title
		if ( 'posts' == get_option( 'show_on_front' ) && is_home() ) {
			// for home page without static page
			$title = esc_html__( 'Blog', 'silicon' );
		} elseif ( is_home() || is_front_page() || is_singular( array( 'page', 'post' ) ) ) {
			// applicable for home with static page, for front page and single page
			$title = single_post_title( '', false );
		} elseif ( is_search() ) {
			// search results
			// NOTE: translators, there is a space after "Results for: "
			$title = silicon_get_text( esc_html( get_search_query() ), esc_html__( 'Results for: ', 'silicon' ) );
		} elseif ( is_archive() ) {
			// archive page
			$title = get_the_archive_title();
		} else {
			$title = get_the_title();
		}

		/**
		 * Filter the Page Title
		 *
		 * @param string $title Page Title
		 */
		$title = apply_filters( 'silicon_page_title', $title );
		if ( empty( $title ) ) {
			return;
		}

		/**
		 * This filter allows to disable dots coloring in Page Title
		 *
		 * @example
		 * add_filter( 'silicon_page_title_dots', '__return_false' );
		 *
		 * @param bool $is_dots Enable / Disable dots coloring. Default is true.
		 */
		if ( apply_filters( 'silicon_page_title_dots', true ) ) {
			// Search for dots (our brand feature)
			$title = str_replace( '.', '<span class="text-primary">.</span>', $title );
		}

		// Get settings and merge with defaults
		$settings = silicon_get_setting( 'all' );
		$settings = wp_parse_args( $settings, array(
			'pt_bg_type'         => 'none',
			'header_pt_size'     => 'default', // fallback to Theme Options
			'pt_skin'            => 'dark',
			'pt_bg_image'        => 0,
			'pt_bg_color'        => '#f5f5f5',
			'pt_parallax'        => 0,
			'pt_parallax_type'   => 'scroll',
			'pt_parallax_speed'  => 0.4,
			'pt_parallax_video'  => '',
			'pt_overlay'         => 0,
			'pt_overlay_type'    => 'color',
			'pt_overlay_color'   => '#000000',
			'pt_overlay_opacity' => 60,
		) );

		// Variables
		$classes = array();
		$styles  = array();
		$attr    = array();
		$overlay = array();

		// General classes for div.page-title
		$classes[] = 'page-title';
		$classes[] = 'page-title-' . esc_attr( $settings['pt_skin'] );

		if ( 'default' === $settings['header_pt_size'] ) {
			// check Theme Options for the default value
			$classes[] = 'page-title-' . silicon_get_option( 'header_pt_size', 'normal' );
		} else {
			$classes[] = 'page-title-' . esc_attr( $settings['header_pt_size'] );
		}

		// Background options
		$type = esc_attr( $settings['pt_bg_type'] );

		if ( 'gradient' === $type ) {
			// Gradient color
			$classes[] = 'background-gradient';
		} elseif ( 'color' === $type ) {
			// Solid color
			$styles['background-color'] = sanitize_hex_color( $settings['pt_bg_color'] );
		} elseif ( 'image' === $type ) {
			// Image

			$image = (int) $settings['pt_bg_image'];
			if ( ! empty( $image ) ) {
				$styles['background-image'] = sprintf( 'url(%s)', esc_url( silicon_get_image_src( $image ) ) );

				// If parallax is enabled. We use a Jarallax plugin.
				// So all settings should be in data-jarallax-* attributes
				if ( (bool) $settings['pt_parallax'] ) {
					$classes[] = 'bg-parallax';
					$metadata  = wp_get_attachment_metadata( $image );
					$jarallax  = array(
						'type'      => esc_attr( $settings['pt_parallax_type'] ),
						'speed'     => silicon_sanitize_float( $settings['pt_parallax_speed'] ),
						'imgWidth'  => empty( $metadata['width'] ) ? 'null' : (int) $metadata['width'],
						'imgHeight' => empty( $metadata['height'] ) ? 'null' : (int) $metadata['height'],
						'noAndroid' => 'true',
						'noIos'     => 'true',
					);

					$attr['data-jarallax']       = $jarallax;
					$attr['data-jarallax-video'] = esc_url( $settings['pt_parallax_video'] );
					unset( $metadata, $jarallax );
				}

				// If overlay is enabled
				// collect all data in $overlay array
				if ( (bool) $settings['pt_overlay'] ) {
					if ( 'gradient' === $settings['pt_overlay_type'] ) {
						$overlay['class'] = 'overlay background-gradient';
						$overlay['style'] = sprintf( 'opacity: %s;',
							silicon_get_opacity_value( (int) $settings['pt_overlay_opacity'] )
						);
					} else {
						$overlay['class'] = 'overlay';
						$overlay['style'] = silicon_css_declarations( array(
							'background-color' => sanitize_hex_color( $settings['pt_overlay_color'] ),
							'opacity'          => silicon_get_opacity_value( (int) $settings['pt_overlay_opacity'] ),
						) );
					}
				}
			}
			unset( $image );
		} else {
			// none, do nothing
		}

		/**
		 * Filter the page title class
		 *
		 * @param array $classes Page title classes
		 */
		$classes = apply_filters( 'silicon_page_title_class', $classes );

		/**
		 * Filter the Page Title style attribute
		 *
		 * Callback MUST return an array, where key is a css property,
		 * and "value" is a valid value of this property. For example:
		 *
		 * ```
		 * return [
		 *   'max-height' => '250px',
		 *   'background-color' => 'red',
		 * ]
		 * ```
		 *
		 * NOTE: don't use semicolon at the end of property value
		 *
		 * @param array $styles Styles
		 */
		$styles = apply_filters( 'silicon_page_title_style', $styles );

		// Apply attributes
		$attr['class'] = esc_attr( silicon_get_classes( $classes ) );
		$attr['style'] = esc_attr( silicon_css_declarations( $styles ) );

		/**
		 * Filter the page title attributes
		 *
		 * @param array $attr Page title attr
		 */
		$attr = apply_filters( 'silicon_page_title_attr', $attr );

		/* Output */

		?>
        <div <?php echo silicon_get_attr( $attr ); ?>>

			<?php echo empty( $overlay ) ? '' : silicon_get_tag( 'span', $overlay, '' ); ?>

            <div class="inner">
				<?php

				/**
				 * Display the content before the Page Title
				 *
				 * @see silicon_page_title_breadcrumbs() 10
				 */
				do_action( 'silicon_page_title_before' );

				/**
				 * This filter allows to change the markup of Page Title itself,
				 * not the wrapper around. This may be useful in situations,
				 * when you don't need the <h1> tag on the page.
				 *
				 * @param string $page_title Page title with HTML tag
				 */
				echo apply_filters( 'silicon_page_title_markup', silicon_get_text( $title, '<h1>', '</h1>' ) );

				/**
				 * Display the extra content inside the Page Title
				 *
				 * @see silicon_page_title_meta() 10
				 * @see silicon_bbp_page_title_tags() 10
				 * @see silicon_bbp_page_title_subscription() 20
				 */
				do_action( 'silicon_page_title_after' );

				?>
            </div>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_page_title_disabler' ) ) :
	/**
	 * Some extra checks to whether enable or disable Page Title
     *
     * @hooked silicon_is_page_title 10
	 *
	 * @param bool $is_page_title
	 *
	 * @return bool
	 */
	function silicon_page_title_disabler( $is_page_title ) {
        if ( is_404() ) {
            $is_page_title = false; // hide for 404 page
        } elseif ( silicon_is_intro() ) {
            $is_page_title = false; // do not show if intro is enabled
        }

        return $is_page_title;
	}
endif;

if ( ! function_exists( 'silicon_page_title_breadcrumbs' ) ) :
	/**
	 * Display the Breadcrumbs in the Page Title
	 *
	 * @hooked silicon_page_title_before 10
	 */
	function silicon_page_title_breadcrumbs() {
		silicon_the_breadcrumbs();
	}
endif;

if ( ! function_exists( 'silicon_page_title_meta' ) ) :
	/**
	 * Display the Page Title meta information for posts and portfolio
	 *
	 * @hooked silicon_page_title_after 10
	 */
	function silicon_page_title_meta() {
		if ( ! is_singular( array( 'post', 'silicon_portfolio' ) ) ) {
			return;
		}

		echo '<div class="page-title-meta border-default-top">';
		silicon_entry_meta();
		silicon_entry_categories();
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_intro' ) ) :
	/**
	 * Display the intro section
	 *
	 * @hooked silicon_header_after 10
	 * @see    template-parts/intros/
	 */
	function silicon_intro() {
		if ( ! silicon_is_intro() ) {
			return;
		}

		// get post ID and intro type
		$postID = (int) silicon_get_setting( 'intro' );
		$type   = silicon_get_meta( $postID, '_silicon_intro_type', 'type', 'none' );

		get_template_part( 'template-parts/intros/intro', $type );
	}
endif;

if ( ! function_exists( 'silicon_related_posts' ) ) :
	/**
	 * Display the Related Posts
	 *
	 * Related Posts could be assigned only to posts.
	 * This template tag should be used within the Loop.
	 *
	 * @hooked silicon_single_after 15
	 * @see    silicon_meta_box_related_posts()
	 */
	function silicon_related_posts() {
		/**
		 * This filter allows to disable related posts globally
		 *
		 * @example add_filter( 'silicon_is_related_posts', '__return_false' );
		 *
		 * @param bool $is_related True is enable, false = disable
		 */
		if ( false === apply_filters( 'silicon_is_related_posts', true ) ) {
			return;
		}

		$post_id = get_the_ID();
		$args    = silicon_get_meta( $post_id, '_silicon_related' );
		$args    = wp_parse_args( $args, array(
			'is_enabled' => false,
			'label'      => esc_html__( 'Related Posts', 'silicon' ),
			'posts'      => array(),
		) );

		// check is Related Posts enabled in meta box
		if ( false === (bool) $args['is_enabled'] || empty( $args['posts'] ) ) {
			return;
		}

		$related = array_map( 'intval', array_filter( $args['posts'], 'is_numeric' ) );
		if ( empty( $related ) ) {
			return;
		}

		/**
		 * Filter the arguments passed to WP_Query to get the Related Posts
		 *
		 * @param array $query_args Query args, {@see WP_Query}
		 * @param int   $post_id    Current post ID
		 */
		$query = new WP_Query( apply_filters( 'silicon_related_posts_args', array(
			'post__in'            => $related,
			'posts_per_page'      => - 1,
			'suppress_filters'    => true,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'nopaging'            => true,
			'orderby'             => 'post__in',
		), $post_id ) );

		if ( ! $query->have_posts() ) {
			return;
		}

		/**
		 * Filter the Related Posts carousel options. Based on owlCarousel.js
		 *
		 * @param array $carousel owlCarousel options
		 * @param int   $post_id  Current post ID
		 */
		$owl = apply_filters( 'silicon_related_posts_carousel', array(
			'items'      => 3,
			'loop'       => false,
			'margin'     => 30,
			'responsive' => array(
				0    => array( 'items' => 1, 'margin' => false ),
				550  => array( 'items' => 2, 'margin' => false ),
				768  => array( 'items' => 2 ),
				991  => array( 'items' => 3 ),
				1200 => array( 'items' => 4 ),
			),
		), $post_id );

		// carousel settings
		$carousel = array(
			'class'            => 'owl-carousel',
			'data-si-carousel' => $owl,
		);

		?>
        <div class="related-posts padding-bottom-3x">
            <div class="container">

				<?php
				echo '<h3 class="margin-bottom-1x">', esc_html( $args['label'] ), '</h3>';
				echo '<div ', silicon_get_attr( $carousel ), '>';
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/tiles/post-simple' );
				endwhile;
				echo '</div>';
				wp_reset_postdata();
				?>

            </div>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_related_projects' ) ) :
	/**
	 * Display the Related Projects
	 *
	 * This template tag should be used within the Loop.
	 *
	 * @hooked silicon_portfolio_after 15
	 * @see    Silicon_CPT_Portfolio::add_related_projects_meta_box()
	 */
	function silicon_related_projects() {
		/**
		 * This filter allows to disable related projects globally
		 *
		 * @example add_filter( 'silicon_is_related_projects', '__return_false' );
		 *
		 * @param bool $is_related True is enable, false = disable
		 */
		if ( false === apply_filters( 'silicon_is_related_projects', true ) ) {
			return;
		}

		$post_id = get_the_ID();
		$args    = silicon_get_meta( $post_id, '_silicon_portfolio_related' );
		$args    = wp_parse_args( $args, array(
			'is_enabled' => false,
			'label'      => esc_html__( 'Related Projects', 'silicon' ),
			'posts'      => array(),
		) );

		// check is Related Posts enabled in meta box locally
		if ( false === (bool) $args['is_enabled'] || empty( $args['posts'] ) ) {
			return;
		}

		$related = array_map( 'intval', array_filter( $args['posts'], 'is_numeric' ) );
		if ( empty( $related ) ) {
			return;
		}

		/**
		 * Filter the arguments passed to WP_Query to get the Related Projects
		 *
		 * @param array $query_args Query args, {@see WP_Query}
		 * @param int   $post_id    Current post ID
		 */
		$query = new WP_Query( apply_filters( 'silicon_related_projects_args', array(
			'post_type'           => 'silicon_portfolio',
			'post__in'            => $related,
			'posts_per_page'      => - 1,
			'suppress_filters'    => true,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'nopaging'            => true,
		), $post_id ) );

		if ( ! $query->have_posts() ) {
			return;
		}

		/**
		 * Filter the Related Projects carousel options. Based on owlCarousel.js
		 *
		 * @param array $carousel owlCarousel options
		 * @param int   $post_id  Current post ID
		 */
		$owl = apply_filters( 'silicon_related_projects_carousel', array(
			'items'      => 4,
			'loop'       => false,
			'margin'     => 0,
			'autoHeight' => true,
			'responsive' => array(
				0    => array( 'items' => 1 ),
				550  => array( 'items' => 2 ),
				768  => array( 'items' => 2 ),
				991  => array( 'items' => 3 ),
				1200 => array( 'items' => 4 ),
			),
		), $post_id );

		// carousel settings
		$carousel = array(
			'class'            => 'owl-carousel portfolio-carousel portfolio-carousel-no-gap',
			'data-si-carousel' => $owl,
		);

		?>
        <div class="related-projects padding-bottom-3x">
            <div class="container">

				<?php
				echo '<h3 class="margin-bottom-1x">', esc_html( $args['label'] ), '</h3>';
				echo '<div ', silicon_get_attr( $carousel ), '>';
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/tiles/portfolio-simple' );
				endwhile;
				echo '</div>';
				wp_reset_postdata();
				?>

            </div>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_scroll_to_top' ) ) :
	/**
	 * Display scroll to top button
	 *
	 * @hooked silicon_footer_before 10
	 * @see    footer.php
	 * @see    silicon_options_footer()
	 */
	function silicon_scroll_to_top() {
		// Check if Scroll to Top button is enabled in Theme Options
		if ( false === (bool) silicon_get_option( 'general_is_scroll_to_top', true ) ) {
			return;
		}

		?>
        <a href="#" class="scroll-to-top-btn">
            <i class="si si-angle-up"></i>
        </a>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_excerpt_more' ) ) :
	/**
	 * Returns  the string in the "more" link displayed after a trimmed excerpt
	 *
	 * @hooked excerpt_more 10
	 *
	 * @return string
	 */
	function silicon_excerpt_more() {
		return '...';
	}
endif;

if ( ! function_exists( 'silicon_edit_post_link' ) ) :
	/**
	 * Add a tooltip to the edit post link
	 *
	 * @param string $link    Edit link HTML tag
	 * @param int    $post_id Post ID
	 * @param string $text    Text passed to the {@see edit_post_link()}
	 *
	 * @hooked edit_post_link 10
	 *
	 * @return string
	 */
	function silicon_edit_post_link( $link, $post_id, $text ) {
		return str_replace(
			'class="edit-link"',
			sprintf( 'class="edit-link" data-toggle="tooltip" title="%s"', esc_html__( 'Edit', 'silicon' ) ),
			$link
		);
	}
endif;

if ( ! function_exists( 'silicon_archive_open_wrapper' ) ) :
	/**
	 * Wrap the archive to div.container. Open tag.
	 *
	 * @hooked silicon_archive_before 5
	 * @see    silicon_archive_close_wrapper()
	 * @see    archive.php
	 */
	function silicon_archive_open_wrapper() {
		echo '<div class="container padding-bottom-3x">';
	}
endif;

if ( ! function_exists( 'silicon_archive_close_wrapper' ) ) :
	/**
	 * Wrap the archive to div.container. Close tag.
	 *
	 * @hooked silicon_archive_after 5
	 * @see    silicon_archive_open_wrapper()
	 * @see    archive.php
	 */
	function silicon_archive_close_wrapper() {
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_site_backdrop' ) ) :
	/**
	 * Echoes the footer backdrop
	 *
	 * Should be right before the footer. Required for offcanvas, etc.
	 *
	 * @hooked silicon_footer_after 999
	 */
	function silicon_site_backdrop() {
		echo '<div class="site-backdrop"></div>';
	}
endif;

if ( ! function_exists( 'silicon_404_image' ) ) :
	/**
	 * Display image in 404 Page
	 */
	function silicon_404_image() {

		$image_id = (int) silicon_get_option( '404_image', 0 );

		if ( $image_id ) {
			$image = wp_get_attachment_image( $image_id, 'full' );
		} else {
			/**
			 * Filter the URI to image fallback
			 *
			 * This image will be loaded by default if user does not specify custom image in Theme Options -> 404
			 *
			 * This filter may be useful if you want to change the default fallback image
			 *
			 * @param string $uri Image URI
			 */
			$fallback_src = apply_filters( 'silicon_404_image_fallback', SILICON_TEMPLATE_URI . '/img/silibot.jpg' );

			$image = silicon_get_tag( 'img', array(
				'src' => $fallback_src,
				'alt' => '404',
			) );
		}

		echo '<div class="margin-bottom-2x">', $image, '</div>';
	}
endif;


if ( ! function_exists( 'silicon_language_switcher' ) ) :
	/**
	 * Display the language switcher
	 *
	 * @hooked silicon_topbar_right 20
	 */
	function silicon_language_switcher() {

		if ( false === (bool) apply_filters( 'silicon_is_language_switcher', true ) ) {
			return;
		}

		/**
		 * This filter allows to change a type of Language Switcher
		 *
		 * For example, you can set the type always been "default" or use your own.
		 * If you want to customize the language switcher further with your own callback.
		 *
		 * @param string $type Language switcher type
		 */
		$type = apply_filters( 'silicon_language_switcher_type', 'default' );

		/*
		<div class="lang-switcher">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHzSURBVHjaYkxOP8IAB//+Mfz7w8Dwi4HhP5CcJb/n/7evb16/APL/gRFQDiAAw3JuAgAIBEDQ/iswEERjGzBQLEru97ll0g0+3HvqMn1SpqlqGsZMsZsIe0SICA5gt5a/AGIEarCPtFh+6N/ffwxA9OvP/7//QYwff/6fZahmePeB4dNHhi+fGb59Y4zyvHHmCEAAAW3YDzQYaJJ93a+vX79aVf58//69fvEPlpIfnz59+vDhw7t37968efP3b/SXL59OnjwIEEAsDP+YgY53b2b89++/awvLn98MDi2cVxl+/vl6mituCtBghi9f/v/48e/XL86krj9XzwEEEENy8g6gu22rfn78+NGs5Ofr16+ZC58+fvyYwX8rxOxXr169fPny+fPn1//93bJlBUAAsQADZMEBxj9/GBxb2P/9+S/R8u3vzxuyaX8ZHv3j8/YGms3w8ycQARmi2eE37t4ACCDGR4/uSkrKAS35B3TT////wADOgLOBIaXIyjBlwxKAAGKRXjCB0SOEaeu+/y9fMnz4AHQxCP348R/o+l+//sMZQBNLEvif3AcIIMZbty7Ly6t9ZmXl+fXj/38GoHH/UcGfP79//BBiYHjy9+8/oUkNAAHEwt1V/vI/KBY/QSISFqM/GBg+MzB8A6PfYC5EFiDAABqgW776MP0rAAAAAElFTkSuQmCC" title="English" alt="English">
            <span class="caret"></span>
            <ul class="sub-menu">
                <li><a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHzSURBVHjaYkxOP8IAB//+Mfz7w8Dwi4HhP5CcJb/n/7evb16/APL/gRFQDiAAw3JuAgAIBEDQ/iswEERjGzBQLEru97ll0g0+3HvqMn1SpqlqGsZMsZsIe0SICA5gt5a/AGIEarCPtFh+6N/ffwxA9OvP/7//QYwff/6fZahmePeB4dNHhi+fGb59Y4zyvHHmCEAAAW3YDzQYaJJ93a+vX79aVf58//69fvEPlpIfnz59+vDhw7t37968efP3b/SXL59OnjwIEEAsDP+YgY53b2b89++/awvLn98MDi2cVxl+/vl6mituCtBghi9f/v/48e/XL86krj9XzwEEEENy8g6gu22rfn78+NGs5Ofr16+ZC58+fvyYwX8rxOxXr169fPny+fPn1//93bJlBUAAsQADZMEBxj9/GBxb2P/9+S/R8u3vzxuyaX8ZHv3j8/YGms3w8ycQARmi2eE37t4ACCDGR4/uSkrKAS35B3TT////wADOgLOBIaXIyjBlwxKAAGKRXjCB0SOEaeu+/y9fMnz4AHQxCP348R/o+l+//sMZQBNLEvif3AcIIMZbty7Ly6t9ZmXl+fXj/38GoHH/UcGfP79//BBiYHjy9+8/oUkNAAHEwt1V/vI/KBY/QSISFqM/GBg+MzB8A6PfYC5EFiDAABqgW776MP0rAAAAAElFTkSuQmCC" title="English" alt="English"><span style="margin-left:0.3em;">English</span></a></li>
                <li><a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAE2SURBVHjaYvz69T8DAvz79w9CQVj/0MCffwwAAcQClObiAin6/x+okxHMgPCAbOb//5n+I4EXL74ABBALxGSwagTjPzbAyMgItAQggBg9Pf9nZPx//x7kjL9////9C2QAyf9//qCQQCQkxFhY+BEggFi2b/+nq8v46BEDSPQ3w+8//3//BqFfv9BJeXmQEwACCOSkP38YgHy4Bog0RN0vIOMXVOTPH6Cv/gEEEEgDxFKgHEgDXCmGDUAE1AAQQCybGZg1f/d8//XsH0jTn3+///z79RtE/v4NZfz68xfI/vOX+4/0ZoZFAAHE4gYMvD+3/v2+h91wCANo9Z+/jH9VxBkYAAKIBRg9TL//MEhKAuWAogxgZzGC2CCfgUggAoYdGAEVAwQQ41egu5AQAyoXTQoIAAIMAD+JZR7YOGEWAAAAAElFTkSuQmCC" title="Русский" alt="Русский"><span style="margin-left:0.3em;">Русский</span></a></li>
            </ul>
        </div>
		*/

		/**
		 * This action allows you to output your own markup for Language Switcher.
		 *
		 * For example, you can use this action to add a multisite-based translations.
		 * See the styled markup above. You can use it without worrying about
		 * breaking the layout.
		 *
		 * Also, I use this action to output Polylang and WPML Language Switchers
		 *
		 * The dynamic part refers to language switcher type.
		 * See filter "silicon_language_switcher_{type}"
		 */
		do_action( "silicon_language_switcher_{$type}" );

		/**
		 * The same as above, but type passed as parameter
		 *
		 * @param string $type Language switcher type
		 */
		do_action( 'silicon_language_switcher', $type );
	}
endif;
