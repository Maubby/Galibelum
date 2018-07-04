<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link   https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @author 8guild
 */

/**
 * Fires right before the footer
 *
 * @see silicon_scroll_to_top() 10
 */
do_action( 'silicon_footer_before' );

?>
<footer class="<?php silicon_footer_class(); ?>"
        style="<?php silicon_footer_style(); ?>" <?php silicon_footer_attr(); ?>
>
	<?php silicon_footer_overlay(); ?>
	<div class="<?php echo (bool) silicon_get_option( 'footer_is_fullwidth', false ) ? 'container-fluid' : 'container'; ?>">
		<?php get_template_part( 'template-parts/footers/footer', silicon_footer_layout() ); ?>
	</div>
</footer>
<?php

/**
 * Fires right after the closing <footer>
 *
 * @see silicon_content_wrapper_close() 5
 * @see silicon_scroll_to_top() 6
 * @see silicon_page_wrapper_close() 7
 * @see silicon_photoswipe() 999
 * @see silicon_site_backdrop() 999
 */
do_action( 'silicon_footer_after' );

wp_footer(); ?>

</body>
</html>
