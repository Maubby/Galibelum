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
    .enableVersioning()
    .createSharedEntry('vendor', ['jquery', 'bootstrap-sass', 'bootstrap-sass/assets/stylesheets/_bootstrap.scss',
        'datatables.net-dt/css/jquery.dataTables.min.css', 'datatables.net-dt/js/dataTables.dataTables.min.js'])
    .addStyleEntry('style', './assets/scss/style.scss')
    .addStyleEntry('check_confirmed_email', './assets/scss/check_confirmed_email.scss')
    .addStyleEntry('organization_inscription', './assets/scss/organization_inscription.scss')
    .addStyleEntry('organization_show', './assets/scss/organization_show.scss')
    .addStyleEntry('waiting', './assets/scss/waiting.scss')
    .addStyleEntry('login', './assets/scss/login.scss')
    .addStyleEntry('profile', './assets/scss/profile.scss')
    .addStyleEntry('register', './assets/scss/register.scss')
    .addStyleEntry('dashboard', './assets/scss/dashboard.scss')
    .addStyleEntry('offer', './assets/scss/offer.scss')
    .addStyleEntry('inscription-choose', './assets/scss/inscription-choose.scss')
    .addStyleEntry('activity', './assets/scss/activity.scss')
    .addStyleEntry('admin', './assets/scss/admin.scss')
    .addStyleEntry('activity_index', './assets/scss/activity_index.scss')
    .addStyleEntry('manager', './assets/scss/manager.scss')
    .addStyleEntry('search', './assets/scss/search.scss')
    .addEntry('login-script', './assets/js/login-script.js')
    .addEntry('carousel', './assets/js/carousel.js')
    .addEntry('input_display', './assets/js/input_display.js')
    .addEntry('menu-toggle', './assets/js/menu-toggle.js')
    .addEntry('table-manager', './assets/js/table-manager.js')
    // Targeting images repository
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images'}
    ]));

module.exports = Encore.getWebpackConfig();
