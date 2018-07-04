<?php
/**
 * BuddyPress - Groups Admin - Edit Details
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<h2 class="bp-screen-reader-text"><?php esc_html_e( 'Manage Group Details', 'silicon' ); ?></h2>

<?php

/**
 * Fires before the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_details_admin' ); ?>

<label for="group-name"><?php esc_html_e( 'Group Name (required)', 'silicon' ); ?></label>
<input type="text" name="group-name" id="group-name" value="<?php bp_group_name(); ?>" aria-required="true" />

<label for="group-desc"><?php esc_html_e( 'Group Description (required)', 'silicon' ); ?></label>
<textarea name="group-desc" id="group-desc" aria-required="true"><?php bp_group_description_editable(); ?></textarea>

<?php

/**
 * Fires after the group description admin details.
 *
 * @since 1.0.0
 */
do_action( 'groups_custom_group_fields_editable' ); ?>

<p>
	<label for="group-notify-members">
		<input type="checkbox" name="group-notify-members" id="group-notify-members" value="1" /> <?php esc_html_e( 'Notify group members of these changes via email', 'silicon' ); ?>
	</label>
</p>

<?php

/**
 * Fires after the display of group admin details.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_details_admin' ); ?>

<p><input type="submit" value="<?php esc_attr_e( 'Save Changes', 'silicon' ); ?>" id="save" name="save" class="btn btn-solid btn-pill btn-default" /></p>
<?php wp_nonce_field( 'groups_edit_group_details' ); ?>
