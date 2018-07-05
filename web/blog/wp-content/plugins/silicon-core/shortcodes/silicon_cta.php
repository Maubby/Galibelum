<?php
/**
 * Call To Action | silicon_cta
 *
 * This shortcode uses $content
 *
 * @var string $shortcode Shortcode tag
 * @var array  $atts      Shortcode attributes
 * @var mixed  $content   Shortcode content
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter the default shortcode attributes
 *
 * @param array  $atts      Pairs of default attributes
 * @param string $shortcode Shortcode tag
 */
$a = shortcode_atts( apply_filters( 'silicon_shortcode_default_atts', array(
	'date'    => '',
	'days'    => __( 'Days', 'silicon' ),
	'hours'   => __( 'Hours', 'silicon' ),
	'minutes' => __( 'Minutes', 'silicon' ),
	'seconds' => __( 'Seconds', 'silicon' ),

	'bg_color'        => '#f5f5f5',
	'bg_image'        => 0,
	'width'           => '',
	'alignment'       => 'left',
	'top'             => 24,
	'right'           => 24,
	'bottom'          => 24,
	'left'            => 24,
	'overlay'         => 'disable', // checkbox
	'overlay_color'   => '#000000',
	'overlay_opacity' => 30,
	'skin'            => 'dark',

	'button_text'             => '',
	'button_link'             => '',
	'button_type'             => 'solid',
	'button_shape'            => 'pill',
	'button_color'            => 'default',
	'button_color_custom'     => '', // rgba or hex?
	'button_size'             => 'nl',
	'button_alignment'        => 'inline',
	'button_is_icon'          => 'disable',
	'button_icon_library'     => 'silicon',
	'button_icon_position'    => 'left',
	'button_icon_silicon'     => '',
	'button_icon_socicon'     => '',
	'button_icon_material'    => '',
	'button_icon_fontawesome' => '',
	'button_icon_custom'      => '',
	'button_is_waves'         => 'disable',
	'button_waves_skin'       => 'light',
	'button_class'            => '',

	'animation' => '',
	'class'     => '',
), $shortcode ), $atts );

// vars
$button  = '';
$date    = '';
$overlay = array();
$style   = array();

// button
if ( ! empty( $a['button_text'] ) && ! empty( $a['button_link'] ) ) {
	$button = silicon_shortcode_build( 'silicon_button', silicon_parse_array( $a, 'button_' ) );
}

// date
if ( ! empty( $a['date'] ) && class_exists( 'DateTime' ) ) {
	try {
		$datetime = new DateTime( $a['date'] );
		$date     = $datetime->format( 'm/d/Y H:i:s' );
	} catch ( Exception $e ) {
		trigger_error( $e->getMessage() ); // in case of wrong date provided
	}
}

// overlay
if ( 'enable' === $a['overlay'] ) {
    $overlay['class'] = 'overlay';
    $overlay['style'] = silicon_css_declarations( array(
	    'background-color' => sanitize_hex_color( $a['overlay_color'] ),
	    'opacity'          => silicon_get_opacity_value( $a['overlay_opacity'] ),
    ) );
}

// style
$style['background-color'] = sanitize_hex_color( $a['bg_color'] );
$style['background-image'] = sprintf( 'url(%s)', silicon_get_image_src( (int) $a['bg_image'] ) );
$style['padding']          = implode( ' ', array_map( function ( $item ) {
    return empty( $item ) ? 0 : (int) $item . 'px';
}, array( $a['top'], $a['right'], $a['bottom'], $a['left'] ) ) );

?>
<div class="si-cta text-<?php echo esc_attr( $a['alignment'] ); ?>"
     style="<?php echo silicon_css_declarations( $style ); ?>"
>

	<?php
    // display overlay
    echo empty( $overlay ) ? '' : silicon_get_tag( 'span', $overlay, '' ); ?>

	<div class="si-cta-inner" <?php
         if ( ! empty( $a['width']) ) :
             echo sprintf( 'style="max-width: %dpx"', absint( $a['width'] ) );
         endif;
         ?>>

		<?php
        // display content
        echo silicon_do_shortcode( $content, true );

        // counter
        if ( ! empty( $date ) ) : ?>
            <div class="si-cta-counter si-cta-counter-<?php echo esc_attr( $a['skin'] ); ?>"
                 data-date-time="<?php echo esc_attr( $date ); ?>"
            >
                <div class="box">
                    <h4 class="days digit">00</h4>
		            <?php
		            echo silicon_get_text(
			            esc_html( $a['days'] ),
			            'light' === $a['skin'] ? '<div class="description text-white opacity-50">' : '<div class="description text-gray">',
			            '</div>'
		            );
		            ?>
                </div>

                <div class="box">
                    <h4 class="hours digit">00</h4>
		            <?php
		            echo silicon_get_text(
			            esc_html( $a['hours'] ),
			            'light' === $a['skin'] ? '<div class="description text-white opacity-50">' : '<div class="description text-gray">',
			            '</div>'
		            );
		            ?>
                </div>

                <div class="box">
                    <h4 class="minutes digit">00</h4>
	                <?php
	                echo silicon_get_text(
		                esc_html( $a['minutes'] ),
		                'light' === $a['skin'] ? '<div class="description text-white opacity-50">' : '<div class="description text-gray">',
		                '</div>'
	                );
	                ?>
                </div>

                <div class="box">
                    <h4 class="seconds digit">00</h4>
	                <?php
	                echo silicon_get_text(
		                esc_html( $a['seconds'] ),
		                'light' === $a['skin'] ? '<div class="description text-white opacity-50">' : '<div class="description text-gray">',
		                '</div>'
	                );
	                ?>
                </div>
            </div>
		<?php endif; ?>

		<?php
		// display button
		if ( ! empty( $button ) ) :
			echo silicon_do_shortcode( $button );
		endif;
		?>
	</div>
</div>
