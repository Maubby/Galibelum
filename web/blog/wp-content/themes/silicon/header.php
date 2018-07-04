<?php
/**
 * The header for our theme
 *
 * @link   https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @author 8guild
 */

?><!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/**
 * Fires right before the <header>
 *
 * @see silicon_the_preloader() -1
 * @see silicon_offcanvas_cart() 5
 * @see silicon_offcanvas_menu() 5
 * @see silicon_menu_mobile() 5
 */
do_action( 'silicon_header_before' );

get_template_part( 'template-parts/headers/header', silicon_header_layout() );

/**
 * Fires right after the .site-header
 *
 * @see silicon_content_wrapper_open() 5
 * @see silicon_page_title() 10
 * @see silicon_intro() 10
 */
do_action( 'silicon_header_after' );
