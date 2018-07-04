<?php
/**
 * Template part for displaying posts
 *
 * @link   https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 8guild
 */

/**
 * Fires right before the single post content
 *
 * NOTE: this action executes before <article> element
 */
do_action( 'silicon_post_before' );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    silicon_post_header();
    the_content();
    wp_link_pages( array(
        'before' => '<div class="container"><div class="page-links"><span>' . esc_html__( 'Pages:', 'silicon' ),
        'after'  => '</span></div></div>',
    ) );
    silicon_post_footer();
    ?>

</article>
<?php

/**
 * Fires right after the single post content
 *
 * NOTE: this action executes after the <article> element
 *
 * @see silicon_post_author() 15
 * @see silicon_post_navigation() 20
 */
do_action( 'silicon_post_after' );
