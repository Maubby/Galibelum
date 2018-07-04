<?php
/**
 * Search
 *
 * @package    bbPress
 * @subpackage Theme
 * @author     bbPress, 8guild
 */

?>
<form method="get" action="<?php bbp_search_url(); ?>"
      id="bbp-search-form" class="search-box"
      role="search" autocomplete="off"
>
    <label class="screen-reader-text hidden" for="bbp_search"><?php esc_html_e( 'Search for:', 'silicon' ); ?></label>
    <input type="hidden" name="action" value="bbp-search-request">
    <input type="text" name="bbp_search" id="bbp_search"
           placeholder="<?php echo esc_attr_x( 'Search', 'search form placeholder', 'silicon' ); ?>"
           tabindex="<?php bbp_tab_index(); ?>"
           value="<?php echo esc_attr( trim( bbp_get_search_terms() ) ); ?>"
    >
    <button type="submit" id="bbp_search_submit" tabindex="<?php bbp_tab_index(); ?>"><i class="si si-search"></i></button>
</form>
