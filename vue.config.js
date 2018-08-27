module.exports = {
    filenameHashing: false,
    outputDir: 'public/assets',
    devServer: {
        proxy: {
            '/ajax': {
                target: 'http://quiz.test/',
                ws: true,
                changeOrigin: true
            }
        }
    },
    pages: {
        index: {
            entry: 'resources/app.js'
        }
    },
    // css:{
    //     sourceMap: true
    // },
    chainWebpack: config => {
        if (process.env.NODE_ENV === 'production') {
            config.plugins.delete('html-index');
            config.plugins.delete('preload-index');
            config.plugins.delete('prefetch-index');
            config.plugins.delete('copy');
            config.optimization.delete('splitChunks');
        }
        const svgRule = config.module.rule('svg');
        svgRule.uses.clear();
        svgRule.use('vue-svg-loader').loader('vue-svg-loader');
    }
};