/** @type {import('tailwindcss').Config} */
export default {
	content: ['./pages/**/*.{php,js}', './app/**/*.{php,js}'],
	theme: {
		colors: {
			surface: 'hsl(var(--color-surface-400-hsl) / <alpha-value>)',
			'surface-400': 'hsl(var(--color-surface-400-hsl) / <alpha-value>)',
		},
		borderRadius: {
			none: '0',
			sm: '0.125rem',
			DEFAULT: '.5rem',
			lg: '2rem',
			xl: '4rem',
			full: '9999px',
		},
		extend: {
			boxShadow: {
				DEFAULT: '0 1rem 4rem -1rem hsl(0, 0%, 0%, 0.15)',
				lg: '0 3rem 6rem -2rem hsl(0, 0%, 0%, 0.2)',
				focused: '0 3rem 3rem -2rem hsl(0, 0%, 0%, 0.2)',
			},
		},
	},
	plugins: [],
}
