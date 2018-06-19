global.$ = global.jQuery = $;

// If you want require some css like : require('../scss/style.scss');
// If you want require only one script / Bootstrap's component : require('bootstrap-sass/assets/javascripts/bootstrap/tooltip');

$(function () {
    /* Activate modals function */
    $(window).on('load',function(){
        $('#modal').modal('show');
    });
});