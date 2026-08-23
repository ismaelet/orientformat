@pushOnce('styles')
	<style>
		.title {
			background: -webkit-linear-gradient(180deg, var(--color-primary-400), var(--color-secondary-400));
			font-size: var(--text-900);
			-webkit-background-clip: text !important;
			-webkit-text-fill-color: transparent;

			[data-school-group='highschool'] & {
				background: -webkit-linear-gradient(180deg, var(--color-transition-400), var(--color-secondary-400));
			}
		}

		.page__header span {
			color: var(--color-tertiary-400);
			font-weight: var(--font-weight-bold);
		}

		.area-wrapper {
			--_slope: min(4rem, 8vw);
			--_padding: 4rem;
			padding-block: var(--_padding) calc(var(--_padding) + var(--_slope) / 2);
		}

		.area-wrapper:nth-child(2n + 1) {
			background-color: var(--color-background-500);
			clip-path: polygon(0 0, 100% 0, 100% calc(100% - var(--_slope)), 0 100%);
		}

		.area-wrapper:last-child {
			clip-path: unset;
		}

		.progress-bar {
			position: relative;
			overflow: hidden;
			padding-block: 1rem;
			background-color: var(--color-background-400);
			border-bottom-left-radius: inherit;
			border-bottom-right-radius: inherit;
			text-align: center;
		}

		.progress-bar::before {
			content: '';
			position: absolute;
			inset: 0;
			width: max(1rem, calc(var(--_percentage) * 1%));
			background: var(--gradient);
		}

		.progress-bar__value {
			position: relative;
			font-family: var(--ff-titles);
			font-size: var(--fs-600);
			font-weight: var(--font-weight-black);
			text-shadow: 1px 1px 0px hsl(0, 0%, 0%, 0.2), -1px 1px 0px hsl(0, 0%, 0%, 0.2), 1px -1px 0px hsl(0, 0%, 0%, 0.2), -1px -1px 0px hsl(0, 0%, 0%, 0.2);
		}

		.sections {
			display: flex;
			flex-wrap: wrap;
			gap: 2rem;
			justify-content: center;
		}

		.section-wrapper {
			flex-basis: 23rem;
			display: grid;
		}

		.section {
			display: grid;
			grid-template-rows: 7rem 1fr;
			overflow: hidden;
			background-color: #fff;
			border-radius: var(--radius-xl);
			box-shadow: 0 1rem 2rem -1rem var(--color-neutral-border);
			text-align: center;
			transition: background-color 0.3s, box-shadow 0.3s;
		}

		.section:hover {
			box-shadow: var(--shadow);
		}

		.section-img {
			overflow: hidden;
			background-color: var(--color-background-400);
			color: var(--_section-color);
			box-shadow: 0 0 1rem var(--color-neutral-border);
		}

		.section__icon {
			height: 45%;
			transition: transform 0.3s, color 0.3s;
		}

		.section.completed .section__icon,
		.section:hover .section__icon {
			color: #fff;
		}

		.section:not(.completed):hover .section__icon {
			transform: scale(1.2);
		}

		.section-img-over {
			justify-self: left;
			position: relative;
			z-index: -2;
			translate: 60% 0;
			opacity: 0.4;
			width: calc(100% + 5rem);
			height: 100%;
			background-color: var(--_section-color);
			clip-path: polygon(5rem 0, 100% 0, 100% 100%, 0% 100%);
			transition: opacity 0.3s ease-out, translate 0.3s ease-out;
		}

		.section.completed .section-img-over,
		.section:hover .section-img-over {
			translate: -5rem 0;
			opacity: 1;
		}

		.section__body {
			--_spacing: 1rem;
			display: grid;
			align-content: center;
			border-bottom-left-radius: inherit;
			border-bottom-right-radius: inherit;
			padding: var(--_spacing) 2rem;
		}

		.area-wrapper:nth-child(2n) .section {
			border: 1px solid var(--color-neutral-border);
		}

		.section__content {
			padding-block: var(--_spacing);
			transition: translate 0.3s;
		}

		.section:hover .section__content {
			translate: 0 calc(var(--_spacing) * -1.5);
		}

		.section-desc {
			max-width: 40ch;
		}

		.section__progress {
			--icon-size: 0.8em;
			gap: 0.25rem;
			margin-top: 0.25rem;
			color: var(--color-tertiary-400);
		}

		.section__cta-wrapper {
			--_height: calc(var(--_spacing) * 2);
			margin-top: calc(var(--_height) * -1);
			transition: opacity 0.3s, transform 0.3s;
		}

		.section__cta {
			padding-block: 0;
			opacity: 0;
			color: var(--_section-color) !important;
			border-color: var(--_section-color) !important;
			border-style: dashed !important;
			transform: scale(0.7);
			transition: opacity 0.3s, transform 0.3s;
		}

		.section:hover .section__cta {
			opacity: 1;
			transform: scale(1);
		}

		.section-color {
			--_h: calc((var(--_h-start) - var(--_h-range) / 2) + var(--_h-range) * (var(--counter) - 1));
			--_section-color: hsl(var(--_h), var(--_s), var(--_l));
		}

		.section-color--area-1 {
			--_h-start: 41;
			--_h-range: -5;
			--_s: 100%;
			--_l: 50%;
		}

		.section-color--area-2 {
			--_h-start: 216;
			--_h-range: 15;
			--_s: 100%;
			--_l: 37%;
		}

		.section-color--area-3 {
			--_h-start: 216;
			--_h-range: 40;
			--_s: 100%;
			--_l: 35%;
		}

		.section-color--area-4 {
			--_h-start: 310;
			--_h-range: 20;
			--_s: 100%;
			--_l: 35%;
		}

		.section-color--area-reviews {
			--_h-start: 120;
			--_h-range: 70;
			--_s: 100%;
			--_l: 45%;
		}

		.section-color:nth-child(1) {
			--counter: 1;
		}

		.section-color:nth-child(2) {
			--counter: 2;
		}

		.section-color:nth-child(3) {
			--counter: 3;
		}

		.section-color:nth-child(4) {
			--counter: 4;
		}

		.section-color:nth-child(5) {
			--counter: 5;
		}

		.section-color:nth-child(6) {
			--counter: 6;
		}

		.section-color:nth-child(7) {
			--counter: 7;
		}

		.section-color:nth-child(8) {
			--counter: 8;
		}

		.section-color:nth-child(9) {
			--counter: 9;
		}

		.section-color:nth-child(10) {
			--counter: 10;
		}

		.section-color:nth-child(11) {
			--counter: 11;
		}

		.section-color:nth-child(12) {
			--counter: 12;
		}

		.section-color:nth-child(13) {
			--counter: 13;
		}

		.gradient-overlay {
			position: relative;
			isolation: isolate;
		}

		.gradient-overlay::before {
			content: '';
			position: absolute;
			inset: 0;
			z-index: -1;
			opacity: 0.4;
			background: linear-gradient(135deg, hsl(0, 0%, 100%, 1), hsl(0, 0%, 0%, 1));
			mix-blend-mode: overlay;
		}

		.gradient-overlay--hover {
			overflow: hidden;
		}

		.gradient-overlay--hover::before {
			border-radius: inherit;
			opacity: 0;
			transition: opacity 0.4s;
		}

		.gradient-overlay--hover:hover::before {
			opacity: 1;
		}
	</style>
@endpushOnce

<x-layouts.main>
	<div class="page__header py-20">
		<div class="grid justify-items-center gap-8 text-center">
			<div>
				<x-heading.main class="title">
					{{ ucfirst(__($grade->ordinal())) }} {{ __('year') }}
				</x-heading.main>

				<p class="text-2xl">
					{{ __('misc.grade-percentage') }}
					<span>
						{{ $student->percentageSectionsCompletedInGrade($grade) }}%
					</span>
				</p>
			</div>

			<x-button
				href="{{ route('activities.grades.index') }}"
				variant="secondary"
			>
				{{ __('misc.change-year') }}
			</x-button>
		</div>
	</div>

	<div class="areas full-width">
		@foreach ($grade->areas as $area)
			<div class="area-wrapper full-width">
				<section class="area grid gap-8">
					<div class="area__header text-center">
						<x-heading.section class="area__title">
							{{ __('areas.' . $area->id) }}
						</x-heading.section>

						<p class="section-subtitle text-lg">
							{{ $area->description }}
						</p>

						{{-- Read more --}}
						@if ($area->id == 4)
							<x-button
								href="{{ route('analysis.student.area', $area) }}"
								variant="secondary"
								class="mt-8 gap-2 justify-self-center"
							>
								<x-icon-read class="w-5" />

								{{ __('Know More') }}
							</x-button>
						@endif
					</div>

					<div class="sections mt-8">
						@foreach ($grade->sectionsInArea($area) as $key => $section)
							<div
								class="section-wrapper fade-in-bottom section-color section-color--area-{{ $section->areaId }} animation-delay-{{ (($key - 1) % 3) * 100 }}"
							>
								<a
									href="{{ $section->url() }}"
									@class([
										'section',
										'grid-cols-1',
										'completed' =>
											!$section->isCompletable() ||
											$student->percentageTestsCompletedInSection($section) === 100,
									])
								>
									<div class="section-img gradient-overlay stack-content grid items-center justify-items-center">
										<div class="section-img-over"></div>

										<div class="section__icon flex w-20 justify-center">
											@if (in_array($section->slug, ['capolavori', 'eportfolio']))
												{!! embed_icon('sections/' . $section->slug) !!}
											@else
												{!! embed_icon('sections/section-' . $section->originalSection()->id) !!}
											@endif
										</div>
									</div>

									<div class="section__body grid-cols-1">
										<div class="section__content grid grid-cols-1 justify-items-center gap-2 text-center">
											<h3 class="section__title text-xl font-bold">
												{{ __('sections.' . $section->slug) }}
											</h3>

											<p class="section-desc">
												{{ __('sections.description-' . $section->slug) }}
											</p>

											@if ($section->isCompletable())
												<p class="section__progress center-content flex items-center font-semibold">
													@if ($student->percentageTestsCompletedInSection($section) === 100)
														<x-icon-correct class="w-4" />

														{{ __('Section completed') }}
													@else
														{{ __('Completed activities') }}:

														<span class="font-bold">
															{{ $student->testsCompletedInSection($section) }}/{{ $section->testCount() ?: '??' }}
														</span>
													@endif
												</p>
											@endif
										</div>

										<div class="section__cta-wrapper">
											<x-button
												variant="secondary"
												class="section__cta"
												size="xs"
											>
												{{ __('explore') }}
											</x-button>
										</div>
									</div>
								</a>
							</div>
						@endforeach
					</div>
				</section>
			</div>
		@endforeach
	</div>
</x-layouts.main>
