<?php

/**
 * Widget "Silicon Contacts"
 *
 * Display the contacts
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Contacts extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'silicon_contacts';

	/**
     * Default widget settings
     *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Display the contacts.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Contacts', 'silicon' ), $opts );

		$this->defaults = array(
			'title'     => '',
			'l_addr'    => esc_html__( 'Find Us', 'silicon' ),
			'addr'      => '',
			'addr_link' => '',
			'l_phone'   => esc_html__( 'Call Us', 'silicon' ),
			'phone'     => '',
			'is_call'   => 'disable',
			'l_email'   => esc_html__( 'Write Us', 'silicon' ),
			'email'     => '',
			'is_mail'   => 'disable',
			'color'     => 'white',
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

		// prepare data

		$color = esc_attr( $instance['color'] );
		$items = array();

		if ( ! empty( $instance['addr'] ) ) {
			$address = nl2br( strip_tags( stripslashes( trim( $instance['addr'] ) ) ) );

			if ( ! empty( $instance['addr_link'] ) ) {
				$address = sprintf( '<a href="%s" class="contact-info font-family-body">%s</a>',
					esc_url( $instance['addr_link'] ), $address
				);
			} else {
				$address = '<span class="contact-info font-family-body">' . $address . '</span>';
			}

			$r = array(
				'{color}'   => $color,
				'{label}'   => esc_html( $instance['l_addr'] ),
				'{address}' => $address,
			);

			$items[] = str_replace( array_keys($r), array_values($r), '
			<li>
				<i class="si si-location background-{color}"></i>
				<span class="contact-label">{label}</span>
				{address}
			</li>
			');

			unset( $address, $r );
		}

		if ( ! empty( $instance['phone'] ) ) {
			$is_active = ( 'enable' === $instance['is_call'] );
			$phone     = array_map( function ( $phone ) use ( $is_active ) {
				$phone = esc_attr( trim( $phone ) );
				if ( $is_active ) {
					return sprintf( '<a href="tel:%1$s" class="contact-info font-family-body">%2$s</a>',
						preg_replace('/\s+/', '', $phone ),
                        $phone
                    );
				}

				return '<span class="contact-info font-family-body">' . esc_attr( $phone ) . '</span>';
			}, explode( "\n", $instance['phone'] ) );

			$r = array(
				'{color}' => $color,
				'{label}' => esc_html( $instance['l_phone'] ),
				'{phone}' => implode( '', $phone ),
			);

			$items[] = str_replace( array_keys( $r ), array_values( $r ), '
			<li>
				<i class="si si-phone background-{color}"></i>
				<span class="contact-label font-family-nav">{label}</span>
				{phone}
			</li>
			' );

			unset( $is_active, $phone, $r );
		}

		if ( ! empty( $instance['email'] ) ) {
			$is_active = ( 'enable' === $instance['is_mail'] );
			$email     = array_map( function ( $mail ) use ( $is_active ) {
				$mail = esc_attr( trim( $mail ) );

				if ( $is_active ) {
					return sprintf( '<a href="mailto:%1$s" class="contact-info font-family-body">%1$s</a>', $mail );
				}

				return '<span class="contact-info font-family-body">' . $mail . '</span>';
			}, explode( "\n", $instance['email'] ) );

			$r = array(
				'{color}' => $color,
				'{label}' => esc_html( $instance['l_email'] ),
				'{email}' => implode( '', $email ),
			);

			$items[] = str_replace( array_keys( $r ), array_values( $r ), '
			<li>
				<i class="si si-email-black background-{color}"></i>
				<span class="contact-label font-family-nav">{label}</span>
				{email}
			</li>
			' );

			unset( $is_active, $email, $r );
		}

		// output

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		echo '<ul>', implode( '', $items ), '</ul>';
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
            <label for="<?php echo esc_attr( $this->get_field_id( 'addr' ) ); ?>">
		        <?php echo esc_html__( 'Address', 'silicon' ); ?>
            </label>
            <input type="text" class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'l_addr' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'l_addr' ) ); ?>"
                   value="<?php echo esc_html( trim( $instance['l_addr'] ) ); ?>"
                   placeholder="<?php echo esc_html__( 'Address label', 'silicon' ); ?>">
        </div>
        <div class="silicon-widget-form-group">
            <textarea class="widefat"
                      id="<?php echo esc_attr( $this->get_field_id( 'addr' ) ); ?>"
                      name="<?php echo esc_attr( $this->get_field_name( 'addr' ) ); ?>"
                      placeholder="<?php echo esc_html__( 'Your address', 'silicon' ); ?>"
            ><?php echo esc_textarea( trim( $instance['addr'] ) ); ?></textarea>
            <p class="description"><?php echo esc_html__( 'This field supports only one address.', 'silicon' ); ?></p>
        </div>
        <div class="silicon-widget-form-group">
            <input type="text" class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'addr_link' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'addr_link' ) ); ?>"
                   value="<?php echo esc_url( trim( $instance['addr_link'] ) ); ?>"
                   placeholder="<?php echo esc_html__( 'Address Link', 'silicon' ); ?>">
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>">
				<?php echo esc_html__( 'Phone', 'silicon' ); ?>
            </label>
            <input type="text" class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'l_phone' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'l_phone' ) ); ?>"
                   value="<?php echo esc_html( trim( $instance['l_phone'] ) ); ?>"
                   placeholder="<?php echo esc_html__( 'Phone label', 'silicon' ); ?>">
        </div>
        <div class="silicon-widget-form-group">
            <textarea class="widefat"
                      id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"
                      name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>"
                      placeholder="<?php echo esc_html__( 'Your phone', 'silicon' ); ?>"
            ><?php echo esc_textarea( trim( $instance['phone'] ) ); ?></textarea>
            <p class="description"><?php echo esc_html__( 'You can add as many phones as you wish, every item on new line.', 'silicon' ); ?></p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'is_call' ) ); ?>">
                <input type="checkbox"
                       id="<?php echo esc_attr( $this->get_field_id( 'is_call' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'is_call' ) ); ?>"
                       value="enable" <?php checked( 'enable', $instance['is_call'] ); ?>
                >
		        <?php echo esc_html__( 'Make clickable', 'silicon' ); ?>
            </label>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>">
				<?php echo esc_html__( 'Email', 'silicon' ); ?>
            </label>
            <input type="text" class="widefat"
                   id="<?php echo esc_attr( $this->get_field_id( 'l_email' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'l_email' ) ); ?>"
                   value="<?php echo esc_html( trim( $instance['l_email'] ) ); ?>"
                   placeholder="<?php echo esc_html__( 'Email label', 'silicon' ); ?>">
        </div>
        <div class="silicon-widget-form-group">
            <textarea class="widefat"
                      id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"
                      name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>"
                      placeholder="<?php echo esc_html__( 'Your email', 'silicon' ); ?>"
            ><?php echo esc_textarea( trim( $instance['email'] ) ); ?></textarea>
            <p class="description"><?php echo esc_html__( 'You can add as many emails as you wish, every item on new line.', 'silicon' ); ?></p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'is_mail' ) ); ?>">
                <input type="checkbox"
                       id="<?php echo esc_attr( $this->get_field_id( 'is_mail' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'is_mail' ) ); ?>"
                       value="enable" <?php checked( 'enable', $instance['is_mail'] ); ?>
                >
		        <?php echo esc_html__( 'Make clickable', 'silicon' ); ?>
            </label>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>">
				<?php echo esc_html__( 'Icon Color', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>">
                <option value="white" <?php selected( 'white', $instance['color'] ); ?>><?php esc_html_e( 'White', 'silicon' ); ?></option>
                <option value="dark" <?php selected( 'dark', $instance['color'] ); ?>><?php esc_html_e( 'Dark', 'silicon' ); ?></option>
                <option value="primary" <?php selected( 'primary', $instance['color'] ); ?>><?php esc_html_e( 'Primary', 'silicon' ); ?></option>
                <option value="info" <?php selected( 'info', $instance['color'] ); ?>><?php esc_html_e( 'Info', 'silicon' ); ?></option>
                <option value="success" <?php selected( 'success', $instance['color'] ); ?>><?php esc_html_e( 'Success', 'silicon' ); ?></option>
                <option value="warning" <?php selected( 'warning', $instance['color'] ); ?>><?php esc_html_e( 'Warning', 'silicon' ); ?></option>
                <option value="danger" <?php selected( 'danger', $instance['color'] ); ?>><?php esc_html_e( 'Danger', 'silicon' ); ?></option>
                <option value="gradient" <?php selected( 'gradient', $instance['color'] ); ?>><?php esc_html_e( 'Gradient', 'silicon' ); ?></option>
            </select>
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

		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		$instance['l_addr']    = sanitize_text_field( $new_instance['l_addr'] );
		$instance['addr']      = esc_textarea( trim( $new_instance['addr'] ) );
		$instance['addr_link'] = esc_url_raw( trim( $new_instance['addr_link'] ) );
		$instance['l_phone']   = sanitize_text_field( $new_instance['l_phone'] );
		$instance['phone']     = esc_textarea( trim( $new_instance['phone'] ) );
		$instance['is_call']   = isset( $new_instance['is_call'] ) ? 'enable' : 'disable';
		$instance['l_email']   = sanitize_text_field( $new_instance['l_email'] );
		$instance['email']     = esc_textarea( trim( $new_instance['email'] ) );
		$instance['is_mail']   = isset( $new_instance['is_mail'] ) ? 'enable' : 'disable';
		$instance['color']     = esc_attr( $new_instance['color'] );

		return $instance;
	}
}
