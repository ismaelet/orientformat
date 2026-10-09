@pushOnce('styles')
	<style>
		/* Header */
		.section-recap .content-header {
			position: relative;
			overflow: hidden;
			height: 22rem;
			background-color: var(--color-tertiary-400);
			clip-path: polygon(0 0, 0 calc(100% - 1.6vw), 30% 100%, 54% calc(100% - 1.2vw), 76% 100%, 100% calc(100% - 1.4vw), 100% 0);
		}

		.section-recap .content-header__image {
			position: absolute;
			inset: 0;
			width: 100%;
			height: 100%;
			object-fit: cover;
			opacity: .3;
		}

		.section-recap .content-header__overlay::before {
			content: '';
			position: absolute;
			inset: 0;
			z-index: -1;
			opacity: 0.4;
			background: linear-gradient(135deg, var(--color-tertiary-100), var(--color-tertiary-700));
			mix-blend-mode: overlay;
		}

		.section-recap .content-header__content {
			position: relative;
			z-index: 1;
			min-height: 20rem;
			display: grid;
			place-content: center;
			justify-items: center;
			gap: 1.5rem;
			text-align: center;
		}

		/* Test cards */
		.section-recap .tests {
			display: grid;
			grid-template-columns: repeat(auto-fit,
					minmax(min(100%, 25rem), 1fr));
			gap: 2rem;
		}

		.section-recap .test {
			display: grid;
			grid-template-columns: 4rem minmax(0, 1fr);
			gap: 2rem;
			align-items: center;
			width: 100%;
			padding: 2rem 1rem 1rem;
			border-radius: var(--radius-lg, 1rem);
			background: white;
			transition: box-shadow .4s;
		}

		.section-recap .test:hover {
			box-shadow: var(--shadow, 0 8px 24px rgb(0 0 0 / .12));
		}

		.section-recap .test-img {
			width: 4rem;
			margin-inline: auto;
		}

		.section-recap .test-img svg {
			width: 100%;
			height: auto;
		}

		.section-recap .test-stitle.active {
			color: var(--color-primary-400, currentColor);
		}

		.section-recap .test-texts {
			transition: transform .3s;
		}

		.section-recap .test:hover .test-texts {
			transform: translateY(-1rem);
		}

		/* Actions */
		.section-recap .test-btn-box {
			display: flex;
			flex-wrap: wrap;
			gap: .3rem;
			opacity: 0;
			transform: translateY(1rem);
			transition: opacity .4s, transform .4s;
		}

		.section-recap .test-btn {
			display: inline-block;
			white-space: nowrap;
			cursor: pointer;
			color: var(--color-primary-600, inherit);
		}

		.section-recap .test-btn+.test-btn::before,
		.section-recap .test-btn+form::before {
			content: '\00B7';
			margin-inline: .3rem;
		}

		.section-recap .test:hover .test-btn-box,
		.section-recap .test:focus-within .test-btn-box {
			opacity: 1;
			transform: none;
		}

		.section-recap .restart {
			color: #c62828;
		}

		@media (max-width: 1024px) {
			.section-recap .test {
				grid-template-columns: minmax(0, 1fr);
				gap: 1rem;
				padding: 1.5rem;
				box-shadow: var(--shadow, 0 8px 24px rgb(0 0 0 / .12));
				text-align: center;
			}

			.section-recap .test-btn-box {
				justify-content: center;
				margin-top: 1rem;
				opacity: 1;
				transform: none;
			}

			.section-recap .test-img {
				width: 3.5rem;
			}
		}

		@media (prefers-reduced-motion: reduce) {

			.section-recap .test,
			.section-recap .test-texts,
			.section-recap .test-btn-box {
				transition: none;
			}
		}
	</style>
@endPushOnce

<x-layouts.main :title="__('sections.' . $section->slug)">
	<div class="section-recap full-width">

		{{-- Header --}}
		<section class="content-header stack-content contrasting-background fill-width grid text-center">
			<img
				class="content-header__image"
				src="{{ $coverImage }}"
				alt=""
			>

			<div class="content-header__overlay fill-all background-fill relative isolate"></div>

			<div class="content-header__content">
				<h1 class="text-850 font-semibold text-white">
					{{ __('sections.' . $section->slug) }}
				</h1>

				@if ($section->areaId != 4)
					<x-button
						class="center-icon"
						href="{{ route('analysis.student.section', $section) }}"
					>
						<x-icon-read />
						{{ __('Know More') }}
					</x-button>
				@endif
			</div>
		</section>

		{{-- Content --}}
		<div
			id="content"
			class="breakout py-20"
		>

			{{-- Introduction --}}
			<div class="grid justify-items-center gap-4 text-center">
				<h2 class="text-2xl font-semibold">
					{{ __('Section summary') }}
				</h2>

				<p class="subsection-subtitle">
					{{ __('Here you can check your progress in this section, restart an activity, or revisit it.') }}
				</p>

				<x-button
					href="{{ $backUrl }}"
					variant="secondary"
					class="mt-4"
				>
					{{ __('Choose another section') }}
				</x-button>
			</div>

			{{-- Tests --}}
			<div class="tests mt-12">
				@foreach ($tests as $test)
					@php
						$completed = $test->recap_completed;
						$percentage = $test->recap_percentage;
					@endphp

					<article class="test">

						{{-- Icon --}}
						<div class="test-img">
							@php
								$iconPath = resource_path('svg/icons/' . $test->recap_image . '.svg');
							@endphp

							@if (is_file($iconPath))
								{!! file_get_contents($iconPath) !!}
							@endif
						</div>

						{{-- Test information --}}
						<div class="test-data">
							<div class="test-texts">
								<h3 class="test-title text-xl font-bold uppercase">
									{{ $test->name }}
								</h3>

								@unless ($test->static)
									<p class="test-stitle {{ !$completed ? 'active' : '' }} mt-2 text-lg font-medium">
										@if ($completed)
											@if ($percentage == 100 || $test->template === 'survey')
												{{ __('Already completed') }}
											@else
												{{ __('Result') }}:
												<span class="font-bold">{{ $percentage }}%</span>
											@endif
										@else
											{{ __('Not completed') }}
										@endif
									</p>
								@endunless

								<p class="mt-3">
									{{ $test->summary }}
								</p>
							</div>

							{{-- Actions --}}
							<div class="test-btn-box mt-4">

								{{-- View --}}
								@if (($test->template !== 'survey' && $test->type != 3) || !$completed)
									<a
										href="{{ $test->url() }}"
										class="test-btn"
									>
										{{ __('View') }}
									</a>
								@endif

								{{-- Survey download placeholder --}}
								@if ($test->template === 'survey' && $completed)
									<a
										href="{{ route('test.answers.download', $test) }}"
										class="test-btn"
									>
										{{ __('Download answers') }}
									</a>
								@endif

								{{-- Restart --}}
								@if ($completed && !$test->static)
									<form
										method="POST"
										action="{{ route('test.reset', $test->id) }}"
										onsubmit="return confirm(@js(__('Are you sure you want to restart the activity?')))"
									>
										@csrf

										<button
											type="submit"
											class="test-btn restart"
										>
											{{ __('Restart') }}
										</button>
									</form>
								@endif

							</div>
						</div>

					</article>
				@endforeach
			</div>
		</div>
	</div>
</x-layouts.main>
