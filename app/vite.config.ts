import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
	plugins: [
		laravel({
			input: ['resources/css/app.css', 'resources/js/app.js'],
			refresh: true,
		}),
	],
	server: {
		origin: process.env.VITE_SERVER_ORIGIN || 'http://localhost:5173',
		host: process.env.VITE_SERVER_HOST === 'true',
	},
})
