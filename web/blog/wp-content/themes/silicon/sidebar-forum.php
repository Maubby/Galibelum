<?php
/**
 * The sidebar containing the Forum widget area.
 *
 * @link   https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @author 8guild
 */

if ( ! is_active_sidebar( 'sidebar-forum' ) ) {
	return;
}

?>
<div class="padding-top-2x visible-xs"></div>
<aside class="sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-forum' ); ?>
</aside>
