webpackJsonp([20],{

/***/ "./assets/js/input_display.js":
/*!************************************!*\
  !*** ./assets/js/input_display.js ***!
  \************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {$(document).ready(function () {
    // On Select option changed
    $(".activity").change(function () {
        // Check if current value is "Évènement eSport"
        if ($(this).val() === "Évènement eSport") {
            // Remove default date value when you want to create an event and Show input
            $(".activityDate").removeAttr("value").show();
            // Remove n/a value when you want to create an event and Show input
            $(".activityAddress").val("").show();
            // Set n/a value when you want to create an event and Hide input field
            $(".activityAchievement").val('').hide();
        }

        if ($(this).val() === "Equipe eSport") {
            // Set default date value when you want to create a team and Hide input
            $(".activityDate").attr("value", "1993-07-07").hide();
            // Set n/a value when you want to create a team and Hide input
            $(".activityAddress").val("n/a").hide();
            // Remove n/a value when you want to create a team and Show input field
            $(".activityAchievement").show();
        }

        if ($(this).val() === "Activité de streaming") {
            // Set default value date when you want to create an activity and Hide input
            $(".activityDate").attr("value", "1993-07-07").hide();
            // Set n/a value when you want to create an activity and Hide input
            $(".activityAddress").val("n/a").hide();
            // Hide input field
            $(".activityAchievement").val('').hide();
        }

        if ($(this).val() === "") {
            // Set default value date when you want to create an activity and Hide input
            $(".activityDate").attr("value", "1993-07-07").hide();
            // Set n/a value when you want to create a team and Hide input
            $(".activityAddress").val("n/a").hide();
            // Hide input field
            $(".activityAchievement").val('').hide();
        }
    });
});
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ })

},["./assets/js/input_display.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaW5wdXRfZGlzcGxheS5qcyJdLCJuYW1lcyI6WyIkIiwiZG9jdW1lbnQiLCJyZWFkeSIsImNoYW5nZSIsInZhbCIsInJlbW92ZUF0dHIiLCJzaG93IiwiaGlkZSIsImF0dHIiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQSx5Q0FBQUEsRUFBRUMsUUFBRixFQUFZQyxLQUFaLENBQWtCLFlBQVc7QUFDekI7QUFDQUYsTUFBRSxXQUFGLEVBQWVHLE1BQWYsQ0FBc0IsWUFBVztBQUM3QjtBQUNBLFlBQUdILEVBQUUsSUFBRixFQUFRSSxHQUFSLE9BQWtCLGtCQUFyQixFQUF5QztBQUNyQztBQUNBSixjQUFFLGVBQUYsRUFBbUJLLFVBQW5CLENBQThCLE9BQTlCLEVBQXVDQyxJQUF2QztBQUNBO0FBQ0FOLGNBQUUsa0JBQUYsRUFBc0JJLEdBQXRCLENBQTBCLEVBQTFCLEVBQThCRSxJQUE5QjtBQUNBO0FBQ0FOLGNBQUUsc0JBQUYsRUFBMEJJLEdBQTFCLENBQThCLEVBQTlCLEVBQWtDRyxJQUFsQztBQUNIOztBQUVELFlBQUdQLEVBQUUsSUFBRixFQUFRSSxHQUFSLE9BQWtCLGVBQXJCLEVBQXNDO0FBQ2xDO0FBQ0FKLGNBQUUsZUFBRixFQUFtQlEsSUFBbkIsQ0FBd0IsT0FBeEIsRUFBZ0MsWUFBaEMsRUFBOENELElBQTlDO0FBQ0E7QUFDQVAsY0FBRSxrQkFBRixFQUFzQkksR0FBdEIsQ0FBMEIsS0FBMUIsRUFBaUNHLElBQWpDO0FBQ0E7QUFDQVAsY0FBRSxzQkFBRixFQUEwQk0sSUFBMUI7QUFDSDs7QUFFRCxZQUFHTixFQUFFLElBQUYsRUFBUUksR0FBUixPQUFrQix1QkFBckIsRUFBOEM7QUFDMUM7QUFDQUosY0FBRSxlQUFGLEVBQW1CUSxJQUFuQixDQUF3QixPQUF4QixFQUFnQyxZQUFoQyxFQUE4Q0QsSUFBOUM7QUFDQTtBQUNBUCxjQUFFLGtCQUFGLEVBQXNCSSxHQUF0QixDQUEwQixLQUExQixFQUFpQ0csSUFBakM7QUFDQTtBQUNBUCxjQUFFLHNCQUFGLEVBQTBCSSxHQUExQixDQUE4QixFQUE5QixFQUFrQ0csSUFBbEM7QUFDSDs7QUFFRCxZQUFHUCxFQUFFLElBQUYsRUFBUUksR0FBUixPQUFrQixFQUFyQixFQUF5QjtBQUNyQjtBQUNBSixjQUFFLGVBQUYsRUFBbUJRLElBQW5CLENBQXdCLE9BQXhCLEVBQWdDLFlBQWhDLEVBQThDRCxJQUE5QztBQUNBO0FBQ0FQLGNBQUUsa0JBQUYsRUFBc0JJLEdBQXRCLENBQTBCLEtBQTFCLEVBQWlDRyxJQUFqQztBQUNBO0FBQ0FQLGNBQUUsc0JBQUYsRUFBMEJJLEdBQTFCLENBQThCLEVBQTlCLEVBQWtDRyxJQUFsQztBQUNIO0FBQ0osS0FyQ0Q7QUFzQ0gsQ0F4Q0QsRSIsImZpbGUiOiJpbnB1dF9kaXNwbGF5LmpzIiwic291cmNlc0NvbnRlbnQiOlsiJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgLy8gT24gU2VsZWN0IG9wdGlvbiBjaGFuZ2VkXG4gICAgJChcIi5hY3Rpdml0eVwiKS5jaGFuZ2UoZnVuY3Rpb24oKSB7XG4gICAgICAgIC8vIENoZWNrIGlmIGN1cnJlbnQgdmFsdWUgaXMgXCLDiXbDqG5lbWVudCBlU3BvcnRcIlxuICAgICAgICBpZigkKHRoaXMpLnZhbCgpID09PSBcIsOJdsOobmVtZW50IGVTcG9ydFwiKSB7XG4gICAgICAgICAgICAvLyBSZW1vdmUgZGVmYXVsdCBkYXRlIHZhbHVlIHdoZW4geW91IHdhbnQgdG8gY3JlYXRlIGFuIGV2ZW50IGFuZCBTaG93IGlucHV0XG4gICAgICAgICAgICAkKFwiLmFjdGl2aXR5RGF0ZVwiKS5yZW1vdmVBdHRyKFwidmFsdWVcIikuc2hvdygpO1xuICAgICAgICAgICAgLy8gUmVtb3ZlIG4vYSB2YWx1ZSB3aGVuIHlvdSB3YW50IHRvIGNyZWF0ZSBhbiBldmVudCBhbmQgU2hvdyBpbnB1dFxuICAgICAgICAgICAgJChcIi5hY3Rpdml0eUFkZHJlc3NcIikudmFsKFwiXCIpLnNob3coKTtcbiAgICAgICAgICAgIC8vIFNldCBuL2EgdmFsdWUgd2hlbiB5b3Ugd2FudCB0byBjcmVhdGUgYW4gZXZlbnQgYW5kIEhpZGUgaW5wdXQgZmllbGRcbiAgICAgICAgICAgICQoXCIuYWN0aXZpdHlBY2hpZXZlbWVudFwiKS52YWwoJycpLmhpZGUoKTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmKCQodGhpcykudmFsKCkgPT09IFwiRXF1aXBlIGVTcG9ydFwiKSB7XG4gICAgICAgICAgICAvLyBTZXQgZGVmYXVsdCBkYXRlIHZhbHVlIHdoZW4geW91IHdhbnQgdG8gY3JlYXRlIGEgdGVhbSBhbmQgSGlkZSBpbnB1dFxuICAgICAgICAgICAgJChcIi5hY3Rpdml0eURhdGVcIikuYXR0cihcInZhbHVlXCIsXCIxOTkzLTA3LTA3XCIpLmhpZGUoKTtcbiAgICAgICAgICAgIC8vIFNldCBuL2EgdmFsdWUgd2hlbiB5b3Ugd2FudCB0byBjcmVhdGUgYSB0ZWFtIGFuZCBIaWRlIGlucHV0XG4gICAgICAgICAgICAkKFwiLmFjdGl2aXR5QWRkcmVzc1wiKS52YWwoXCJuL2FcIikuaGlkZSgpO1xuICAgICAgICAgICAgLy8gUmVtb3ZlIG4vYSB2YWx1ZSB3aGVuIHlvdSB3YW50IHRvIGNyZWF0ZSBhIHRlYW0gYW5kIFNob3cgaW5wdXQgZmllbGRcbiAgICAgICAgICAgICQoXCIuYWN0aXZpdHlBY2hpZXZlbWVudFwiKS5zaG93KCk7XG4gICAgICAgIH1cblxuICAgICAgICBpZigkKHRoaXMpLnZhbCgpID09PSBcIkFjdGl2aXTDqSBkZSBzdHJlYW1pbmdcIikge1xuICAgICAgICAgICAgLy8gU2V0IGRlZmF1bHQgdmFsdWUgZGF0ZSB3aGVuIHlvdSB3YW50IHRvIGNyZWF0ZSBhbiBhY3Rpdml0eSBhbmQgSGlkZSBpbnB1dFxuICAgICAgICAgICAgJChcIi5hY3Rpdml0eURhdGVcIikuYXR0cihcInZhbHVlXCIsXCIxOTkzLTA3LTA3XCIpLmhpZGUoKTtcbiAgICAgICAgICAgIC8vIFNldCBuL2EgdmFsdWUgd2hlbiB5b3Ugd2FudCB0byBjcmVhdGUgYW4gYWN0aXZpdHkgYW5kIEhpZGUgaW5wdXRcbiAgICAgICAgICAgICQoXCIuYWN0aXZpdHlBZGRyZXNzXCIpLnZhbChcIm4vYVwiKS5oaWRlKCk7XG4gICAgICAgICAgICAvLyBIaWRlIGlucHV0IGZpZWxkXG4gICAgICAgICAgICAkKFwiLmFjdGl2aXR5QWNoaWV2ZW1lbnRcIikudmFsKCcnKS5oaWRlKCk7XG4gICAgICAgIH1cblxuICAgICAgICBpZigkKHRoaXMpLnZhbCgpID09PSBcIlwiKSB7XG4gICAgICAgICAgICAvLyBTZXQgZGVmYXVsdCB2YWx1ZSBkYXRlIHdoZW4geW91IHdhbnQgdG8gY3JlYXRlIGFuIGFjdGl2aXR5IGFuZCBIaWRlIGlucHV0XG4gICAgICAgICAgICAkKFwiLmFjdGl2aXR5RGF0ZVwiKS5hdHRyKFwidmFsdWVcIixcIjE5OTMtMDctMDdcIikuaGlkZSgpO1xuICAgICAgICAgICAgLy8gU2V0IG4vYSB2YWx1ZSB3aGVuIHlvdSB3YW50IHRvIGNyZWF0ZSBhIHRlYW0gYW5kIEhpZGUgaW5wdXRcbiAgICAgICAgICAgICQoXCIuYWN0aXZpdHlBZGRyZXNzXCIpLnZhbChcIm4vYVwiKS5oaWRlKCk7XG4gICAgICAgICAgICAvLyBIaWRlIGlucHV0IGZpZWxkXG4gICAgICAgICAgICAkKFwiLmFjdGl2aXR5QWNoaWV2ZW1lbnRcIikudmFsKCcnKS5oaWRlKCk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pO1xuXG5cblxuLy8gV0VCUEFDSyBGT09URVIgLy9cbi8vIC4vYXNzZXRzL2pzL2lucHV0X2Rpc3BsYXkuanMiXSwic291cmNlUm9vdCI6IiJ9