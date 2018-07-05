<?php
/**
 * Page Preloader
 *
 * @author 8guild
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if Equip not installed
if ( ! defined( 'EQUIP_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'silicon_is_preloader' ) ) :
	/**
	 * Check if Page Preloader is enabled in Theme Options
	 *
	 * @see silicon_options_general()
	 *
	 * @return bool
	 */
	function silicon_is_preloader() {
		return (bool) silicon_get_option( 'general_is_preloader', false );
	}
endif;

if ( ! function_exists( 'silicon_preloader_styles' ) ) :
	/**
	 * Add Page Preloader styles to <head>
	 *
	 * @hooked wp_print_styles
	 */
	function silicon_preloader_styles() {
		if ( ! silicon_is_preloader() || is_admin() ) {
			return;
		}

		$spinner       = esc_attr( silicon_get_option( 'general_preloader_type', 'progress' ) );
		$spinner_color = sanitize_hex_color( silicon_get_option( 'general_preloader_color', '#3d59f9' ) );
		$screen_color  = sanitize_hex_color( silicon_get_option( 'general_preloader_screen_color', '#ffffff' ) );

		$css = "
		body { overflow-y: hidden; }
		.page-wrapper {
			-webkit-transition: opacity .7s .9s;
			transition: opacity .7s .9s;
			opacity: 0;
		}
		.page-wrapper.loading-done { opacity: 1; }
		.loading-screen {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background-color: {$screen_color};
			z-index: 9999;
			opacity: 1;
			visibility: visible;
			-webkit-transition: all .1s;
			transition: all 1s;
		}
		.loading-screen.loading-done {
			opacity: 0;
			visibility: hidden;
		}
		.loading-screen .inner {
			position: absolute;
			width: 100%;
			top: 50%;
			left: 0;
			padding: 20px;
			-webkit-transform: translateY(-50%);
			-moz-transform: translateY(-50%);
			-ms-transform: translateY(-50%);
			transform: translateY(-50%);
		}
		.loading-screen .preloader-logo {
			display: block;
			margin: 0 auto 30px auto;
		}
		";

		switch ( $spinner ) {
			case 'spinner':
				$css .= "
				.spinner-wrap {
					display: block;
				    height: 54px;
				    width: 54px;
				    margin: auto;
				    -webkit-animation: container-rotate 1568ms linear infinite;
				    animation: container-rotate 1568ms linear infinite;
				}
				.spinner-layer {
					position: absolute;
					width: 100%;
					height: 100%;
					border-color: {$spinner_color};
				    -webkit-animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				    animation: fill-unfill-rotate 5332ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				}
				.circle-clipper {
					display: inline-block;
					position: relative;
					width: 50%;
					height: 100%;
					overflow: hidden;
					border-color: inherit;
				}
				.circle-clipper.left {
					float: left;
				}
				.circle-clipper.right {
					float: right;
				}
				.circle-clipper .circle {
					width: 200%;
					height: 100%;
					border-width: 2px;
					border-style: solid;
					border-color: inherit;
					border-bottom-color: transparent !important;
					border-radius: 50%;
					position: absolute;
					top: 0;
					right: 0;
					bottom: 0;
				}
				.circle-clipper.left .circle {
					left: 0;
					border-right-color: transparent !important;
					-webkit-transform: rotate(129deg);
					transform: rotate(129deg);
				    -webkit-animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				    animation: left-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				}
				.circle-clipper.right .circle {
					left: -100%;
					border-left-color: transparent !important;
					-webkit-transform: rotate(-129deg);
					transform: rotate(-129deg);
				    -webkit-animation: right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				    animation: right-spin 1333ms cubic-bezier(0.4, 0, 0.2, 1) infinite both;
				}
				.gap-patch {
					position: absolute;
					top: 0;
					left: 45%;
					width: 10%;
					height: 100%;
					overflow: hidden;
					border-color: inherit;
				}
				.gap-patch .circle {
					width: 1000%;
					left: -450%;
					border-radius: 50%;
				}
				@-webkit-keyframes container-rotate {
				    100% { -webkit-transform: rotate(360deg); }
				}
				@keyframes container-rotate {
					100% {
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg);
					}
				}
				@-webkit-keyframes fill-unfill-rotate {
				    12.5% { -webkit-transform: rotate(135deg); }
				    25% { -webkit-transform: rotate(270deg); }
				    37.5% { -webkit-transform: rotate(405deg); }
				    50% { -webkit-transform: rotate(540deg); }
				    62.5% { -webkit-transform: rotate(675deg); }
				    75% { -webkit-transform: rotate(810deg); }
				    87.5% { -webkit-transform: rotate(945deg); }
				    100% { -webkit-transform: rotate(1080deg); }
				}
				@keyframes fill-unfill-rotate {
				    12.5% {
						-webkit-transform: rotate(135deg);
						transform: rotate(135deg);
					}
				    25% {
						-webkit-transform: rotate(270deg);
						transform: rotate(270deg);
					}
				    37.5% {
						-webkit-transform: rotate(405deg);
						transform: rotate(405deg);
					}
				    50% {
						-webkit-transform: rotate(540deg);
						transform: rotate(540deg);
					}
				    62.5% {
						-webkit-transform: rotate(675deg);
						transform: rotate(675deg);
					}
				    75% {
						-webkit-transform: rotate(810deg);
						transform: rotate(810deg);
					}
				    87.5% {
						-webkit-transform: rotate(945deg);
						transform: rotate(945deg);
					}
				    100% {
						-webkit-transform: rotate(1080deg);
						transform: rotate(1080deg);
					}
				}
				@-webkit-keyframes left-spin {
				    0% { -webkit-transform: rotate(130deg); }
				    50% { -webkit-transform: rotate(-5deg); }
				    100% { -webkit-transform: rotate(130deg); }
				}
				@keyframes left-spin {
					0% {
						-webkit-transform: rotate(130deg);
						transform: rotate(130deg);
					}
					50% {
						-webkit-transform: rotate(-5deg);
						transform: rotate(-5deg);
					}
					100% {
						-webkit-transform: rotate(130deg);
						transform: rotate(130deg);
					}
				}
				@-webkit-keyframes right-spin {
				    0% { -webkit-transform: rotate(-130deg); }
				    50% { -webkit-transform: rotate(5deg); }
				    100% { -webkit-transform: rotate(-130deg); }
				}
				@keyframes right-spin {
					0% {
						-webkit-transform: rotate(-130deg);
						transform: rotate(-130deg);
					}
					50% {
						-webkit-transform: rotate(5deg);
						transform: rotate(5deg);
					}
					100% {
						-webkit-transform: rotate(-130deg);
						transform: rotate(-130deg);
					}
				}
				";
				break;

			case 'progress':
			default:
				$css .= "
				.progress-wrap {
					display: block;
				    position: relative;
					height: 2px;
					width: 220px;
					border-radius: 2px;
					background-color: #f0f0f0;
					overflow: hidden;
					margin: auto;
				}
				.progress-wrap .indeterminate {
					background-color: {$spinner_color};
				}
				.progress-wrap .indeterminate::before,
				.progress-wrap .indeterminate::after {
					content: '';
					position: absolute;
					background-color: inherit;
					top: 0;
					left: 0;
					bottom: 0;
					will-change: left, right;
				}
				.progress-wrap .indeterminate::before {
				    -webkit-animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
				    animation: indeterminate 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;
				}
				.progress-wrap .indeterminate::after {
				    -webkit-animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
				    animation: indeterminate-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;
					-webkit-animation-delay: 1.15s;
					animation-delay: 1.15s;
				}
				@-webkit-keyframes indeterminate {
					0% {
						left: -35%;
						right: 100%;
					}
					60% {
						left: 100%;
						right: -90%;
					}
					100% {
						left: 100%;
						right: -90%;
					}
				}
				@keyframes indeterminate {
					0% {
						left: -35%;
						right: 100%;
					}
					60% {
						left: 100%;
						right: -90%;
					}
					100% {
						left: 100%;
						right: -90%;
					}
				}
				@-webkit-keyframes indeterminate-short {
					0% {
						left: -200%;
						right: 100%;
					}
					60% {
						left: 107%;
						right: -8%;
					}
					100% {
						left: 107%;
						right: -8%;
					}
				}
				@keyframes indeterminate-short {
					0% {
						left: -200%;
						right: 100%;
					}
					60% {
						left: 107%;
						right: -8%;
					}
					100% {
						left: 107%;
						right: -8%;
					}
				}
				";
				break;
		}

		$css = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $css );
		$css = preg_replace( '/\\s\\s+/', ' ', $css ); // remove possible multiple whitespaces

		echo '<style type="text/css">', $css, '</style>';
	}
endif;

add_action( 'wp_print_styles', 'silicon_preloader_styles', 5, 0 );

if ( ! function_exists( 'silicon_preloader_scripts' ) ) :
	/**
	 * Add Page Preloader scripts to <head>
	 *
	 * @hooked wp_print_scripts
	 */
	function silicon_preloader_scripts() {
		if ( ! silicon_is_preloader() || is_admin() ) {
			return;
		}

		?>
        <script type="text/javascript">
			( function () {
                window.onload = function () {
                    var body = document.querySelector( "body" );
                    var preloader = body.querySelector( ".loading-screen" );
                    var page = body.querySelector( ".page-wrapper" );
                    body.style.overflowY = "auto";
                    preloader.classList.add( "loading-done" );
                    page.classList.add( "loading-done" );
                };
            } )();
        </script>
		<?php
	}
endif;

add_action( 'wp_print_scripts', 'silicon_preloader_scripts', 5, 0 );

if ( ! function_exists( 'silicon_the_preloader' ) ) :
	/**
	 * Displays Page Preloader Markup
	 *
	 * @hooked silicon_header_before
	 * @see    header.php
	 */
	function silicon_the_preloader() {
		if ( ! silicon_is_preloader() ) {
			return;
		}

		$logo_image = silicon_get_option( 'general_preloader_logo' );
		$logo_width = silicon_get_option( 'general_preloader_logo_width', 150 );

		if ( ! empty( $logo_image ) ) {
			$logo = sprintf( '<div class="preloader-logo" style="%2$s">%1$s</div>',
				wp_get_attachment_image( (int) $logo_image, 'full' ),
				silicon_css_width( (int) $logo_width )
			);
		} else {
			$logo = '';
		}

		$type = esc_attr( silicon_get_option( 'general_preloader_type', 'progress' ) );
		switch ( $type ) {
			case 'spinner':
				$spinner = '
				<div class="spinner-wrap">
					<div class="spinner-layer">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div>
						<div class="gap-patch">
							<div class="circle"></div>
						</div>
						<div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
				</div>
				';
				break;

			case 'progress':
			default:
				$spinner = '
				<div class="progress-wrap">
					<div class="indeterminate"></div>
				</div>
				';
				break;
		}

		$spinner = str_replace( array( "\r\n", "\r", "\n", "\t" ), '', $spinner );

		echo "
        <div class=\"loading-screen\">
            <div class=\"inner\">
                {$logo}
                {$spinner}
            </div>
        </div>
		";
	}
endif;

add_action( 'silicon_header_before', 'silicon_the_preloader', -1 );
