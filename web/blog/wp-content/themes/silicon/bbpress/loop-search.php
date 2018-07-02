<?php
/**
 * Search Loop
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>

<?php do_action( 'bbp_template_before_search_results_loop' ); ?>

<ul id="bbp-search-results" class="forums bbp-search-results">
	<li class="bbp-header font-family-headings text-gray">
		<div class="bbp-search-author"><?php  esc_html_e( 'Author',  'silicon' ); ?></div>
		<div class="bbp-search-content"><?php esc_html_e( 'Search Results', 'silicon' ); ?></div>
	</li>

	<li class="bbp-body">
		<?php
        while ( bbp_search_results() ) :
            bbp_the_search_result();
            bbp_get_template_part( 'loop', 'search-' . get_post_type() );
		endwhile;
		?>
	</li>
</ul>

<?php do_action( 'bbp_template_after_search_results_loop' );
