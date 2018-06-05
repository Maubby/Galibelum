var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/web')
    .addEntry('style', './assets/scss/main.scss')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableBuildNotifications()
    .enableSassLoader()
    .enableVersioning()


module.exports = Encore.getWebpackConfig();
