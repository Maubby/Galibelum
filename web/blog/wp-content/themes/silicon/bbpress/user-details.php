<?php
/**
 * User Details
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

do_action( 'bbp_template_before_user_details' ); ?>

<div id="bbp-single-user-details">

    <div id="bbp-user-avatar">
        <span class='vcard'>
            <a class="url fn n" href="<?php bbp_user_profile_url(); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>" rel="me">
                <?php echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 150 ) ); ?>
            </a>
        </span>
    </div>

    <div id="bbp-user-navigation">
        <ul>
            <li class="<?php if ( bbp_is_single_user_profile() ) :?>current<?php endif; ?>">
                <span class="vcard bbp-user-profile-link">
                    <a href="<?php bbp_user_profile_url(); ?>"
                       class="url fn n navi-link-color navi-link-hover-color font-family-nav"
                       title="<?php printf( esc_attr__( "%s's Profile", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                       rel="me"><?php esc_html_e( 'Profile', 'silicon' ); ?></a>
                </span>
            </li>

            <li class="<?php if ( bbp_is_single_user_topics() ) :?>current<?php endif; ?>">
                <span class='bbp-user-topics-created-link'>
                    <a href="<?php bbp_user_topics_created_url(); ?>"
                       class="navi-link-color navi-link-hover-color font-family-nav"
                       title="<?php printf( esc_attr__( "%s's Topics Started", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                    ><?php esc_html_e( 'Topics Started', 'silicon' ); ?></a>
                </span>
            </li>

            <li class="<?php if ( bbp_is_single_user_replies() ) :?>current<?php endif; ?>">
                <span class='bbp-user-replies-created-link'>
                    <a href="<?php bbp_user_replies_created_url(); ?>"
                       class="navi-link-color navi-link-hover-color font-family-nav"
                       title="<?php printf( esc_attr__( "%s's Replies Created", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                    ><?php esc_html_e( 'Replies Created', 'silicon' ); ?></a>
                </span>
            </li>

            <?php if ( bbp_is_favorites_active() ) : ?>
                <li class="<?php if ( bbp_is_favorites() ) :?>current<?php endif; ?>">
                    <span class="bbp-user-favorites-link">
                        <a href="<?php bbp_favorites_permalink(); ?>"
                           class="navi-link-color navi-link-hover-color font-family-nav"
                           title="<?php printf( esc_attr__( "%s's Favorites", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                        ><?php esc_html_e( 'Favorites', 'silicon' ); ?></a>
                    </span>
                </li>
            <?php endif; ?>

            <?php if ( bbp_is_user_home() || current_user_can( 'edit_users' ) ) : ?>

                <?php if ( bbp_is_subscriptions_active() ) : ?>
                    <li class="<?php if ( bbp_is_subscriptions() ) :?>current<?php endif; ?>">
                        <span class="bbp-user-subscriptions-link">
                            <a href="<?php bbp_subscriptions_permalink(); ?>"
                               class="navi-link-color navi-link-hover-color font-family-nav"
                               title="<?php printf( esc_attr__( "%s's Subscriptions", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                            ><?php esc_html_e( 'Subscriptions', 'silicon' ); ?></a>
                        </span>
                    </li>
                <?php endif; ?>

                <li class="<?php if ( bbp_is_single_user_edit() ) :?>current<?php endif; ?>">
                    <span class="bbp-user-edit-link">
                        <a href="<?php bbp_user_profile_edit_url(); ?>"
                           class="navi-link-color navi-link-hover-color font-family-nav"
                           title="<?php printf( esc_attr__( "Edit %s's Profile", 'silicon' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"
                        ><?php esc_html_e( 'Edit', 'silicon' ); ?></a>
                    </span>
                </li>

            <?php endif; ?>
        </ul>
    </div>
</div>

<?php do_action( 'bbp_template_after_user_details' );
