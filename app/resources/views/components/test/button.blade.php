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

			if (!button) return;

			fields.forEach(field => {
				field.addEventListener('input', () => {
					const filledFields = Array.from(fields).filter(f => f.value.trim() !== '').length;
					const progress = (filledFields / fields.length) * 100;
					button.style.setProperty('--_width', `${progress}%`);


					if (progress === 100) {
						button.disabled = false;
					} else {
						button.disabled = true;
					}
				});
			});
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
