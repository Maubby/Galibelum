<?php
/**
 * Search Loop - Single Topic
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div class="bbp-topic-header font-family-headings">

	<div class="bbp-meta">

		<span class="bbp-topic-post-date text-gray text-sm"><?php bbp_topic_post_date( bbp_get_topic_id() ); ?></span>

		<a href="<?php bbp_topic_permalink(); ?>"
           class="bbp-topic-permalink navi-link-color navi-link-hover-color font-family-nav"
        >#<?php bbp_topic_id(); ?></a>

	</div><!-- .bbp-meta -->

	<div class="bbp-topic-title">

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

        <h3>
			<?php esc_html_e( 'Topic: ', 'silicon' ); ?>
            <a href="<?php bbp_topic_permalink(); ?>"
               class="navi-link-color navi-link-hover-color font-family-nav"><?php bbp_topic_title(); ?></a>
        </h3>

		<div class="bbp-topic-title-meta">

			<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>
				<span class="text-gray"><?php esc_html_e( 'in group forum ', 'silicon' ); ?>&nbsp;</span>
			<?php else : ?>
				<span class="text-gray"><?php esc_html_e( 'in forum ', 'silicon' ); ?>&nbsp;</span>
			<?php endif; ?>

			<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"
               class="navi-link-color navi-link-hover-color font-family-nav"
            ><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

		</div><!-- .bbp-topic-title-meta -->

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

	</div><!-- .bbp-topic-title -->
</div>

<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

	<div class="bbp-topic-author">

		<?php do_action( 'bbp_theme_before_topic_author_details' ); ?>

		<?php bbp_topic_author_link( array( 'sep' => '', 'show_role' => true ) ); ?>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_topic_author_admin_details' ); ?>

			<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_after_topic_author_details' ); ?>

	</div><!-- .bbp-topic-author -->

	<div class="bbp-topic-content" style="padding-top: 10px;">

		<?php do_action( 'bbp_theme_before_topic_content' ); ?>

		<?php bbp_topic_content(); ?>

		<?php do_action( 'bbp_theme_after_topic_content' ); ?>

	</div><!-- .bbp-topic-content -->

</div>
