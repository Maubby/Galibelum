/*!
 * siCarousel - wrapper for owlCarousel with data-attributes support
 */
(function($, window, document){
	'use strict';

	$.fn.siCarousel = function() {
		if ( 'undefined' === typeof $.fn.owlCarousel ) {
			return this;
		}

		return this.each( function() {
			var $el = $( this );
			var settings = $.extend( true, {}, $.fn.siCarousel.defaults, $el.data( 'si-carousel' ) );

			$el.owlCarousel( settings );
		} );
	};

	$.fn.siCarousel.defaults = {
		items: 3,
		loop: false,
		nav: false,
		dots: true,
		slideBy: 1,
		lazyLoad: false,
		autoplay: false,
		autoplayTimeout: 4e3,
		responsive: {},
		animateOut: false,
		animateIn: false,
		navText: ['<span class="si si-angle-left"></span>', '<span class="si si-angle-right"></span>']
	};

	// auto-init the plugin
	// after all images in carousel loaded
	$( function() {
		$( '[data-si-carousel]' ).imagesLoaded( function() {
			$( '[data-si-carousel]' ).siCarousel();
		} );
	} );

})(jQuery, window, document);

(function ($, document, window) {
    'use strict';

	function hasScrollbar() {
		// The Modern solution
		if ( typeof window.innerWidth === 'number' ) {
			return window.innerWidth > document.documentElement.clientWidth;
		}

		// rootElem for quirksmode
		var rootElem = document.documentElement || document.body;

		// Check overflow style property on body for fauxscrollbars
		var overflowStyle;

		if ( typeof rootElem.currentStyle !== 'undefined' ) {
			overflowStyle = rootElem.currentStyle.overflow;
		}

		overflowStyle = overflowStyle || window.getComputedStyle( rootElem, '' ).overflow;

		// Also need to check the Y axis overflow
		var overflowYStyle;

		if ( typeof rootElem.currentStyle !== 'undefined' ) {
			overflowYStyle = rootElem.currentStyle.overflowY;
		}

		overflowYStyle = overflowYStyle || window.getComputedStyle( rootElem, '' ).overflowY;

		var contentOverflows = rootElem.scrollHeight > rootElem.clientHeight;
		var overflowShown = /^(visible|auto)$/.test( overflowStyle ) || /^(visible|auto)$/.test( overflowYStyle );
		var alwaysShowScroll = overflowStyle === 'scroll' || overflowYStyle === 'scroll';

		return (contentOverflows && overflowShown) || alwaysShowScroll;
	}

	function ajaxFail( xhr, status, error ) {
		console.log( [ 'silicon.ajax.error', status, error, xhr, xhr.responseText ] );
	}

	function parsePosts( posts ) {
		var $posts = [];
		$.each( posts, function ( index, post ) {
			var parsed = $.parseHTML( post );
			$posts.push( parsed[ 0 ] );
		} );

		return $posts;
	}

	function updateMoreButton( $button, total, page, perPage ) {
		total = parseInt( total, 10 );
		page = parseInt( page, 10 );
		perPage = parseInt( perPage, 10 );

		var num = total - (page * perPage );
		if ( num <= 0 || total <= perPage ) {
			$button.parent( '.pagination' ).hide();
			return false;
		}

		num = ( num > perPage ) ? perPage : num;

		// replace the counter with new value
		$button.find( '[data-load-more-counter]' ).text( num );

		return true;
	}

	function initIsotope() {
		if ( 'undefined' === typeof $.fn.isotope ) {
			return;
		}

		$( '.isotope-grid' ).isotope( {
			itemSelector: '.grid-item',
			transitionDuration: '0.7s',
			masonry: {
				columnWidth: '.grid-sizer',
				gutter: '.gutter-sizer'
			}
		} );

		// re-built isotope layout on page resize
		$( window ).on( 'resize', function () {
			$( '.isotope-grid' ).isotope( 'layout' );
		} );

		// re-built isotope layout when owl carousel loaded
		$( '[data-si-carousel]' ).on( 'initialized.owl.carousel', function() {
			$( '.isotope-grid' ).isotope( 'layout' );
		} );
	}

	function initInfiniteScroll() {
		if ( 'undefined' === typeof $.fn.waypoint ) {
			return;
		}

		$( '[data-si-infinite-scroll]' ).waypoint( {
			offset: 'bottom-in-view',
			handler: function ( direction ) {
				if ( 'up' === direction ) {
					return false;
				}

				var $el = $( this.element );
				var loadingClass = 'loading';
				var data = $el.data( 'si-infinite-scroll' );

				var maxPages = parseInt( data.maxPages, 10 );
				var page = parseInt( $el.data( 'page' ), 10 );
				if ( isNaN( page ) ) {
					page = data.page;
				} else {
					data.page = page;
				}

				// do not load posts, if no more pages
				if ( page > maxPages ) {
					var noMore = $( '<p/>', {
						'class': 'no-more text-gray',
						text: data.noMore
					} );

					$el.parent( '.pagination' ).prepend( noMore );
					$el.hide();
					this.destroy(); // destroy waypoint
					return false;
				}

				$el.parent( '.pagination' ).addClass( loadingClass );
				$.post( silicon.ajaxurl, data )
				 .fail( function ( xhr, status, error ) {
					 $el.removeClass( loadingClass );
					 ajaxFail( xhr, status, error );
				 } )
				 .done( function ( response ) {
					 $el.parent( '.pagination' ).removeClass( loadingClass );
					 if ( false === response.success ) {
						 alert( response.data );
						 return;
					 }

					 $el.data( 'page', page + 1 );

					 var $posts = parsePosts( response.data );
					 var $container = data.hasOwnProperty( 'gridID' ) ? $( '#' + data.gridID ) : $( '.isotope-grid' );
					 $container.append( $posts ).isotope( 'appended', $posts );
					 $container.imagesLoaded().progress( function () {
						 $container.isotope( 'layout' );
					 } );

					 // refresh waypoint for allow further loading
					 Waypoint.refreshAll();

					 // trigger event
					 $el.trigger( 'infinite-scroll.silicon' );
				 } );
			}
		} );
	}

	$( document ).ready( function () {

		// Check if Page Scrollbar is visible
		//------------------------------------------------------------------
		if ( hasScrollbar() ) {
			$( 'body' ).addClass( 'hasScrollbar' );
		}

		// Site Search
		//------------------------------------------------------------------
		function searchActions( openTrigger, closeTrigger, clearTrigger, target ) {
			$( openTrigger ).on( 'click', function() {
				$( target ).addClass( 'search-visible' );
				setTimeout( function() {
					$( target + ' .site-search input' ).focus();
				}, 200);
			} );
			$( closeTrigger ).on( 'click', function() {
				$( target ).removeClass( 'search-visible' );
			} );
			$( clearTrigger ).on('click', function(){
				$( target + ' .site-search input' ).val('');
				setTimeout(function() {
					$( target + ' .site-search input' ).focus();
				}, 200);
			});
		}
		searchActions( '.navbar-horizontal:not(.navbar-sticky) .site-search-toggle', '.search-close', '.search-clear', '.navbar-horizontal:not(.navbar-sticky)' );
		searchActions( '.navbar-sticky .site-search-toggle', '.search-close', '.search-clear', '.navbar-sticky' );


		// Off-Canvas / Mobile Navigation / Cart
		//---------------------------------------------------------

		// Shopping Cart
		function offcanvasCart ( openTrigger, target, closeTrigger ) {
			$( openTrigger ).on( 'click', function() {
				$( target ).addClass( 'offcanvas-cart-in-view' );
				$( '[data-jarallax]' ).jarallax( 'destroy' ); // fix jarallax issue with off-canvas
			} );
			$( closeTrigger ).on( 'click', function() {
				$( target ).removeClass( 'offcanvas-cart-in-view' );
				$( '[data-jarallax]' ).jarallax();
			} );
		}
		offcanvasCart( '.cart-toggle', 'body', '.site-backdrop' );

		// Offcanvas Container
		function offcanvasMenu ( openTrigger, target, closeTrigger ) {
			$( openTrigger ).on( 'click', function() {
				$( target ).addClass( 'offcanvas-menu-in-view' );
				$( '[data-jarallax]' ).jarallax( 'destroy' ); // fix jarallax issue with off-canvas
			} );
			$( closeTrigger ).on( 'click', function() {
				$( target ).removeClass( 'offcanvas-menu-in-view' );
				$( '[data-jarallax]' ).jarallax();
			} );
		}
		offcanvasMenu( '.offcanvas-menu-toggle', 'body', '.site-backdrop' );

		// Mobile Container
		function mobileMenu( openTrigger, target, closeTrigger ) {
			$( openTrigger ).on( 'click', function() {
				$( target ).addClass( 'mobile-menu-in-view' );
			} );
			$( closeTrigger ).on( 'click', function() {
				$( target ).removeClass( 'mobile-menu-in-view' );
			} );
		}
		mobileMenu( '.mobile-menu-toggle', 'body', '.site-backdrop' );

		// Menu
		var menuInitHeight = $( '.offcanvas-container .main-navigation .menu' ).height(),
			backBtnText = $( '.offcanvas-container .main-navigation' ).data( 'back-btn-text' ) || 'Back',
			subMenu = $( '.offcanvas-container .main-navigation .sub-menu' );

		subMenu.each( function() {
			$( this ).prepend( '<li class="back-btn"><a href="#">' + backBtnText + '</a></li>' );
		} );

		var hasChildLink = $( '.offcanvas-container .menu-item-has-children > .sub-menu-toggle' ),
			backBtn = $( '.offcanvas-container .main-navigation .sub-menu .back-btn' );

		backBtn.on( 'click', function( e ) {
			var self = this,
				parent = $( self ).parent(),
				siblingParent = $( self ).parent().parent().siblings().parent(),
				menu = $( self ).parents( '.menu' );

			setTimeout( function() {
				$( self ).parent().parent().removeClass( 'current' );
			}, 250 );
			parent.removeClass( 'in-view' );
			siblingParent.removeClass( 'off-view' );
			if ( siblingParent.attr( "class" ) === "menu" ) {
				menu.velocity( {height: menuInitHeight}, 100 );
			} else {
				menu.velocity( {height: siblingParent.height()}, 100 );
			}

			e.preventDefault();
		} );

		hasChildLink.on( 'click', function( e ) {
			var self = this,
				parent = $( self ).parent().parent(),
				menu = $( self ).parents( '.menu' );

			parent.addClass( 'off-view' );
			setTimeout( function() {
				$( self ).parent().addClass( 'current' );
			}, 250 );
			$( self ).parent().find( '> .sub-menu' ).addClass( 'in-view' );
			menu.velocity( {height: $( self ).parent().find( '> .sub-menu' ).height()}, 100 );

			e.preventDefault();
			return false;
		} );

		// Wraps all select elements with div.form-select
		//---------------------------------------------------------
		$( 'select:not([multiple]):not(.country_select)' ).wrap( "<div class='form-select'></div>" );

		// Tabs Collapse On Mobile
		//---------------------------------------------------------
		var $navTabs = $( '.nav-tabs' );
		if ( typeof $.fn.tabCollapse === 'function' && $navTabs.length > 0 ) {
			$navTabs.tabCollapse();
		}

		// Scroll Spy
		$( '.fw-section' ).scrollSpy();

	} ); // End document ready

	$( window ).on( 'load', function () {
		initIsotope();
		initInfiniteScroll();
	} );

	// Smooth scroll to element
	$( document ).on( 'click', '.scroll-to', function ( event ) {
		var target = $( this ).attr( 'href' );
		if ( '#' === target ) {
			return false;
		}

		var $target = $( target );
		if( $target.length > 0 ) {
			var $elemOffsetTop = $target.data( 'offset-top' ) || 180;
			$( 'html' ).velocity( "scroll", {
				offset: $( this.hash ).offset().top - $elemOffsetTop,
				duration: 1000,
				easing: 'easeOutExpo',
				mobileHA: false
			} );
		}
		event.preventDefault();
	} );

	/**
	 * Shares
	 *
	 * @link https://dev.twitter.com/web/tweet-button/web-intent
	 * @link https://developers.google.com/+/web/share/#sharelink
	 * @link https://developers.google.com/+/web/share/#sharelink
	 */
	$( document ).on( 'click', '[data-si-share="true"]', function ( e ) {
		e.preventDefault();

		var $share = $( this );
		var query = {};
		var network = $share.data( 'network' );
		var wSettings = 'menubar=no,toolbar=no,resizable=yes,height=600,width=660,top=100';

		switch ( network ) {
			case 'twitter':
				query.text = $share.data( 'text' );
				query.url = $share.data( 'url' );
				window.open( 'http://twitter.com/intent/tweet?' + $.param( query ), network, wSettings );
				break;

			case 'facebook':
				query.u = $share.data( 'url' );
				window.open( 'https://www.facebook.com/sharer/sharer.php?' + $.param( query ), network, wSettings );
				break;

			case 'gplus':
				query.url = $share.data( 'url' );
				window.open( 'https://plus.google.com/share?' + $.param( query ), network, wSettings );
				break;

			case 'pinterest':
				query.url = $share.data( 'url' );
				query.media = $share.data( 'thumb' );
				query.description = $share.data( 'text' );
				window.open( 'https://pinterest.com/pin/create/button/?' + $.param( query ), network, wSettings );
				break;

			default:
				break;
		}

		$( '.entry-share' ).removeClass( 'popover-visible' );
	} );

	$( document ).on( 'click', '[data-si-popover="true"]', function ( e ) {
		e.preventDefault();
		$( this ).parents( '.entry-share' ).addClass( 'popover-visible' );
	} );

	$( document ).on( 'click', function ( e ) {
		var $share = $( '.entry-share' );
		if ( ! $( '[data-si-popover="true"]' ).is( e.target )
		     && ! $share.is( e.target )
		     && $share.has( e.target ).length === 0
		) {
			$share.removeClass( 'popover-visible' );
		}
	} );

	/*
	 * Animated Scroll to Top Button
	 */
	var $scrollTop = $( '.scroll-to-top-btn' );
	if ( $scrollTop.length > 0 ) {
		$( window ).on( 'scroll', function () {
			if ( $( this ).scrollTop() > 700 ) {
				$scrollTop.addClass( 'visible' );
			} else {
				$scrollTop.removeClass( 'visible' );
			}
		} );
		$scrollTop.on( 'click', function ( e ) {
			e.preventDefault();
			$( 'html' ).velocity( "scroll", {
				offset: 0,
				duration: 1100,
				easing: 'easeOutExpo',
				mobileHA: false
			} );
		} );
	}

	// Sticky header
	var lastScrollTop = 0, delta = 50;
	$( window ).on( 'scroll', function( e ) {
		var $sticky = $( '.navbar-sticky' );
		if ( $sticky.length === 0 ) {
			return;
		}

		var st = $( this ).scrollTop();
		if ( Math.abs( lastScrollTop - st ) <= delta ) {
			return;
		}

		var direction = st > lastScrollTop ? 'down' : 'up';
		lastScrollTop = st; // save the previous scrollTop value

		var offsetTrigger = 130; // magic number!
		if ( st >= offsetTrigger ) {
			$sticky.css('display', 'block');
			if ( 'up' === direction ) {
				$sticky.addClass( 'stuck' );
			} else {
				$sticky.removeClass( 'stuck' );
			}
		} else {
			$sticky.css('display', 'none');
			$sticky.removeClass( 'stuck' );
		}
	} );

	/**
	 * Add some additional classes to accordion
	 * after the transformation from tabs or tour with tabCollapse plugin
	 *
	 * @link https://github.com/flatlogic/bootstrap-tabcollapse
	 */
	$( document ).on( 'shown-accordion.bs.tabcollapse', function ( e ) {
		var $tabs = $( e.target );
		var $panelGroup = $tabs.siblings( '.panel-group' );

		var $panels = $panelGroup.find( '.panel' );
		$.each( $panels, function ( i, panel ) {
			var $panel = $( panel );
			var $contentEl = $panel.find( '.panel-collapse' );
			var $titleEl = $panel.find( '.panel-title>a' );

			$contentEl.addClass( 'border-default-bottom' );
			$titleEl.addClass( 'border-default-bottom' );
			$titleEl.prepend( '<span class="si si-plus text-gray"></span>' );

			if ( ! $contentEl.hasClass( 'in' ) ) {
				$titleEl.addClass( 'collapsed' );
			}
		} );

		if ( $tabs.parent( '.tabs' ).hasClass( 'tabs-light' ) ) {
			$panelGroup.addClass( 'panel-group-light' );
		}
	} );

	// Removes the close icon when transform from accordion to tabs
	$( document ).on( 'shown-tabs.bs.tabcollapse', function ( e ) {
		var $tabs = $( e.target );
		$tabs.find( 'a' ).replaceWith( function () {
			var el = $( this );
			var text = el.text();

			el.empty();
			el.text( text );

			return el;
		} );
	} );

	// Post Navigation: Show Popover on button hover
	var $prev_next_btns = '.post-nav-prev > .btn, .post-nav-next > .btn';
	$( document ).on( 'mouseenter', $prev_next_btns, function() {
		$( this ).parent().find( '.popover' ).addClass( 'is-visible' );
	} );
	$( document ).on( 'mouseleave', $prev_next_btns, function() {
		$( this ).parent().find( '.popover' ).removeClass( 'is-visible' );
	} );

	// Load More
	$( document ).on( 'click', '[data-si-load-more]', function( e ) {
		e.preventDefault();

		// collect data
		var $button = $( this );
		var loadingClass = 'loading';
		var data = $button.data( 'si-load-more' );

		// get stored page
		var page = parseInt( $button.data( 'page' ), 10 );
		if ( isNaN( page ) ) {
			page = data.page;
		} else {
			data.page = page;
		}

		// add loading class
		$button.parent( '.pagination' ).addClass( loadingClass );

		// send form
		$.post( silicon.ajaxurl, data )
		 .fail( function ( xhr, status, error ) {
			 // remove loading class
			 $button.removeClass( loadingClass );
			 ajaxFail( xhr, status, error );
		 } )
		 .done( function ( response ) {
			 $button.parent( '.pagination' ).removeClass( loadingClass );
			 if ( false === response.success ) {
				 alert( response.data );
				 return false;
			 }

			 // store page in data-attribute
			 // to be able to load more than one page
			 $button.data( 'page', page + 1 );

			 // append posts
			 var $posts = parsePosts( response.data );
			 var $container = data.hasOwnProperty( 'gridID' ) ? $( '#' + data.gridID ) : $( '.isotope-grid' );
			 $container.append( $posts ).isotope( 'appended', $posts );
			 $container.imagesLoaded().progress( function () {
				 $container.isotope( 'layout' );
			 } );

			 // update more button
			 var total = parseInt( data.total, 10 );
			 var perPage = parseInt( data.perPage, 10 );
			 updateMoreButton( $button, total, page, perPage );

			 // trigger event
			 $button.trigger( 'load-more.silicon' );
		 } );
	} );

})(jQuery, document, window);
