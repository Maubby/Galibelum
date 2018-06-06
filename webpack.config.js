var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .addEntry('style', './assets/scss/style.scss')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning();

module.exports = Encore.getWebpackConfig();
