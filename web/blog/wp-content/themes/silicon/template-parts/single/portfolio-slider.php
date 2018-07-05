<?php
/**
 * Template part for displaying the "Slider" layout for Portfolio.
 *
 * Based on Page Settings for Portfolio post type
 *
 * @see    single-silicon_portfolio.php
 * @see    silicon_meta_box_page_settings()
 *
 * @author 8guild
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container padding-bottom-1x">
        <div class="row">
            <div class="col-sm-12">
				<?php silicon_portfolio_toolbar(); ?>
                <div class="margin-bottom-2x">
					<?php silicon_portfolio_gallery(); ?>
                </div>
				<?php the_content(); ?>
            </div>
        </div>
    </div>
</article>
