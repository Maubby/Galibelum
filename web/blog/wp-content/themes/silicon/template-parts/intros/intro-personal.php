<?php
/**
 * Template for displaying "Personal" intro section
 *
 * @author 8guild
 */

$_intro_id = silicon_get_setting( 'intro', 0 );
if ( empty( $_intro_id ) ) {
	return;
}

$_s = silicon_get_meta( $_intro_id, '_silicon_intro_personal' );
$_s = wp_parse_args( $_s, array(
	'name'                  => '',
	'position'              => '',
	'avatar'                => 0,
	'shape'                 => 'circle',
	'title'                 => '',
	'subtitle'              => '',
	'button_1_text'         => '',
	'button_1_link'         => '',
	'button_1_type'         => 'solid',
	'button_1_color'        => 'default',
	'button_1_shape'        => 'pill',
	'button_1_color_custom' => '#f5f5f5',
	'button_2_text'         => '',
	'button_2_link'         => '',
	'button_2_type'         => 'solid',
	'button_2_color'        => 'default',
	'button_2_shape'        => 'pill',
	'button_2_color_custom' => '#f5f5f5',
	'skin'                  => 'dark',
	'bg_type'               => 'solid',
	'bg_color'              => '#f5f5f5',
	'bg_image'              => 0,
	'parallax'              => false,
	'parallax_type'         => 'scroll',
	'parallax_speed'        => 0.4,
	'parallax_video'        => '',
	'overlay'               => false,
	'overlay_type'          => 'color',
	'overlay_color'         => '#000000',
	'overlay_opacity'       => 60,
) );

// vars
$_attr    = array();
$_class   = array();
$_overlay = array();
$_style   = array();

$_class[] = 'intro-section';
$_class[] = 'intro-personal';
$_class[] = 'intro-' . esc_attr( $_s['skin'] );

// appearance
if ( 'gradient' === $_s['bg_type'] ) {
	$_class[] = 'background-gradient';
} elseif ( 'solid' === $_s['bg_type'] ) {
	$_style['background-color'] = sanitize_hex_color( $_s['bg_color'] );
} elseif ( 'image' === $_s['bg_type'] && ! empty( $_s['bg_image'] ) ) {
	$_style['background-image'] = sprintf( 'url(%s)', esc_url( silicon_get_image_src( (int) $_s['bg_image'] ) ) );

	// parallax
	if ( true === (bool) $_s['parallax'] ) {
		$meta     = wp_get_attachment_metadata( (int) $_s['bg_image'] );
		$jarallax = array(
			'type'      => esc_attr( $_s['parallax_type'] ),
			'speed'     => silicon_sanitize_float( $_s['parallax_speed'] ),
			'imgWidth'  => empty( $meta['width'] ) ? 'null' : (int) $meta['width'],
			'imgHeight' => empty( $meta['height'] ) ? 'null' : (int) $meta['height'],
			'noAndroid' => 'true',
			'noIos'     => 'true',
		);

		$_attr['data-jarallax']       = $jarallax;
		$_attr['data-jarallax-video'] = esc_url( $_s['parallax_video'] );
		unset( $meta, $jarallax );
	}

	// overlay
	if ( true === (bool) $_s['overlay'] ) {
		if ( 'gradient' === $_s['overlay_type'] ) {
			$_overlay['class'] = 'overlay background-gradient';
			$_overlay['style'] = sprintf( 'opacity: %s;', silicon_get_opacity_value( $_s['overlay_opacity'] ) );
		} else {
			$_overlay['class'] = 'overlay';
			$_overlay['style'] = silicon_css_declarations( array(
				'background-color' => sanitize_hex_color( $_s['overlay_color'] ),
				'opacity'          => silicon_get_opacity_value( $_s['overlay_opacity'] ),
			) );
		}
	}
}

$_attr['class'] = esc_attr( silicon_get_classes( $_class ) );
$_attr['style'] = esc_attr( silicon_css_declarations( $_style ) );
unset( $_class, $_style );

?>
<section <?php echo silicon_get_attr( $_attr ); ?>>

    <?php
    // overlay
    echo empty( $_overlay ) ? '' : silicon_get_tag( 'span', $_overlay, '' );
    ?>

	<div class="container text-center">
        <?php
        // title
        $title = strip_tags( trim( $_s['title'] ) );
        $title = str_replace( '.', '<span class="text-primary">.</span>', $title );
        echo silicon_get_text( $title, 'light' === $_s['skin'] ? '<h1 class="intro-title text-huge">' : '<h1 class="text-huge">', '</h1>' );
        unset( $title );

        // description
        $desc = nl2br( strip_tags( stripslashes( trim( $_s['subtitle'] ) ) ) );
        echo silicon_get_text( $desc, '<div class="intro-description"><p>', '</p></div>' );
        unset( $desc );

        // buttons
        if ( ( ! empty( $_s['button_1_link'] ) && ! empty( $_s['button_1_text'] ) )
             || ( ! empty( $_s['button_2_link'] ) && ! empty( $_s['button_2_text'] ) )
        ) : ?>
            <div class="intro-buttons">
		        <?php
		        $b1 = silicon_parse_array( $_s, 'button_1_' );
		        if ( ! empty( $b1['link'] ) && ! empty( $b1['text'] ) ) {
			        $b1['link']     = silicon_vc_build_link( array( 'url' => esc_url( $b1['link'] ) ) );
			        $b1['is_waves'] = 'enable';

			        $sh = silicon_shortcode_build( 'silicon_button', $b1 );
			        echo silicon_do_shortcode( $sh );
			        unset( $sh );
		        }

		        $b2 = silicon_parse_array( $_s, 'button_2_' );
		        if ( ! empty( $b2['link'] ) && ! empty( $b2['text'] ) ) {
			        $b2['link']     = silicon_vc_build_link( array( 'url' => esc_url( $b1['link'] ) ) );
			        $b2['is_waves'] = 'enable';

			        $sh = silicon_shortcode_build( 'silicon_button', $b2 );
			        echo silicon_do_shortcode( $sh );
			        unset( $sh );
		        }

		        unset( $b1, $b2 );
		        ?>
            </div>
        <?php endif; ?>
	</div>
	<div class="personal-info-wrap">
		<div class="container">
			<div class="personal-info">
				<div class="person-ava">
                    <div class="person-ava-inner">
						<?php
						if ( ! empty( $_s['avatar'] ) ) :
							echo wp_get_attachment_image( (int) $_s['avatar'], 'full' );
						else :
							echo silicon_get_tag( 'img', array(
								'src' => esc_html( SILICON_TEMPLATE_URI . '/img/avatar.png' ),
								'alt' => strip_tags( stripslashes( trim( $_s['name'] ) ) ),
							) );
						endif;
						?>
                    </div>
				</div>
				<div class="person-details">
                    <?php
                    echo silicon_get_text( esc_html( trim( $_s['name'] ) ), '<h2 class="person-name">', '</h2>' );
                    echo silicon_get_text( esc_html( trim( $_s['position'] ) ), '<p class="person-position">', '</p>' );
                    ?>
				</div>
			</div>
		</div>
	</div>
</section>
