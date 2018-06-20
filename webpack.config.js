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
    .addStyleEntry('inscription-choose', './assets/scss/inscription-choose.scss')
    .addStyleEntry('organization_edit', './assets/scss/organization_edit.scss')
    .addStyleEntry('activity_new', './assets/scss/activity_new.scss')
    .addEntry('main', './assets/js/main.js')
    .addEntry('login-script', './assets/js/login-script.js')
    .addEntry('carousel', './assets/js/carousel.js')
    // Targeting images repository
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images'}
    ]));


module.exports = Encore.getWebpackConfig();