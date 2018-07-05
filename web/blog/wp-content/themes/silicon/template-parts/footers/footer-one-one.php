<?php
/**
 * Template part for displaying the "1 + 1 Columns" footer
 *
 * @author 8guild
 */

if ( is_active_sidebar( 'footer-column-1' ) ) :
	?>
	<div class="footer-row">
		<?php dynamic_sidebar( 'footer-column-1' ); ?>
	</div>
	<?php
endif;

if ( is_active_sidebar( 'footer-column-2' ) ) :
	?>
	<div class="footer-row border-default-top">
		<?php dynamic_sidebar( 'footer-column-2' ); ?>
	</div>
	<?php
endif;
