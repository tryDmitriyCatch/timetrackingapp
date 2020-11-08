const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('web', './assets/js/web.js')
    //.addEntry('page1', './assets/page1.js')
    //.addEntry('page2', './assets/page2.js')

    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enableSassLoader(options => {
        options.sassOptions.includePaths = [
            './assets/sass',
        ]
    })

    .enableReactPreset()
    //.addEntry('admin', './assets/admin.js')
    .configureBabel(babelConfig => {
        babelConfig.plugins.push('@babel/plugin-proposal-class-properties');
        babelConfig.plugins.push([
            'babel-plugin-root-import',
            {
                'rootPathSuffix': './assets',
                'rootPathPrefix': '~/'
            }
        ]);
    })

    .configureDefinePlugin(options => {
        let path = './.env-front';

        const env = dotenv.config({ path });

        if (env.error) {
            throw env.error;
        }

        options['process.env'].BASE_API_URL = JSON.stringify(env.parsed.BASE_API_URL);
    })
;

module.exports = Encore.getWebpackConfig();
