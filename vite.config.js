import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { local } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.js'],
			refresh: true,
			fonts: [
				// Jost from google/fonts, cut down to latin + latin-ext and weights 300–500 with fonttools.
				local('Jost', {
					variants: [{ src: 'resources/fonts/jost-variable.woff2', weight: '300 500' }],
					variable: '--font-jost',
				}),
			],
		}),
		tailwindcss(),
	],
	server: {
		watch: {
			ignored: ['**/storage/framework/views/**'],
		},
	},
});
