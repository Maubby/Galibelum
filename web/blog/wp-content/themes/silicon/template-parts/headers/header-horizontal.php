<?php
/**
 * The template part for displaying the Header "Horizontal"
 *
 * @author 8guild
 */
?>
<header class="<?php silicon_header_class(); ?>">

	<?php if ( silicon_is_topbar() ) : ?>
        <div class="<?php silicon_topbar_class(); ?>"
             style="<?php silicon_topbar_style(); ?>" <?php silicon_topbar_attr(); ?>>
            <div class="topbar-inner">
                <div class="topbar-inner-column">
					<?php

					/**
					 * silicon_topbar_left hook.
                     *
                     * @see silicon_topbar_info() 10
                     * @see silicon_topbar_socials() 20
					 */
                    do_action( 'silicon_topbar_left' );

					?>
                </div>
                <div class="topbar-inner-column">
                    <?php

                    /**
                     * silicon_topbar_right hook.
                     *
                     * @see silicon_topbar_menu() 10
                     * @see silicon_language_switcher() 20
                     * @see silicon_topbar_login() 30
                     */
                    do_action( 'silicon_topbar_right' );

                    ?>
                </div>
            </div>
        </div>
	<?php endif; ?>

	<div class="<?php silicon_navbar_class(); ?>"
         style="<?php silicon_navbar_style(); ?>" <?php silicon_navbar_attr(); ?>>

		<?php if ( silicon_is_search() ) : ?>
            <div class="site-search">
                <div class="inner">
                    <div class="search-form">
						<?php get_search_form(); ?>
                        <div class="search-tools font-family-nav">
                            <span class="search-clear"><?php esc_html_e( 'Clear', 'silicon' ); ?></span>
                            <span class="search-close"><i class="si si-cross"></i></span>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif; ?>

        <div class="navbar-inner">
            <div class="navbar-branding">
                <div class="mobile-menu-toggle">
                    <i class="si si-menu"></i>
                </div>
				<?php silicon_logo(); ?>
            </div>
            <div class="navbar-utils font-family-nav">
                <div class="inner">
					<?php silicon_navbar_utils(); ?>
                </div>
            </div>
        </div>

		<?php if ( ! silicon_is_offcanvas() ) : ?>
            <div class="menu-wrap">
				<?php silicon_menu_primary(); ?>
            </div>
		<?php endif; ?>

	</div>

	<?php if ( (bool) silicon_get_setting( 'header_is_sticky', 0 ) ) : ?>
        <div class="<?php silicon_navbar_stuck_class(); ?>"
             style="<?php silicon_navbar_stuck_style(); ?>" <?php silicon_navbar_stuck_attr(); ?>>

			<?php if ( silicon_is_search() ) : ?>
                <div class="site-search">
                    <div class="inner">
                        <div class="search-form">
							<?php get_search_form(); ?>
                            <div class="search-tools font-family-nav">
                                <span class="search-clear"><?php esc_html_e( 'Clear', 'silicon' ); ?></span>
                                <span class="search-close"><i class="si si-cross"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endif; ?>

            <div class="navbar-inner">
                <div class="navbar-branding">
                    <div class="mobile-menu-toggle">
                        <i class="si si-menu"></i>
                    </div>
					<?php silicon_logo_stuck(); ?>
                </div>
                <div class="navbar-utils font-family-nav">
                    <div class="inner">
						<?php silicon_navbar_utils(); ?>
                    </div>
                </div>
            </div>

			<?php if ( ! silicon_is_offcanvas() ) : ?>
                <div class="menu-wrap">
					<?php silicon_menu_primary(); ?>
                </div>
			<?php endif; ?>

        </div>
	<?php endif; ?>

</header>
