/*!
 * Silicon Intro Sections
 * @author 8guild
 */
;(function( $, document, window ) {
	'use strict';

	// Comparison Slider
	function drags(e,a,n,i,o){e.on("mousedown vmousedown",function(s){e.addClass("draggable"),a.addClass("resizable");var r=e.outerWidth(),t=e.offset().left+r-s.pageX,d=n.offset().left,g=n.outerWidth(),m=d+10,u=d+g-r-10;e.parents().on("mousemove vmousemove",function(e){dragging||(dragging=!0,window.requestAnimationFrame?requestAnimationFrame(function(){animateDraggedHandle(e,t,r,m,u,d,g,a,i,o)}):setTimeout(function(){animateDraggedHandle(e,t,r,m,u,d,g,a,i,o)},100))}).on("mouseup vmouseup",function(n){e.removeClass("draggable"),a.removeClass("resizable")}),s.preventDefault()}).on("mouseup vmouseup",function(n){e.removeClass("draggable"),a.removeClass("resizable")})}function animateDraggedHandle(e,a,n,i,o,s,r,t,d,g){var m=e.pageX+a-n;i>m?m=i:m>o&&(m=o);var u=100*(m+n/2-s)/r+"%";$(".draggable").css("left",u).on("mouseup vmouseup",function(){$(this).removeClass("draggable"),t.removeClass("resizable")}),$(".resizable").css("width",u),dragging=!1}var dragging=!1,resizing=!1,imageComparisonContainers=$(".cd-image-container");$(window).on("load",function(){setTimeout(function(){imageComparisonContainers.addClass("is-visible")},600)}),imageComparisonContainers.each(function(){var e=$(this);drags(e.find(".cd-handle"),e.find(".cd-resize-img"),e,e.find('.cd-image-label[data-type="original"]'),e.find('.cd-image-label[data-type="modified"]'))});

	// Mobile App Showcase
	var $wrapper = $( '.intro-app-showcase' );
	$( '.platform-swith > a', $wrapper ).on( 'click', function( e ) {
		var $platform = $( this ).attr( 'href' );
		$( '.platform-swith > a' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		$( '[data-platform]', '' ).removeClass( 'active' );
		$( '[data-platform="' + $platform + '"]' ).addClass( 'active' );
		e.preventDefault();
	} );

})( jQuery, document, window );
