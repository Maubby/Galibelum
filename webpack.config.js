var Encore = require('@symfony/webpack-encore');

// Including CopyWebpackPlugin to manage static images
const CopyWebpackPlugin = require('copy-webpack-plugin');


Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .autoProvidejQuery()
    .createSharedEntry('vendor', ['jquery', 'jquery-ui', 'bootstrap-sass', 'bootstrap-datepicker', 'bootstrap-sass/assets/stylesheets/_bootstrap.scss',
        'datatables.net-dt/css/jquery.dataTables.min.css', 'datatables.net-dt/js/dataTables.dataTables.min.js'])
    .addStyleEntry('style', './assets/scss/style.scss')
    .addStyleEntry('register', './assets/scss/register.scss')
    .addStyleEntry('login', './assets/scss/login.scss')
    .addStyleEntry('profile', './assets/scss/profile.scss')
    .addStyleEntry('organization_inscription', './assets/scss/organization_inscription.scss')
    .addStyleEntry('organization_show', './assets/scss/organization_show.scss')
    .addStyleEntry('contract_show', './assets/scss/contract_show.scss')
    .addStyleEntry('waiting', './assets/scss/waiting.scss')
    .addStyleEntry('dashboard', './assets/scss/dashboard.scss')
    .addStyleEntry('activity_show', './assets/scss/activity_show.scss')
    .addStyleEntry('inscription_choose', './assets/scss/inscription_choose.scss')
    .addStyleEntry('activity', './assets/scss/activity.scss')
    .addStyleEntry('offer', './assets/scss/offer.scss')
    .addStyleEntry('admin', './assets/scss/admin.scss')
    .addStyleEntry('manager', './assets/scss/manager.scss')
    .addStyleEntry('search', './assets/scss/search.scss')
    .addStyleEntry('page_404', './assets/scss/page_404.scss')
    .addStyleEntry('_variables', './assets/scss/_variables.scss')
    .addStyleEntry('check_confirmed_email', './assets/scss/check_confirmed_email.scss')
    .addStyleEntry('custom_datepicker', './assets/scss/custom_datepicker.scss')
    .addEntry('login_script', './assets/js/login_script.js')
    .addEntry('carousel', './assets/js/carousel.js')
    .addEntry('input_display', './assets/js/input_display.js')
    .addEntry('autocomplete', './assets/js/autocomplete.js')
    .addEntry('menu_toggle', './assets/js/menu_toggle.js')
    .addEntry('table_manager', './assets/js/table_manager.js')
    .addEntry('add_collection_widget', './assets/js/add_collection_widget.js')
    .addEntry('fees_calculator', './assets/js/fees_calculator.js')
    .addEntry('datepicker', './assets/js/datepicker.js')

    // Targeting images repository
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images'}
    ]));

module.exports = Encore.getWebpackConfig();
