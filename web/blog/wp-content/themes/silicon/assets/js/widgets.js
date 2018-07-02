(function ( $ ) {
	'use strict';

	/* Silicon Gallery + Silicon Google Map */

	if ( typeof $.fn.equipMedia === 'function' ) {
		$( '.silicon-widget-gallery' ).equipMedia();
		$( document ).on( 'widget-added widget-updated', function ( e, widget ) {
			var base = widget.find( 'input[name="id_base"]' ).val();
			if ( 'silicon_gallery' === base || 'silicon_map' === base ) {
				var $field = widget.find( '.silicon-widget-gallery' );
				if ( $field.length === 0 ) {
					return;
				}

				$field.siblings( '.equip-media-wrapper' ).remove();
				$field.equipMedia();
			}
		} );
	}

	/* Silicon Button + Silicon Image Gallery */

	if ( typeof $.fn.equipIcon === 'function' ) {
		$( document ).on( 'widget-added widget-updated', function ( e, widget ) {
			var base = widget.find( 'input[name="id_base"]' ).val();
			if ( 'silicon_button' === base || 'silicon_gallery' === base ) {
				var $field = widget.find( '.equip-icon' );
				if ( $field.length === 0 ) {
					return;
				}

				// remove markup
				if ( $field.parent().is( 'div.equip-icon-select' ) ) {
					$field.siblings( 'i' ).remove();
					$field.siblings( '.equip-icon-button' ).remove();
					$field.unwrap( '.equip-icon-select' );
				}

				// re-init
				$field.equipIcon();
			}
		} );
	}

	/* Silicon Socials */

	if ( typeof $.fn.equipSocials === 'function' ) {
		$( '.silicon-socials' ).equipSocials( {} );
		$( document ).on( 'widget-added widget-updated', function ( e, widget ) {
			var base = widget.find( 'input[name="id_base"]' ).val();
			if ( 'silicon_socials' === base ) {
				var $field = widget.find( '.silicon-socials' );
				if ( $field.length === 0 ) {
					return;
				}

				// remove markup
				$field.siblings( '.equip-socials-wrap' ).remove();
				$field.siblings( '.equip-socials-add' ).remove();

				// re-init
				$field.equipSocials({});
			}
		} );
	}

	/* Limit widgets in sidebars */

	/**
	 * Restrict the allowed widgets in provided sidebar
	 *
	 * @param {jQuery} widget jQuery object
	 * @param {String} sidebar Sidebar selector
	 * @param {Array} allowed Allowed widgets for provided sidebar
	 */
	function siliconRestrictWidgets( widget, sidebar, allowed ) {
		var base = widget.find( 'input[name="id_base"]' ).val();

		if ( - 1 === $.inArray( base, allowed ) ) {
			var $sidebar = widget.parent( sidebar );

			$sidebar.addClass( 'widget-not-allowed' );
			setTimeout( function () {
				$sidebar.removeClass( 'widget-not-allowed' );
			}, 700 );

			widget.find( 'a.widget-control-remove' ).click();
		}
	}

	$( document ).on( 'widget-added', function ( e, widget ) {
		// Header Buttons sidebar
		if ( widget.parent( '#sidebar-header-buttons' ).length ) {
			siliconRestrictWidgets( widget, '#sidebar-header-buttons', [ 'silicon_button' ] );
		}

		// Mega Menu sidebar
		if ( widget.parent( '[id^="mega-menu-"]' ).length ) {
			siliconRestrictWidgets( widget, '[id^="mega-menu-"]', [
				'silicon_button',
				'categories',
				'pages',
				'nav_menu',
				'black-studio-tinymce'
			] );
		}
	} );
	
	/* Restrict widgets when user drag widget from another sidebar */

	$( document ).on( 'sortreceive', '#sidebar-header-buttons', function ( e, ui ) {
		if ( ui.helper !== null ) {
			return;
		}

		var widget = $( ui.item );
		siliconRestrictWidgets( widget, '#sidebar-header-buttons', [ 'silicon_button' ] );
	} );

	$( document ).on( 'sortreceive', '[id^="mega-menu-"]', function ( e, ui ) {
		if ( ui.helper !== null ) {
			return;
		}

		var widget = $( ui.item );
		siliconRestrictWidgets( widget, '[id^="mega-menu-"]', [
			'silicon_button',
			'categories',
			'pages',
			'nav_menu',
			'black-studio-tinymce'
		] );
	} );

})( jQuery );
