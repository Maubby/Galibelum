const $ = require('jquery');
global.$ = global.jQuery = $;

require('bootstrap-sass');

// If you want require some css like : require('../scss/style.scss');
// If you want require only one script / Bootstrap's component : require('bootstrap-sass/assets/javascripts/bootstrap/tooltip');

// To try tooltip JS component
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});