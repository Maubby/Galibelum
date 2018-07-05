if ( ! window.ajaxurl ) {
	window.ajaxurl = window.location.href;
}

/**
 * Callback for Products shortcode
 * Loads the terms by changing the current attribute
 *
 * @see mapping/silicon_products.php
 */
var siliconWCProductsAttributeDependencyCallback;

siliconWCProductsAttributeDependencyCallback = function () {
	(function ( $, shortcode ) {
		var $filter, $empty;
		var valuesNotFound = $( '<div class="vc_checkbox-label"><span>Values not found</span></div>' );

		$filter = $( '[data-vc-shortcode-param-name="query_filter"]', shortcode.$content );
		$filter.removeClass( 'vc_dependent-hidden' );

		$empty = $( '#query_filter-empty', $filter );
		if ( $empty.length ) {
			$empty.parent().remove();
			$( '.edit_form_line', $filter ).prepend( valuesNotFound );
		}

		$( 'select[name="query_attribute"]', shortcode.$content ).change( function ( e ) {
			// hide "query_filter if query_attribute = none and stop
			if ( 'none' == this.value ) {
				$filter.addClass( 'vc_dependent-hidden' );

				return;
			}

			$( '.vc_checkbox-label', $filter ).remove();
			$filter.removeClass( 'vc_dependent-hidden' );

			// to prevent removing checked boxes when user open shortcode settings
			// also send values of query_filter param
			// backend should return some boxes already checked

			$.ajax( {
				type: 'POST',
				dataType: 'json',
				url: window.ajaxurl,
				data: {
					action: 'silicon_wc_attribute_terms',
					attribute: this.value,
					value: shortcode.currentModelParams.query_filter,
					nonce: window.siliconPlugin.nonce
				}
			} ).done( function ( response ) {

				// if some error occur show error to console and "values not found" for user
				if ( false === response.success ) {
					console.log( [ 'silicon.products.response', response.data ] );
					$( '.edit_form_line', $filter ).prepend( valuesNotFound );

					return;
				}

				// show checkboxes
				$( '.edit_form_line', $filter ).prepend( $( response.data ) );
			} );
		} );
	}( window.jQuery, this ));
};