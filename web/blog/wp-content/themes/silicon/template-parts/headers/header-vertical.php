<?php
/**
 * The template part for displaying the Header "Vertical (Lateral)"
 *
 * @author 8guild
 */
?>
<header class="<?php silicon_header_class( 'header-lateral border-default-right border-default-bottom' ); ?>">
	<div class="header-lateral-head">
		<div class="navbar-branding">
			<div class="mobile-menu-toggle">
				<i class="si si-menu"></i>
			</div>
			<?php silicon_logo(); ?>
		</div>
	</div>
	<?php
    // search form, check Theme Options > Header > Navbar Utilities > Search
    if ( silicon_is_search() ) :
	    get_search_form();
    endif;

	silicon_menu_primary();
	silicon_navbar_socials();
	silicon_navbar_buttons();
	?>
</header>
