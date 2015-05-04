var gulp = require('gulp');
var elixir = require('union-elixir');

elixir(function(mix) {
	mix.sass('screen.scss', 'public/webplate/project/css')
		.browserify('app.js', 'public/webplate/project/js/app.js');
});