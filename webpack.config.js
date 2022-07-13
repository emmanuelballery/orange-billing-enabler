const Encore = require('@symfony/webpack-encore');
const path = require('path');
const pugLoader = path.resolve('./assets/js/webpack/pug-loader');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.ts')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableIntegrityHashes(Encore.isProduction())
    .enableTypeScriptLoader()
    .configureBabel(config => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    .configureBabelPresetEnv(config => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader()
    .enablePostCssLoader()
    .enableVueLoader(config => {
        config.compilerOptions = {preserveWhitespace: false};
    }, {
        runtimeCompilerBuild: false,
    })
    .addLoader({
        test: /\.pug$/,
        oneOf: [{
            exclude: /\.vue$/,
            use: [{loader: 'html-loader', options: {minimize: true, esModule: false}}, pugLoader],
        }, {
            use: [pugLoader],
        }],
        exclude: /node_modules/,
    })
    .configureDevServerOptions(options => {
        options.allowedHosts = 'all';
    });

module.exports = Encore.getWebpackConfig();
