const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/views/layouts/app.scss', 'public/css/bootstrap.css')
    .styles([
        'resources/css/style.css'
    ], 'public/css/app.css')
    .scripts([
        'node_modules/jquery/dist/jquery.min.js'], 'public/js/jquery.js')
    .scripts([
        'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js'], 'public/js/bootstrap.js')
    .scripts([
        'resources/js/app.js',
        'resources/js/notify.js'
    ], 'public/js/app.js')
    .version()
    .scripts([
        'resources/js/sw.js'], 'public/sw.js')
    .disableNotifications();