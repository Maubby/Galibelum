<?php
/**
 * User Topics Created
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_user_topics_created' ); ?>

<div id="bbp-user-topics-started" class="bbp-user-topics-started">
    <h2 class="entry-title"><?php esc_html_e( 'Forum Topics Started', 'silicon' ); ?></h2>
    <div class="bbp-user-section">

		<?php
        if ( bbp_get_user_topics_started() ) :
            
            bbp_get_template_part( 'pagination', 'topics' );
			bbp_get_template_part( 'loop', 'topics' );

		else : ?>

            <p><?php bbp_is_user_home() ? esc_html_e( 'You have not created any topics.', 'silicon' ) : esc_html_e( 'This user has not created any topics.', 'silicon' ); ?></p>

		<?php endif; ?>

    </div>
</div>

<?php

do_action( 'bbp_template_after_user_topics_created' );
