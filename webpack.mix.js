const mix = require('laravel-mix');
const Dotenv = require('dotenv-webpack');

mix.webpackConfig({
  plugins: [new Dotenv()],
  resolve: {
    extensions: ['js', 'vue'],
    alias: {
      '@': __dirname + '/resources/js',
      '~': __dirname + '/resources/images'
    }
  },
  module: {
    rules: [
      {
        test: /\.s(c|a)ss$/
      }
    ]
  }
});

// mix
mix
  .sass('resources/scss/sb-admin-2.scss', 'public/css')
  .copy('resources/vendor', 'public/vendor')
  .copy('resources/js/sb-admin-2.min.js', 'public/js')
  .copy('resources/js/demo/datatables-demo.js', 'public/js/demo')

  .copyDirectory('resources/img', 'public/img')
  .version();

// // tailwind
// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
//     require('tailwindcss'),
//     require('autoprefixer'),
// ]);

