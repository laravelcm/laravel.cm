const mix = require('laravel-mix');
const path = require('path');

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

mix.disableNotifications();

mix.js('resources/js/app.js', 'public/js').react()
  .postCss('resources/css/app.css', 'public/css')
  .webpackConfig({
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
      extensions: ['*', '.js', '.jsx'],
      alias: {
        '@': path.resolve('./resources/js'),
        '@api': path.resolve('./resources/js/api'),
        '@components': path.resolve('./resources/js/components'),
        '@helpers': path.resolve('./resources/js/helpers'),
        "react": "preact/compat",
        "react-dom": "preact/compat"
      },
      modules: [
        'node_modules',
        __dirname + '/vendor/spatie/laravel-medialibrary-pro/resources/js',
      ]
    }
  });

if (mix.inProduction()) {
  mix.version();
}
