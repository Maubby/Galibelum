<?php
/**
 * This is a fallback template which loads when user enable Intro Section,
 * but not configured it properly.
 *
 * Show the error message with short instructions what to do next.
 *
 * @author 8guild
 */

$_intro = (int) silicon_get_setting( 'intro' );
$_edit  = sprintf( '<a href="%1$s">%2$s</a>', get_edit_post_link( $_intro ), get_the_title( $_intro ) );

?>
<div class="container">
	<p>
		<?php
		echo sprintf( esc_html__(
				'Ouch! It seems you not configured the Intro Section properly. Make sure you specified
				the correct Type and filled all those settings in your Dashboard > Intros > %s.',
				'silicon'
			), $_edit
		);

		unset( $_intro, $_edit );
		?>
	</p>
</div>
