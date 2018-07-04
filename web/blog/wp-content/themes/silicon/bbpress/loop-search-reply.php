<?php
/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 * @author bbPress, 8guild
 */

?>

<div class="bbp-reply-header font-family-headings">

	<div class="bbp-meta">

		<span class="bbp-reply-post-date text-gray text-sm"><?php bbp_reply_post_date(); ?></span>

		<a href="<?php bbp_reply_url(); ?>"
           class="bbp-reply-permalink navi-link-color navi-link-hover-color font-family-nav"
        >#<?php bbp_reply_id(); ?></a>

	</div><!-- .bbp-meta -->

	<div class="bbp-reply-title">

		<h3>
            <?php esc_html_e( 'In reply to: ', 'silicon' ); ?>
		    <a href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"
               class="bbp-topic-permalink navi-link-color navi-link-hover-color font-family-nav"
            ><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
        </h3>

	</div><!-- .bbp-reply-title -->

</div><!-- .bbp-reply-header -->

<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

	<div class="bbp-reply-author">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => true ) ); ?>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content" style="padding-top: 10px;">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

	</div><!-- .bbp-reply-content -->

</div><!-- #post-<?php bbp_reply_id(); ?> -->

