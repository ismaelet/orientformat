/** @type {import('tailwindcss').Config} */
export default {
	content: ['./pages/**/*.{php,js}', './app/**/*.{php,js}'],
	theme: {
		colors: {
			surface: 'hsl(var(--color-surface-400-hsl) / <alpha-value>)',
			'surface-400': 'hsl(var(--color-surface-400-hsl) / <alpha-value>)',
		},
		extend: {},
	},
	plugins: [],
}
