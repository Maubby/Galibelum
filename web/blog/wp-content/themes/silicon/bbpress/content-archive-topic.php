<?php
/**
 * Archive Topic Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div id="bbpress-forums" class="content-archive-topic">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9">

	            <?php if ( bbp_is_topic_tag() ) bbp_topic_tag_description(); ?>

	            <?php do_action( 'bbp_template_before_topics_index' ); ?>

	            <?php if ( bbp_has_topics() ) : ?>

		            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

		            <?php bbp_get_template_part( 'loop',       'topics'    ); ?>

		            <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

	            <?php else : ?>

		            <?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

	            <?php endif; ?>

	            <?php do_action( 'bbp_template_after_topics_index' ); ?>

            </div>
            <div class="col-sm-4 col-md-3">
                <?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
