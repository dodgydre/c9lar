var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

var paths = {
  'bs_fonts': 'node_modules/bootstrap-sass/assets/fonts',
  'fa_fonts': 'node_modules/font-awesome/fonts',
  'datatables_images': 'node_modules/datatables/media/images/'
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
      .copy(paths.datatables_images + '/*.png', 'public/images')

      .styles([
        '../../../node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
        '../../../node_modules/datatables/media/css/jquery.dataTables.css',
        '../../../node_modules/font-awesome/css/font-awesome.css',
        '../../../node_modules/selectize/dist/css/selectize.bootstrap3.css',
        '../../../node_modules/jasny-bootstrap/dist/css/jasny-bootstrap.css'
      ], 'public/css/lib.css')
      .styles([
        '../fullcalendar/fullcalendar.css'
      ], 'public/css/fullcalendar.css')
      .styles([
        'statement.css'
      ], 'public/css/statement.css')
      .browserify('app.js')
      .scripts('fullcalendar.js', 'public/js/fullcalendar.js')
      .scripts('moment.min.js', 'public/js/moment.min.js');
});
