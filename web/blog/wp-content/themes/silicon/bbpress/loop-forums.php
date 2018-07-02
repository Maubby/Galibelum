<?php
/**
 * Forums Loop
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

    <li class="bbp-header">

        <ul class="forum-titles font-family-headings text-gray">
            <li class="bbp-forum-info"><?php esc_html_e( 'Forum', 'silicon' ); ?></li>
            <li class="bbp-forum-topic-count"><?php esc_html_e( 'Topics', 'silicon' ); ?></li>
            <li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? esc_html_e( 'Replies', 'silicon' ) : esc_html_e( 'Posts', 'silicon' ); ?></li>
            <li class="bbp-forum-freshness"><?php esc_html_e( 'Freshness', 'silicon' ); ?></li>
        </ul>

    </li>

    <li class="bbp-body">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

    </li>

    <li class="bbp-footer">

        <div class="tr">
            <p class="td colspan4">&nbsp;</p>
        </div><!-- .tr -->

    </li>

</ul>

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
