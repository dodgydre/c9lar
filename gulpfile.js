var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

var paths = {
  'bs_fonts': 'node_modules/bootstrap-sass/assets/fonts',
  'fa_fonts': 'node_modules/font-awesome/fonts'
};

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
      .copy(paths.bs_fonts + 'bootstrap/**', 'public/fonts/bootstrap')
      .copy(paths.fa_fonts + '/**', 'public/fonts')
      .styles([
        '../../../node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
        '../../../node_modules/datatables/media/css/jquery.dataTables.css',
        '../../../node_modules/font-awesome/css/font-awesome.css',
        '../../../node_modules/selectize/dist/css/selectize.bootstrap3.css'
      ], 'public/css/lib.css')

      .browserify('app.js');

});
