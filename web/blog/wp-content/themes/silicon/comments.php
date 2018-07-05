<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
 * @author 8guild
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * Fires at the most top of the comments page
 *
 * @see silicon_comments_open_wrapper() 5
 */
do_action( 'silicon_comments_before' );

/**
 * Comments title
 */
printf( '<h3 class="comments-main-title text-center margin-top-3x margin-bottom-2x">%1$s</h3>',
	esc_html_x( 'Comments', 'comments title', 'silicon' )
);

if ( have_comments() ) :

	// Display the list of comments
	wp_list_comments( array(
		'style'        => 'div',
		'callback'     => 'silicon_comment',
		'end-callback' => 'silicon_comment_end',
		'max_depth'    => silicon_comments_nesting_level(),
		'type'         => 'comment',
		'reply_text'   => esc_html_x( 'Reply', 'comment reply', 'silicon' ),
		'avatar_size'  => 60,
		'short_ping'   => true,
	) );

	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="post-navigation comment-navigation border-default-top border-default-bottom" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'silicon' ); ?></h2>
            <div class="post-nav-prev"><?php previous_comments_link( '<i class="si si-angle-left"></i><span class="hidden-xs">' . esc_html__( 'Prev', 'silicon' ) . '</span>' ); ?></div>
            <div class="post-nav-next border-default-left"><?php next_comments_link( '<span class="hidden-xs">' . esc_html__( 'Next', 'silicon' ) . '</span><i class="si si-angle-right"></i>' ); ?></div>
		</nav>
		<?php
	endif;

endif;

// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open()
     && get_comments_number()
     && post_type_supports( get_post_type(), 'comments' )
) {
	printf( '<p class="no-comments">%s</p>', esc_html__( 'Comments are closed.', 'silicon' ) );
}

comment_form();

/**
 * Fires at the most bottom of the comments page
 *
 * @see silicon_comments_close_wrapper() 5
 */
do_action( 'silicon_comments_after' );
