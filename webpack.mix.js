const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/fonts', 'public/fonts')
    .copyDirectory('resources/css', 'public/css')
    .copy('resources/images/favicon.ico', 'public/favicon.ico')
    .js('resources/js/app.js', 'public/js')
    // .js('resources/js/admin/index.js', 'public/js/admin/index.js')
    .js('resources/js/auth.js', 'public/js')
    .js('resources/js/account.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .sass('resources/sass/auth.scss', 'public/css/auth.css')
    .sass('resources/sass/popup-account.scss', 'public/css/account.css')
    .sass('resources/sass/web_launcher.scss', 'public/css/web_launcher.css')
    .version();

mix.js('resources/js/landing/index.js', 'public/js/landing.js') // tương tự JS    
    .copyDirectory('resources/images/landing', 'public/images/landing')
    .sass('resources/sass/landing.scss', 'public/css/landing.css')
    .version();

mix.js('resources/js/admin/index.js', 'public/js/admin/app.js') // tương tự JS
    .version();

// mix.js('vendor/tcg/voyager/resources/assets/js/app.js', 'public/voyager/js')
//     .sass('vendor/tcg/voyager/resources/assets/sass/app.scss', 'public/voyager/css');
