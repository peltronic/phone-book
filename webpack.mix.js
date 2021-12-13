const mix = require('laravel-mix')
const path = require('path')

mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources', 'js'),
      '~': path.resolve(__dirname, 'resources', 'sass'),
      '@components': path.resolve(__dirname, 'resources', 'js', 'components'),
      //'@views': path.resolve(__dirname, 'resources', 'assets', 'js', 'views'),
      //'@routes': path.resolve(__dirname, 'resources', 'assets', 'js', 'routes'),
      //'@helpers': path.resolve(__dirname, 'resources', 'assets', 'js', 'helpers'),
      //'@mixins': path.resolve(__dirname, 'resources', 'assets', 'js', 'mixins'),
    },
  },
})

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/css/app.scss', 'public/css')
  .vue()
