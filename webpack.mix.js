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

mix.react('resources/js/app.js', 'public/js')
    .sass('resources/sass/fonts.scss', 'public/css')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .copyDirectory('resources/img', 'public/img')
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts');
