<?php

/**
 * Widget "Silicon Author"
 *
 * Display the Author information
 *
 * @uses WP_Widget
 */
class Silicon_Widget_Author extends WP_Widget {

	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	protected $widget_id = 'silicon_author';

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
		$widget_opts = array( 'description' => esc_html__( 'Display the information about the author.', 'silicon' ) );
		parent::__construct( $this->widget_id, esc_html__( 'Silicon Author', 'silicon' ), $widget_opts );

		add_action( 'profile_update', array( $this, 'flush' ) );
		add_action( 'user_register', array( $this, 'flush' ) );
		add_action( 'switch_theme', array( $this, 'flush' ) );

		$this->defaults = array(
			'title'  => '',
			'author' => 0,
		);
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$cached   = array();
		$is_cache = apply_filters( 'silicon_widget_author_is_cache', ! $this->is_preview() );

		if ( $is_cache ) {
			$cached = wp_cache_get( $this->widget_id, $this->group );
			if ( false !== $cached && is_array( $cached ) && array_key_exists( $this->id, $cached ) ) {
				echo silicon_content_decode( $cached[ $this->id ] );

				return;
			}
		}

		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );

		/** @var WP_User $author */
		$author = get_user_by( 'id', (int) $instance['author'] );
		if ( false === $author ) {
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}

			echo '<p>', esc_html__( 'It seems provided user not found.', 'silicon' ), '</p>';
			echo $args['after_widget'];

			return;
		}

		$link = get_author_posts_url( $author->ID, $author->user_nicename );

		// @see inc/user.php
		$meta = wp_parse_args( get_user_meta( $author->ID, 'silicon_additions', true ), array(
			'avatar'   => 0,
			'cover'    => 0,
			'position' => 0,
			'socials'  => '',
		) );

		// socials
		if ( ! empty( $meta['socials'] ) ) {
			$socials = silicon_shortcode_build( 'silicon_socials', array(
				'socials'   => $this->convert_socials( $meta['socials'] ),
				'color'     => 'brand',
				'shape'     => 'no',
				'alignment' => 'left',
			) );
		} else {
		    $socials = '';
        }

        /* Start output */

		ob_start();

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		?>
        <div class="silicon-author border-default">
            <div class="silicon-author-cover"
                 style="<?php echo sprintf( 'background-image: url(%s);', silicon_get_image_src( (int) $meta['cover'] ) ); ?>">
            </div>
            <div class="silicon-author-info font-family-nav">
                <a href="<?php echo esc_url( $link ); ?>" class="silicon-author-avatar">
                    <?php echo wp_get_attachment_image( (int) $meta['avatar'], 'full' ); ?>
                </a>
                <div class="silicon-author-about">
                    <?php
                    echo sprintf( '<a href="%s" class="silicon-author-name navi-link-color navi-link-hover-color">%s</a>', esc_url( $link ), esc_html( $author->display_name ) );
                    echo silicon_get_text( esc_html( $meta['position'] ), '<span class="silicon-author-position">', '</span>' );
                    ?>
                </div>
            </div>
            <div class="silicon-author-footer">
                <?php
                echo silicon_get_text( esc_html( $author->description ), '<p>', '</p>' );
                echo silicon_do_shortcode( $socials );
                ?>
            </div>
        </div>
        <?php

		echo $args['after_widget'];

		if ( $is_cache ) {
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>">
				<?php echo esc_html__( 'Author', 'silicon' ); ?>
			</label>
			<select class="widefat"
			        name="<?php echo esc_attr( $this->get_field_name( 'author' ) ); ?>"
			        id="<?php echo esc_attr( $this->get_field_id( 'author' ) ); ?>">
				<?php
				/** @var WP_User $user */
				foreach ( get_users() as $user ) : ?>
					<option value="<?php echo (int) $user->ID; ?>" <?php selected( $user->ID, $instance['author'] ); ?>>
                        <?php echo esc_html( $user->display_name ); ?>
                    </option>
				<?php endforeach; ?>
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

		$instance['title']  = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['author'] = absint( $new_instance['author'] );

		$this->flush();

		return $instance;
	}

	/**
	 * Flush the cache
	 */
	public function flush() {
		wp_cache_delete( $this->widget_id, $this->group );
	}

	/**
	 * Returns socials for "silicon_socials" shortcode in the appropriate format
	 *
	 * @param array $socials A network=>url pairs
	 *
	 * @return string
	 */
	protected function convert_socials( $socials ) {
		$converted = array();
		foreach ( (array) $socials as $network => $url ) {
			$converted[] = array( 'network' => $network, 'url' => $url );
		}
		unset( $network, $url );

		return urlencode( json_encode( $converted ) );
	}
}