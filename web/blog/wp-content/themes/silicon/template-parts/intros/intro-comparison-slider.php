<?php
/**
 * Template for displaying "Comparison Slider" intro section
 *
 * @author 8guild
 */

$_intro_id = silicon_get_setting( 'intro', 0 );
if ( empty( $_intro_id ) ) {
	return;
}

$_s = silicon_get_meta( $_intro_id, '_silicon_intro_comparison' );
$_s = wp_parse_args( $_s, array(
	'title'               => '',
	'description'         => '',
	'button_text'         => '',
	'button_link'         => '',
	'button_type'         => 'solid',
	'button_color'        => 'primary',
	'button_shape'        => 'pill',
	'button_color_custom' => '#f5f5f5',
	'left_image'          => 0,
	'left_label'          => esc_html__( 'Before', 'silicon' ),
	'right_image'         => 0,
	'right_label'         => esc_html__( 'After', 'silicon' ),
	'skin'                => 'dark',
	'bg_type'             => 'solid',
	'bg_color'            => '#f5f5f5',
	'bg_image'            => 0,
	'parallax'            => false,
	'parallax_type'       => 'scroll',
	'parallax_speed'      => 0.4,
	'parallax_video'      => '',
	'overlay'             => false,
	'overlay_type'        => 'color',
	'overlay_color'       => '#000000',
	'overlay_opacity'     => 60,
) );

// vars
$_attr    = array();
$_class   = array();
$_overlay = array();
$_style   = array();

$_class[] = 'intro-section';
$_class[] = 'intro-comparison';
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
        echo silicon_get_text( $title, '<h1 class="intro-title text-huge">', '</h1>' );
        unset( $title );

        // description
        $desc = nl2br( strip_tags( stripslashes( trim( $_s['description'] ) ) ) );
        echo silicon_get_text( $desc, '<div class="intro-description"><p>', '</p></div>' );
        unset( $desc );

        // buttons
        if ( ! empty( $_s['button_link'] ) && ! empty( $_s['button_text'] ) ) :
	        $b             = silicon_parse_array( $_s, 'button_' );
	        $b['link']     = silicon_vc_build_link( array( 'url' => esc_url( $b['link'] ) ) );
	        $b['is_waves'] = 'enable';

	        $sh = silicon_shortcode_build( 'silicon_button', $b );

	        echo '<div class="intro-buttons">', silicon_do_shortcode( $sh ), '</div>';
	        unset( $b, $sh );
        endif;
        ?>
        <div class="compar-slider-wrap">
            <?php
            echo silicon_get_text( esc_html( trim( $_s['left_label'] ) ), '<div class="cs-label">', '</div>' );
            echo silicon_get_text( esc_html( trim( $_s['right_label'] ) ), '<div class="cs-label">', '</div>' );
            ?>
            <div class="compar-slider">
                <img src="<?php echo esc_url( SILICON_TEMPLATE_URI . '/img/macbook.png' ); ?>"
                     class="macbook"
                     alt="<?php echo esc_html__( 'MacBook', 'silicon' ); ?>"
                >
                <div class="cs-screen">
                    <figure class="cd-image-container">
	                    <?php echo wp_get_attachment_image( (int) $_s['right_image'],'full' ); ?>
                        <div class="cd-resize-img">
	                        <?php echo wp_get_attachment_image( (int) $_s['left_image'], 'full' ); ?>
                        </div>
                        <span class="cd-handle"></span>
                    </figure>
                </div>
            </div>
        </div>
    </div>
</section>
