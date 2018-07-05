<?php

/**
 * Widget "Silicon Socials"
 *
 * Display the Social Networks
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Socials extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_socials';

	/**
     * Widget default values
     *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Social Networks', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Socials', 'silicon' ), $opts );

		$this->defaults = array(
			'title'             => '',
			'socials'           => '',
			'shape'             => 'circle',
			'color'             => 'monochrome',
			'skin'              => 'dark',
			'alignment'         => 'left',
			'is_tooltips'       => 'enable',
			'tooltips_position' => 'top',
			'class'             => '',
		);
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );

		if ( empty( $instance['socials'] ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			echo '<p>', esc_html__( 'Please provide social links to make this widget works.', 'silicon' ), '</p>';
			echo $args['after_widget'];

			return;
		}

		$atts = $instance;
		unset( $atts['title'] );

		// convert socials to format, used in shortcode
		$converted = array();
		foreach ( (array) $instance['socials'] as $network => $url ) {
			$converted[] = array( 'network' => $network, 'url' => $url );
		}
		unset( $network, $url );

		$atts['socials'] = urlencode( json_encode( $converted ) );
		$shortcode       = silicon_shortcode_build( 'silicon_socials', $atts );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		echo silicon_do_shortcode( $shortcode );
		echo $args['after_widget'];
	}

	/**
	 * Output the widget settings form
	 *
	 * @param array $instance Current settings
	 *
	 * @return bool
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		?>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html_x( 'Title', 'widget title', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['title'] ) ); ?>">
		</div>

        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'socials' ) ); ?>">
		        <?php esc_html_e( 'Socials', 'silicon' ); ?>
            </label>
	        <?php
	        if ( defined( 'EQUIP_VERSION' ) ) :
		        $_networks = silicon_get_networks();
		        $networks  = array();
		        array_walk( $_networks, function ( $data, $network ) use ( &$networks ) {
			        $networks[ $network ] = $data['name'];
		        } );

		        printf( '<input type="hidden" class="silicon-socials" id="%s" name="%s" value="%s" data-networks=\'%s\'>',
			        esc_attr( $this->get_field_id( 'socials' ) ),
			        esc_attr( $this->get_field_name( 'socials' ) ),
			        $this->escape( $instance['socials'] ),
			        json_encode( $networks )
		        );
		        unset( $_networks, $networks );
	        else :
		        echo '<p>', esc_html__( 'This field requires Equip plugin.', 'silicon' ), '</p>';
	        endif;
	        ?>
		</div>

        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>">
				<?php echo esc_html__( 'Shape', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'shape' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>"
            >
                <option value="no" <?php selected( 'no', $instance['shape'] ); ?>><?php esc_html_e( 'No shape', 'silicon' ); ?></option>
                <option value="circle" <?php selected( 'circle', $instance['shape'] ); ?>><?php esc_html_e( 'Circle', 'silicon' ); ?></option>
                <option value="rounded" <?php selected( 'rounded', $instance['shape'] ); ?>><?php esc_html_e( 'Rounded', 'silicon' ); ?></option>
                <option value="square" <?php selected( 'square', $instance['shape'] ); ?>><?php esc_html_e( 'Square', 'silicon' ); ?></option>
                <option value="polygon" <?php selected( 'polygon', $instance['shape'] ); ?>><?php esc_html_e( 'Polygon', 'silicon' ); ?></option>
            </select>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>">
				<?php echo esc_html__( 'Color', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"
            >
                <option value="monochrome" <?php selected( 'monochrome', $instance['color'] ); ?>><?php esc_html_e( 'Monochrome', 'silicon' ); ?></option>
                <option value="brand" <?php selected( 'brand', $instance['color'] ); ?>><?php esc_html_e( 'Brand Color', 'silicon' ); ?></option>
            </select>
        </div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>">
				<?php echo esc_html__( 'Skin', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'skin' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'skin' ) ); ?>"
			>
                <option value="dark" <?php selected( 'dark', $instance['skin'] ); ?>><?php esc_html_e( 'Dark', 'silicon' ); ?></option>
                <option value="light" <?php selected( 'light', $instance['skin'] ); ?>><?php esc_html_e( 'Light', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>">
				<?php echo esc_html__( 'Alignment', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'alignment' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>"
			>
				<option value="left" <?php selected( 'left', $instance['alignment'] ); ?>><?php esc_html_e( 'Left', 'silicon' ); ?></option>
				<option value="center" <?php selected( 'center', $instance['alignment'] ); ?>><?php esc_html_e( 'Center', 'silicon' ); ?></option>
				<option value="right" <?php selected( 'right', $instance['alignment'] ); ?>><?php esc_html_e( 'Right', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_tooltips' ) ); ?>">
				<?php echo esc_html__( 'Tooltips', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'is_tooltips' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'is_tooltips' ) ); ?>"
			>
                <option value="enable" <?php selected( 'enable', $instance['is_tooltips'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
                <option value="disable" <?php selected( 'disable', $instance['is_tooltips'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
			</select>
		</div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'tooltips_position' ) ); ?>">
				<?php esc_html_e( 'Tooltips Position', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'tooltips_position' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'tooltips_position' ) ); ?>"
            >
                <option value="top" <?php selected( 'top', $instance['tooltips_position'] ); ?>><?php esc_html_e( 'Top', 'silicon' ); ?></option>
                <option value="right" <?php selected( 'right', $instance['tooltips_position'] ); ?>><?php esc_html_e( 'Right', 'silicon' ); ?></option>
                <option value="left" <?php selected( 'left', $instance['tooltips_position'] ); ?>><?php esc_html_e( 'Left', 'silicon' ); ?></option>
                <option value="bottom" <?php selected( 'bottom', $instance['tooltips_position'] ); ?>><?php esc_html_e( 'Bottom', 'silicon' ); ?></option>
            </select>
        </div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>">
				<?php esc_html_e( 'Custom class', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>"
			       value="<?php echo esc_attr( trim( $instance['class'] ) ); ?>">
		</div>
		<?php

		return true;
	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New values
	 * @param array $old_instance Old values
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']             = sanitize_text_field( $new_instance['title'] );
		$instance['socials']           = $this->sanitize( $new_instance['socials'] );
		$instance['shape']             = esc_attr( $new_instance['shape'] );
		$instance['color']             = esc_attr( $new_instance['color'] );
		$instance['skin']              = esc_attr( $new_instance['skin'] );
		$instance['alignment']         = esc_attr( $new_instance['alignment'] );
		$instance['is_tooltips']       = esc_attr( $new_instance['is_tooltips'] );
		$instance['tooltips_position'] = esc_attr( $new_instance['tooltips_position'] );
		$instance['class']             = esc_attr( $new_instance['class'] );

		return $instance;
	}


	/**
	 * Convert input to more suitable format
	 *
	 * Input format should be:
	 * network|url,facebook|http://...,twitter|#,linkedin|#
	 *
	 * Output format:
	 * [network => url, facebook => http://..., twitter => #, linkedin => #]
	 *
	 * @param string $value Socials data, user input
	 *
	 * @return array
	 */
	public function sanitize( $value ) {
		if ( empty( $value ) ) {
			return array();
		}

		$sanitized = array();
		$pairs     = explode( ',', $value );
		$networks  = array_keys( silicon_get_networks() );
		foreach ( (array) $pairs as $pair ) {
			list( $network, $url ) = explode( '|', $pair );

			// skip empty links
			if ( empty( $url ) ) {
				continue;
			}

			// do not allow unknown networks
			if ( ! in_array( $network, $networks, true ) ) {
				continue;
			}

			$url     = preg_match( '@^https?://@i', $url ) ? esc_url_raw( $url ) : esc_attr( $url );
			$network = esc_attr( $network );

			$sanitized[ $network ] = $url;
			unset( $network, $url );
		}

		return $sanitized;
	}

	/**
	 * Convert socials data from database in format,
	 * required by equipSocials.js to work properly
	 *
	 * Output format should be:
	 * network|url,facebook|http://...,twitter|#
	 *
	 * @param array $value Socials data from database
	 *
	 * @return string
	 */
	public function escape( $value ) {
		if ( ! is_array( $value ) || empty( $value ) ) {
			return '';
		}

		$pairs = array();
		foreach ( (array) $value as $network => $url ) {
			$network = esc_attr( $network );
			$url     = preg_match( '@^https?://@i', $url ) ? esc_url_raw( $url ) : esc_attr( $url );

			$pairs[] = implode( '|', [ $network, $url ] );
			unset( $network, $url );
		}

		return implode( ',', $pairs );
	}
}