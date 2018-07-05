<?php
/**
 * Template part for displaying the "Side Gallery" layout for Portfolio.
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
            <div class="col-md-8">
				<?php silicon_portfolio_gallery(); ?>
            </div>
            <div class="col-md-4">
                <div class="padding-top-4x visible-xs"></div>
				<?php
				the_content();
				silicon_portfolio_toolbar();
				?>
            </div>
        </div>
    </div>
</article>
