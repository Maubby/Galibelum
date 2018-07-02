<?php
/**
 * Search Loop - Single Forum
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<div class="bbp-forum-header font-family-headings">
	<div class="bbp-meta">
		<span class="bbp-forum-post-date text-gray text-sm"><?php printf( esc_html__( 'Last updated %s', 'silicon' ), bbp_get_forum_last_active_time() ); ?></span>
		<a href="<?php bbp_forum_permalink(); ?>"
           class="bbp-forum-permalink navi-link-color navi-link-hover-color font-family-nav"
        >#<?php bbp_forum_id(); ?></a>
	</div>
	<div class="bbp-forum-title">
		<?php do_action( 'bbp_theme_before_forum_title' ); ?>
		<h3>
            <?php esc_html_e( 'Forum: ', 'silicon' ); ?>
            <a href="<?php bbp_forum_permalink(); ?>"
               class="navi-link-color navi-link-hover-color font-family-nav"
            ><?php bbp_forum_title(); ?></a>
        </h3>
		<?php do_action( 'bbp_theme_after_forum_title' ); ?>
	</div>
</div>

<div id="post-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
	<div class="bbp-forum-content">
		<?php do_action( 'bbp_theme_before_forum_content' ); ?>
		<?php bbp_forum_content(); ?>
		<?php do_action( 'bbp_theme_after_forum_content' ); ?>
	</div>
</div>
