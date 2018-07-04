<?php

/**
 * Widget "Silicon Google Maps"
 *
 * Display the Google Map
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Map extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_map';

	/**
	 * Widget default values
	 *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Simple Google Maps widget for general purposes.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Google Maps', 'silicon' ), $opts );

		$this->defaults = array(
			'title'        => '',
			'location'     => '',
			'height'       => 250,
			'zoom'         => 14,
			'is_zoom'      => 'disable',
			'is_scroll'    => 'disable',
			'is_marker'    => 'disable',
			'marker'       => '',
			'marker_title' => '',
			'class'        => '',
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

		if ( empty( $instance['location'] ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			echo '<p>', esc_html__( 'Please provide a location to initialize a Google Maps.', 'silicon' ), '</p>';
			echo $args['after_widget'];

			return;
		}

		$atts = $instance;
		unset( $atts['title'] );

		/**
		 * This filter allows to add a custom map styling
		 *
		 * Generate your styles in @link https://snazzymaps.com/editor Snazzymaps Editor
		 * and encode a JavaScript array. See more info in docs.
		 *
		 * @param string $style     Encoded js array from Snazzymaps Editor
		 * @param array  $instance  Widget settings
		 * @param string $widget_id Widget ID
		 */
		$atts['style'] = apply_filters( 'silicon_widget_map_style', '', $instance, $this->id_base );

		$shortcode = silicon_shortcode_build( 'silicon_map', $atts );

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
			<label for="<?php echo esc_attr( $this->get_field_id( 'location' ) ); ?>">
				<?php echo esc_html__( 'Location', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'location' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'location' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['location'] ) ); ?>">
            <span class="description"><?php esc_html_e( 'Enter any search query, which you can find on Google Maps, e.g. "New York, USA".', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>">
				<?php echo esc_html__( 'Height', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['height'] ) ); ?>">
            <span class="description"><?php esc_html_e( 'Height of the map in pixels.', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>">
				<?php echo esc_html__( 'Zoom', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['zoom'] ) ); ?>">
            <span class="description"><?php esc_html_e( 'The initial Map zoom level', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_zoom' ) ); ?>">
				<?php echo esc_html__( 'Zoom Controls', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'is_zoom' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'is_zoom' ) ); ?>"
			>
				<option value="enable" <?php selected( 'enable', $instance['is_zoom'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
				<option value="disable" <?php selected( 'disable', $instance['is_zoom'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
			</select>
            <span class="description"><?php esc_html_e( 'Enable or disable map controls like pan, zoom, etc.', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_scroll' ) ); ?>">
				<?php echo esc_html__( 'Scroll Wheel', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'is_scroll' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'is_scroll' ) ); ?>"
			>
				<option value="enable" <?php selected( 'enable', $instance['is_scroll'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
				<option value="disable" <?php selected( 'disable', $instance['is_scroll'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
			</select>
            <span class="description"><?php esc_html_e( 'Enable or disable scroll wheel zooming on the map.', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_marker' ) ); ?>">
				<?php echo esc_html__( 'Marker', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'is_marker' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'is_marker' ) ); ?>"
			>
				<option value="enable" <?php selected( 'enable', $instance['is_marker'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
				<option value="disable" <?php selected( 'disable', $instance['is_marker'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
			</select>
            <span class="description"><?php esc_html_e( 'Enable or disable marker on the map.', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'marker_title' ) ); ?>">
				<?php echo esc_html__( 'Marker Title', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'marker_title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'marker_title' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['marker_title'] ) ); ?>">
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'marker' ) ); ?>">
				<?php echo esc_html__( 'Marker Icon', 'silicon' ); ?>
			</label>
			<?php
			if ( defined( 'EQUIP_VERSION' ) ) :
				// prepare preview for media field
				if ( ! empty( $instance['marker'] ) ) {
					$preview = esc_url( silicon_get_image_src( $instance['marker'], 'medium' ) );
					$preview = (array) $preview;
				} else {
					$preview = '';
				}

				$attr = array(
					'type'          => 'hidden',
					'class'         => 'silicon-widget-gallery',
					'id'            => esc_attr( $this->get_field_id( 'marker' ) ),
					'name'          => esc_attr( $this->get_field_name( 'marker' ) ),
					'value'         => trim( $instance['marker'] ),
					'data-preview'  => $preview,
					'data-multiple' => 'false',
					'data-sortable' => 'false',
					'data-title'    => esc_html__( 'Select the Custom Marker Icon', 'silicon' ),
					'data-button'   => esc_html__( 'Choose', 'silicon' ),
				);

				echo '<input ', silicon_get_attr( $attr ), '>';
				unset( $preview, $attr );
			else :
				echo '<p>', esc_html__( 'This field requires Equip plugin.', 'silicon' ), '</p>';
			endif;
			?>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>">
				<?php esc_html_e( 'Custom Class', 'silicon' ); ?>
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

		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['location']     = sanitize_text_field( $new_instance['location'] );
		$instance['height']       = absint( $new_instance['height'] );
		$instance['zoom']         = absint( $new_instance['zoom'] );
		$instance['is_zoom']      = sanitize_key( $new_instance['is_zoom'] );
		$instance['is_scroll']    = sanitize_key( $new_instance['is_scroll'] );
		$instance['is_marker']    = sanitize_key( $new_instance['is_marker'] );
		$instance['marker']       = absint( $new_instance['marker'] );
		$instance['marker_title'] = sanitize_text_field( $new_instance['marker_title'] );
		$instance['class']        = esc_attr( $new_instance['class'] );

		return $instance;
	}
}