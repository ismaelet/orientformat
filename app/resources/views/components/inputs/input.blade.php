@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'isolate' => false,
])

@pushOnce('styles')
	<style>
		.input {
			--input-background: transparent;
			padding-inline: .5em;
			background-color: var(--input-background);
			border-radius: .5rem;
			outline: var(--border);
			color: var(--color-neutral-700);
			line-height: 2.8;
			transition: outline-color 0.2s ease-in-out, background-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out, color 0.2s ease-in-out;

			/* Focus state */
			&:focus {
				outline-color: var(--color-primary-400);
			}

			/* Modern theme*/
			[data-theme="modern"] &:focus {
				background-color: var(--color-background);
			}

			/* Classic theme */
			[data-theme="classic"] & {
				outline-width: 2px;
				--input-background: var(--color-neutral-100);
			}

			/* Autofill resets */
			&:-webkit-autofill {
				outline: var(--border-width) solid var(--border-color) !important;
				-webkit-box-shadow: 0 0 0 100vw var(--input-background) inset !important;
				box-shadow: 0 0 0 100vw var(--input-background) inset !important;
				-webkit-text-fill-color: var(--color-neutral-700) !important;
				transition: none !important;
			}

			&:focus:-webkit-autofill {
				outline: var(--border-width) solid var(--color-primary-400) !important;
			}

			/* Has a warning */
			:has(> .error-warning) & {
				outline-color: var(--color-error-400);

				&:-webkit-autofill,
				&:focus:-webkit-autofill {
					outline-color: var(--color-error-400) !important;
				}
			}
		}

		.input-backgrond {
			background-color: hsl(var(--color-neutral-400-hsl));

			[data-theme="classic"] & {
				display: none;
			}
		}
	</style>
@endPushOnce

<input
	type="{{ $type }}"
	name="{{ $name }}"
	value="{{ $value }}"
	placeholder="{{ $placeholder }}"
	{{ $required ? 'required' : '' }}
	{{ $attributes->class(['input peer text-sm sm:text-base', 'relative z-[11]' => $isolate]) }}
/>

@if ($isolate)
	<span
		class="input-backgrond pointer-events-none fixed inset-0 z-10 opacity-0 transition-opacity peer-[:focus]:opacity-5 group-has-[:focus]:opacity-5"
	></span>
@endif
