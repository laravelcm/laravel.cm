const mix = require('laravel-mix')
const path = require('path')

mix.disableNotifications()

mix.js('resources/js/app.js', 'public/js').react()
  .postCss('resources/css/app.css', 'public/css')
  .postCss('resources/css/filament.css', 'public/css')
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
    }
  })

if (mix.inProduction()) {
  mix.version()
}
