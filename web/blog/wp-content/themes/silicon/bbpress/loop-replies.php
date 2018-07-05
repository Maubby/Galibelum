<?php
/**
 * Replies Loop
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_replies_loop' ); ?>

<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">

	<li class="bbp-header text-gray font-family-headings">
		<div class="bbp-reply-author"><?php esc_html_e( 'Author',  'silicon' ); ?></div>
		<div class="bbp-reply-content">

			<?php if ( !bbp_show_lead_topic() ) : ?>

				<?php esc_html_e( 'Posts', 'silicon' ); ?>

			<?php else : ?>

				<?php esc_html_e( 'Replies', 'silicon' ); ?>

			<?php endif; ?>

		</div>
	</li>

	<li class="bbp-body">

		<?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</li>
</ul>

<?php do_action( 'bbp_template_after_replies_loop' ); ?>
