<?php
/**
 * bbPress additions
 *
 * @author 8guild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! silicon_is_bbp() ) {
	return;
}

/**
 * Disable the bbPress Breadcrumbs in favor of using Breadcrumb NavXT plugin
 *
 * @see bbp_get_breadcrumb()
 */
add_filter( 'bbp_no_breadcrumb', '__return_true' );

if ( ! function_exists( 'silicon_bbp_password_form' ) ) :
	/**
	 * Wrap the Password Protection form into the container for bbPress topic page
	 *
	 * @param string $form
	 *
	 * @return string
	 */
	function silicon_bbp_password_form( $form ) {
		if ( ! bbp_is_single_topic() ) {
			return $form;
		}

		return '
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					' . $form . '
				</div>
			</div>
		';
	}
endif;

add_filter( 'the_password_form', 'silicon_bbp_password_form' );

if ( ! function_exists( 'silicon_bbp_topic_author_link_class' ) ) :
	/**
	 * Add some extra classes to "Author" name inside topics and replies
	 *
	 * @param string $link
	 *
	 * @return mixed
	 */
	function silicon_bbp_author_link_class( $link ) {
		return str_replace(
			'bbp-author-name',
			'bbp-author-name navi-link-color navi-link-hover-color font-family-nav',
			$link
		);
	}
endif;

add_filter( 'bbp_get_reply_author_link', 'silicon_bbp_author_link_class', 10 );
add_filter( 'bbp_get_topic_author_link', 'silicon_bbp_author_link_class', 10 );

if ( ! function_exists( 'silicon_bbp_freshness_link_class' ) ) :
	/**
	 * Add extra classes to bbPress freshness link
	 *
	 * @param string $link
	 *
	 * @return mixed
	 */
	function silicon_bbp_freshness_link_class( $link ) {
		return str_replace(
			'<a ',
			'<a class="navi-link-color navi-link-hover-color font-family-nav" ',
			$link
		);
	}
endif;

add_filter( 'bbp_get_author_link', 'silicon_bbp_freshness_link_class' );
add_filter( 'bbp_get_topic_freshness_link', 'silicon_bbp_freshness_link_class' );
add_filter( 'bbp_get_forum_freshness_link', 'silicon_bbp_freshness_link_class' );

if ( ! function_exists( 'silicon_bbp_list_forums_link_class' ) ) :
	/**
	 * Add extra classes to bbPress list forums
	 * Appears below the forum description in forums list (forum subcategories)
	 *
	 * @param string $output
	 *
	 * @return string
	 */
	function silicon_bbp_list_forums_link_class( $output ) {
		return str_replace(
			'bbp-forum-link',
			'bbp-forum-link navi-link-color navi-link-hover-color font-family-nav',
			$output
		);
	}
endif;

add_filter( 'bbp_list_forums', 'silicon_bbp_list_forums_link_class' );

if ( ! function_exists( 'silicon_bbp_page_title_style' ) ) :
	/**
	 * Custom styling for bbPress page
	 *
	 * This filter adds inline background color and image
	 * on the Page Title for bbPress pages.
	 *
	 * @param array $style
	 *
	 * @return array
	 */
	function silicon_bbp_page_title_style( $style ) {
		if ( ! is_bbpress() ) {
			return $style;
		}

		// NOTE: if provided properties already exists they will not be overridden
		return array_merge( array(
			'background-color' => '#f5f5f5',
			'background-image' => sprintf( 'url(%s)', SILICON_TEMPLATE_URI . '/img/bbpress-pt-bg.jpg' ),
		), $style );
	}
endif;

add_filter( 'silicon_page_title_style', 'silicon_bbp_page_title_style' );

if ( ! function_exists( 'silicon_bbp_page_title_tags' ) ) :
	/**
	 * Display the Topic tags in the Page Title
	 *
	 * @hooked silicon_page_title_after 10
	 * @uses   bbp_get_topic_tag_list()
	 */
	function silicon_bbp_page_title_tags() {
		if ( ! is_bbpress() ) {
			return;
		}

		$tags = bbp_get_topic_tag_list( bbp_is_topic_edit() ? bbp_get_topic_id() : 0, array(
			'before' => '',
			'sep'    => '',
			'after'  => '',
		) );

		echo '<div class="bbp-page-title-tags">', $tags, '</div>';
	}
endif;

add_action( 'silicon_page_title_after', 'silicon_bbp_page_title_tags' );

if ( ! function_exists( 'silicon_bbp_page_title_tags_style' ) ) :
	/**
	 * Add a custom style attribute to topic tags links
	 *
	 * @param array $links
	 *
	 * @return mixed
	 */
	function silicon_bbp_page_title_tags_style( $links ) {
		return array_map( function ( $link ) {
			return str_replace( '<a ', '<a style="background-color: #fff; color: #222;"', $link );
		}, (array) $links );
	}
endif;

add_filter( 'term_links-topic-tag', 'silicon_bbp_page_title_tags_style' );

if ( ! function_exists( 'silicon_bbp_page_title_subscription' ) ) :
	/**
	 * Display the "Subscribe" and "Favorite" link in the Page Title
	 *
	 * @hooked silicon_page_title_after 20
	 * @uses   bbp_forum_subscription_link()
	 */
	function silicon_bbp_page_title_subscription() {
		if ( ! is_bbpress() ) {
			return;
		}

		$favorite  = bbp_get_user_favorites_link();
		$subscribe = bbp_get_user_subscribe_link( array( 'before' => '', 'after' => '' ) );

		echo '<div class="bbp-page-title-links text-center">', $favorite, $subscribe, '</div>';
	}
endif;

add_action( 'silicon_page_title_after', 'silicon_bbp_page_title_subscription', 20 );

if ( ! function_exists( 'silicon_bbp_user_favorites_link_class' ) ) :
	/**
	 * Add extra classes to user "Favorite" link
	 *
	 * @param string $html
	 *
	 * @return string
	 */
	function silicon_bbp_user_favorites_link_class( $html ) {
		return str_replace(
			'class="favorite-toggle',
			'class="favorite-toggle btn btn-solid btn-pill btn-sm btn-success',
			$html
		);
	}
endif;

add_filter( 'bbp_get_user_favorites_link', 'silicon_bbp_user_favorites_link_class' );

if ( ! function_exists( 'silicon_bbp_user_subscription_link_class' ) ) :
	/**
	 * Add extra classes to user "Subscribe" link
	 *
	 * @param string $html
	 *
	 * @return string
	 */
	function silicon_bbp_user_subscription_link_class( $html ) {
		return str_replace(
			array( 'class="subscription-toggle', '&nbsp;|&nbsp;' ),
			array( 'class="subscription-toggle btn btn-solid btn-pill btn-sm btn-primary', '' ),
			$html
		);
	}
endif;

add_filter( 'bbp_get_user_subscribe_link', 'silicon_bbp_user_subscription_link_class' );

if ( ! function_exists( 'silicon_bbp_reply_admin_links_class' ) ) :
	/**
	 * Add extra classes to reply admin links
	 *
	 * @param string $output
	 * @param array $r
	 * @param array $args
	 *
	 * @return mixed
	 */
	function silicon_bbp_reply_admin_links_class( $output, $r, $args ) {
		return preg_replace(
			'/class="(bbp-(reply|topic)-[a-z-]+)"/',
			'class="$1 text-gray navi-link-hover-color"',
			$output
		);
	}
endif;

add_filter( 'bbp_get_reply_admin_links', 'silicon_bbp_reply_admin_links_class', 10, 3 );
add_filter( 'bbp_get_topic_admin_links', 'silicon_bbp_reply_admin_links_class', 10, 3 );

if ( ! function_exists( 'silicon_bbp_user_profile_link' ) ) :
	/**
	 * Add custom class to user profile link
	 *
	 * @see BBP_Login_Widget
	 *
	 * @param string $link
	 * @param int    $user_id
	 *
	 * @return string
	 */
	function silicon_bbp_user_profile_link( $link, $user_id ) {
		return str_replace(
			'<a ',
			'<a class="navi-link-color navi-link-hover-color text-semibold" ',
			$link
		);
	}
endif;

add_filter( 'bbp_get_user_profile_link', 'silicon_bbp_user_profile_link', 10, 2 );

if ( ! function_exists( 'silicon_bbp_logout_link' ) ) :
	/**
	 * Add custom class to logout link
	 *
	 * @see BBP_Login_Widget
	 *
	 * @param string $link
	 *
	 * @return string
	 */
	function silicon_bbp_logout_link( $link ) {
		return str_replace(
			'class="button ',
			'class="navi-link-color navi-link-hover-color text-sm ',
			$link
		);
	}
endif;

add_filter( 'bbp_get_logout_link', 'silicon_bbp_logout_link' );
