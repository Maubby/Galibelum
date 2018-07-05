<?php
/**
 * Polylang compatibility
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Polylang', false ) ) {
	return;
}

/**
 * Allow Polylang to use it's own Language Switcher
 *
 * @hooked silicon_language_switcher_type
 * @see    silicon_language_switcher()
 *
 * @param string $type Type
 *
 * @return string
 */
function silicon_polylang_register_switcher( $type ) {
	return function_exists( 'pll_the_languages' ) ? 'polylang' : $type;
}

add_filter( 'silicon_language_switcher_type', 'silicon_polylang_register_switcher' );

if ( ! function_exists( 'silicon_polylang_switcher' ) ) :
	/**
	 * Echoes the markup of Polylang Language Switcher
	 *
	 * @hooked silicon_language_switcher 10
	 * @see    silicon_language_switcher()
	 */
	function silicon_polylang_switcher() {
		// make sure all required functions exists
		if ( ! function_exists( 'pll_the_languages' ) || ! function_exists( 'pll_current_language' ) ) {
			return;
		}

		$template = '
		<div class="lang-switcher">
			{current-lang}
			<span class="caret"></span>
			<ul class="sub-menu">
				{languages}
			</ul>
		</div>';

		$r = array(
			'{current-lang}' => pll_current_language( 'flag' ),
			'{languages}'    => pll_the_languages( array( 'echo' => false, 'show_flags' => true ) ),
		);

		echo str_replace( array_keys( $r ), array_values( $r ), $template );
	}
endif;

add_action( 'silicon_language_switcher_polylang', 'silicon_polylang_switcher' );


/**
 * Returns the strings from Theme Options which should be translated
 *
 * @return array
 */
function silicon_polylang_translatable_strings() {
	return array(
		'header_topbar_login_title' => array( 'name' => esc_html__( 'Login Link Title Info', 'silicon' ), 'multiline' => false ),
		'header_topbar_info'        => array( 'name' => esc_html__( 'Additional Info', 'silicon' ), 'multiline' => true ),
		'404_title'                 => array( 'name' => esc_html__( '404 Main Title', 'silicon' ), 'multiline' => false ),
		'404_subtitle_1'            => array( 'name' => esc_html__( '404 Subtitle 1', 'silicon' ), 'multiline' => false ),
		'404_button_text'           => array( 'name' => esc_html__( '404 Home Button Text', 'silicon' ), 'multiline' => false ),
		'404_subtitle_2'            => array( 'name' => esc_html__( '404 Subtitle 2', 'silicon' ), 'multiline' => false ),
	);
}

/**
 * Register the strings in Polylang.
 *
 * You can translate them in Settings > Languages > Strings translations
 */
function silicon_polylang_register_strings() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$options = silicon_get_option( 'all' );
	$context = esc_html__( 'Silicon', 'silicon' );
	$strings = (array) silicon_polylang_translatable_strings();

	foreach ( $strings as $option => $string ) {
		pll_register_string( $string['name'], empty( $options[ $option ] ) ? '' : $options[ $option ], $context, $string['multiline'] );
	}
}

add_action( 'admin_init', 'silicon_polylang_register_strings' );

/**
 * Translate the previously registered string
 *
 * @param mixed  $value  String value
 * @param string $string String key
 *
 * @return string
 */
function silicon_polylang_translate_string( $value, $string ) {
	if ( ! function_exists( 'pll__' ) ) {
		return $value;
	}

	$strings = silicon_polylang_translatable_strings();
	$strings = array_keys( $strings );

	if ( ! in_array( $string, $strings, true ) ) {
		return $value;
	}

	return pll_translate_string( $value, pll_current_language() );
}

add_filter( 'silicon_get_option', 'silicon_polylang_translate_string', 10, 2 );
