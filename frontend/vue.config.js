module.exports = {
    devServer: {
        proxy: 'http://bitter-project.test:81'
    },
    configureWebpack:{
        devtool: 'inline-source-map'
    },
    // output built static files to Laravel's public dir.
    // note the "build" script in package.json needs to be modified as well.
    outputDir: '../public/assets',

    publicPath: process.env.NODE_ENV === 'production'
        ? '/assets/'
        : '/',

    // modify the location of the generated HTML file.
    indexPath: process.env.NODE_ENV === 'production'
        ? '../resources/views/app.blade.php'
        : 'index.html',

    runtimeCompiler: true,
}
