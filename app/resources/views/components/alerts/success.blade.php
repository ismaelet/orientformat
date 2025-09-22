@pushOnce('styles')
	<style>
		.success-message {
			padding-block: .5em;
			border: var(--border-width) solid var(--color-success-400);
			border-radius: calc(var(--border-radius-400) / 2);
			background-color: hsl(var(--color-success-400-hsl) / .1);
			box-shadow: 0px 1rem 2rem -1rem hsl(var(--color-success-400-hsl) / .2);
			text-align: center;

			:where(&:has(svg)) {
				--icon-size: 1em;
				display: flex;
				justify-content: center;
				align-items: center;
				gap: .5em;
			}
		}
	</style>
@endPushOnce

<p {{ $attributes->merge(['class' => 'success-message text-success-600']) }}>{{ $slot }}</p>
