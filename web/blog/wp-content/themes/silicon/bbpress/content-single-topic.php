<?php
/**
 * Single Topic Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div id="bbpress-forums">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">

				<?php do_action( 'bbp_template_before_single_topic' ); ?>

				<?php if ( post_password_required() ) : ?>

					<?php bbp_get_template_part( 'form', 'protected' ); ?>

				<?php else : ?>

					<?php bbp_single_topic_description( array(
						'before' => '<div class="bbp-template-notice"><p class="bbp-topic-description border-default-top border-color-info margin-bottom-none">',
					) ); ?>

					<?php if ( bbp_show_lead_topic() ) : ?>

						<?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

					<?php endif; ?>

					<?php if ( bbp_has_replies() ) : ?>

						<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

						<?php bbp_get_template_part( 'loop', 'replies' ); ?>

					<?php endif; ?>

					<?php bbp_get_template_part( 'form', 'reply' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_template_after_single_topic' ); ?>

            </div>
            <div class="col-md-3 col-sm-4">
				<?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
