<?php
/**
 * Template part for displaying the "2 Columns" footer
 *
 * @author 8guild
 */

if ( ! silicon_is_active_sidebars( array(
	'footer-column-1',
	'footer-column-2',
) ) ) {
	return;
}
?>
<div class="footer-row">
	<div class="row">

		<?php if ( is_active_sidebar( 'footer-column-1' ) ) : ?>
			<div class="col-sm-6">
				<?php dynamic_sidebar( 'footer-column-1' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'footer-column-2' ) ) : ?>
			<div class="col-sm-6">
				<?php dynamic_sidebar( 'footer-column-2' ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>