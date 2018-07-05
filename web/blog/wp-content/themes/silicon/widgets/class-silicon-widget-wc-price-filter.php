<?php

/**
 * Overrides the WooCommerce Price Filter widget
 *
 * @see    WC_Widget_Price_Filter
 * @author 8guild
 */
class Silicon_Widget_WC_Price_Filter extends WC_Widget_Price_Filter {

	public function __construct() {
		parent::__construct();
	}

	/**
	 * Output
	 *
	 * @see WC_Widget_Price_Filter::widget()
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		global $wp, $wp_the_query;

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) ) {
			return;
		}

		if ( ! $wp_the_query->post_count ) {
			return;
		}

		$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
		$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

		wp_enqueue_script( 'wc-price-slider' );

		// Find min and max price in current result set
		$prices = $this->get_filtered_price();
		$min    = floor( $prices->min_price );
		$max    = ceil( $prices->max_price );

		if ( $min === $max ) {
			return;
		}

		$this->widget_start( $args, $instance );

		if ( '' === get_option( 'permalink_structure' ) ) {
			$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
		} else {
			$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
		}

		/**
		 * Adjust max if the store taxes are not displayed how they are stored.
		 * Min is left alone because the product may not be taxable.
		 * Kicks in when prices excluding tax are displayed including tax.
		 */
		if ( wc_tax_enabled() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) && ! wc_prices_include_tax() ) {
			$tax_classes = array_merge( array( '' ), WC_Tax::get_tax_classes() );
			$class_max   = $max;

			foreach ( $tax_classes as $tax_class ) {
				if ( $tax_rates = WC_Tax::get_rates( $tax_class ) ) {
					$class_max = $max + WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max, $tax_rates ) );
				}
			}

			$max = $class_max;
		}

		// +Silicon custom output
		$tpl = '
		<form method="get" action="{action}">
			<div class="price_slider_wrapper">
				<div class="price_slider" style="display:none;"></div>
				<div class="price_slider_amount">
					<input type="text" id="min_price" name="min_price" value="{min}" data-min="{min-data}" placeholder="{min-placeholder}">
					<input type="text" id="max_price" name="max_price" value="{max}" data-max="{max-data}" placeholder="{max-placeholder}">
					<button type="submit" class="btn btn-solid btn-pill btn-sm btn-primary">{button}</button>
					<div class="price_label" style="display:none;">
						<span class="price-label-wrap">{price}</span>
						<span class="from"></span> &mdash; <span class="to"></span>
					</div>
					{query}
					<div class="clear"></div>
				</div>
			</div>
		</form>';

		$r = array(
			'{action}'          => esc_url( $form_action ),
			'{min}'             => esc_attr( $min_price ),
			'{min-data}'        => esc_attr( apply_filters( 'woocommerce_price_filter_widget_min_amount', $min ) ),
			'{min-placeholder}' => esc_attr__( 'Min price', 'silicon' ),
			'{max}'             => esc_attr( $max_price ),
			'{max-data}'        => esc_attr( apply_filters( 'woocommerce_price_filter_widget_max_amount', $max ) ),
			'{max-placeholder}' => esc_attr__( 'Max price', 'silicon' ),
			'{button}'          => esc_html__( 'Filter', 'silicon' ),
			'{price}'           => esc_html__( 'Price:', 'silicon' ),
			'{query}'           => wc_query_string_form_fields( null, array( 'min_price', 'max_price' ), '', true ),
		);

		echo str_replace( array_keys($r), array_values($r), $tpl );
		// -Silicon custom output

		$this->widget_end( $args );
	}
}