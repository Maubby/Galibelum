<?php
/**
 * Single Reply Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div id="bbpress-forums">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9">
				<?php do_action( 'bbp_template_before_single_reply' ); ?>

				<?php if ( post_password_required() ) : ?>

					<?php bbp_get_template_part( 'form', 'protected' ); ?>

				<?php else : ?>

					<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_template_after_single_reply' ); ?>
            </div>
            <div class="col-sm-4 col-md-3">
				<?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
