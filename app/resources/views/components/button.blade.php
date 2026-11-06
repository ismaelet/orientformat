@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'regular',
    'color' => 'default',
    'disabled' => false,
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

				&:disabled {
					pointer-events: none;
					filter: grayscale(100%);
					opacity: 0.6;
				}

				&[data-variant="primary"] {
					position: relative;
					isolation: isolate;
					padding-block: 1em;
					background-color: var(--color-primary-300);
					color: #fff;

					&::before {
						content: '';
						position: absolute;
						inset: 0;
						z-index: -1;
						background: linear-gradient(120deg, var(--color-primary-300), var(--color-transition-400), var(--color-tertiary-400));
						border-radius: inherit;
						transition: inherit;
					}

					/* Primary but ton: Hover state */
					&:hover::before {
						opacity: 0;
					}

					&[data-color="alternative"] {
						background-color: var(--color-secondary-300);

						&::before {
							background: linear-gradient(120deg, var(--color-secondary-300), var(--color-transition-400), var(--color-tertiary-400));
						}
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
						--_border-color: var(--color-tertiary-300);
						--_color: var(--color-tertiary-300);
					}

					.dark & {
						color: #fff;
						border-color: var(--color-slate-600);

						&:hover {
							color: var(--color-primary-400);
							border-color: var(--color-primary-400);
						}
					}

					&[data-color="primary"] {
						--_border-color: var(--color-primary-600);
						--_color: var(--color-primary-600);

						&:hover {
							--_border-color: var(--color-primary-400);
							--_color: var(--color-primary-400);
						}
					}

					&[data-color="secondary"] {
						--_border-color: var(--color-secondary-400);
						--_color: var(--color-secondary-400);

						&:hover {
							--_border-color: var(--color-secondary-300);
							--_color: var(--color-secondary-300);
						}
					}

					&[data-color="purple"] {
						--_border-color: var(--color-transition-400);
						--_color: var(--color-transition-400);

						&:hover {
							--_border-color: var(--color-transition-500);
							--_color: var(--color-transition-500);
						}
					}

					&[data-color="green"] {
						--_border-color: var(--color-green-800);
						--_color: var(--color-green-800);

						&:hover {
							--_border-color: var(--color-green-500);
							--_color: var(--color-green-500);
						}
					}

					&[data-color="danger"] {
						--_border-color: var(--color-error-400);
						--_color: var(--color-error-400);

						&:hover {
							--_border-color: var(--color-error-500);
							--_color: var(--color-error-500);
						}
					}

					&[data-color="success"] {
						--_border-color: var(--color-success-400);
						--_color: var(--color-success-400);

						&:hover {
							--_border-color: var(--color-success-500);
							--_color: var(--color-success-500);
						}
					}
				}

				&[data-size="small"] {
					min-width: 8rem;
					font-size: var(--font-size-300);
				}

				&[data-size="xs"] {
					min-width: 6rem;
					font-size: 0.8rem;
				}

				&[data-size="2xs"] {
					min-width: 5rem;
					font-size: 0.75rem;
				}

				&[data-size="auto"] {
					width: auto;
					min-width: unset;
				}

				&:has(svg) {
					display: flex;
					align-items: center;
					justify-content: space-between;

					&.center-icon {
						justify-content: center;
						gap: 0.5em;
					}

					:where(svg) {
						width: 1em;
						height: 1em;
						flex-shrink: 0;
					}
				}
			}
		</style>
	@endPushOnce
@endonce

@if ($href)
	<a
		href="{{ $href }}"
		{{ $attributes->class($classes) }}
		data-variant="{{ $variant }}"
		data-size="{{ $size }}"
		data-color="{{ $color }}"
	>{{ $slot }}</a>
@else
	<button
		type="{{ $type }}"
		{{ $attributes->class($classes) }}
		data-variant="{{ $variant }}"
		data-size="{{ $size }}"
		data-color="{{ $color }}"
		@disabled($disabled)
	>{{ $slot }}</button>
@endif
