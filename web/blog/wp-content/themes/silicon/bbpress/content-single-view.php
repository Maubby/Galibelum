<?php
/**
 * Single View Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div id="bbpress-forums" class="container content-single-view">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9">

				<?php bbp_set_query_name( bbp_get_view_rewrite_id() ); ?>

				<?php if ( bbp_view_query() ) : ?>

					<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

					<?php bbp_get_template_part( 'loop', 'topics' ); ?>

					<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

				<?php else : ?>

					<?php bbp_get_template_part( 'feedback', 'no-topics' ); ?>

				<?php endif; ?>

				<?php bbp_reset_query_name(); ?>

            </div>
            <div class="col-sm-4 col-md-3">
				<?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
