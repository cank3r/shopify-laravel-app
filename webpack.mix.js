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

mix.js('resources/js/app.js', 'public/js')
	.scripts([
		'public/js/app.js'
		, 'resources/js/jquery-3.3.1.min.js'
		, 'resources/js/bootsrap.js'
		, 'resources/js/bootstrap-select.min.js'
		, 'resources/js/jquery.dataTables.min.js'
		, 'resources/js/dataTables.bootstrap4.js'
	], 'public/js/app.js')
	.sass('resources/sass/app.scss', 'public/css')
	.styles([
		'public/css/all.css'
	    , 'resources/sass/jquery.dataTables.min.css'
	    , 'resources/sass/dataTables.bootstrap4.css'
	    , 'resources/sass/bootstrap-select.min.css'
	], 'public/css/all.css');
