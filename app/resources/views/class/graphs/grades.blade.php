@pushOnce('styles')
	<style>
		.grade {
			--color-1-of-5: #0c4aa8;
			--color-2-of-5: #6945a0;
			--color-3-of-5: #944192;
			--color-4-of-5: #b04480;
			--color-5-of-5: #c14e6e;
			flex-grow: 1;
			text-align: center;
			filter: saturate(0.2);
			transition: transform 0.2s, filter 0.2s;
		}

		.grade--highlighted {
			filter: saturate(1);
		}

		.grades:has(.grade:hover) .grade {
			filter: saturate(0.2);
		}

		.grade:hover {
			filter: saturate(1) !important;
		}

		.grade:nth-child(1) {
			--_color: var(--color-1-of-5);
		}

		.grade:nth-child(2) {
			--_color: var(--color-2-of-5);
		}

		.grade:nth-child(3) {
			--_color: var(--color-3-of-5);
		}

		.grade:nth-child(4) {
			--_color: var(--color-4-of-5);
		}

		.grade:nth-child(5) {
			--_color: var(--color-5-of-5);
		}

		.grade__number {
			--_size: 5rem;
			position: relative;
			z-index: 1;
			width: var(--_size);
			padding-left: 0.1em;
			margin-inline: auto;
			margin-bottom: calc(var(--_size) / 2 * -1);
			background-color: var(--_color);
			box-shadow: var(--shadow);
			border-radius: 50%;
			color: #fff;
			font-size: var(--fs-800);
			letter-spacing: 0.1em;
			line-height: var(--_size);
		}

		.grade__content {
			border: 1px solid transparent;
			border-radius: var(--border-radius-700);
			box-shadow: var(--shadow);
			transition: border 0.2s;
		}

		.grade__body {
			padding: 2rem;
			padding-top: 4rem;
		}

		.grade--highlighted .grade__content {
			border-color: var(--_color);
		}

		.grades:has(.grade:hover) .grade .grade__content {
			border-color: transparent;
		}

		.grade:hover .grade__content {
			border-color: var(--_color) !important;
		}

		.grade__name {
			font-size: var(--fs-600);
		}

		.grade__text {
			max-width: 300px;
			margin-inline: auto;
		}

		.grade__button {
			--_padding-block: 0.75em;
			background: var(--_color);
		}

		.grade__button,
		.grade__button::before {
			background: var(--_color) !important;
		}

		.grade__footer {
			padding-block: 0.5rem;
			background-color: var(--color-surface-400);
			overflow: hidden;
			border-bottom-left-radius: inherit;
			border-bottom-right-radius: inherit;
			position: relative;
		}

		.grade__footer::before {
			content: '';
			position: absolute;
			inset: 0;
			width: max(0.5rem, calc(var(--_percentage) * 1%));
			background-color: var(--_color);
		}

		.grade__progress {
			position: relative;
			font-family: var(--ff-titles);
			font-size: var(--fs-600);
			font-weight: var(--fw-black);
			text-shadow: 1px 1px 1px hsl(0, 0%, 0%, 0.2), -1px 1px 1px hsl(0, 0%, 0%, 0.2), 1px -1px 1px hsl(0, 0%, 0%, 0.2), -1px -1px 1px hsl(0, 0%, 0%, 0.2);
		}
	</style>
@endpushOnce

<x-layouts.class-dashboard :$class>

	<div class="columns-25rem grid min-h-[70svh] content-center items-center gap-8">

		@foreach ($grades as $key => $grade)
			<a
				class="grade relative"
				href="{{ route('class.general.graphs.index', [$class, $grade]) }}"
			>
				<div>
					<h3 class="grade__number ff-serif">{{ $grade->romanNumeral() }}</h3>

					<div class="grade__content">
						<div class="grade__body center-content grid gap-4">
							<h3 class="grade__name colored-title">Grafici del {{ $grade->ordinal() }} anno
							</h3>
							<p class="grade__text">
								Clicca qui per visualizzare i grafici relativi alle attività del
								{{ $grade->ordinal() }} anno.
							</p>
						</div>
					</div>
				</div>
			</a>
		@endforeach

	</div>

</x-layouts.class-dashboard>
