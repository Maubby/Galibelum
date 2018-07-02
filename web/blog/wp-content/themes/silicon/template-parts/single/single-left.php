<?php
/**
 * Template part for displaying the "Left Sidebar" layout for Single Post
 *
 * @author 8guild
 */

?>
<div class="container padding-bottom-2x">
	<div class="row">
		<div class="col-md-9 col-sm-8 col-md-push-3 col-sm-push-4">
			<?php get_template_part( 'template-parts/single/content' ); ?>
		</div>
		<div class="col-md-3 col-sm-4 col-md-pull-9 col-sm-pull-8">
			<div class="padding-top-4x visible-xs"></div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
