<?php
/**
 * bbPress User Profile Edit Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<form id="bbp-your-profile"
      action="<?php bbp_user_profile_edit_url( bbp_get_displayed_user_id() ); ?>"
      method="post"
      enctype="multipart/form-data"
>

	<?php do_action( 'bbp_user_edit_before' ); ?>

	<?php do_action( 'bbp_user_edit_before_name' ); ?>

    <div>
        <label for="first_name"><?php esc_html_e( 'First Name', 'silicon' ) ?></label>
        <input type="text" name="first_name" id="first_name"
               value="<?php bbp_displayed_user_field( 'first_name', 'edit' ); ?>" class="regular-text"
               tabindex="<?php bbp_tab_index(); ?>"/>
    </div>

    <div>
        <label for="last_name"><?php esc_html_e( 'Last Name', 'silicon' ) ?></label>
        <input type="text" name="last_name" id="last_name"
               value="<?php bbp_displayed_user_field( 'last_name', 'edit' ); ?>" class="regular-text"
               tabindex="<?php bbp_tab_index(); ?>"/>
    </div>

    <div>
        <label for="nickname"><?php esc_html_e( 'Nickname', 'silicon' ); ?></label>
        <input type="text" name="nickname" id="nickname"
               value="<?php bbp_displayed_user_field( 'nickname', 'edit' ); ?>" class="regular-text"
               tabindex="<?php bbp_tab_index(); ?>"/>
    </div>

    <div>
        <label for="display_name"><?php esc_html_e( 'Display Name', 'silicon' ) ?></label>
		<?php bbp_edit_user_display_name(); ?>
    </div>

	<?php do_action( 'bbp_user_edit_after_name' ); ?>

	<?php do_action( 'bbp_user_edit_before_contact' ); ?>

    <div>
        <label for="url"><?php esc_html_e( 'Website', 'silicon' ) ?></label>
        <input type="text" name="url" id="url"
               value="<?php bbp_displayed_user_field( 'user_url', 'edit' ); ?>"
               class="regular-text code" tabindex="<?php bbp_tab_index(); ?>">
    </div>

	<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

        <div>
            <label for="<?php echo esc_attr( $name ); ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
            <input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>"
                   value="<?php bbp_displayed_user_field( $name, 'edit' ); ?>" class="regular-text"
                   tabindex="<?php bbp_tab_index(); ?>">
        </div>

	<?php endforeach; ?>

	<?php do_action( 'bbp_user_edit_after_contact' ); ?>

	<?php do_action( 'bbp_user_edit_before_about' ); ?>

    <div>
        <label for="description"><?php esc_html_e( 'Biographical Info', 'silicon' ); ?></label>
        <textarea name="description" id="description" rows="5" cols="30"
                  tabindex="<?php bbp_tab_index(); ?>"
        ><?php bbp_displayed_user_field( 'description', 'edit' ); ?></textarea>
    </div>

	<?php do_action( 'bbp_user_edit_after_about' ); ?>

	<?php do_action( 'bbp_user_edit_before_account' ); ?>

    <div>
        <label for="user_login"><?php esc_html_e( 'Username', 'silicon' ); ?></label>
        <input type="text" name="user_login" id="user_login"
               value="<?php bbp_displayed_user_field( 'user_login', 'edit' ); ?>" disabled="disabled"
               class="regular-text" tabindex="<?php bbp_tab_index(); ?>"/>
    </div>

    <div>
        <label for="email"><?php esc_html_e( 'Email', 'silicon' ); ?></label>
        <input type="text" name="email" id="email"
               value="<?php bbp_displayed_user_field( 'user_email', 'edit' ); ?>" class="regular-text"
               tabindex="<?php bbp_tab_index(); ?>"/>

	    <?php
	    // Handle address change requests
	    $new_email = get_option( bbp_get_displayed_user_id() . '_new_email' );
	    if ( ! empty( $new_email ) && $new_email !== bbp_get_displayed_user_field( 'user_email', 'edit' ) ) : ?>
            <span class="updated inline">
                <?php
                printf(
	                wp_kses(
		                __( 'There is a pending email address change to <code>%1$s</code>. <a href="%2$s">Cancel</a>', 'silicon' ),
		                array( 'a' => array( 'href' => true ), 'code' => true )
	                ),
	                $new_email['newemail'],
	                esc_url( self_admin_url( 'user.php?dismiss=' . bbp_get_current_user_id() . '_new_email' ) )
                );
                ?>
            </span>
	    <?php endif; ?>

    </div>

    <div id="password">
        <div class="row password">
            <div class="col-sm-6">
                <label for="pass1"><?php esc_html_e( 'New Password', 'silicon' ); ?></label>
                <input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off"
                       tabindex="<?php bbp_tab_index(); ?>">
                <div id="pass-strength-result"></div>
                <span class="description"><?php esc_html_e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'silicon' ); ?></span>
            </div>
            <div class="col-sm-6">
                <label for="pass2"><?php esc_html_e( 'Repeat Password', 'silicon' ); ?></label>
                <input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off"
                       tabindex="<?php bbp_tab_index(); ?>">
                <span class="description indicator-hint"><?php esc_html_e( 'Your password should be at least ten characters long. Use upper and lower case letters, numbers, and symbols to make it even stronger.', 'silicon' ); ?></span>
            </div>
        </div>
    </div>

	<?php do_action( 'bbp_user_edit_after_account' ); ?>

	<?php if ( current_user_can( 'edit_users' ) && ! bbp_is_user_home_edit() ) : ?>

		<?php do_action( 'bbp_user_edit_before_role' ); ?>

		<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

            <div>
                <label for="super_admin"><?php esc_html_e( 'Network Role', 'silicon' ); ?></label>
                <label>
                    <input class="checkbox" type="checkbox" id="super_admin"
                           name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?>
                           tabindex="<?php bbp_tab_index(); ?>"/>
					<?php esc_html_e( 'Grant this user super admin privileges for the Network.', 'silicon' ); ?>
                </label>
            </div>

		<?php endif; ?>

		<?php bbp_get_template_part( 'form', 'user-roles' ); ?>

		<?php do_action( 'bbp_user_edit_after_role' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_user_edit_after' ); ?>

    <div class="submit margin-top-1x margin-bottom-2x">
	    <?php bbp_edit_user_form_fields(); ?>
        <button type="submit" tabindex="<?php bbp_tab_index(); ?>"
                name="bbp_user_edit_submit"
                id="bbp_user_edit_submit"
                class="btn btn-solid btn-primary btn-pill user-submit"
        ><?php bbp_is_user_home_edit() ? esc_html_e( 'Update Profile', 'silicon' ) : esc_html_e( 'Update User', 'silicon' ); ?></button>
    </div>

</form>