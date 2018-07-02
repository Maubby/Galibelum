<?php
/**
 * Replies Loop - Single Reply
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>
<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class( 0, array( 'border-default-top' ) ); ?>>

    <div class="bbp-reply-author">

        <span class="bbp-reply-post-date text-gray"><?php bbp_reply_post_date(); ?></span>

	    <?php if ( bbp_is_single_user_replies() ) : ?>

            <span class="forum-titles font-family-nav text-gray" style="display: block">
				<?php esc_html_e( 'in reply to: ', 'silicon' ); ?>
                <a class="bbp-topic-permalink navi-link-color navi-link-hover-color" style="text-transform: none;"
                   href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"
                ><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>

	    <?php endif; ?>

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => true ) ); ?>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

            <div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

    </div><!-- .bbp-reply-author -->

    <div class="bbp-reply-content">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

        <div class="bbp-reply-meta">
	        <?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

	        <?php bbp_reply_admin_links( array( 'sep' => '' ) ); ?>

	        <?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

            <a href="<?php bbp_reply_url(); ?>"
               class="bbp-reply-permalink text-gray navi-link-hover-color font-family-nav"
            >#<?php bbp_reply_id(); ?></a>
        </div>
    </div>

</div>
