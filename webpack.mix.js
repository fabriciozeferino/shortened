const mix = require('laravel-mix');
require('laravel-mix-purgecss');

const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .browserSync('shortened.test');

// Globs adds node_module plug into to purgeCss lookup files
if (mix.inProduction()) {
    mix.purgeCss({
        globs: [
            path.join(__dirname, 'node_modules/laravel-vue-pagination/**/*.js'),
        ],
    }).version();
}

