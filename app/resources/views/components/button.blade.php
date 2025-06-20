@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'regular',
])

@php
	$classes = 'button px-16 rounded-full font-heading text-center text-sm sm:text-base transition-all';
@endphp

@once
	@pushOnce('styles')
		<style>
			.button {
				display: inline-block;
				position: relative;
				min-width: 12rem;
				cursor: pointer;

				&[data-variant="primary"] {
					position: relative;
					isolation: isolate;
					padding-block: 1em;
					background-color: var(--color-transition-400);
					color: #fff;

					&::before {
						content: '';
						position: absolute;
						inset: 0;
						z-index: -1;
						background: var(--gradient);
						border-radius: inherit;
						transition: inherit;
					}

					/* Primary button: Hover state */
					&:hover::before {
						opacity: 0;
					}
				}

				&[data-variant="secondary"] {
					--_border-width: 1px;
					--_border-color: currentColor;
					--_color: var(--color-neutral-700);
					padding-block: calc(1em - var(--border-width));
					border: var(--_border-width) solid var(--_border-color);
					color: var(--_color);

					&:hover {
						--_border-color: var(--color-primary-400);
						--_color: var(--color-primary-400);
					}
				}

				&[data-size="small"] {
					min-width: 8rem;
					font-size: var(--font-size-300);
				}

				&[data-size="auto"] {
					width: auto;
					min-width: unset;
				}

				&:has(svg) {
					display: flex;
				}
			}
		</style>
	@endPushOnce
@endonce

@if ($href)
	<a
		href="{{ $href }}"
		{{ $attributes->class($classes) }}"
		data-variant="{{ $variant }}"
		data-size="{{ $size }}"
	>{{ $slot }}</a>
@else
	<button
		type="{{ $type }}"
		{{ $attributes->class($classes) }}"
		data-variant="{{ $variant }}"
		data-size="{{ $size }}"
	>{{ $slot }}</button>
@endif
