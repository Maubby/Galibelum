<?php
/**
 * Template part for displaying the "Blank" layout for Portfolio.
 *
 * Based on Page Settings for Portfolio post type
 *
 * NOTE: this is a fallback template
 *
 * @see single-silicon_portfolio.php
 * @see silicon_meta_box_page_settings()
 *
 * @author 8guild
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container"><?php silicon_portfolio_toolbar(); ?></div>
	<?php the_content(); ?>

</article>
