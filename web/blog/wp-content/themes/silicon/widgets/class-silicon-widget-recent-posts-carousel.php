<?php

/**
 * Widget "Silicon Recent Posts Carousel"
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Recent_Posts_Carousel extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_recent_posts_carousel';

	/**
	 * Group for cached widgets
	 *
	 * @var string
	 */
	protected $group = 'silicon_widgets';

	/**
     * Widget default values
     *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$widget_options = array( 'description' => esc_html__( 'Your site\'s most recent Posts in Carousel.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Recent Posts Carousel', 'silicon' ), $widget_options );

		add_action( 'save_post', array( $this, 'flush' ) );
		add_action( 'deleted_post', array( $this, 'flush' ) );
		add_action( 'switch_theme', array( $this, 'flush' ) );

		$this->defaults = array(
			'title'   => '',
			'number'  => 4,
			'is_loop' => 'disable',
			'is_auto' => 'disable',
			'timeout' => 3000,
		);
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$cached = false;
		if ( ! $this->is_preview() ) {
			$cached = wp_cache_get( $this->widget_id, $this->group );
		}

		if ( is_array( $cached ) && array_key_exists( $this->id, $cached ) ) {
			wp_enqueue_script( 'owl-carousel' );
			echo silicon_content_decode( $cached[ $this->id ] );

			return;
		}

		if ( ! is_array( $cached ) ) {
			$cached = array();
		}

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$number   = false === (bool) $instance['number'] ? 3 : (int) $instance['number'];

		/**
		 * Filter the argument for querying Recent Posts widget
		 *
		 * @param array                                $args     An array of arguments for WP_Query
		 * @param array                                $instance Current widget settings
		 * @param Silicon_Widget_Recent_Posts_Carousel $widget   Current widget object
		 */
		$query = new WP_Query( apply_filters( 'silicon_widget_recent_posts_carousel_query_args', array(
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'suppress_filters'    => true,
			'posts_per_page'      => $number,
			'ignore_sticky_posts' => true,
		), $instance, $this ) );

		/* Message to user in case of no posts */

		if ( ! $query->have_posts() ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			printf(
				wp_kses(
					__( '<p>Posts not found. Ready to publish your first post? <a href="%s">Click here</a>.</p>', 'silicon' ),
					array( 'a' => array( 'href' => true ), 'p' => array() )
				),
				esc_url( admin_url( 'post-new.php' ) )
			);
			echo $args['after_widget'];

			return;
		}

		/* Carousel settings */

		/**
		 * Filter the Recent Posts carousel options. Based on owlCarousel.js
		 *
		 * @param array                                $carousel owlCarousel options
		 * @param array                                $instance Current widget settings
		 * @param Silicon_Widget_Recent_Posts_Carousel $widget   Current widget object
		 */
		$owl = apply_filters( 'silicon_widget_recent_posts_carousel_owl', array(
			'items'           => 1,
			'loop'            => 'enable' === $instance['is_loop'],
			'autoplay'        => 'enable' === $instance['is_auto'],
			'autoplayTimeout' => absint( $instance['timeout'] ),
		), $instance, $this );

		$carousel = array(
			'class'            => 'owl-carousel',
			'data-si-carousel' => $owl,
		);

		ob_start();

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		echo '<div ', silicon_get_attr( $carousel ), '>';
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/widgets/recent-post' );
		}
		echo '</div>';

		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cached[ $this->id ] = silicon_content_encode( ob_get_flush() );
			wp_cache_set( $this->widget_id, $cached, $this->group );
		} else {
			ob_end_flush();
		}
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php echo esc_html__( 'Number of posts', 'silicon' ); ?>
			</label>
			<input type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
			       value="<?php echo absint( $instance['number'] ); ?>">
		</div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'is_loop' ) ); ?>">
				<?php echo esc_html__( 'Loop Mode', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'is_loop' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'is_loop' ) ); ?>"
            >
                <option value="enable" <?php selected( 'enable', $instance['is_loop'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
                <option value="disable" <?php selected( 'disable', $instance['is_loop'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
            </select>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'is_auto' ) ); ?>">
				<?php echo esc_html__( 'Auto Play', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'is_auto' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'is_auto' ) ); ?>"
            >
                <option value="enable" <?php selected( 'enable', $instance['is_auto'] ); ?>><?php esc_html_e( 'Enable', 'silicon' ); ?></option>
                <option value="disable" <?php selected( 'disable', $instance['is_auto'] ); ?>><?php esc_html_e( 'Disable', 'silicon' ); ?></option>
            </select>
        </div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'timeout' ) ); ?>">
				<?php echo esc_html__( 'Auto Play Timeout', 'silicon' ); ?>
            </label>
            <input type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'timeout' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'timeout' ) ); ?>"
                   value="<?php echo absint( $instance['timeout'] ); ?>">
        </div>
		<?php

		return true;
	}

	/**
	 * Update widget form
	 *
	 * @param array $new_instance New values
	 * @param array $old_instance Old values
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']   = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['number']  = absint( $new_instance['number'] );
		$instance['is_loop'] = sanitize_key( $new_instance['is_loop'] );
		$instance['is_auto'] = sanitize_key( $new_instance['is_auto'] );
		$instance['timeout'] = absint( $new_instance['timeout'] );

		$this->flush();

		return $instance;
	}

	/**
	 * Flush widget cache
	 */
	public function flush() {
		wp_cache_delete( $this->widget_id, $this->group );
	}
}