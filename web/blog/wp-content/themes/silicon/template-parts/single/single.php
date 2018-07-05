<?php
/**
 * Template part for displaying the "Right Sidebar" layout for Single Post
 *
 * NOTE: This is a fallback in case if a template part is missing
 *
 * @see    template-parts/single/single-right.php
 * @link   https://codex.wordpress.org/Template_Hierarchy
 *
 * @author 8guild
 */

?>
<div class="container padding-bottom-2x">
    <div class="row">
        <div class="col-md-9 col-sm-8">
			<?php get_template_part( 'template-parts/single/content' ); ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="padding-top-2x visible-sm visible-xs"></div>
			<?php get_sidebar(); ?>
        </div>
    </div>
</div>
