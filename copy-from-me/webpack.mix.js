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

mix
    .js('themes/default/js/app.js', 'public/js')
    .copy('themes/default/js/focus-trap.js', 'public/js')
    .postCss("themes/default/css/app.css", "public/css", [
        require("postcss-nesting"),
        require("tailwindcss"),
    ])
