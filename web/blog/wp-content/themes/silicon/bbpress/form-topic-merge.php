<?php
/**
 * Merge Topic
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

	            <?php if ( is_user_logged_in() && current_user_can( 'edit_topic', bbp_get_topic_id() ) ) : ?>

                    <div id="merge-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-merge">

                        <form id="merge_topic" name="merge_topic" method="post" action="<?php the_permalink(); ?>">

                            <fieldset class="bbp-form">

                                <legend><?php printf( esc_html__( 'Merge topic "%s"', 'silicon' ), bbp_get_topic_title() ); ?></legend>

                                <div>

                                    <div class="bbp-template-notice">
                                        <p class="font-family-headings border-default-top border-color-primary"><?php esc_html_e( 'Select the topic to merge this one into. The destination topic will remain the lead topic, and this one will change into a reply.', 'silicon' ); ?></p> <br>
                                        <p class="font-family-headings border-default-top border-color-primary"><?php esc_html_e( 'To keep this topic as the lead, go to the other topic and use the merge tool from there instead.', 'silicon' ); ?></p>
                                    </div>

                                    <div class="bbp-template-notice ">
                                        <p class="font-family-headings border-default-top border-color-info"><?php esc_html_e( 'All replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted. If the destination topic was created after this one, it\'s post date will be updated to second earlier than this one.', 'silicon' ); ?></p>
                                    </div>

                                    <fieldset class="bbp-form">
                                        <legend><?php esc_html_e( 'Destination', 'silicon' ); ?></legend>
                                        <div>
								            <?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ), 'post__not_in' => array( bbp_get_topic_id() ) ) ) ) : ?>

                                                <label for="bbp_destination_topic"><?php esc_html_e( 'Merge with this topic:', 'silicon' ); ?></label>

									            <?php
									            bbp_dropdown( array(
										            'post_type'   => bbp_get_topic_post_type(),
										            'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ),
										            'selected'    => -1,
										            'exclude'     => bbp_get_topic_id(),
										            'select_id'   => 'bbp_destination_topic'
									            ) );
									            ?>

								            <?php else : ?>

                                                <label><?php esc_html_e( 'There are no other topics in this forum to merge with.', 'silicon' ); ?></label>

								            <?php endif; ?>

                                        </div>
                                    </fieldset>

                                    <fieldset class="bbp-form">
                                        <legend><?php esc_html_e( 'Topic Extras', 'silicon' ); ?></legend>

                                        <div>

								            <?php if ( bbp_is_subscriptions_active() ) : ?>

                                                <input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                                <label for="bbp_topic_subscribers"><?php esc_html_e( 'Merge topic subscribers', 'silicon' ); ?></label>

								            <?php endif; ?>

                                            <input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                            <label for="bbp_topic_favoriters"><?php esc_html_e( 'Merge topic favoriters', 'silicon' ); ?></label>

								            <?php if ( bbp_allow_topic_tags() ) : ?>

                                                <input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                                <label for="bbp_topic_tags"><?php esc_html_e( 'Merge topic tags', 'silicon' ); ?></label>

								            <?php endif; ?>

                                        </div>
                                    </fieldset>

                                    <div class="bbp-template-notice">
                                        <p class="font-family-headings border-default-top border-color-warning"><?php echo wp_kses( __( '<strong>WARNING:</strong> This process cannot be undone.', 'silicon' ), array( 'strong' => true ) ); ?></p>
                                    </div>

                                    <div class="bbp-submit-wrapper">
                                        <button type="submit" name="bbp_merge_topic_submit"
                                                id="bbp_merge_topic_submit"
                                                class="btn btn-solid btn-pill btn-primary"
                                                tabindex="<?php bbp_tab_index(); ?>"
                                        ><?php esc_html_e( 'Submit', 'silicon' ); ?></button>
                                    </div>
                                </div>

					            <?php bbp_merge_topic_form_fields(); ?>

                            </fieldset>
                        </form>
                    </div>

	            <?php else : ?>

                    <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
                        <div class="entry-content"><?php is_user_logged_in() ? esc_html_e( 'You do not have the permissions to edit this topic!', 'silicon' ) : esc_html_e( 'You cannot edit this topic.', 'silicon' ); ?></div>
                    </div>

	            <?php endif; ?>
            </div>
            <div class="col-sm-4 col-md-3">
	            <?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
