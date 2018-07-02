<?php

/**
 * Widget "Silicon Button"
 *
 * Display the simple button with description
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Button extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_button';

	/**
     * Widget default values
     *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Common button for general purposes.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Button', 'silicon' ), $opts );

		$this->defaults = array(
			'title'         => '',
			'description'   => '',
			'text'          => '',
			'link'          => '',
			'type'          => 'solid',
			'shape'         => 'pill',
			'color'         => 'default',
			'size'          => 'nl',
			'icon'          => '', // custom icon field
			'icon_position' => 'left',
			'is_waves'      => 'disable',
			'waves_skin'    => 'light',
			'class'         => '',
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

		$title = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$atts  = $instance;

		if ( empty( $instance['link'] ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			echo '<p>', esc_html__( 'Please enter a valid Button Link.', 'silicon' ), '</p>';
			echo $args['after_widget'];
			return;
		}

		$atts['link']    = silicon_vc_build_link( array( 'url' => esc_url( $instance['link'] ) ) );
		$atts['is_full'] = 'enable'; // button always full-width

		// icon preparations
		if ( ! empty( $atts['icon'] ) ) {
            $lib = $this->get_icon_library( $atts['icon'] );

			$atts['is_icon']      = 'enable';
			$atts['icon_library'] = $lib;
			$atts['icon_' . $lib] = esc_attr( $atts['icon'] );
			unset( $atts['icon'], $lib );
		}

		// build a shortcode
		$shortcode = silicon_shortcode_build( 'silicon_button', $atts );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		echo silicon_do_shortcode( $shortcode );
		echo '<span class="text-sm text-gray">', nl2br( wp_kses( trim( $instance['description'] ), $this->allowed_html() ) ), '</span>';
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
				<?php echo esc_html__( 'Description', 'silicon' ); ?>
			</label>
			<textarea class="widefat"
			          name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"
			          id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
			><?php echo esc_textarea( $instance['description'] ); ?></textarea>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
				<?php echo esc_html__( 'Button Text', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['text'] ) ); ?>">
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>">
				<?php echo esc_html__( 'Link', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['link'] ) ); ?>">
			<span class="description"><?php echo esc_html__( 'Enter the button link here.', 'silicon' ); ?></span>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
				<?php echo esc_html__( 'Type', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"
			>
				<option value="solid" <?php selected( 'solid', $instance['type'] ); ?>><?php esc_html_e( 'Solid', 'silicon' ); ?></option>
				<option value="ghost" <?php selected( 'ghost', $instance['type'] ); ?>><?php esc_html_e( 'Ghost', 'silicon' ); ?></option>
				<option value="link" <?php selected( 'link', $instance['type'] ); ?>><?php esc_html_e( 'Link', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>">
				<?php echo esc_html__( 'Shape', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'shape' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'shape' ) ); ?>"
			>
                <option value="pill" <?php selected( 'pill', $instance['shape'] ); ?>><?php esc_html_e( 'Pill', 'silicon' ); ?></option>
                <option value="rounded" <?php selected( 'rounded', $instance['shape'] ); ?>><?php esc_html_e( 'Rounded', 'silicon' ); ?></option>
                <option value="square" <?php selected( 'square', $instance['shape'] ); ?>><?php esc_html_e( 'Square', 'silicon' ); ?></option>
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
				<option value="default" <?php selected( 'default', $instance['color'] ); ?>><?php esc_html_e( 'Default', 'silicon' ); ?></option>
				<option value="primary" <?php selected( 'primary', $instance['color'] ); ?>><?php esc_html_e( 'Primary', 'silicon' ); ?></option>
				<option value="success" <?php selected( 'success', $instance['color'] ); ?>><?php esc_html_e( 'Success', 'silicon' ); ?></option>
				<option value="info" <?php selected( 'info', $instance['color'] ); ?>><?php esc_html_e( 'Info', 'silicon' ); ?></option>
				<option value="warning" <?php selected( 'warning', $instance['color'] ); ?>><?php esc_html_e( 'Warning', 'silicon' ); ?></option>
				<option value="danger" <?php selected( 'danger', $instance['color'] ); ?>><?php esc_html_e( 'Danger', 'silicon' ); ?></option>
				<option value="white" <?php selected( 'white', $instance['color'] ); ?>><?php esc_html_e( 'White', 'silicon' ); ?></option>
				<option value="gradient" <?php selected( 'gradient', $instance['color'] ); ?>><?php esc_html_e( 'Gradient', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>">
				<?php echo esc_html__( 'Size', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"
			>
                <option value="sm" <?php selected( 'sm', $instance['size'] ); ?>><?php esc_html_e( 'Small', 'silicon' ); ?></option>
                <option value="nl" <?php selected( 'nl', $instance['size'] ); ?>><?php esc_html_e( 'Normal', 'silicon' ); ?></option>
                <option value="lg" <?php selected( 'lg', $instance['size'] ); ?>><?php esc_html_e( 'Large', 'silicon' ); ?></option>
            </select>
		</div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>">
				<?php echo esc_html__( 'Icon', 'silicon' ); ?>
            </label>
			<?php
			if ( defined( 'EQUIP_VERSION' ) ) :
				$sources = array(
					'silicon' => esc_html__( 'Silicon Icons', 'silicon' ),
					'socicon' => esc_html__( 'Social Icons', 'silicon' ),
				);
				printf( '<input type="text" class="equip-icon" id="%s" name="%s" value="%s" data-source=\'%s\'>',
					esc_attr( $this->get_field_id( 'icon' ) ),
					esc_attr( $this->get_field_name( 'icon' ) ),
					esc_attr( trim( $instance['icon'] ) ),
					json_encode( $sources )
				);
				unset( $sources );
			else :
				echo '<p>', esc_html__( 'This field requires Equip plugin.', 'silicon' ), '</p>';
			endif;
			?>
        </div>

		<?php if ( defined( 'EQUIP_VERSION' ) ) : ?>
            <div class="silicon-widget-form-group">
                <label for="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>">
					<?php echo esc_html__( 'Icon Position', 'silicon' ); ?>
                </label>
                <select class="widefat"
                        name="<?php echo esc_attr( $this->get_field_name( 'icon_position' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>"
                >
                    <option value="left" <?php selected( 'left', $instance['icon_position'] ); ?>><?php esc_html_e( 'Left', 'silicon' ); ?></option>
                    <option value="right" <?php selected( 'right', $instance['icon_position'] ); ?>><?php esc_html_e( 'Right', 'silicon' ); ?></option>
                </select>
            </div>
		<?php endif; ?>

		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'is_waves' ) ); ?>">
				<?php echo esc_html__( 'Waves', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'is_waves' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'is_waves' ) ); ?>"
			>
				<option value="disable" <?php selected( 'disable', $instance['is_waves'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
				<option value="enable" <?php selected( 'enable', $instance['is_waves'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'waves_skin' ) ); ?>">
				<?php echo esc_html__( 'Waves Color', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'waves_skin' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'waves_skin' ) ); ?>"
			>
				<option value="light" <?php selected( 'light', $instance['waves_skin'] ); ?>><?php esc_html_e( 'Light', 'silicon' ); ?></option>
				<option value="dark" <?php selected( 'dark', $instance['waves_skin'] ); ?>><?php esc_html_e( 'Dark', 'silicon' ); ?></option>
			</select>
		</div>
		<div class="silicon-widget-form-group">
			<label for="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>">
				<?php echo esc_html__( 'Custom class', 'silicon' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'class' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'class' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['class'] ) ); ?>">
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

		$instance['title']         = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['description']   = wp_kses( $new_instance['description'], $this->allowed_html() );
		$instance['text']          = sanitize_text_field( trim( $new_instance['text'] ) );
		$instance['link']          = esc_url_raw( trim( $new_instance['link'] ) );
		$instance['type']          = sanitize_key( $new_instance['type'] );
		$instance['shape']         = sanitize_key( $new_instance['shape'] );
		$instance['color']         = sanitize_key( $new_instance['color'] );
		$instance['size']          = sanitize_key( $new_instance['size'] );
		$instance['icon']          = esc_attr( trim( $new_instance['icon'] ) );
		$instance['icon_position'] = sanitize_key( $new_instance['icon_position'] );
		$instance['is_waves']      = sanitize_key( $new_instance['is_waves'] );
		$instance['waves_skin']    = sanitize_key( $new_instance['waves_skin'] );
		$instance['class']         = esc_attr( $new_instance['class'] );

		return $instance;
	}

	/**
	 * Return the allowed HTML for description field
	 *
	 * @see wp_kses()
	 *
	 * @return array
	 */
	private function allowed_html() {
		return array(
			'a'      => array( 'href' => true, 'target' => true, 'rel' => true, 'class' => true ),
			'i'      => array( 'class' => true ),
			'span'   => array( 'class' => true ),
			'em'     => true,
			'strong' => true,
			'br'     => true,
		);
	}

	/**
	 * Detects the icon library by provided icon class
	 *
	 * @param string $icon Icon, provided by user
	 *
	 * @return string
	 */
	private function get_icon_library( $icon ) {
		preg_match( '/(fa fa-|si si-|socicon-|material-icons)(.+)/', $icon, $match );
		$libs = array(
			'fa fa-'         => 'fontawesome',
			'si si-'         => 'silicon',
			'socicon-'       => 'socicon',
			'material-icons' => 'material',
		);

		// if icon found in $libs array use a special slug,
		// otherwise we will assume user provide a custom icon
		if ( ! empty( $match[1] ) && array_key_exists( $match[1], $libs ) ) {
			$lib = $libs[ $match[1] ];
		} else {
			$lib = 'custom';
		}

		return $lib;
	}
}
