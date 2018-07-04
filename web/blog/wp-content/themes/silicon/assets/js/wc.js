/**
 * WooCommerce Additions
 * @author 8guild
 */
(function( $, document, window ) {
	'use strict';

	$( document ).on( 'click', '[data-si-rating]', function( e ) {
		e.preventDefault();
		var $star = $( this );
		var $target = $star.siblings( 'input[name="rating"]' );
		var rating = parseInt( $star.data( 'si-rating' ), 10 );

		$target.val( rating );
		$star.siblings( 'a' ).removeClass( 'active' );
		$star.addClass( 'active' );
	} );

	// For Slider Thumbs Active Element
	$( document ).on( 'click', '.flex-control-nav li', function( e ) {
		var activeEl = $(this);
		activeEl.siblings('li').removeClass('active');
		activeEl.addClass('active');
	} );

	$( window ).on( 'load', function( e ) {
		$( '.flex-active' ).parent( 'li' ).addClass( 'active' );
	} );

	// Add to cart event
	// NOTE: called on document ready event
	$( function() {
		$( document ).off( 'added_to_cart' ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
			$button = typeof $button === 'undefined' ? false : $button;

			// update button
			if ( $button ) {
				$button.removeClass( 'loading' );
				$button.addClass( 'added' );
				if ( typeof wc_add_to_cart_params !== 'undefined' ) {
					var $thumbWrapper = $button.parent( '.product-tile-body' ).siblings( '.product-thumb-wrapper' );
					if ( ! wc_add_to_cart_params.is_cart && $thumbWrapper.find( '.added_to_cart' ).length === 0 ) {
						var $link = $( '<a/>', {
							href: wc_add_to_cart_params.cart_url,
							'class': 'added_to_cart wc-forward si-added-to-cart background-success font-family-headings ',
							title: wc_add_to_cart_params.i18n_view_cart,
							text: wc_add_to_cart_params.i18n_view_cart
						} );

						$thumbWrapper.append( $link );
					}
				}

				// remove sibling added_to_cart
				$button.siblings( '.added_to_cart' ).hide();
			}

			// update counter
			var $counter = $( '[data-si-product-count]' );
			var currentQuantity = parseInt( $counter.data( 'si-product-count' ), 10 );
			var addedQuantity = parseInt( $button.data( 'quantity' ), 10 );
			var newQuantity = currentQuantity + addedQuantity;
			$counter.data( 'si-product-count', newQuantity ).text( newQuantity );

			// Replace fragments.
			if ( fragments ) {
				$.each( fragments, function( key, value ) {
					$( key ).replaceWith( value );
				});

				$( document.body ).trigger( 'wc_fragments_loaded' );
			}

			$( document.body ).trigger( 'cart_page_refreshed' );
		} );
	} );



})(jQuery, document, window);
