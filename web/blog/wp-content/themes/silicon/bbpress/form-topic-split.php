<?php
/**
 * Split Topic
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

                    <div id="split-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-split">

                        <form id="split_topic" name="split_topic" method="post" action="<?php the_permalink(); ?>">

                            <fieldset class="bbp-form">

                                <legend><?php printf( esc_html__( 'Split topic "%s"', 'silicon' ), bbp_get_topic_title() ); ?></legend>

                                <div>

                                    <div class="bbp-template-notice">
                                        <p class="font-family-headings border-default-top border-color-info"><?php esc_html_e( 'When you split a topic, you are slicing it in half starting with the reply you just selected. Choose to use that reply as a new topic with a new title, or merge those replies into an existing topic.', 'silicon' ); ?></p>
                                    </div>

                                    <div class="bbp-template-notice">
                                        <p class="font-family-headings border-default-top border-color-primary"><?php esc_html_e( 'If you use the existing topic option, replies within both topics will be merged chronologically. The order of the merged replies is based on the time and date they were posted.', 'silicon' ); ?></p>
                                    </div>

                                    <fieldset class="bbp-form">
                                        <legend><?php esc_html_e( 'Split Method', 'silicon' ); ?></legend>

                                        <div>
                                            <input name="bbp_topic_split_option" id="bbp_topic_split_option_reply" type="radio" checked="checked" value="reply" tabindex="<?php bbp_tab_index(); ?>" />
                                            <label for="bbp_topic_split_option_reply"><?php printf( wp_kses( __( 'New topic in <strong>%s</strong> titled:', 'silicon' ), array( 'strong' => true ) ), bbp_get_forum_title( bbp_get_topic_forum_id( bbp_get_topic_id() ) ) ); ?></label>
                                            <input type="text" id="bbp_topic_split_destination_title" value="<?php printf( esc_html__( 'Split: %s', 'silicon' ), bbp_get_topic_title() ); ?>" tabindex="<?php bbp_tab_index(); ?>" size="35" name="bbp_topic_split_destination_title" />
                                        </div>

							            <?php if ( bbp_has_topics( array( 'show_stickies' => false, 'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ), 'post__not_in' => array( bbp_get_topic_id() ) ) ) ) : ?>

                                            <div>
                                                <input name="bbp_topic_split_option" id="bbp_topic_split_option_existing" type="radio" value="existing" tabindex="<?php bbp_tab_index(); ?>" />
                                                <label for="bbp_topic_split_option_existing"><?php esc_html_e( 'Use an existing topic in this forum:', 'silicon' ); ?></label>

									            <?php
									            bbp_dropdown( array(
										            'post_type'   => bbp_get_topic_post_type(),
										            'post_parent' => bbp_get_topic_forum_id( bbp_get_topic_id() ),
										            'selected'    => -1,
										            'exclude'     => bbp_get_topic_id(),
										            'select_id'   => 'bbp_destination_topic'
									            ) );
									            ?>

                                            </div>

							            <?php endif; ?>

                                    </fieldset>

                                    <fieldset class="bbp-form">
                                        <legend><?php esc_html_e( 'Topic Extras', 'silicon' ); ?></legend>

                                        <div>

								            <?php if ( bbp_is_subscriptions_active() ) : ?>

                                                <input name="bbp_topic_subscribers" id="bbp_topic_subscribers" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                                <label for="bbp_topic_subscribers"><?php esc_html_e( 'Copy subscribers to the new topic', 'silicon' ); ?></label>

								            <?php endif; ?>

                                            <input name="bbp_topic_favoriters" id="bbp_topic_favoriters" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                            <label for="bbp_topic_favoriters"><?php esc_html_e( 'Copy favoriters to the new topic', 'silicon' ); ?></label>

								            <?php if ( bbp_allow_topic_tags() ) : ?>

                                                <input name="bbp_topic_tags" id="bbp_topic_tags" type="checkbox" value="1" checked="checked" tabindex="<?php bbp_tab_index(); ?>" />
                                                <label for="bbp_topic_tags"><?php esc_html_e( 'Copy topic tags to the new topic', 'silicon' ); ?></label>

								            <?php endif; ?>

                                        </div>
                                    </fieldset>

                                    <div class="bbp-template-notice">
                                        <p class="font-family-headings border-default-top border-color-warning"><?php echo wp_kses( __( '<strong>WARNING:</strong> This process cannot be undone.', 'silicon' ), array( 'strong' => true ) ); ?></p>
                                    </div>

                                    <div class="bbp-submit-wrapper">
                                        <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_merge_topic_submit" name="bbp_merge_topic_submit" class="button submit"><?php esc_html_e( 'Submit', 'silicon' ); ?></button>
                                    </div>
                                </div>

					            <?php bbp_split_topic_form_fields(); ?>

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
