module.exports = {
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
    }
};