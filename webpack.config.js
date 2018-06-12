let Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .createSharedEntry('vendor', ['jquery','bootstrap-sass', 'bootstrap-sass/assets/stylesheets/_bootstrap.scss',])
    .addStyleEntry('style', './assets/scss/style.scss')
    .autoProvidejQuery()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning();

module.exports = Encore.getWebpackConfig();
