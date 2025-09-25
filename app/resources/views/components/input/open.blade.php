@pushOnce('styles')
	<style>
		.open-input {
			border: none !important;
			outline: none !important;
			border-bottom: 1px solid var(--color-neutral-300) !important;
			border-radius: 0;
			box-shadow: none;
		}

		.open-input:-internal-autofill-selected {
			background-color: var(--color-neutral-50) !important;
		}

		.open-input:focus {
			border-color: var(--color-primary-400) !important;
		}
	</style>
@endpushOnce

<input {{ $attributes->merge(['class' => 'open-input leading-[3] transition-colors']) }}>
