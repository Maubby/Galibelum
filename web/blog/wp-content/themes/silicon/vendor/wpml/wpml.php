<?php
/**
 * WPML Compatibility
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
	return;
}

/**
 * Allow WPML to use it's own Language Switcher
 *
 * @hooked silicon_language_switcher_type
 * @see    silicon_language_switcher()
 *
 * @param string $type Type
 *
 * @return string
 */
function silicon_wpml_register_switcher( $type ) {
	return function_exists( 'wpml_get_active_languages_filter' ) ? 'wpml' : $type;
}

add_filter( 'silicon_language_switcher_type', 'silicon_wpml_register_switcher' );

if ( ! function_exists( 'silicon_wpml_switcher' ) ) :
	/**
	 * Echoes the markup of WPML Language Switcher
	 *
	 * @hooked silicon_language_switcher 10
	 * @see    silicon_language_switcher()
	 */
	function silicon_wpml_switcher() {
		if ( ! function_exists( 'wpml_get_active_languages_filter' ) ) {
			return;
		}

		$template = '
		<div class="lang-switcher">
			<img src="{current-flag-url}" alt="{current-lang}" />
			<span class="caret"></span>
			<ul class="sub-menu">
				{languages}
			</ul>
		</div>';

		$languages = wpml_get_active_languages_filter( null );
		$current   = array_filter( $languages, function( $language ) {
			return ( 1 === (int) $language['active'] );
		} );
		$current = reset( $current );

		$languages_html = array();
		foreach ( $languages as $language ) {
			$languages_html[] = sprintf( '<li><a href="%1$s"><img src="%3$s" alt="%2$s">%2$s</a></li>',
				esc_url( $language['url'] ),
				esc_html( $language['native_name'] ),
				esc_url( $language['country_flag_url'] )
			);
		}
		unset( $language );

		$r = array(
			'{current-flag-url}' => esc_url( $current['country_flag_url'] ),
			'{current-lang}'     => esc_html( $current['native_name'] ),
			'{languages}'        => implode( '', $languages_html ),
		);

		echo str_replace( array_keys( $r ), array_values( $r ), $template );
	}
endif;

add_action( 'silicon_language_switcher_wpml', 'silicon_wpml_switcher' );
