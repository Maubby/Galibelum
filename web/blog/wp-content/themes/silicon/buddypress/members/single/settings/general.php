<?php
/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_before_member_settings_template' ); ?>

<h2 class="bp-screen-reader-text"><?php
	/* translators: accessibility text */
	esc_html_e( 'Account settings', 'silicon' );
?></h2>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

	<?php if ( !is_super_admin() ) : ?>

		<label for="pwd"><?php esc_html_e( 'Current Password', 'silicon' ); ?></label>
		<input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" <?php bp_form_field_attributes( 'password' ); ?>>
        <span class="description"><?php esc_html_e( 'Required to update email or change current password.', 'silicon' ); ?></span>
        <a href="<?php echo wp_lostpassword_url(); ?>"
           title="<?php esc_attr_e( 'Password Lost and Found', 'silicon' ); ?>"
        ><?php esc_html_e( 'Lost your password?', 'silicon' ); ?></a>


	<?php endif; ?>

	<label for="email"><?php esc_html_e( 'Account Email', 'silicon' ); ?></label>
	<input type="email" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" <?php bp_form_field_attributes( 'email' ); ?>/>

	<label for="pass1"><?php esc_html_e( 'Change Password', 'silicon' ); ?></label>
	<input type="password" name="pass1" id="pass1" size="16" value=""
           class="settings-input small password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
    <span class="description"><?php esc_html_e( 'Leave blank for no change.', 'silicon' ); ?></span>
    <div id="pass-strength-result"></div>

    <label for="pass2"><?php esc_html_e( 'Repeat New Password', 'silicon' ); ?></label>
	<input type="password" name="pass2" id="pass2" size="16" value=""
           class="settings-input small password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>

	<?php

	/**
	 * Fires before the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit">
        <button type="submit" name="submit" id="submit"
                class="btn btn-solid btn-pill btn-default"
        ><?php esc_html_e( 'Save Changes', 'silicon' ); ?></button>
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_after_member_settings_template' ); ?>
