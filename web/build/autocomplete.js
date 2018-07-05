webpackJsonp([22],{

/***/ "./assets/js/autocomplete.js":
/*!***********************************!*\
  !*** ./assets/js/autocomplete.js ***!
  \***********************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

function initializeAutocomplete(id) {
    var element = document.getElementById(id);
    if (element) {
        var autocomplete = new google.maps.places.Autocomplete(element, { types: ['geocode'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}

function onPlaceChanged() {
    var place = this.getPlace();

    // console.log(place);  // Uncomment this line to view the full object returned by Google API.

    for (var i in place.address_components) {
        var component = place.address_components[i];
        for (var j in component.types) {
            // Some types are ["country", "political"]
            var type_element = document.getElementById(component.types[j]);
            if (type_element) {
                type_element.value = component.long_name;
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', function () {
    initializeAutocomplete('appbundle_activity_address');
    initializeAutocomplete('appbundle_organization_address');
});

/***/ })

},["./assets/js/autocomplete.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvYXV0b2NvbXBsZXRlLmpzIl0sIm5hbWVzIjpbImluaXRpYWxpemVBdXRvY29tcGxldGUiLCJpZCIsImVsZW1lbnQiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiYXV0b2NvbXBsZXRlIiwiZ29vZ2xlIiwibWFwcyIsInBsYWNlcyIsIkF1dG9jb21wbGV0ZSIsInR5cGVzIiwiZXZlbnQiLCJhZGRMaXN0ZW5lciIsIm9uUGxhY2VDaGFuZ2VkIiwicGxhY2UiLCJnZXRQbGFjZSIsImkiLCJhZGRyZXNzX2NvbXBvbmVudHMiLCJjb21wb25lbnQiLCJqIiwidHlwZV9lbGVtZW50IiwidmFsdWUiLCJsb25nX25hbWUiLCJhZGREb21MaXN0ZW5lciIsIndpbmRvdyJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7OztBQUFBLFNBQVNBLHNCQUFULENBQWdDQyxFQUFoQyxFQUFvQztBQUNoQyxRQUFJQyxVQUFVQyxTQUFTQyxjQUFULENBQXdCSCxFQUF4QixDQUFkO0FBQ0EsUUFBSUMsT0FBSixFQUFhO0FBQ1QsWUFBSUcsZUFBZSxJQUFJQyxPQUFPQyxJQUFQLENBQVlDLE1BQVosQ0FBbUJDLFlBQXZCLENBQW9DUCxPQUFwQyxFQUE2QyxFQUFFUSxPQUFPLENBQUMsU0FBRCxDQUFULEVBQTdDLENBQW5CO0FBQ0FKLGVBQU9DLElBQVAsQ0FBWUksS0FBWixDQUFrQkMsV0FBbEIsQ0FBOEJQLFlBQTlCLEVBQTRDLGVBQTVDLEVBQTZEUSxjQUE3RDtBQUNIO0FBQ0o7O0FBRUQsU0FBU0EsY0FBVCxHQUEwQjtBQUN0QixRQUFJQyxRQUFRLEtBQUtDLFFBQUwsRUFBWjs7QUFFQTs7QUFFQSxTQUFLLElBQUlDLENBQVQsSUFBY0YsTUFBTUcsa0JBQXBCLEVBQXdDO0FBQ3BDLFlBQUlDLFlBQVlKLE1BQU1HLGtCQUFOLENBQXlCRCxDQUF6QixDQUFoQjtBQUNBLGFBQUssSUFBSUcsQ0FBVCxJQUFjRCxVQUFVUixLQUF4QixFQUErQjtBQUFHO0FBQzlCLGdCQUFJVSxlQUFlakIsU0FBU0MsY0FBVCxDQUF3QmMsVUFBVVIsS0FBVixDQUFnQlMsQ0FBaEIsQ0FBeEIsQ0FBbkI7QUFDQSxnQkFBSUMsWUFBSixFQUFrQjtBQUNkQSw2QkFBYUMsS0FBYixHQUFxQkgsVUFBVUksU0FBL0I7QUFDSDtBQUNKO0FBQ0o7QUFDSjs7QUFFRGhCLE9BQU9DLElBQVAsQ0FBWUksS0FBWixDQUFrQlksY0FBbEIsQ0FBaUNDLE1BQWpDLEVBQXlDLE1BQXpDLEVBQWlELFlBQVc7QUFDeER4QiwyQkFBdUIsNEJBQXZCO0FBQ0FBLDJCQUF1QixnQ0FBdkI7QUFDSCxDQUhELEUiLCJmaWxlIjoiYXV0b2NvbXBsZXRlLmpzIiwic291cmNlc0NvbnRlbnQiOlsiZnVuY3Rpb24gaW5pdGlhbGl6ZUF1dG9jb21wbGV0ZShpZCkge1xuICAgIHZhciBlbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoaWQpO1xuICAgIGlmIChlbGVtZW50KSB7XG4gICAgICAgIHZhciBhdXRvY29tcGxldGUgPSBuZXcgZ29vZ2xlLm1hcHMucGxhY2VzLkF1dG9jb21wbGV0ZShlbGVtZW50LCB7IHR5cGVzOiBbJ2dlb2NvZGUnXSB9KTtcbiAgICAgICAgZ29vZ2xlLm1hcHMuZXZlbnQuYWRkTGlzdGVuZXIoYXV0b2NvbXBsZXRlLCAncGxhY2VfY2hhbmdlZCcsIG9uUGxhY2VDaGFuZ2VkKTtcbiAgICB9XG59XG5cbmZ1bmN0aW9uIG9uUGxhY2VDaGFuZ2VkKCkge1xuICAgIHZhciBwbGFjZSA9IHRoaXMuZ2V0UGxhY2UoKTtcblxuICAgIC8vIGNvbnNvbGUubG9nKHBsYWNlKTsgIC8vIFVuY29tbWVudCB0aGlzIGxpbmUgdG8gdmlldyB0aGUgZnVsbCBvYmplY3QgcmV0dXJuZWQgYnkgR29vZ2xlIEFQSS5cblxuICAgIGZvciAodmFyIGkgaW4gcGxhY2UuYWRkcmVzc19jb21wb25lbnRzKSB7XG4gICAgICAgIHZhciBjb21wb25lbnQgPSBwbGFjZS5hZGRyZXNzX2NvbXBvbmVudHNbaV07XG4gICAgICAgIGZvciAodmFyIGogaW4gY29tcG9uZW50LnR5cGVzKSB7ICAvLyBTb21lIHR5cGVzIGFyZSBbXCJjb3VudHJ5XCIsIFwicG9saXRpY2FsXCJdXG4gICAgICAgICAgICB2YXIgdHlwZV9lbGVtZW50ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoY29tcG9uZW50LnR5cGVzW2pdKTtcbiAgICAgICAgICAgIGlmICh0eXBlX2VsZW1lbnQpIHtcbiAgICAgICAgICAgICAgICB0eXBlX2VsZW1lbnQudmFsdWUgPSBjb21wb25lbnQubG9uZ19uYW1lO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfVxufVxuXG5nb29nbGUubWFwcy5ldmVudC5hZGREb21MaXN0ZW5lcih3aW5kb3csICdsb2FkJywgZnVuY3Rpb24oKSB7XG4gICAgaW5pdGlhbGl6ZUF1dG9jb21wbGV0ZSgnYXBwYnVuZGxlX2FjdGl2aXR5X2FkZHJlc3MnKTtcbiAgICBpbml0aWFsaXplQXV0b2NvbXBsZXRlKCdhcHBidW5kbGVfb3JnYW5pemF0aW9uX2FkZHJlc3MnKTtcbn0pO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL2F1dG9jb21wbGV0ZS5qcyJdLCJzb3VyY2VSb290IjoiIn0=