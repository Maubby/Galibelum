<?php
/**
 * BuddyPress - Members Notifications Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<form action="" method="post" id="notifications-bulk-management">
	<table class="notifications">
		<thead>
			<tr>
				<th class="icon"></th>
				<th class="bulk-select-all"><input id="select-all-notifications" type="checkbox"><label class="bp-screen-reader-text" for="select-all-notifications"><?php
					/* translators: accessibility text */
					esc_html_e( 'Select all', 'silicon' );
				?></label></th>
				<th class="title"><?php esc_html_e( 'Notification', 'silicon' ); ?></th>
				<th class="date"><?php esc_html_e( 'Date Received', 'silicon' ); ?></th>
				<th class="actions"><?php esc_html_e( 'Actions',    'silicon' ); ?></th>
			</tr>
		</thead>

		<tbody>

			<?php while ( bp_the_notifications() ) : bp_the_notification(); ?>

				<tr>
					<td></td>
					<td class="bulk-select-check"><label for="<?php bp_the_notification_id(); ?>"><input id="<?php bp_the_notification_id(); ?>" type="checkbox" name="notifications[]" value="<?php bp_the_notification_id(); ?>" class="notification-check"><span class="bp-screen-reader-text"><?php
						/* translators: accessibility text */
						esc_html_e( 'Select this notification', 'silicon' );
					?></span></label></td>
					<td class="notification-description"><?php bp_the_notification_description();  ?></td>
					<td class="notification-since"><?php bp_the_notification_time_since();   ?></td>
                    <td class="notification-actions"><?php bp_the_notification_action_links( array( 'sep' => '' ) ); ?></td>
				</tr>

			<?php endwhile; ?>

		</tbody>
	</table>

	<div class="notifications-options-nav">
        <label class="bp-screen-reader-text" for="notification-select"><?php
			/* translators: accessibility text */
			esc_html_e( 'Select Bulk Action', 'silicon' );
			?></label>
        <select name="notification_bulk_action" id="notification-select">
            <option value="" selected="selected"><?php esc_html_e( 'Bulk Actions', 'silicon' ); ?></option>

			<?php if ( bp_is_current_action( 'unread' ) ) : ?>
                <option value="read"><?php esc_html_e( 'Mark read', 'silicon' ); ?></option>
			<?php elseif ( bp_is_current_action( 'read' ) ) : ?>
                <option value="unread"><?php esc_html_e( 'Mark unread', 'silicon' ); ?></option>
			<?php endif; ?>
            <option value="delete"><?php esc_html_e( 'Delete', 'silicon' ); ?></option>
        </select>
        <button type="submit" id="notification-bulk-manage"
                class="btn btn-solid btn-pill btn-default action"
        ><?php esc_html_e( 'Apply', 'silicon' ); ?></button>
	</div><!-- .notifications-options-nav -->

	<?php wp_nonce_field( 'notifications_bulk_nonce', 'notifications_bulk_nonce' ); ?>
</form>
