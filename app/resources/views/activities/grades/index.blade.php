@pushOnce('styles')
	<style>
		.grades {
			flex-wrap: wrap;
			justify-content: center;
			align-content: center;
			gap: 3rem;
			height: 100%;
			padding-block: 4rem;
		}

		.grade {
			max-width: 25rem;
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

		.grades--middleschool .grade:nth-child(1) {
			--_color: var(--color-primary-400);
		}

		.grades--middleschool .grade:nth-child(2) {
			--_color: var(--color-transition-400);
		}

		.grades--middleschool .grade:nth-child(3) {
			--_color: var(--color-secondary-400);
		}

		.grades--highschool .grade:nth-child(1) {
			--_color: var(--color-1-of-5);
		}

		.grades--highschool .grade:nth-child(2) {
			--_color: var(--color-2-of-5);
		}

		.grades--highschool .grade:nth-child(3) {
			--_color: var(--color-3-of-5);
		}

		.grades--highschool .grade:nth-child(4) {
			--_color: var(--color-4-of-5);
		}

		.grades--highschool .grade:nth-child(5) {
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
			font-size: var(--text-3xl);
			letter-spacing: 0.1em;
			line-height: var(--_size);
		}

		.grade__content {
			border: 1px solid transparent;
			border-radius: var(--radius-lg);
			box-shadow: var(--shadow-round);
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
			background-color: var(--color-slate-100);
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
			font-family: var(--font-heading);
			font-size: var(--text-lg);
			font-weight: var(--font-weight-bold);
			text-shadow: 1px 1px 5px hsl(0, 0%, 0%, 0.2), -1px 1px 5px hsl(0, 0%, 0%, 0.2), 1px -1px 5px hsl(0, 0%, 0%, 0.2), -1px -1px 5px hsl(0, 0%, 0%, 0.2);
		}
	</style>
@endpushOnce

<x-layouts.main>
	<div
		class="grades main-wrap {{ $class?->isMiddleSchool() ? 'grades--middleschool' : 'grades--highschool' }} flex items-center justify-center"
	>

		@if ($grades->isEmpty())
			<p class="mx-auto my-12 text-center text-3xl">Devi associarti ad una classe per poter visualizzare le
				attività.</p>
		@else
			@foreach ($grades as $key => $grade)
				<a
					class="grade {{ $grade->id == $class?->grade ? 'grade--highlighted' : '' }}"
					href="{{ route('activities.grades.show', $grade->id) }}"
				>
					<h3 class="grade__number font-serif!">{{ $grade->romanNumeral() }}</h3>

					<div class="grade__content">
						<div class="grade__body center-content grid gap-4">
							<x-heading.component>{{ __('misc.grade-description', ['numeral' => __($grade->ordinal())]) }}
							</x-heading.component>
							<p class="grade__text">
								{{ __('misc.grade-cta', ['numeral' => __($grade->ordinal())]) }}
							</p>
						</div>

						<div
							class="grade__footer contrasting-background grid"
							style="--_percentage: {{ $student->percentageSectionsCompletedInGrade($grade) }}"
						>
							<p class="grade__progress text-white">{{ $student->sectionsCompletedInGrade($grade) }} /
								{{ $grade->completable_sections->count() }}</p>
						</div>
					</div>
				</a>
			@endforeach
		@endif

	</div>
</x-layouts.main>
