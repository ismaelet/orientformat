@props([
    'name' => null,
    'value' => null,
    'required' => false,
    'options' => null,
    'placeholder' => null,
])

@pushOnce('styles')
	<style>
		.select {
			padding-inline: .75em;
			padding-block: .75em;
			border-radius: var(--radius-sm);
			outline: var(--border);
			line-height: 2.8;
			background-color: var(--color-surface-500);
			transition: outline-color 0.2s ease-in-out;

			&:focus {
				outline-color: var(--color-primary-400);
			}

			:has(> .input-warning) & {
				outline-color: var(--color-error-400);
			}
		}
	</style>
@endPushOnce

<select
	name="{{ $name }}"
	@if ($value) value="{{ $value }}" @endif
	@required($required)
	{{ $attributes->merge(['class' => 'select']) }}
>
	@if ($placeholder)
		<option
			selected
			value=""
		>{{ $placeholder }}</option>
	@endif

	@if ($options)
		@foreach ($options as $optionValue => $label)
			<option
				value="{{ $optionValue }}"
				@if ($optionValue == $value) selected @endif
			>
				{{ $label }}
			</option>
		@endforeach
	@else
		{{ $slot }}
	@endif
</select>
