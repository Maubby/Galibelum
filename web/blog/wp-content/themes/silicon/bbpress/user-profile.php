<?php
/**
 * User Profile
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_user_profile' ); ?>

<div id="bbp-user-profile" class="bbp-user-profile">
    <h2 class="entry-title"><?php esc_html_e( 'Profile', 'silicon' ); ?></h2>
    <div class="bbp-user-section">

		<?php if ( bbp_get_displayed_user_field( 'description' ) ) : ?>
            <p class="bbp-user-description text-gray"><?php bbp_displayed_user_field( 'description' ); ?></p>
		<?php endif; ?>

        <p class="bbp-user-forum-role text-gray"><?php printf( esc_html__( 'Forum Role: %s', 'silicon' ), bbp_get_user_display_role() ); ?></p>
        <p class="bbp-user-topic-count text-gray"><?php printf( esc_html__( 'Topics Started: %s', 'silicon' ), bbp_get_user_topic_count_raw() ); ?></p>
        <p class="bbp-user-reply-count text-gray"><?php printf( esc_html__( 'Replies Created: %s', 'silicon' ), bbp_get_user_reply_count_raw() ); ?></p>
    </div>
</div>

<?php

do_action( 'bbp_template_after_user_profile' );
