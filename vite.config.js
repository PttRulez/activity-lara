import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/css/app.css',
				'resources/js/app.js',
				'resources/static/favicon.ico'
			],
			refresh: true,
		}),
	],
	// build: {
  //       rollupOptions: {
  //           input: {
  //               app: resolve(__dirname, 'resources/js/app.js'),
  //               favicon: resolve(__dirname, 'resources/static/favicon.ico'), // Include favicon
  //           },
  //       },
  //   },
});
