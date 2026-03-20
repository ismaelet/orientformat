@pushOnce('styles')
	<style>
		button.test-button[data-progressive="true"] {
			position: relative;
			isolation: isolate;
			overflow: hidden;
			color: white;
			border: 1px solid var(--color-primary-400);

			&::before {
				content: '';
				position: absolute;
				top: 0;
				left: 0;
				z-index: -1;
				width: var(--_width, 0%);
				height: 100%;
				background-color: var(--color-primary-400);
				transition: width 0.3s ease-in-out, background 0.3s ease-in-out;
			}

			&:disabled {
				color: var(--color-neutral-500);

				&::before {
					background-color: var(--color-neutral-300);
				}
			}

			&:hover::before {
				background-color: var(--color-primary-500);
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', () => {
			const fields = document.querySelectorAll('.js-field');
			const button = document.querySelector('.test-button[data-progressive="true"]');

			if (!button || !fields.length) return;

			const isFilled = field => {
				if (field.tagName === 'SELECT') {
					const selectedOption = field.options[field.selectedIndex];

					return field.selectedIndex > 0 && selectedOption.value !== '';
				}

				return field.value.trim() !== '';
			};

			const updateProgress = () => {
				const filledFields = [...fields].filter(isFilled).length;
				const progress = (filledFields / fields.length) * 100;

				button.style.setProperty('--_width', `${progress}%`);
				button.disabled = progress !== 100;
			};

			fields.forEach(field => {
				field.addEventListener('input', updateProgress);
				field.addEventListener('change', updateProgress);
			});

			updateProgress();
		});
	</script>
@endpushOnce

<div class="contents">
	@if ($url)
		<x-button
			{{ $attributes->merge(['class' => 'test-button']) }}
			:href="$url"
			variant="secondary"
		>{{ $label }}</x-button>
	@else
		<x-button
			{{ $attributes->merge(['class' => 'test-button']) }}
			type="submit"
			data-progressive="{{ $progressive ? 'true' : 'false' }}"
			:disabled="$progressive ? true : false"
			:variant="$progressive ? 'secondary' : 'primary'"
		>
			{{ $label }}
		</x-button>
	@endif
</div>
