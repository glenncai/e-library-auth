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

// add sourceMaps -> load the popper.js.map
mix.js('resources/js/app.js', 'public/js').sourceMaps()
.sass('resources/scss/app.scss', 'public/css');

// For production mode, we will disable notifications, but we should comment it in development mode.
// mix.disableNotifications();
