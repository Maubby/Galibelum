<?php

/**
 * Widget "Silicon Recent Posts"
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Recent_Posts extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'silicon_recent_posts';

	/**
	 * Group for cached widgets
	 *
	 * @var string
	 */
	private $group = 'silicon_widgets';

	/**
	 * Widget default values
	 *
	 * @var array
	 */
	protected $defaults = array();

	public function __construct() {
		$widget_options = array( 'description' => esc_html__( 'Your site\'s most recent Posts.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Recent Posts', 'silicon' ), $widget_options );

		add_action( 'save_post', array( $this, 'flush' ) );
		add_action( 'deleted_post', array( $this, 'flush' ) );
		add_action( 'switch_theme', array( $this, 'flush' ) );

		$this->defaults = array(
			'title'    => '',
			'number'   => 3,
			'category' => 'all',
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
			echo silicon_content_decode( $cached[ $this->id ] );

			return;
		}

		if ( ! is_array( $cached ) ) {
			$cached = array();
		}

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$number   = false === (bool) $instance['number'] ? 3 : (int) $instance['number'];
		$category = ( 'all' === $instance['category'] || empty( $instance['category'] ) ) ? '' : absint( $instance['category'] );

		/**
		 * Filter the argument for querying Recent Posts widget
		 *
		 * @since 1.0.0
		 *
		 * @param array $args An array of arguments for WP_Query
		 */
		$query = new WP_Query( apply_filters( 'silicon_widget_recent_posts_query_args', array(
			'cat'                 => $category,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'suppress_filters'    => true,
			'posts_per_page'      => $number,
			'ignore_sticky_posts' => true,
		) ) );

		if ( ! $query->have_posts() ) {
			return;
		}

		ob_start();

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'template-parts/widgets/recent-post' );
		}

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

		$categories = get_terms( array(
			'taxonomy'     => 'category',
			'hide_empty'   => false,
			'hierarchical' => false,
		) );

		if ( empty( $categories ) || is_wp_error( $categories ) ) {
			$categories = array();
		}

		$data = array();
		foreach ( $categories as $category ) {
			$data[] = array(
				'label' => $category->name,
				'value' => $category->slug,
			);
		}
		unset( $category );
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
			       value="<?php echo esc_attr( $instance['number'] ); ?>">
		</div>
        <div class="silicon-widget-form-group">
            <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
				<?php echo esc_html__( 'Category', 'silicon' ); ?>
            </label>
            <select class="widefat"
                    name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
                <option value="all"><?php esc_html_e( 'All', 'silicon' ); ?></option>
				<?php
				/** @var WP_Term $category */
				foreach ( (array) $categories as $category ) :
                    echo sprintf( '<option value="%1$s" %3$s>%2$s</option>',
	                    (int) $category->term_id,
	                    esc_html( $category->name ),
	                    selected( $category->term_id, $instance['category'], false )
                    );
                endforeach;
                ?>
            </select>
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

		$instance['title']    = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['number']   = absint( $new_instance['number'] );
		$instance['category'] = absint( $new_instance['category'] );

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