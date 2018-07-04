<?php
/**
 * Actions and filters for comments list and comment form
 *
 * @author 8guild
 */

if ( ! function_exists( 'silicon_comment' ) ) :
	/**
	 * Start the single comment
	 *
	 * @see wp_list_comments
	 *
	 * @param object $comment Comment to display.
	 * @param array  $args    An array of arguments.
	 * @param int    $depth   Depth of comment.
	 */
	function silicon_comment( $comment, $args, $depth ) {
		// Extra comment wrap class
		$extra_class = silicon_get_classes( $args['has_children'] ? 'parent' : '' );
		?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class( $extra_class ); ?>>
			<div class="inner">
				<?php if ( 0 != $args['avatar_size'] && (bool) get_option( 'show_avatars' ) ) : ?>
					<div class="author-ava">
						<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
					</div>
				<?php endif; ?>
				<div class="comment-body">
					<h4 class="author-name"><?php comment_author(); ?></h4>
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Comment is awaiting moderation.', 'silicon' ); ?></p>
						<?php
					else:
						comment_text();
					endif; ?>
					<span class="comment-date"><?php comment_date(); ?></span>
					<div class="reply-link">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth ) ) ); ?>
					</div>
				</div>
			</div>
		<?php
	}
endif;

if ( ! function_exists( 'silicon_comment_end' ) ) :
	/**
	 * End of a single comment
	 *
	 * @see Walker::end_el
	 * @see wp_list_comments
	 *
	 * @param object $comment The comment object. Default current comment.
	 * @param array  $args    An array of arguments.
	 * @param int    $depth   Depth of comment.
	 */
	function silicon_comment_end( $comment, $args, $depth ) {
		echo '</div>'; // close div#comment-%d
	}
endif;

if ( ! function_exists( 'silicon_comment_form_defaults' ) ) :
	/**
	 * Modify the comment_form_defaults arguments
	 *
	 * @see comment_form
	 *
	 * @param array $args The default comment form arguments.
	 *
	 * @return array
	 */
	function silicon_comment_form_defaults( $args ) {
		// remove comment notes before and after, unnecessary
		$args['comment_notes_before'] = $args['comment_notes_after'] = '';

		// modify the title of the respond form
		$args['title_reply_before']  = '<div class="reply-title">';
		$args['title_reply_after']   = '</div>';
		$args['title_reply_to']      = '';
		$args['cancel_reply_before'] = '<span class="cancel-reply">';
		$args['cancel_reply_after']  = '</span>';
		$args['title_reply']         = silicon_get_text( esc_html_x( 'Comment', 'comment form title', 'silicon' ), '<h4>', '</h4>' );

		// textarea html template
		$comment_field_tpl = '<label for="cf_comment" class="sr-only">%1$s</label>'
		                     . '<textarea name="comment" id="cf_comment" class="input-rounded" rows="6" placeholder="%2$s" required></textarea>';

		$args['id_form']       = 'comment-form';
		$args['submit_field']  = '<div class="col-sm-3 form-submit">%1$s %2$s</div>';
		$args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>';
		$args['class_submit']  = 'btn btn-solid btn-rounded btn-primary btn-block margin-top-none margin-bottom-none';
		$args['label_submit']  = esc_html_x( 'Comment', 'comment form submit', 'silicon' );
		$args['comment_field'] = sprintf( $comment_field_tpl,
			esc_html_x( 'Comment', 'noun', 'silicon' ),
			esc_html__( 'Enter your comment', 'silicon' )
		);

		return $args;
	}
endif;

if ( ! function_exists( 'silicon_comment_form_top' ) ) :
	/**
	 * Open the div.row when the form starts
	 *
	 * Fires right after the opening <form> tag
	 *
	 * @see comment_form()
	 * @see silicon_comment_form()
	 */
	function silicon_comment_form_top() {
		echo '<div class="row">';
	}
endif;

if ( ! function_exists( 'silicon_comment_form_logged_in' ) ) :
	/**
	 * Wrap the 'logged in' message into the div.col-sm-12.
	 *
	 * Because this message is inside the div.row
	 *
	 * @param string $logged_in The logged-in-as HTML-formatted message.
	 *
	 * @return string
	 */
	function silicon_comment_form_logged_in( $logged_in ) {
		return '<div class="col-sm-12">' . $logged_in . '</div>';
	}
endif;

if ( ! function_exists( 'silicon_comment_form_field_comment' ) ) :
	/**
	 * Wrap the comment field (textarea) to div.col-sm-12
	 *
	 * Because we opened a div.row at the form top.
	 *
	 * @param string $field The content of the comment textarea field.
	 *
	 * @return string
	 */
	function silicon_comment_form_field_comment( $field ) {
		return '<div class="col-sm-12">' . $field . '</div>';
	}
endif;

if ( ! function_exists( 'silicon_comment_form_before_fields' ) ) :
	/**
	 * Wrap comment form fields (author, email) with div.col-sm-9 > div.row
	 *
	 * @see comment_form()
	 * @see silicon_comment_form_after_fields()
	 */
	function silicon_comment_form_before_fields() {
		echo '<div class="col-sm-9"><div class="row">';
	}
endif;

if ( ! function_exists( 'silicon_comment_form_default_fields' ) ) :
	/**
	 * Modify the comment form's field like author and email
	 *
	 * @param array $fields Default fields
	 *
	 * @return array
	 */
	function silicon_comment_form_default_fields( $fields ) {
		// remove URL field
		unset( $fields['url'] );

		$commenter = wp_get_current_commenter();
		$req       = (bool) get_option( 'require_name_email' );
		$aria_req  = $req ? 'required' : '';

		// html templates for author and email fields
		$author_tpl = '
		<div class="col-sm-6">
			<label for="cf_name" class="sr-only">%1$s</label>
		    <input type="text" name="author" id="cf_name" class="input-rounded" placeholder="%1$s" value="%2$s" %3$s>
		</div>';

		$email_tpl = '
	    <div class="col-sm-6">
			<label for="cf_email" class="sr-only">%1$s</label>
			<input type="email" name="email" id="cf_email" class="input-rounded" placeholder="%1$s" value="%2$s" %3$s>
		</div>';

		// ready fields
		$author = sprintf( $author_tpl,
			esc_html__( 'Name', 'silicon' ),
			esc_attr( $commenter['comment_author'] ),
			$aria_req
		);

		$email = sprintf( $email_tpl,
			esc_html__( 'Email', 'silicon' ),
			esc_attr( $commenter['comment_author_email'] ),
			$aria_req
		);

		return array(
			'author' => $author,
			'email'  => $email,
		);
	}
endif;

if ( ! function_exists( 'silicon_comment_form_after_fields' ) ) :
	/**
	 * Close div.row < div.col-sm-9 wrapper after comment form fields (author, email)
	 *
	 * @see comment_form
	 * @see silicon_comment_form_before_fields()
	 */
	function silicon_comment_form_after_fields() {
		echo '</div></div>';
	}
endif;

if ( ! function_exists( 'silicon_comment_form_submit_button' ) ) :
	/**
	 * Add icon to comment form submit button.
	 *
	 * @param string $btn  HTML markup for the submit button.
	 * @param array  $args Arguments passed to comment_form().
	 *
	 * @return string
	 */
	function silicon_comment_form_submit_button( $btn, $args ) {
		return sprintf(
			$args['submit_button'],
			esc_attr( $args['name_submit'] ),
			esc_attr( $args['id_submit'] ),
			esc_attr( $args['class_submit'] ),
			esc_attr( $args['label_submit'] )
		);
	}
endif;

if ( ! function_exists( 'silicon_comment_form' ) ) :
	/**
	 * Close the div.row at the end of form
	 *
	 * Fires right before the closing </form> tag
	 *
	 * @see comment_form()
	 * @see silicon_comment_form_top()
	 */
	function silicon_comment_form() {
		echo '</div>';
	}
endif;

if ( ! function_exists( 'silicon_comment_reply_link' ) ) :
	/**
	 * Add extra classes to Reply Link
	 *
	 * @hooked comment_reply_link 10
	 *
	 * @param string $link Reply Link markup
	 *
	 * @return string
	 */
	function silicon_comment_reply_link( $link ) {
		return preg_replace( '/(comment-reply-[\w]+)/', '$1 btn btn-link btn-primary btn-pill', $link );
	}
endif;

if ( ! function_exists( 'silicon_comment_cancel_reply_link' ) ) :
	/**
	 * Add extra class and icon to Cancel Reply Link
	 *
	 * @hooked cancel_comment_reply_link 10
	 *
	 * @param string $link Cancel reply link markup
	 *
	 * @return string
	 */
	function silicon_comment_cancel_reply_link( $link ) {
		return preg_replace( '/>([^<]*)</', ' class="text-danger"><i class="si si-cross"></i> $1<', $link );
	}
endif;

if ( ! function_exists( 'silicon_comment_prev_next_attributes' ) ) :
	/**
	 * Add extra classes to previous / next comments navigation links
	 *
	 * @hooked previous_comments_link_attributes 10
	 * @hooked next_comments_link_attributes 10
	 *
	 * @param string $attributes
	 *
	 * @return string
	 */
	function silicon_comment_prev_next_attributes( $attributes ) {
		return $attributes . ' class="btn btn-link btn-pill btn-sm btn-default"';
	}
endif;

if ( ! function_exists( 'silicon_comments_open_wrapper' ) ) :
	/**
	 * Wrap the comments page to div#comments. Open tag.
	 *
	 * @hooked silicon_comments_before 5
	 * @see    silicon_comments_close_wrapper()
	 * @see    comments.php
	 */
	function silicon_comments_open_wrapper() {
		echo '
        <div class="comments-area border-default-top padding-bottom-3x" id="comments">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
        ';
	}
endif;

if ( ! function_exists( 'silicon_comments_close_wrapper' ) ) :
	/**
	 * Wrap the comments page to div#comments. Close tag.
	 *
	 * @hooked silicon_comments_after 5
	 * @see    silicon_comments_open_wrapper()
	 * @see    comments.php
	 */
	function silicon_comments_close_wrapper() {
		echo '
            		</div>
                </div>
            </div>
        </div>';
	}
endif;

/**
 * Returns supported level of nesting for comments list.
 * Depends on threaded_comment option and CSS support.
 *
 * @see wp_list_comments
 *
 * @return int|string
 */
function silicon_comments_nesting_level() {
	// Respect the "Enable threaded comments" option in Settings > Discussion
	if ( false === (bool) get_option( 'thread_comments' ) ) {
		return '';
	}

	/**
	 * Filter the comments nesting level for {@see wp_list_comments}
	 *
	 * @param int $level max_depth argument
	 */
	return apply_filters( 'silicon_comments_nesting_level', get_option( 'thread_comments_depth' ) );
}

/**
 * Don't count pingbacks or trackbacks when determining
 * the number of comments on a post.
 *
 * Comments number is cached for 6 hours!
 *
 * @param string $count Number of comments, pingbacks and trackbacks
 *
 * @return int
 */
function silicon_comments_number( $count ) {
	global $id;

	/**
	 * Filter for enabling the counting pingbacks and trackbacks when
	 * determining the number of comments on a post. Default is disabled.
	 *
	 * @param bool $is_count Default is false.
	 */
	if ( null === $id || apply_filters( 'silicon_count_pingbacks_trackbacks', false ) ) {
		return $count;
	}

	$cache_key   = 'comments_number_for_' . $id;
	$cache_group = 'comments';

	$comment_count = wp_cache_get( $cache_key, $cache_group );
	if ( false === $comment_count ) {
		$comment_count = 0;
		$comments      = get_approved_comments( $id );
		foreach ( $comments as $comment ) {
			if ( $comment->comment_type === '' ) {
				$comment_count ++;
			}
		}

		wp_cache_set( $cache_key, $comment_count, $cache_group, 6 * HOUR_IN_SECONDS );
	}

	return $comment_count;
}

add_filter( 'get_comments_number', 'silicon_comments_number', 0 );

/**
 * Flush the comments number cache when the post comment count updates
 *
 * @param int $post_id Post ID
 */
function silicon_comments_number_flush( $post_id ) {
	$cache_key   = 'comments_number_for_' . $post_id;
	$cache_group = 'comments';

	wp_cache_delete( $cache_key, $cache_group );
}

add_action( 'wp_update_comment_count', 'silicon_comments_number_flush' );
