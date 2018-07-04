<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes, 8guild
 * @package WooCommerce/Templates
 * @version 2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) :
	return;
endif;

?>
<section class="pagination font-family-nav border-default-top border-default-bottom text-center margin-bottom-1x">
    <div class="pagination-links">
        <nav class="nav-links">
			<?php
			echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'type'      => 'plain',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'format'    => '',
				'add_args'  => false,
				'prev_next' => false,
				'end_size'  => 2,
				'mid_size'  => 2,
			) ) );
			?>
        </nav>
    </div>
</section>
