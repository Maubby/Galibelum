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
    .addEntry('main', './assets/js/main.js')
    // Targeting images repository
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images'}
    ]));


module.exports = Encore.getWebpackConfig();