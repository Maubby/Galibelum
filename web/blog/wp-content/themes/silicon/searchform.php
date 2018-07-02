<?php
/**
 * Search Form
 *
 * @author 8guild
 */
?>
<form method="get" class="search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off">
	<input type="text" name="s"
	       placeholder="<?php echo esc_attr_x( 'Search', 'search form placeholder', 'silicon' ); ?>"
	       value="<?php echo esc_attr( trim( get_search_query( false ) ) ); ?>">
	<button type="submit"><i class="si si-search"></i></button>
</form>
