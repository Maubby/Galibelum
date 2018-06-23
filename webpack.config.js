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
    .createSharedEntry('vendor', ['jquery', 'bootstrap-sass', 'bootstrap-sass/assets/stylesheets/_bootstrap.scss'])
    .addStyleEntry('style', './assets/scss/style.scss')
    .addStyleEntry('check_confirmed_email', './assets/scss/check_confirmed_email.scss')
    .addStyleEntry('organization_inscription', './assets/scss/organization_inscription.scss')
    .addStyleEntry('waiting', './assets/scss/waiting.scss')
    .addStyleEntry('login', './assets/scss/login.scss')
    .addStyleEntry('profile', './assets/scss/profile.scss')
    .addStyleEntry('register', './assets/scss/register.scss')
    .addStyleEntry('dashboard', './assets/scss/dashboard.scss')
    .addStyleEntry('inscription', './assets/scss/inscription_choose.scss')
    .addStyleEntry('offer', './assets/scss/offer.scss')
    .addStyleEntry('inscription-choose', './assets/scss/inscription-choose.scss')
    .addStyleEntry('activity', './assets/scss/activity.scss')
    .addEntry('login-script', './assets/js/login-script.js')
    .addEntry('carousel', './assets/js/carousel.js')
    .addEntry('datepicker', './assets/js/datepicker.js')
    .addEntry('login-script', './assets/js/login-script.js')
    .addEntry('carousel', './assets/js/carousel.js')
    .addEntry('input_display', './assets/js/input_display.js')
    // Targeting images repository
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images'}
    ]));

module.exports = Encore.getWebpackConfig();