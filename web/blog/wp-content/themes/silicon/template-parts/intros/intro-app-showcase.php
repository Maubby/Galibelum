<?php
/**
 * Template for displaying "Mobile App Showcase" intro section
 *
 * @author 8guild
 */

$_intro_id = silicon_get_setting( 'intro', 0 );
if ( empty( $_intro_id ) ) {
	return;
}

$_settings = silicon_get_meta( $_intro_id, '_silicon_intro_app' );
$_settings = wp_parse_args( $_settings, array(
	// ios
	'ios_logo'           => 0,
	'ios_tagline'        => '',
	'ios_screen'         => 0,
	'ios_bg_type'        => 'solid',
	'ios_bg_color'       => '#f5f5f5',
	'ios_bg_image'       => 0,
	'ios_f1_icon'        => '',
	'ios_f1_title'       => '',
	'ios_f1_desc'        => '',
	'ios_f2_icon'        => '',
	'ios_f2_title'       => '',
	'ios_f2_desc'        => '',
	'ios_f3_icon'        => '',
	'ios_f3_title'       => '',
	'ios_f3_desc'        => '',

	// android
	'android_logo'       => 0,
	'android_tagline'    => '',
	'android_screen'     => 0,
	'android_bg_type'    => 'solid',
	'android_bg_color'   => '#f5f5f5',
	'android_bg_image'   => 0,
	'android_f1_icon'    => '',
	'android_f1_title'   => '',
	'android_f1_desc'    => '',
	'android_f2_icon'    => '',
	'android_f2_title'   => '',
	'android_f2_desc'    => '',
	'android_f3_icon'    => '',
	'android_f3_title'   => '',
	'android_f3_desc'    => '',

	// win
	'windows_logo'       => 0,
	'windows_tagline'    => '',
	'windows_screen'     => 0,
	'windows_bg_type'    => 'solid',
	'windows_bg_color'   => '#f5f5f5',
	'windows_bg_image'   => 0,
	'windows_f1_icon'    => '',
	'windows_f1_title'   => '',
	'windows_f1_desc'    => '',
	'windows_f2_icon'    => '',
	'windows_f2_title'   => '',
	'windows_f2_desc'    => '',
	'windows_f3_icon'    => '',
	'windows_f3_title'   => '',
	'windows_f3_desc'    => '',

	// appearance
	'skin'               => 'dark',
) );

$_platforms = array(
	'ios'     => silicon_parse_array( $_settings, 'ios_' ),
	'android' => silicon_parse_array( $_settings, 'android_' ),
	'windows' => silicon_parse_array( $_settings, 'windows_' ),
);

?>
<section class="intro-section intro-app-showcase intro-<?php echo esc_attr( $_settings['skin'] ); ?>">

	<?php
	// background
	$_is_first = true;
	foreach ( $_platforms as $_platform => $_s ) :
		if ( empty( $_s['screen'] ) ) {
			continue;
		}

		$_bg_atts = array();

		$_bg_atts['class']         = trim( 'intro-app-background ' . ( $_is_first ? 'active' : '' ) );
		$_bg_atts['data-platform'] = '#' . $_platform;

		if ( 'image' === $_s['bg_type'] && ! empty( $_s['bg_image'] ) ) {
			$_bg_atts['data-jarallax'] = true;
			$_bg_atts['style']         = silicon_css_background_image( (int) $_s['bg_image'] );
		} else {
			$_bg_atts['style'] = silicon_css_background_color( sanitize_hex_color( $_s['bg_color'] ) );
		}

		echo silicon_get_tag( 'div', $_bg_atts, '' );
		$_is_first = false;
	endforeach;
	unset( $_is_first, $_platform, $_s, $_bg_atts );
    ?>
	<div class="container padding-bottom-3x">
		<div class="row">
			<div class="col-md-4 padding-bottom-2x">

				<?php
				// headers
				$_h_tpl    = '<div class="{class}" data-platform="{platform}">{logo}{tagline}</div>';
				$_is_first = true;
				foreach ( $_platforms as $_platform => $_s ) :
					if ( empty( $_s['screen'] ) ) {
						continue;
					}

					if ( empty( $_s['logo'] ) ) {
						$logo = '';
					} else {
						$logo = wp_get_attachment_image( (int) $_s['logo'], 'full', false, array(
							'class' => 'block-center',
							'alt'   => trim( strip_tags( get_post_meta( (int) $_s['logo'], '_wp_attachment_image_alt', true ) ) ),
						) );

						$logo_meta  = wp_get_attachment_metadata( (int) $_s['logo'] );
						$logo_width = empty( $logo_meta['width'] ) ? 240 : (int) $logo_meta['width'];

						$logo = sprintf( '<div class="intro-app-logo" style="width: %2$dpx;">%1$s</div>',
							$logo,
							$logo_width / 2
						);

						unset( $logo_meta, $logo_width );
					}

					$r = array(
						'{class}'    => esc_attr( trim( 'intro-app-header ' . ( $_is_first ? 'active' : '' ) ) ),
						'{platform}' => '#' . $_platform,
						'{logo}'     => $logo,
						'{tagline}'  => silicon_get_text( esc_html( trim( $_s['tagline'] ) ), '<div class="intro-app-tagline">', '</div>' ),
					);

					echo str_replace( array_keys( $r ), array_values( $r ), $_h_tpl );
					$_is_first = false;
					unset( $r, $logo );
				endforeach;
				unset( $_h_tpl, $_is_first, $_platform, $_s );

				?>
				<div class="platform-swith font-family-nav padding-top-2x">
                    <?php
                    // platform switcher
                    $_is_first = true;
                    foreach ( $_platforms as $_platform => $_s ) :
	                    if ( empty( $_s['screen'] ) ) {
		                    continue;
	                    }

	                    echo '
	                    <a href="#' . $_platform . '" class="platform-' . $_platform . ( $_is_first ? ' active' : '' ) . '">
                            <i class="socicon-' . ( 'ios' === $_platform ? 'apple' : $_platform ) . '"></i>
                            ' . ( 'ios' === $_platform ? esc_html__( 'iOS', 'silicon' ) : mb_strtoupper( $_platform ) ) . '
                        </a>
	                    ';

                        $_is_first = false;
                    endforeach;
                    unset( $_is_first, $_platform, $_s );
                    ?>
				</div>
			</div>
			<div class="col-md-4">

                <?php
                // gadgets
                $_is_first = true;
                foreach ( $_platforms as $_platform => $_s ) :
	                if ( empty( $_s['screen'] ) ) {
		                continue;
	                }

	                echo '
                    <div class="gadget-' . $_platform . ( $_is_first ? ' active' : '' ) . '" data-platform="#' . $_platform . '">
                        <img src="' . SILICON_TEMPLATE_URI . '/img/gadgets/gadget-' . $_platform . '.png" alt="' . ucfirst( $_platform ) . '">
                        <div class="screen">
                            ' . wp_get_attachment_image( (int) $_s['screen'], 'full' ) . '
                        </div>
                    </div>
                    ';

	                $_is_first = false;
                endforeach;
                unset( $_is_first, $_platform, $_s );
                ?>
			</div>
			<div class="col-md-4 relative">

				<?php
				// features
				$_f_tpl    = '<div class="feature">{icon}<div class="feature-text">{title}{desc}</div></div>';
				$_is_first = true;
				foreach ( $_platforms as $_platform => $_s ) :
					if ( empty( $_s['screen'] ) ) :
						continue;
					endif;

					?>
                    <div class="intro-app-features <?php echo ( $_is_first ) ? 'active' : ''; ?>"
                         data-platform="#<?php echo esc_attr( $_platform ); ?>">
						<?php
						// three features, increase $j for more features
						for ( $_i = 1, $_j = 3; $_i <= $_j; $_i ++ ) :
							if ( empty( $_s["f{$_i}_icon"] ) && empty( $_s["f{$_i}_title"] ) && empty( $_s["f{$_i}_desc"] ) ) {
								continue;
							}

							if ( ! empty( $_s["f{$_i}_icon"] ) ) {
								$icon = wp_get_attachment_image( (int) $_s["f{$_i}_icon"], 'full' );
								$icon = silicon_get_text( $icon, '<div class="feature-icon">', '</div>' );
							} else {
								$icon = '';
							}

							$r = array(
								'{icon}'  => $icon,
								'{title}' => silicon_get_text( esc_html( trim( $_s["f{$_i}_title"] ) ), '<h4>', '</h4>' ),
								'{desc}'  => silicon_get_text( esc_html( trim( $_s["f{$_i}_desc"] ) ), '<p>', '</p>' ),
							);

							echo str_replace( array_keys( $r ), array_values( $r ), $_f_tpl );
							unset( $r, $icon );
						endfor;
						unset( $_i, $_j );
						?>
                    </div>
					<?php

					$_is_first = false;
				endforeach;
				unset( $_is_first, $_f_tpl );
				?>

			</div>
		</div>
	</div>
</section>
