<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link   https://codex.wordpress.org/Creating_an_Error_404_Page
 * @author 8guild
 */

get_header();

?>
<div class="container text-center">
    <div class="padding-top-5x hidden-xs"></div>
    <div class="padding-top-3x visible-xs"></div>
    <div class="row">
        <div class="col-sm-6">
            <?php silicon_404_image(); ?>
        </div>
        <div class="col-sm-6">
            <h1 class="text-huge text-primary">404</h1>
            <?php

            // Title
            $_title = silicon_get_option( '404_title', esc_html__( 'Looks like SiliBot broke...', 'silicon' ) );
            $_title = strip_tags( stripslashes( trim( $_title ) ) );
            echo silicon_get_text( $_title, '<h2 class="h1 padding-top-1x">', '</h2>' );

            // Subtitle 1
            $_subtitle_1 = silicon_get_option( '404_subtitle_1', esc_html__( 'We couldn\'t find that page', 'silicon' ) );
            echo silicon_get_text( strip_tags( stripslashes( trim( $_subtitle_1 ) ) ), '<p>', '</p>' );

            // Home button
            $_button_text = silicon_get_option( '404_button_text', esc_html__( 'Go To Homepage', 'silicon' ) );
            $_button_text = strip_tags( stripslashes( trim( $_button_text ) ) );
            if ( ! empty( $_button_text ) ) {
                echo sprintf(
                    '<a href="%s" class="btn btn-pill btn-ghost btn-primary waves-effect waves-light">
                    <i class="si si-arrow-left"></i>
                    %s
                </a>',
                    esc_url( get_home_url( null, '/' ) ),
                    $_button_text
                );
            }
            // Subtitle 2
            $_subtitle_2 = silicon_get_option( '404_subtitle_2', esc_html__( 'Or try search', 'silicon' ) );
            $_subtitle_2 = strip_tags( stripslashes( trim( $_subtitle_2 ) ) );
            echo silicon_get_text( $_subtitle_2, '<p class="padding-top-1x">', '</p>' );

            unset( $_title, $_subtitle_1, $_button_text, $_subtitle_2 );

            ?>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="padding-bottom-5x hidden-xs"></div>
    <div class="padding-bottom-4x visible-xs"></div>
</div>
<?php

get_footer();
