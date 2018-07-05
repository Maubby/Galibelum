<?php
/**
 * Archive Forum Content Part
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
				<?php do_action( 'bbp_template_before_forums_index' ); ?>

				<?php if ( bbp_has_forums() ) : ?>

					<?php bbp_get_template_part( 'loop', 'forums' ); ?>

				<?php else : ?>

					<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

				<?php endif; ?>

				<?php do_action( 'bbp_template_after_forums_index' ); ?>
            </div>
            <div class="col-sm-4 col-md-3">
				<?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
