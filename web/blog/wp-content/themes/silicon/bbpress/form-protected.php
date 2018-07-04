<?php
/**
 * Password Protected
 *
 * @package    bbPress
 * @subpackage Theme
 */

?>
<div id="bbpress-forums">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <fieldset class="bbp-form" id="bbp-protected">
                    <Legend><?php esc_html_e( 'Protected', 'silicon' ); ?></legend>

				    <?php echo get_the_password_form(); ?>

                </fieldset>
            </div>
        </div>
    </div>
</div>