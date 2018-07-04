<?php
/**
 * Template part for displaying the "2 + 1 Columns" footer
 *
 * @author 8guild
 */

if ( silicon_is_active_sidebars( array(
	'footer-column-1',
	'footer-column-2',
) ) ) :
	?>
	<div class="footer-row">
		<div class="row">
			<div class="col-sm-6">
				<?php dynamic_sidebar( 'footer-column-1' ); ?>
			</div>
			<div class="col-sm-6">
				<?php dynamic_sidebar( 'footer-column-2' ); ?>
			</div>
		</div>
	</div>
	<?php
endif;

if ( is_active_sidebar( 'footer-column-3' ) ) :
	?>
	<div class="footer-row border-default-top">
		<?php dynamic_sidebar( 'footer-column-3' ); ?>
	</div>
	<?php
endif;
