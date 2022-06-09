const mix = require('laravel-mix')

mix.webpackConfig({
    stats: {
        children: true,
    },
})

mix.sass('resources/views/layouts/app.scss', 'public/css/bootstrap.min.css').sourceMaps()
    .css('resources/css/style.css', 'public/css/app.min.css').sourceMaps()
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.map')
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/js/bootstrap.bundle.min.js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js.map', 'public/js/bootstrap.bundle.min.js.map')
    .js([
        'resources/js/app.js',
        'resources/js/notification.js'
    ], 'public/js/app.min.js').sourceMaps()
    .scripts('resources/js/functions.js', 'public/js/functions.js')
    .version()
    .js('resources/js/sw.js', 'public/sw.js').sourceMaps()
    .disableNotifications()