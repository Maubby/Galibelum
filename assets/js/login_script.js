global.$ = global.jQuery = $;

// If you want require some css like : require('../scss/style.scss');
// If you want require only one script / Bootstrap's component : require('bootstrap-sass/assets/javascripts/bootstrap/tooltip');

/* Activate modals function */
$(document).ready(function(){
    // Show the Modal on load
    $("#modal").modal("show");
});