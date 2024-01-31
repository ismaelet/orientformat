/** @type {import('tailwindcss').Config} */
export default {
	content: ['./pages/**/*.{php,js}', './app/**/*.{php,js}'],
	theme: {
		colors: {
			// Neutral light
			'neutral-light-100': 'hsl(var(--color-neutral-light-100-hsl) / <alpha-value>)',
			'neutral-light-200': 'hsl(var(--color-neutral-light-200-hsl) / <alpha-value>)',
			'neutral-light-400': 'hsl(var(--color-neutral-light-400-hsl) / <alpha-value>)',
			'neutral-light-700': 'hsl(var(--color-neutral-light-700-hsl) / <alpha-value>)',
			'neutral-light-900': 'hsl(var(--color-neutral-light-900-hsl) / <alpha-value>)',

			// Neutral dark
			'neutral-dark-900': 'hsl(var(--color-neutral-dark-900-hsl) / <alpha-value>)',

			// Neutral theme
			'neutral-100': 'hsl(var(--color-neutral-100-hsl) / <alpha-value>)',
			'neutral-200': 'hsl(var(--color-neutral-200-hsl) / <alpha-value>)',
			'neutral-300': 'hsl(var(--color-neutral-300-hsl) / <alpha-value>)',
			'neutral-400': 'hsl(var(--color-neutral-400-hsl) / <alpha-value>)',
			'neutral-700': 'hsl(var(--color-neutral-700-hsl) / <alpha-value>)',
			'neutral-900': 'hsl(var(--color-neutral-900-hsl) / <alpha-value>)',

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
