<?php
/**
 * BuddyPress additions
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! silicon_is_bp() ) {
	return;
}

if ( ! function_exists( 'silicon_bp_user_nav' ) ) :
	/**
	 * Add extra classes to the navigation markup for the displayed user.
	 *
	 * @param string                 $item
	 * @param BP_Core_Nav_Item|array $user_nav_item
	 *
	 * @return string
	 */
	function silicon_bp_user_nav( $item, $user_nav_item ) {
		return str_replace(
			"<a id=\"user-{$user_nav_item->css_id}\" ",
			"<a id=\"user-{$user_nav_item->css_id}\" class=\"\"",
			$item
		);
	}
endif;

add_filter( 'bp_get_displayed_user_nav_activity', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_xprofile', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_notifications', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_messages', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_friends', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_groups', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_settings', 'silicon_bp_user_nav', 10, 2 );
add_filter( 'bp_get_displayed_user_nav_forums', 'silicon_bp_user_nav', 10, 2 );

if ( ! function_exists( 'silicon_bp_options_nav' ) ) :
	/**
	 * Add extra classes to the secondary-level single item navigation menu.
	 *
	 * @param string                 $item
	 * @param BP_Core_Nav_Item|array $sub_nav_item
	 *
	 * @return string
	 */
	function silicon_bp_options_nav( $item, $sub_nav_item ) {
		return str_replace(
			"<a id=\"{$sub_nav_item->css_id}\" ",
			"<a id=\"{$sub_nav_item->css_id}\" class=\"btn btn-link btn-pill\"",
			$item
		);
	}
endif;

add_filter( 'bp_get_options_nav_just-me', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_activity-mentions', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_activity-favs', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_activity-friends', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_activity-groups', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_public', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_edit', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_change-avatar', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_change-cover-image', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_notifications-my-notifications', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_read', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_inbox', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_starred', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_sentbox', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_compose', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_notices', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_friends-my-friends', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_requests', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_groups-my-groups', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_invites', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_general', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_notifications', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_profile', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_topics', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_replies', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_favorites', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_subscriptions', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_capabilities', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_delete-account', 'silicon_bp_options_nav', 10, 2 );

// groups admin
add_filter( 'bp_get_options_nav_edit-details', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_group-settings', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_group-avatar', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_group-cover-image', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_manage-members', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_forum', 'silicon_bp_options_nav', 10, 2 );
add_filter( 'bp_get_options_nav_delete-group', 'silicon_bp_options_nav', 10, 2 );


if ( ! function_exists( 'silicon_bp_activity_delete_link' ) ) :
	/**
	 * Add extra classes to activity delete link.
	 *
	 * @param string $link
	 *
	 * @return string
	 */
	function silicon_bp_activity_delete_link( $link ) {
		return str_replace(
			'class="button',
			'class="btn btn-link btn-pill btn-default btn-sm',
			$link
		);
	}
endif;

add_filter( 'bp_get_activity_delete_link', 'silicon_bp_activity_delete_link' );

if ( ! function_exists( 'silicon_bp_friendship_button' ) ) :
	/**
	 * Add extra classes to BuddyPress "Add Friend" button:
	 *
	 * @param array $button Button args
	 *
	 * @return array
	 */
	function silicon_bp_friendship_button( $button ) {
		// append classes
		$button['link_class'] .= ' btn btn-ghost btn-pill btn-primary'; // NOTE: there is a space before .btn

		return $button;
	}
endif;

add_filter( 'bp_get_add_friend_button', 'silicon_bp_friendship_button' );

if ( ! function_exists( 'silicon_bp_public_message_button' ) ) :
	/**
	 * Add extra classes to BuddyPress "Public Message" button
	 *
	 * @param array $button Button args
	 *
	 * @return array
	 */
	function silicon_bp_public_message_button( $button ) {
		// append classes
		$button['link_class'] .= ' btn btn-ghost btn-pill btn-success'; // NOTE: there is a space before .btn

		return $button;
	}
endif;

add_filter( 'bp_get_send_public_message_button', 'silicon_bp_public_message_button' );

if ( ! function_exists( 'silicon_bp_private_message_button' ) ) :
	/**
	 * Add extra classes to BuddyPress "Private Message" button
	 *
	 * @param array $button Button args
	 *
	 * @return array
	 */
	function silicon_bp_private_message_button( $button ) {
		// append classes
		$button['link_class'] .= ' btn btn-ghost btn-pill btn-warning'; // NOTE: there is a space before .btn

		return $button;
	}
endif;

add_filter( 'bp_get_send_message_button_args', 'silicon_bp_private_message_button' );

if ( ! function_exists( 'silicon_bp_cover_image' ) ) :
	/**
	 * Add Cover Image supports
	 *
	 * @see bp_register_theme_compat_default_features()
	 * @see bp_legacy_theme_cover_image()
	 * @see bp_add_cover_image_inline_css()
	 * @see https://codex.buddypress.org/themes/buddypress-cover-images/
	 *
	 * @param array $params
	 *
	 * @return array
	 */
	function silicon_bp_cover_image( $params = array() ) {
		$params['theme_handle'] = 'bp-parent-css';

		return $params;
	}
endif;

add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'silicon_bp_cover_image', 10, 1 );
add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'silicon_bp_cover_image', 10, 1 );

if ( ! function_exists( 'silicon_bp_group_create_button' ) ) :
	/**
	 * Add classes to "Create Group" button
	 *
	 * @param array $button
	 *
	 * @return array
	 */
	function silicon_bp_group_create_button( $button ) {
		$button['link_class'] .= ' btn btn-solid btn-pill btn-default';

		return $button;
	}
endif;

add_filter( 'bp_get_group_create_button', 'silicon_bp_group_create_button' );

if ( ! function_exists( 'silicon_bp_group_join_button' ) ) :
	/**
	 * Add extra classes to "Join Group" button
	 *
	 * @param array $button
	 *
	 * @return mixed
	 */
	function silicon_bp_group_join_button( $button ) {
		$button['link_class'] .= ' btn btn-solid btn-pill btn-default';

		return $button;
	}
endif;

add_filter( 'bp_get_group_join_button', 'silicon_bp_group_join_button' );

if ( ! function_exists( 'silicon_bp_notification_action_links' ) ) :
	/**
	 * Add extra button classes to action Mark read / unread links.
	 * Check Members > Profile > Notifications screen.
	 *
	 * @see bp_get_the_notification_mark_link()
	 * @see bp_get_the_notification_action_links()
	 *
	 * @param string $link
	 *
	 * @return string
	 */
	function silicon_bp_notification_mark_link( $link ) {
		return preg_replace(
			'/<a(.+?)class="([^"].+?)"/',
			'<a$1class="btn btn-link btn-pill btn-primary btn-sm $2"',
			$link
		);
	}
endif;

add_filter( 'bp_get_the_notification_mark_link', 'silicon_bp_notification_mark_link' );

if ( ! function_exists( 'silicon_bp_notification_delete_link' ) ) :
	/**
	 * Add extra button classes to action delete link.
	 * Check Members > Profile > Notifications screen.
	 *
	 * @see bp_get_the_notification_delete_link()
	 * @see bp_get_the_notification_action_links()
	 *
	 * @param string $link
	 *
	 * @return string
	 */
	function silicon_bp_notification_delete_link( $link ) {
		return preg_replace(
			'/<a(.+?)class="([^"].+?)"/',
			'<a$1class="btn btn-link btn-pill btn-danger btn-sm $2"',
			$link
		);
	}
endif;

add_filter( 'bp_get_the_notification_delete_link', 'silicon_bp_notification_delete_link' );

if ( ! function_exists( 'silicon_bp_notification_description' ) ) :
	/**
	 * Add extra silicon link classes to notifications links.
	 * To support changes in Theme Options
	 *
	 * @param string $description
	 *
	 * @return string
	 */
	function silicon_bp_notification_description( $description ) {
		if ( false !== strpos( $description, 'class="' ) ) {
			$description = str_replace( 'class="', 'class="navi-link-color navi-link-hover-color ', $description );
		} else {
			$description = str_replace( '<a ', '<a class="navi-link-color navi-link-hover-color" ', $description );
		}

		return $description;
	}
endif;

add_filter( 'bp_get_the_notification_description', 'silicon_bp_notification_description' );

if ( ! function_exists( 'silicon_bp_xprofile_tabs' ) ) :
	/**
	 * Add button classes to xProfile tabs.
	 * See Profile > Edit
	 *
	 * @see bp_get_profile_group_tabs()
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function silicon_bp_xprofile_tabs( $tabs ) {
		return array_map( function ( $tab ) {
			return str_replace(
				'<a ',
				'<a class="btn btn-link btn-pill btn-sm" ',
				$tab
			);
		}, $tabs );
	}
endif;

add_filter( 'xprofile_filter_profile_group_tabs', 'silicon_bp_xprofile_tabs' );
