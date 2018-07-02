(function ( $, window, document ) {
	'use strict';

	/*!
	 * Fill in the "Display Category" select.
	 * Selected category will be shown on the post tile. See Posts screen.
	 */
	$( document ).on( 'change', '.wp-admin.post-type-post [name^="post_category"]', function ( e ) {
		var $catCheckbox = $( this );
		var $displaySel = $( '#equip-silicon-display-category-c' );

		var catID = $catCheckbox.val();
		var catName = $catCheckbox.parent( 'label' ).text().trim();

		// when user check the category append the option
		// to "Display Category" select. When uncheck - removes it!
		if ( $catCheckbox.is( ':checked' ) ) {
			var $option = $( '<option/>', {value: catID, text: catName} );
			$displaySel.append( $option );
		} else {
			$displaySel.find( 'option[value="' + catID + '"]' ).remove();
		}

		return true;
	} );

	/*!
	 * Show / hide meta boxes with Intro settings by various Type
	 * See "Add new Intro" screen.
	 */
	$( document ).on( 'change', '[data-slug="_silicon_intro_type"] > [data-key="type"]', function( e ) {
		const META_BOXES = [
			'#silicon-intro-app-showcase',
			'#silicon-intro-personal',
			'#silicon-intro-comparison-slider',
			'#silicon-intro-posts-slider'
		];

		var currentMetaBox = $( this ).find( '#equip-silicon-intro-type-type' ).val();
		var metaBoxes = META_BOXES.filter( function( metaBox ) {
			return ( - 1 === metaBox.search( currentMetaBox ) );
		} );

		$( metaBoxes.join( ', ' ) ).addClass( 'hide-if-js' );
		$( '#silicon-intro-' + currentMetaBox ).removeClass( 'hide-if-js' );
	} );

})( jQuery, window, document );
