let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
require('laravel-mix-vue-svgicon');

mix.svgicon('resources/assets/images')
	.js('resources/assets/scripts/main.js', 'dist/js')
	.sass('resources/assets/styles/main.scss', 'dist/styles')
	.options({
		processCssUrls: false,
		postCss: [tailwindcss('./tailwind.config.js')],
	})
	.copyDirectory('resources/assets/fonts', 'dist/fonts')
	.copyDirectory('resources/assets/images', 'dist/images')
	.setPublicPath('dist')
	.extract()
	.browserSync('max.local');
