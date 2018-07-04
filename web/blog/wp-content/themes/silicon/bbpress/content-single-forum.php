<?php
/**
 * Single Forum Content Part
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div id="bbpress-forums">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
				<?php

				do_action( 'bbp_template_before_single_forum' );

				if ( post_password_required() ) :
					bbp_get_template_part( 'form', 'protected' );
				else :

					if ( bbp_has_forums() ) :
						bbp_get_template_part( 'loop', 'forums' );
					endif;

					if ( ! bbp_is_forum_category() && bbp_has_topics() ) :
						bbp_get_template_part( 'pagination', 'topics' );
						bbp_get_template_part( 'loop', 'topics' );
						bbp_get_template_part( 'form', 'topic' );
                    elseif ( ! bbp_is_forum_category() ) :
						bbp_get_template_part( 'feedback', 'no-topics' );
						bbp_get_template_part( 'form', 'topic' );
					endif;

				endif;

				do_action( 'bbp_template_after_single_forum' );

				?>
            </div>
            <div class="col-md-3 col-sm-4">
				<?php get_sidebar( 'forum' ); ?>
            </div>
        </div>
    </div>
</div>
