/*!
 * siProgressBar - animate progress bars with Waypoint
 */
!function(a){a.fn.siProgressBar=function(){return"function"!=typeof Waypoint?(!1):this.each(function(){new Waypoint({element:a(this),offset:"88%",handler:function(a){this.element.css({width:this.element.data("progress-value")+"%"})}})})},a(function(){a("[data-progress-value]").siProgressBar()})}(jQuery);

/*!
 * siGallery - wrapper for PhotoSwipe light box
 */
(function( $, window, document ) {
	'use strict';

	function SiliconGallery( element ) {
		this.init( element );
	}

	SiliconGallery.prototype = {

		_defaults: {
			index: 0,
			bgOpacity: 0.9,
			showHideOpacity: true,
			closeOnScroll: false
		},

		init: function( element ) {
			var self = this;

			self.gallery = $( element );
			var settings = $.extend( true, {}, self._defaults );

			self.gridItems = self.gallery.find( '.grid-item' );
			self.galleryItems = self.getItems();
			self.gallery.on( 'click', '.grid-item', function( e ) {
				self.showGallery( e, settings, this );
			} );
		},

		getItems: function() {
			var self = this;
			var items = [];

			self.gallery.find( 'a' ).each( function( i, el ) {
				var $item = $( el );
				var size = $item.data( 'size' ).split( 'x' );
				var $caption = $item.find( 'figure' );

				var item = {
					src: $item.attr( 'href' ),
					w: parseInt( size[0], 10 ),
					h: parseInt( size[1], 10 )
				};

				if ( $caption.length ) {
					item.title = $caption.text();
				}

				items.push( item );
			} );

			return items;
		},

		showGallery: function( e, options, gridItem ) {
			var self = this;
			e.preventDefault();

			var index = $.inArray( gridItem, self.gridItems );
			if ( isNaN( index ) ) {
				return;
			}

			options.index = index; // update index
			self.showPhotoSwipe( self.galleryItems, options );
		},

		showPhotoSwipe: function( items, options ) {
			var pswp = document.querySelectorAll( '.pswp' )[0];
			var gallery = new PhotoSwipe( pswp, PhotoSwipeUI_Default, items, options );
			gallery.init();
		}
	};

	$.fn.siGallery = function () {
		if ( 'undefined' === typeof PhotoSwipe ) {
			return this;
		}

		if ( null === document.querySelector( '.pswp' ) ) {
			var t = document.querySelector( '#si-gallery-template' );
			$( 'body' ).append( t.content.querySelector( '.pswp' ) );
		}

		return this.each( function() {
			new SiliconGallery( this );
		} );
	};

	$( function() {
		$( '[data-si-gallery]' ).siGallery();
	} )

})( jQuery, window, document );

/*!
 * Theme Extended JS init files
 */
(function ($, document, window) {
    'use strict';

	// Get custom colors from Button and push them to head in style tag
	// Each button should have a "data-custom-color" attribute
	function collectCustomColor( selector ) {
		var $elements = $( selector );
		if ( $elements.length === 0 ) {
			return false;
		}

		var style = [];
		$.each( $elements, function ( i, element ) {
			var $element = $( element );
			style.push( $element.data( 'custom-color' ) );
		} );

		var css = style.join( "\n" );
		$( 'head' ).append( '<style type="text/css" class="silicon-custom-colors-css">' + css + '</style>' );
	}

	$( document ).ready( function () {

		/* Custom colors for buttons */
	    collectCustomColor( '[data-custom-color]' );

		// Counters
		if ( typeof $.fn.counterUp === 'function' ) {
			$( '.counter .counter-digit > span' ).counterUp( {
				delay: 10,
				time: 1100
			} );
		}

		// Call to Action
		if ( typeof $.fn.downCount === 'function' ) {
			$( '.si-cta-counter' ).each( function() {
				var $countDown = $( this );
				var date = $countDown.data( 'date-time' );
				if ( date.length === 0 ) {
					return true; // skip, call next counter
				}

				$countDown.downCount( {
					date: date
				} );
			} );
		}

		// Google Maps
		var $googleMaps = $( '.google-maps' );
		if ( $googleMaps.length > 0 && typeof $.fn.gmap3 === 'function' ) {
			$googleMaps.each( function () {
				var $map = $( this );
				var options = $map.data();
				var mapInstance = $map.gmap3( {
					address: options.address || 'New York, USA',
					zoom: options.zoom || 14,
					disableDefaultUI: options.disableControls,
					scrollwheel: options.scrollwheel,
					styles: options.styles || ''
				} ).then( function ( map ) {
					this.$.height( options.height || 400 );
				} );

				if ( options.hasOwnProperty( 'isMarker' ) && options.isMarker ) {
					mapInstance
						.marker( {
							address: options.address,
							icon: options.markerIcon || ''
						} )
						.infowindow( {
							content: options.markerTitle || ''
						} )
						.then( function ( infowindow ) {
							if ( infowindow.getContent() !== '' ) {
								var map = this.get( 0 );
								var marker = this.get( 1 );
								marker.addListener( 'mouseover', function () {
									infowindow.open( map, marker );
								} );
								marker.addListener( 'mouseout', function () {
									infowindow.close();
								} );
							}
						} );
					}
			} );
		}

		// Video Popup
		if ( typeof $.fn.magnificPopup === 'function' ) {
			$( '.video-popup-btn' ).magnificPopup( {
				type: 'iframe',
				mainClass: 'mfp-fade'
			} );
		}

    });

	// Switch pricing period on toggle click
	$( document ).on( 'click', '.pricing-toggle', function( e ) {
		e.preventDefault();
		var $switch = $( this );
		$switch.find( '.btn-toggle' ).toggleClass( 'on' );
		$switch.find( '.pricing-label' ).toggleClass( 'on' );
		$switch.parents( '.pricings-container' ).find( '.pricing' ).toggleClass( 'active' );
	} );

	// Portfolio: Isotope Filters
	$( document ).on( 'click', '.isotope-filter a', function ( e ) {
		e.preventDefault();

		var $this = $( this );
		var filter = $this.data( 'filter' );
		var $parent = $this.parent( 'li' );
		var $filter = $this.parents( '.isotope-filter' );
		var $grid = $( '#' + $filter.data( 'grid-id' ) );

		if ( $parent.hasClass( 'active' ) ) {
			return false;
		}

		// add class .active for recently clicked item
		$filter.find( '.active' ).removeClass( 'active' );
		$parent.addClass( 'active' );

		// make option object dynamically, i.e. { filter: '.my-filter-class' }
		// and apply new options to isotope containers
		$grid.isotope( { filter: filter } );

		return true;
	} );

	// Portfolio: Gallery LightBox
	$( document ).on( 'click', '[data-si-gallery-inline]', function( e ) {
		e.preventDefault();

		if ( 'undefined' === typeof PhotoSwipe ) {
			return false;
		}

		if ( null === document.querySelector( '.pswp' ) ) {
			var t = document.querySelector( '#si-gallery-template' );
			$( 'body' ).append( t.content.querySelector( '.pswp' ) );
		}

		var $self = $( this );
		var items = $self.data( 'si-gallery-inline' );
		var options = {
			index: 0,
			bgOpacity: 0.9,
			showHideOpacity: true,
			closeOnScroll: false
		};

		var pswp = document.querySelectorAll( '.pswp' )[0];
		var gallery = new PhotoSwipe( pswp, PhotoSwipeUI_Default, items, options );
		gallery.init();

		return true;
	} );

	// Portfolio: re-init carousel for list tile
	// this event fires after post load
	// fires for both Load More and Infinite Scroll
	// @see /silicon/assets/js/theme.js
	$( document ).on( 'load-more.silicon infinite-scroll.silicon', '[data-si-load-more], [data-si-infinite-scroll]', function ( e ) {
		var $el = $( this );
		var data = 'infinite-scroll' === e.type ? $el.data( 'si-infinite-scroll' ) : $el.data( 'si-load-more' );
		var $container = data.hasOwnProperty( 'gridID' ) ? $( '#' + data.gridID ) : $( '.isotope-grid' );
		if ( data.hasOwnProperty( 'type' ) && 'list' === data.type ) {
			$container.find( '[data-si-carousel]' ).siCarousel();
			$container.isotope( 'layout' );
		}
	} );

})(jQuery, document, window);
