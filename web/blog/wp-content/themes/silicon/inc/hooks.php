<?php
/**
 * A list of actions and filters that affected the frontend
 *
 * For callbacks {@see inc/template-tags.php}
 *
 * @author 8guild
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* WordPress */

add_action( 'after_setup_theme', 'silicon_setup' );
add_action( 'wp_enqueue_scripts', 'silicon_assets_front', 15 );
add_filter( 'body_class', 'silicon_body_classes' );
add_filter( 'the_content', 'silicon_entry_container', 100 );
add_action( 'login_head', 'silicon_login_css' );
add_filter( 'silicon_get_option_slug', 'silicon_options_slug' );
add_filter( 'silicon_get_setting_slug', 'silicon_page_settings_slug' );
add_filter( 'silicon_get_setting_defaults', 'silicon_page_settings_defaults' );

if ( is_admin() ) {
	add_action( 'admin_init', 'silicon_editor_styles' );
	add_action( 'admin_enqueue_scripts', 'silicon_assets_admin' );
	add_filter( 'tiny_mce_before_init', 'silicon_editor_formats' );
	add_filter( 'mce_buttons_2', 'silicon_editor_buttons_2' );
	add_action( 'do_meta_boxes', 'silicon_remove_featured_image_on_pages' );
	add_filter( 'site_transient_update_plugins', 'silicon_no_irritating_updates' );
}

/* Before the <header> */

add_action( 'silicon_header_before', 'silicon_offcanvas_cart', 5 );
add_action( 'silicon_header_before', 'silicon_offcanvas_menu', 5 );
add_action( 'silicon_header_before', 'silicon_menu_mobile', 5 );
add_action( 'silicon_header_before', 'silicon_page_wrapper_open', 7 );

/* Topbar */

add_action( 'silicon_topbar_left', 'silicon_topbar_info', 10 );
add_action( 'silicon_topbar_left', 'silicon_topbar_socials', 20 );
add_action( 'silicon_topbar_right', 'silicon_topbar_menu', 10 );
add_action( 'silicon_topbar_right', 'silicon_language_switcher', 20 );
add_action( 'silicon_topbar_right', 'silicon_topbar_login', 30 );

/* Navbar */

add_action( 'silicon_navbar_left', 'silicon_logo' );
add_action( 'silicon_navbar_left', 'silicon_logo_stuck' );
// add_action( 'silicon_navbar_left', 'silicon_menu_secondary' ); TODO: Enable in the next update
add_action( 'silicon_navbar_center', 'silicon_menu_primary' );
add_action( 'silicon_navbar_right', 'silicon_navbar_search' );
add_action( 'silicon_navbar_right', 'silicon_navbar_lang_switcher' );
add_action( 'silicon_navbar_right', 'silicon_navbar_cart' );
add_action( 'silicon_navbar_right', 'silicon_navbar_buttons' );
add_action( 'silicon_navbar_right', 'silicon_navbar_offcanvas_toggle' );

/* After the <header> */

add_action( 'silicon_header_after', 'silicon_content_wrapper_open', 5 );
add_action( 'silicon_header_after', 'silicon_page_title' );
add_action( 'silicon_header_after', 'silicon_intro' );

/* Blog (Home) */

add_action( 'silicon_loop_after', 'silicon_blog_pagination' );

/* Entry Tile */

add_action( 'silicon_tile_header', 'silicon_tile_header', 10 );
add_action( 'silicon_tile_footer', 'silicon_tile_footer', 20 );
add_filter( 'edit_post_link', 'silicon_edit_post_link', 10, 3 );
add_filter( 'excerpt_more', 'silicon_excerpt_more' );
add_filter( 'the_excerpt', 'silicon_the_excerpt', 20 );

/* Single Post */

add_action( 'silicon_single_after', 'silicon_related_posts', 15 );
add_action( 'silicon_single_after', 'silicon_entry_comments', 20 );
add_action( 'silicon_post_after', 'silicon_post_author', 15 );
add_action( 'silicon_post_after', 'silicon_post_navigation', 20 );

/* Portfolio Post */

add_action( 'silicon_portfolio_after', 'silicon_portfolio_navigation', 10 );
add_action( 'silicon_portfolio_after', 'silicon_related_projects', 15 );
add_action( 'silicon_portfolio_after', 'silicon_entry_comments', 20 );

/* Page */

add_action( 'silicon_page_after', 'silicon_entry_comments', 20 );
add_action( 'silicon_page_title_before', 'silicon_page_title_breadcrumbs' );
add_action( 'silicon_page_title_after', 'silicon_page_title_meta' );
add_filter( 'silicon_is_page_title', 'silicon_page_title_disabler' );

/* Archive */

add_action( 'silicon_archive_before', 'silicon_archive_open_wrapper', 5 );
add_action( 'silicon_archive_after', 'silicon_archive_close_wrapper', 5 );

/* Search Page */

add_action( 'silicon_search_before', 'silicon_search_open_wrapper', 5 );
add_action( 'silicon_search_after', 'silicon_search_close_wrapper', 5 );
add_filter( 'the_title', 'silicon_search_highlight_title', 100 );
add_filter( 'the_content', 'silicon_search_highlight_snippet', 100 );
add_filter( 'request', 'silicon_search_prevent_empty' );

/* Comments */

add_action( 'silicon_comments_before', 'silicon_comments_open_wrapper', 5 );
add_filter( 'comment_form_defaults', 'silicon_comment_form_defaults' );
add_action( 'comment_form_top', 'silicon_comment_form_top' );
add_filter( 'comment_form_logged_in', 'silicon_comment_form_logged_in' );
add_filter( 'comment_form_field_comment', 'silicon_comment_form_field_comment' );
add_action( 'comment_form_before_fields', 'silicon_comment_form_before_fields' );
add_filter( 'comment_form_default_fields', 'silicon_comment_form_default_fields' );
add_action( 'comment_form_after_fields', 'silicon_comment_form_after_fields' );
add_filter( 'comment_form_submit_button', 'silicon_comment_form_submit_button', 10, 2 );
add_action( 'comment_form', 'silicon_comment_form' );
add_action( 'silicon_comments_after', 'silicon_comments_close_wrapper', 5 );
add_filter( 'comment_reply_link', 'silicon_comment_reply_link' );
add_filter( 'cancel_comment_reply_link', 'silicon_comment_cancel_reply_link' );
add_filter( 'previous_comments_link_attributes', 'silicon_comment_prev_next_attributes' );
add_filter( 'next_comments_link_attributes', 'silicon_comment_prev_next_attributes' );

/* After the <footer> */

add_action( 'silicon_footer_after', 'silicon_content_wrapper_close', 5 );
add_action( 'silicon_footer_after', 'silicon_scroll_to_top', 6 );
add_action( 'silicon_footer_after', 'silicon_page_wrapper_close', 7 );
add_action( 'silicon_footer_after', 'silicon_site_backdrop', 999 );
