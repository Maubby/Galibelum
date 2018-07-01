webpackJsonp([19],{

/***/ "./assets/js/carousel.js":
/*!*******************************!*\
  !*** ./assets/js/carousel.js ***!
  \*******************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {// Instantiate the Bootstrap carousel
$('.carousel').carousel({
    interval: false
});

// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
$('.carousel .carousel-inner .item').each(function () {
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    if (next.next().length > 0) {
        next.next().children(':first-child').clone().appendTo($(this));
    } else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
    }
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},["./assets/js/carousel.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvY2Fyb3VzZWwuanMiXSwibmFtZXMiOlsiJCIsImNhcm91c2VsIiwiaW50ZXJ2YWwiLCJlYWNoIiwibmV4dCIsImxlbmd0aCIsInNpYmxpbmdzIiwiY2hpbGRyZW4iLCJjbG9uZSIsImFwcGVuZFRvIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBQUE7QUFDQUEsRUFBRSxXQUFGLEVBQWVDLFFBQWYsQ0FBd0I7QUFDcEJDLGNBQVU7QUFEVSxDQUF4Qjs7QUFJQTtBQUNBO0FBQ0FGLEVBQUUsaUNBQUYsRUFBcUNHLElBQXJDLENBQTBDLFlBQVk7QUFDbEQsUUFBSUMsT0FBT0osRUFBRSxJQUFGLEVBQVFJLElBQVIsRUFBWDtBQUNBLFFBQUksQ0FBQ0EsS0FBS0MsTUFBVixFQUFrQjtBQUNkRCxlQUFPSixFQUFFLElBQUYsRUFBUU0sUUFBUixDQUFpQixRQUFqQixDQUFQO0FBQ0g7QUFDREYsU0FBS0csUUFBTCxDQUFjLGNBQWQsRUFBOEJDLEtBQTlCLEdBQXNDQyxRQUF0QyxDQUErQ1QsRUFBRSxJQUFGLENBQS9DOztBQUVBLFFBQUlJLEtBQUtBLElBQUwsR0FBWUMsTUFBWixHQUFxQixDQUF6QixFQUE0QjtBQUN4QkQsYUFBS0EsSUFBTCxHQUFZRyxRQUFaLENBQXFCLGNBQXJCLEVBQXFDQyxLQUFyQyxHQUE2Q0MsUUFBN0MsQ0FBc0RULEVBQUUsSUFBRixDQUF0RDtBQUNILEtBRkQsTUFFTztBQUNIQSxVQUFFLElBQUYsRUFBUU0sUUFBUixDQUFpQixRQUFqQixFQUEyQkMsUUFBM0IsQ0FBb0MsY0FBcEMsRUFBb0RDLEtBQXBELEdBQTREQyxRQUE1RCxDQUFxRVQsRUFBRSxJQUFGLENBQXJFO0FBQ0g7QUFDSixDQVpELEUiLCJmaWxlIjoiY2Fyb3VzZWwuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBJbnN0YW50aWF0ZSB0aGUgQm9vdHN0cmFwIGNhcm91c2VsXG4kKCcuY2Fyb3VzZWwnKS5jYXJvdXNlbCh7XG4gICAgaW50ZXJ2YWw6IGZhbHNlXG59KTtcblxuLy8gZm9yIGV2ZXJ5IHNsaWRlIGluIGNhcm91c2VsLCBjb3B5IHRoZSBuZXh0IHNsaWRlJ3MgaXRlbSBpbiB0aGUgc2xpZGUuXG4vLyBEbyB0aGUgc2FtZSBmb3IgdGhlIG5leHQsIG5leHQgaXRlbS5cbiQoJy5jYXJvdXNlbCAuY2Fyb3VzZWwtaW5uZXIgLml0ZW0nKS5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgbmV4dCA9ICQodGhpcykubmV4dCgpO1xuICAgIGlmICghbmV4dC5sZW5ndGgpIHtcbiAgICAgICAgbmV4dCA9ICQodGhpcykuc2libGluZ3MoJzpmaXJzdCcpO1xuICAgIH1cbiAgICBuZXh0LmNoaWxkcmVuKCc6Zmlyc3QtY2hpbGQnKS5jbG9uZSgpLmFwcGVuZFRvKCQodGhpcykpO1xuXG4gICAgaWYgKG5leHQubmV4dCgpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgbmV4dC5uZXh0KCkuY2hpbGRyZW4oJzpmaXJzdC1jaGlsZCcpLmNsb25lKCkuYXBwZW5kVG8oJCh0aGlzKSk7XG4gICAgfSBlbHNlIHtcbiAgICAgICAgJCh0aGlzKS5zaWJsaW5ncygnOmZpcnN0JykuY2hpbGRyZW4oJzpmaXJzdC1jaGlsZCcpLmNsb25lKCkuYXBwZW5kVG8oJCh0aGlzKSk7XG4gICAgfVxufSk7XG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL2Nhcm91c2VsLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==