<?php
/**
 * Search Content Part
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
	            <?php bbp_set_query_name( bbp_get_search_rewrite_id() ); ?>

	            <?php do_action( 'bbp_template_before_search' ); ?>

	            <?php if ( bbp_has_search_results() ) : ?>

		            <?php bbp_get_template_part( 'pagination', 'search' ); ?>
		            <?php bbp_get_template_part( 'loop', 'search' ); ?>

	            <?php elseif ( bbp_get_search_terms() ) : ?>

		            <?php bbp_get_template_part( 'feedback', 'no-search' ); ?>

	            <?php else : ?>

		            <?php bbp_get_template_part( 'form', 'search' ); ?>

	            <?php endif; ?>

	            <?php do_action( 'bbp_template_after_search_results' ); ?>
            </div>
            <div class="col-sm-4 col-md-3">
	            <?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>

