var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

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
    mix.sass('app.scss');
    mix.sass('bootstrap.scss');

    mix.browserify('app.js');

    // this can be tidied up likely.
    mix.copy('bower/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'public/css/bootstrap-datepicker.min.css');
    mix.copy('bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'public/js/bootstrap-datepicker.min.js');
});
