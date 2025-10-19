@pushOnce('styles')
	<style>
		.test-button[data-progressive="true"] {
			position: relative;
			isolation: isolate;
			overflow: hidden;

			&::before {
				content: '';
				position: absolute;
				top: 0;
				left: 0;
				width: var(--_width, 0%);
				height: 100%;
				background: var(--color-neutral-300);
				z-index: -1;
				transition: width 0.3s ease-in-out;
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
