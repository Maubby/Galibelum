<?php
/**
 * Anonymous User
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<?php if ( bbp_current_user_can_access_anonymous_user_form() ) : ?>

	<?php do_action( 'bbp_theme_before_anonymous_form' ); ?>

    <fieldset class="bbp-form margin-bottom-2x">
        <legend><?php ( bbp_is_topic_edit() || bbp_is_reply_edit() ) ? esc_html_e( 'Author Information', 'silicon' ) : esc_html_e( 'Your information:', 'silicon' ); ?></legend>

		<?php do_action( 'bbp_theme_anonymous_form_extras_top' ); ?>

        <div class="row">
            <div class="col-sm-4">
                <label for="bbp_anonymous_author"><?php esc_html_e( 'Name (required):', 'silicon' ); ?></label>
                <input type="text" id="bbp_anonymous_author" value="<?php bbp_author_display_name(); ?>"
                       tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_anonymous_name">
            </div>
            <div class="col-sm-4">
                <label for="bbp_anonymous_email"><?php esc_html_e( 'E-mail (required):', 'silicon' ); ?></label>
                <input type="text" id="bbp_anonymous_email" value="<?php bbp_author_email(); ?>"
                       tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_anonymous_email">
            </div>
            <div class="col-sm-4">
                <label for="bbp_anonymous_website"><?php esc_html_e( 'Website:', 'silicon' ); ?></label>
                <input type="text" id="bbp_anonymous_website" value="<?php bbp_author_url(); ?>"
                       tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_anonymous_website">
            </div>
        </div>

		<?php do_action( 'bbp_theme_anonymous_form_extras_bottom' ); ?>

    </fieldset>

	<?php do_action( 'bbp_theme_after_anonymous_form' ); ?>

<?php endif; ?>
