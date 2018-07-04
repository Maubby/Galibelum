<?php
/**
 * User Replies Created
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_user_replies' ); ?>

<div id="bbp-user-replies-created" class="bbp-user-replies-created">
    <h2 class="entry-title"><?php esc_html_e( 'Forum Replies Created', 'silicon' ); ?></h2>
    <div class="bbp-user-section">

        <?php
        if ( bbp_get_user_replies_created() ) :

            bbp_get_template_part( 'pagination', 'replies' );
            bbp_get_template_part( 'loop', 'replies' );

        else : ?>

            <p><?php bbp_is_user_home() ? esc_html_e( 'You have not replied to any topics.', 'silicon' ) : esc_html_e( 'This user has not replied to any topics.', 'silicon' ); ?></p>

        <?php endif; ?>

    </div>
</div>

<?php

do_action( 'bbp_template_after_user_replies' );
