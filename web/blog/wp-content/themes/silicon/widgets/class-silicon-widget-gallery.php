<?php

/**
 * Widget "Silicon Gallery"
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Gallery extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_gallery';

	/**
	 * Widget default values
	 *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Simple image gallery with button for general purposes.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Gallery', 'silicon' ), $opts );

		$this->defaults = array(
			'title'         => '',
			'images'        => '',
			'is_caption'    => 'enable',
			'grid_type'     => 'grid-with-gap',
			'columns'       => 3,
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
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );

		if ( empty( $instance['images'] ) ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			echo '<p>', esc_html__( 'Please provide some images to make this widget works.', 'silicon' ), '</p>';
			echo $args['after_widget'];

			return;
		}

		/* Prepare button shortcode */

		$button = '';
		if ( ! empty( $instance['link'] ) ) {
			$atts = $instance;
			unset( $atts['title'], $atts['images'] );

			$atts['link']    = silicon_vc_build_link( array( 'url' => esc_url( $instance['link'] ) ) );
			$atts['is_full'] = 'enable'; // in widgets button always full-width

			// icon preparations
			if ( ! empty( $atts['icon'] ) ) {
				$lib = $this->get_icon_library( $atts['icon'] );

				$atts['is_icon']        = 'enable';
				$atts['icon_library']   = $lib;
				$atts[ 'icon_' . $lib ] = esc_attr( $atts['icon'] );
				unset( $atts['icon'], $lib );
			}

			// build a shortcode
			$button = silicon_shortcode_build( 'silicon_button', $atts );
			unset( $atts );
		}

		/* Prepare gallery shortcode */

		$gallery = silicon_shortcode_build( 'silicon_gallery', array(
			'images'     => $instance['images'],
			'is_caption' => $instance['is_caption'],
			'grid_type'  => $instance['grid_type'],
			'columns'    => $instance['columns'],
		) );

		/* Start output */

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		echo silicon_do_shortcode( $gallery );
		echo silicon_do_shortcode( $button );
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'images' ) ); ?>">
				<?php echo esc_html__( 'Images', 'silicon' ); ?>
            </label>
			<?php
			if ( defined( 'EQUIP_VERSION' ) ) :
				// prepare preview for media field
				if ( ! empty( $instance['images'] ) ) {
					$images  = explode( ',', $instance['images'] );
					$preview = array_map( function ( $attachment_id ) {
						return esc_url( silicon_get_image_src( $attachment_id, 'medium' ) );
					}, (array) $images );
					unset( $images );
				} else {
					$preview = '';
				}

				$attr = array(
					'type'          => 'hidden',
					'class'         => 'silicon-widget-gallery',
					'id'            => esc_attr( $this->get_field_id( 'images' ) ),
					'name'          => esc_attr( $this->get_field_name( 'images' ) ),
					'value'         => trim( $this->sanitize_images( $instance['images'] ) ),
					'data-preview'  => $preview,
					'data-multiple' => 'true',
					'data-sortable' => 'true',
					'data-title'    => esc_html__( 'Select images for Gallery widget', 'silicon' ),
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'is_caption' ) ); ?>">
				<?php echo esc_html__( 'Add captions?', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'is_caption' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'is_caption' ) ); ?>"
            >
                <option value="enable" <?php selected( 'enable', $instance['is_caption'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
                <option value="disable" <?php selected( 'disable', $instance['is_caption'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
            </select>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'grid_type' ) ); ?>">
				<?php echo esc_html__( 'Grid Type', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'grid_type' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'grid_type' ) ); ?>"
            >
                <option value="grid-with-gap" <?php selected( 'grid-with-gap', $instance['grid_type'] ); ?>><?php esc_html_e( 'Grid with Gap', 'silicon' ); ?></option>
                <option value="grid-no-gap" <?php selected( 'grid-no-gap', $instance['grid_type'] ); ?>><?php esc_html_e( 'Grid no Gap', 'silicon' ); ?></option>
            </select>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>">
				<?php echo esc_html__( 'Columns', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'columns' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'columns' ) ); ?>"
            >
                <option value="1" <?php selected( '1', $instance['columns'] ); ?>>1</option>
                <option value="2" <?php selected( '2', $instance['columns'] ); ?>>2</option>
                <option value="3" <?php selected( '3', $instance['columns'] ); ?>>3</option>
            </select>
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
				// icon sources, used for Icon field
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
		$instance['images']        = $this->sanitize_images( $new_instance['images'] );
		$instance['is_caption']    = esc_attr( $new_instance['is_caption'] );
		$instance['grid_type']     = esc_attr( $new_instance['grid_type'] );
		$instance['columns']       = absint( $new_instance['columns'] );
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
	 * Sanitize the provided image IDs.
	 *
	 * IDs should be comma-separated
	 *
	 * @param string $images
	 *
	 * @return string
	 */
	private function sanitize_images( $images ) {
		$images = explode( ',', $images );
		$images = array_filter( $images, 'is_numeric' );
		$images = array_map( 'absint', $images );
		$images = array_filter( $images );

		return implode( ',', $images );
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
