let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .mix.react('resources/assets/js/react/index.jsx', 'public/js/react/app.js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .copyDirectory('resources/assets/img', 'public/img')
   .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
   .browserSync({
       proxy: 'localhost:8000',
       codeSync: false
   });
