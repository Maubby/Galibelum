<?php
/**
 * Topics Loop
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_topics_loop' ); ?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics">

    <li class="bbp-header">
        <ul class="forum-titles text-gray font-family-headings">
            <li class="bbp-topic-title"><?php esc_html_e( 'Topic', 'silicon' ); ?></li>
            <li class="bbp-topic-voice-count"><?php esc_html_e( 'Voices', 'silicon' ); ?></li>
            <li class="bbp-topic-reply-count"><?php bbp_show_lead_topic() ? esc_html_e( 'Replies', 'silicon' ) : esc_html_e( 'Posts', 'silicon' ); ?></li>
            <li class="bbp-topic-freshness"><?php esc_html_e( 'Freshness', 'silicon' ); ?></li>
        </ul>
    </li>

	<li class="bbp-body">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>

</ul>

<?php do_action( 'bbp_template_after_topics_loop' ); ?>
