<?php

/**
 * Overrides the bbPress Login widget
 *
 * @see    BBP_Login_Widget
 * @author 8guild
 */
class Silicon_Widget_BBP_Login extends BBP_Login_Widget {

	public function __construct() {
		parent::__construct();
		$this->id_base     = 'bbp_login_widget';
		$this->option_name = 'widget_bbp_login_widget';
	}

	/**
	 * Displays the output, the login form
	 *
	 * @since bbPress (r2827)
	 *
	 * @param mixed $args Arguments
	 * @param array $instance Instance
	 * @uses apply_filters() Calls 'bbp_login_widget_title' with the title
	 * @uses get_template_part() To get the login/logged in form
	 */
	public function widget( $args = array(), $instance = array() ) {

		// Get widget settings
		$settings = $this->parse_settings( $instance );

		// Typical WordPress filter
		$settings['title'] = apply_filters( 'widget_title', $settings['title'], $instance, $this->id_base );

		// bbPress filters
		$settings['title']    = apply_filters( 'bbp_login_widget_title',    $settings['title'],    $instance, $this->id_base );
		$settings['register'] = apply_filters( 'bbp_login_widget_register', $settings['register'], $instance, $this->id_base );
		$settings['lostpass'] = apply_filters( 'bbp_login_widget_lostpass', $settings['lostpass'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( !empty( $settings['title'] ) ) {
			echo $args['before_title'] . $settings['title'] . $args['after_title'];
		}

		if ( !is_user_logged_in() ) : ?>

			<form method="post" action="<?php bbp_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="bbp-login-form">
				<fieldset>
					<legend><?php esc_html_e( 'Log In', 'silicon' ); ?></legend>

					<div class="bbp-username">
						<label for="user_login"><?php esc_html_e( 'Username', 'silicon' ); ?>: </label>
						<input type="text" name="log"
						       value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>"
						       size="20"
						       id="user_login"
						       class="input-rounded"
						       tabindex="<?php bbp_tab_index(); ?>" />
					</div>

					<div class="bbp-password">
						<label for="user_pass"><?php esc_html_e( 'Password', 'silicon' ); ?>: </label>
						<input type="password" name="pwd"
						       value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>"
						       size="20"
						       id="user_pass"
						       class="input-rounded"
						       tabindex="<?php bbp_tab_index(); ?>" />
					</div>

					<div class="bbp-remember-me">
						<input type="checkbox" name="rememberme" value="forever" <?php checked( bbp_get_sanitize_val( 'rememberme', 'checkbox' ), true, true ); ?> id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
						<label for="rememberme"><?php esc_html_e( 'Remember Me', 'silicon' ); ?></label>
					</div>

					<div class="bbp-submit-wrapper">

						<?php do_action( 'login_form' ); ?>

						<button type="submit" name="user-submit" id="user-submit" tabindex="<?php bbp_tab_index(); ?>"
						        class="btn btn-solid btn-rounded btn-sm btn-primary user-submit"><?php esc_html_e( 'Log In', 'silicon' ); ?></button>

						<?php bbp_user_login_fields(); ?>

					</div>

					<?php if ( !empty( $settings['register'] ) || !empty( $settings['lostpass'] ) ) : ?>

						<div class="bbp-login-links font-family-nav" style="padding-top: 10px;">

							<?php if ( !empty( $settings['register'] ) ) : ?>

								<a href="<?php echo esc_url( $settings['register'] ); ?>"
								   title="<?php esc_attr_e( 'Register', 'silicon' ); ?>"
								   class="bbp-register-link navi-link-color navi-link-hover-color text-sm"
								   style="display: inline-block; vertical-align: middle; margin-right: 8px;"
								><?php esc_html_e( 'Register', 'silicon' ); ?></a>

							<?php endif; ?>

							<?php if ( !empty( $settings['lostpass'] ) ) : ?>

								<a href="<?php echo esc_url( $settings['lostpass'] ); ?>"
								   title="<?php esc_attr_e( 'Lost Password', 'silicon' ); ?>"
								   class="bbp-lostpass-link navi-link-color navi-link-hover-color text-sm"
								   style="display: inline-block; vertical-align: middle;"
								><?php esc_html_e( 'Lost Password', 'silicon' ); ?></a>

							<?php endif; ?>

						</div>

					<?php endif; ?>

				</fieldset>
			</form>

		<?php else : ?>

			<div class="bbp-logged-in font-family-nav">
				<a href="<?php bbp_user_profile_url( bbp_get_current_user_id() ); ?>"
				   class="submit user-submit"
				><?php echo get_avatar( bbp_get_current_user_id(), '40' ); ?></a>
				<h6 class="margin-bottom-none"><?php bbp_user_profile_link( bbp_get_current_user_id() ); ?></h6>
				<?php bbp_logout_link(); ?>
			</div>

		<?php endif;

		echo $args['after_widget'];
	}
}