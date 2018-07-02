<?php
/**
 * Output the search form markup.
 *
 * @since 2.7.0
 */
?>

<div id="<?php echo esc_attr( bp_current_component() ); ?>-dir-search" class="dir-search" role="search">
	<form method="get" action=""
          id="search-<?php echo esc_attr( bp_current_component() ); ?>-form"
          class="search-box" autocomplete="off"
    >
		<input type="text"
               name="<?php echo esc_attr( bp_core_get_component_search_query_arg() ); ?>"
               id="<?php bp_search_input_name(); ?>"
               placeholder="<?php bp_search_placeholder(); ?>"
        >
		<button type="submit"
                name="<?php bp_search_input_name(); ?>_submit"
                id="<?php echo esc_attr( bp_get_search_input_name() ); ?>_submit"
        ><i class="si si-search"></i></button>
	</form>
</div>
