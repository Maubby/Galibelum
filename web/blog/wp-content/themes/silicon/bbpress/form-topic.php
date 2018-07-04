<?php
/**
 * New/Edit Topic
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */


if ( ! bbp_is_single_forum() ) : ?>
<div id="bbpress-forums">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-md-9">
<?php endif;

if ( bbp_is_topic_edit() ) :
    bbp_single_topic_description( array( 'topic_id' => bbp_get_topic_id() ) );
endif;

if ( bbp_current_user_can_access_create_topic_form() ) : ?>

    <div id="new-topic-<?php bbp_topic_id(); ?>" class="bbp-topic-form">

        <form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">

            <?php do_action( 'bbp_theme_before_topic_form' ); ?>

            <fieldset class="bbp-form">

                <legend><?php
                    if ( bbp_is_topic_edit() ) :
                        printf( esc_html__( 'Now Editing &ldquo;%s&rdquo;', 'silicon' ), bbp_get_topic_title() );
                    else :
                        bbp_is_single_forum()
                            ? printf( esc_html__( 'Create New Topic in &ldquo;%s&rdquo;', 'silicon' ), bbp_get_forum_title() )
                            : esc_html_e( 'Create New Topic', 'silicon' );
                    endif;
                    ?></legend>

                <?php do_action( 'bbp_theme_before_topic_form_notices' ); ?>

                <?php if ( ! bbp_is_topic_edit() && bbp_is_forum_closed() ) : ?>

                    <div class="bbp-template-notice">
                        <p class="font-family-headings border-default-top border-color-primary"><?php esc_html_e( 'This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'silicon' ); ?></p>
                    </div>

                <?php endif; ?>

                <?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

                    <div class="bbp-template-notice">
                        <p class="font-family-headings border-default-top border-color-primary"><?php esc_html_e( 'Your account has the ability to post unrestricted HTML content.', 'silicon' ); ?></p>
                    </div>

                <?php endif; ?>

                <?php do_action( 'bbp_template_notices' ); ?>

                <div class="bbp-form-inner">

                    <?php bbp_get_template_part( 'form', 'anonymous' ); ?>

                    <?php do_action( 'bbp_theme_before_topic_form_title' ); ?>

                    <label for="bbp_topic_title"><?php printf( esc_html__( 'Topic Title (Maximum Length: %d):', 'silicon' ), bbp_get_title_max_length() ); ?></label>
                    <input type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>"
                           tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_title"
                           maxlength="<?php bbp_title_max_length(); ?>">

                    <?php do_action( 'bbp_theme_after_topic_form_title' ); ?>

                    <?php
                    // content field
                    do_action( 'bbp_theme_before_topic_form_content' );
                    bbp_the_content( array( 'context' => 'topic' ) );
                    do_action( 'bbp_theme_after_topic_form_content' );
                    ?>

                    <?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

                        <p class="form-allowed-tags">
                            <label>
                                <?php
                                wp_kses(
                                    __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'silicon' ),
                                    array( 'abbr' => array( 'title' => true ) )
                                );
                                ?>
                            </label>
                            <code><?php bbp_allowed_tags(); ?></code>
                        </p>

                    <?php endif; ?>

                    <?php if ( bbp_allow_topic_tags() && current_user_can( 'assign_topic_tags' ) ) : ?>

                        <?php do_action( 'bbp_theme_before_topic_form_tags' ); ?>

                        <label for="bbp_topic_tags"><?php esc_html_e( 'Topic Tags:', 'silicon' ); ?></label>
                        <input type="text" value="<?php bbp_form_topic_tags(); ?>"
                               tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags"
                               id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />

                        <?php do_action( 'bbp_theme_after_topic_form_tags' ); ?>

                    <?php endif; ?>

                    <?php if ( ! bbp_is_single_forum() ) : ?>

                        <?php do_action( 'bbp_theme_before_topic_form_forum' ); ?>

                        <label for="bbp_forum_id"><?php esc_html_e( 'Forum:', 'silicon' ); ?></label>
                        <?php
                        bbp_dropdown( array(
                            'show_none' => esc_html__( '(No Forum)', 'silicon' ),
                            'selected'  => bbp_get_form_topic_forum()
                        ) );
                        ?>

                        <?php do_action( 'bbp_theme_after_topic_form_forum' ); ?>

                    <?php endif; ?>

                    <?php if ( current_user_can( 'moderate' ) ) : ?>

                        <div class="row">
                            <div class="col-sm-6">

                                <?php do_action( 'bbp_theme_before_topic_form_type' ); ?>

                                <label for="bbp_stick_topic"><?php esc_html_e( 'Topic Type:', 'silicon' ); ?></label>
                                <?php bbp_form_topic_type_dropdown(); ?>

                                <?php do_action( 'bbp_theme_after_topic_form_type' ); ?>

                            </div>
                            <div class="col-sm-6">

                                <?php do_action( 'bbp_theme_before_topic_form_status' ); ?>

                                <label for="bbp_topic_status"><?php esc_html_e( 'Topic Status:', 'silicon' ); ?></label>
                                <?php bbp_form_topic_status_dropdown(); ?>

                                <?php do_action( 'bbp_theme_after_topic_form_status' ); ?>

                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ( bbp_is_subscriptions_active() && ! bbp_is_anonymous() && ( ! bbp_is_topic_edit() || ( bbp_is_topic_edit() && ! bbp_is_topic_anonymous() ) ) ) : ?>

                        <?php do_action( 'bbp_theme_before_topic_form_subscriptions' ); ?>

                        <p class="margin-bottom-1x">
                            <input name="bbp_topic_subscription" id="bbp_topic_subscription"
                                   type="checkbox"
                                   value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?>
                                   tabindex="<?php bbp_tab_index(); ?>">

                            <?php if ( bbp_is_topic_edit() && ( bbp_get_topic_author_id() !== bbp_get_current_user_id() ) ) : ?>

                                <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify the author of follow-up replies via email', 'silicon' ); ?></label>

                            <?php else : ?>

                                <label for="bbp_topic_subscription"><?php esc_html_e( 'Notify me of follow-up replies via email', 'silicon' ); ?></label>

                            <?php endif; ?>
                        </p>

                        <?php do_action( 'bbp_theme_after_topic_form_subscriptions' ); ?>

                    <?php endif; ?>

                    <?php if ( bbp_allow_revisions() && bbp_is_topic_edit() ) : ?>

                        <?php do_action( 'bbp_theme_before_topic_form_revisions' ); ?>

                        <fieldset class="bbp-form">
                            <legend>
                                <input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox"
                                       value="1" <?php bbp_form_topic_log_edit(); ?>
                                       tabindex="<?php bbp_tab_index(); ?>">
                                <label for="bbp_log_topic_edit"><?php esc_html_e( 'Keep a log of this edit:', 'silicon' ); ?></label>
                            </legend>

                            <div>
                                <label for="bbp_topic_edit_reason"><?php esc_html_e( 'Optional reason for editing:', 'silicon' ); ?></label>
                                <input type="text" value="<?php bbp_form_topic_edit_reason(); ?>"
                                       tabindex="<?php bbp_tab_index(); ?>" size="40"
                                       name="bbp_topic_edit_reason"
                                       id="bbp_topic_edit_reason">
                            </div>
                        </fieldset>

                        <?php do_action( 'bbp_theme_after_topic_form_revisions' ); ?>

                    <?php endif; ?>

                    <?php do_action( 'bbp_theme_before_topic_form_submit_wrapper' ); ?>

                    <div class="bbp-submit-wrapper">

                        <?php do_action( 'bbp_theme_before_topic_form_submit_button' ); ?>

                        <button type="submit" name="bbp_topic_submit" id="bbp_topic_submit"
                                tabindex="<?php bbp_tab_index(); ?>"
                                class="btn btn-solid btn-primary btn-pill"
                        ><?php esc_html_e( 'Submit', 'silicon' ); ?></button>

                        <?php do_action( 'bbp_theme_after_topic_form_submit_button' ); ?>

                    </div>

                    <?php do_action( 'bbp_theme_after_topic_form_submit_wrapper' ); ?>

                </div>

                <?php bbp_topic_form_fields(); ?>

            </fieldset>

            <?php do_action( 'bbp_theme_after_topic_form' ); ?>

        </form>
    </div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

    <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
        <div class="bbp-template-notice">
            <p class="font-family-headings border-default-top border-color-primary"><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new topics and replies.', 'silicon' ), bbp_get_forum_title() ); ?></p>
        </div>
    </div>

<?php else : ?>

    <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
        <div class="bbp-template-notice">
            <p class="font-family-headings border-default-top border-color-primary"><?php is_user_logged_in() ? esc_html_e( 'You cannot create new topics.', 'silicon' ) : esc_html_e( 'You must be logged in to create new topics.', 'silicon' ); ?></p>
        </div>
    </div>

<?php endif; ?>

<?php if ( ! bbp_is_single_forum() ) : ?>
            </div>
            <div class="col-sm-4 col-md-3">
                <?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
<?php endif;
