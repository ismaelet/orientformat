@pushOnce('styles')
	<style>
		.slider__header {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: min(3rem, 5vw);
			align-items: center;
		}

		.slider__title-block {
			gap: 2rem;
			padding-top: 2rem;
		}

		.recap-panel {
			min-height: 100%;
		}

		.recap-item {
			--icon-size: min(3rem, 10vw);
			display: grid;
			justify-items: left;
			align-content: flex-end;
			gap: 1.5rem;
			padding: 6rem 2rem 2rem 2rem;
			border-radius: var(--border-radius-700);
			box-shadow: var(--shadow-big);
			color: #fff;
			font-family: var(--ff-titles);

			>svg {
				width: 70%;
			}
		}

		.recap-item .icon-embed {
			margin: unset;
		}

		.recap-item:nth-child(1) {
			background-color: var(--color-primary-400);
		}

		.recap-item:nth-child(2) {
			background-color: var(--color-transition-400);
		}

		.recap-item:nth-child(3) {
			background-color: var(--color-secondary-400);
		}

		.recap-item__label {
			font-size: var(--fs-400);
			opacity: 0.7;
			letter-spacing: 0.05em;
		}

		.recap-item__value {
			line-height: 1;
			font-size: min(var(--fs-700), 7vw);
			font-weight: var(--fw-bold);
		}

		@media (min-width: 1681px) {
			.slider__header {
				grid-template-columns: 29rem minmax(0, 1fr);
			}

			.slider__title-block {
				gap: 3rem;
				padding-block: 3rem;
			}

			.lists {
				grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
			}
		}

		@media (max-width: 480px) {
			.title {
				font-size: 10vw;
			}

			.subtitle {
				font-size: 5vw;
			}

			.recap-item {
				padding: 4rem 1.5rem 1.5rem 1.5rem;
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script defer>
		document.addEventListener('DOMContentLoaded', function() {
			const copyCodeButton = document.querySelector('.js-copy-code');
			const code = document.querySelector('.js-code');
			const copyConfirmation = document.querySelector('.js-copy-confirmation');

			copyCodeButton.addEventListener('click', function() {
				navigator.clipboard.writeText(code.innerText);
				copyConfirmation.dataset.showing = true;

				setTimeout(() => {
					copyConfirmation.dataset.showing = false;
				}, 2000);
			});
		});
	</script>
@endpushOnce

<x-layouts.class-dashboard :$class>
	<div class="grid grid-cols-1 gap-8">
		<section class="slider__header">
			<div class="slider__title-block grid">
				<x-heading.main>Pannello della<br>classe {{ $class->name }}</x-heading.main>
				<p class="section-subtitle">Qui puoi controllare il progresso della classe e modificarne le impostazioni</p>
			</div>

			<ul class="recap-panel columns-15rem grid grid-cols-1 gap-4 sm:gap-8">

				<a
					class="recap-item js-load load--fade-in"
					data-direction="bottom"
					data-delay="1"
					href="{{ route('class.students.index', $class) }}"
					data-tilt
					data-tilt-max="5"
					data-tilt-glare="true"
					data-tilt-max-glare="0.5"
				>
					{!! embed_icon('dashboards/students') !!}
					<div>
						<p class="recap-item__label">Studenti registrati</p>
						<p class="recap-item__value">
							{{ $studentCount . ($studentCount != 1 ? ' studenti' : ' studente') }}</p>
					</div>
				</a>

				<a
					class="recap-item js-load load--fade-in"
					data-direction="bottom"
					data-delay="2"
					href="{{ route('class.general.graphs', $class) }}"
					data-tilt
					data-tilt-max="5"
					data-tilt-glare="true"
					data-tilt-max-glare="0.5"
				>
					{!! embed_icon('dashboards/student-progress') !!}
					<div>
						<p class="recap-item__label">Attività completate</p>
						<p class="recap-item__value">{{ $progressPercent }} %</p>
					</div>
				</a>

				<div
					class="recap-item js-load load--fade-in wf cursor-default"
					data-direction="bottom"
					data-delay="3"
					data-tilt
					data-tilt-max="5"
					data-tilt-glare="true"
					data-tilt-max-glare="0.5"
				>
					{!! embed_icon('dashboards/code') !!}
					<div class="w-full">
						<p class="recap-item__label">Codice della classe</p>
						<p class="recap-item__value flex w-full flex-wrap items-center gap-4">
							<span class="js-code">
								{{ $class->code }}
							</span>

							<span class="js-copy-code relative shrink-0 cursor-pointer">
								<span
									class="bg-secondary-700 js-copy-confirmation pointer-events-none absolute bottom-full left-1/2 z-10 flex w-max -translate-x-1/2 items-center gap-1 rounded px-2 py-1 text-base opacity-0 transition-transform data-[showing=true]:-translate-y-2 data-[showing=true]:opacity-100"
									data-showing="false"
								>
									<x-icon-correct class="w-4 shrink-0" />
									copiato
								</span>

								<x-icon-copy class="w-5" />
							</span>
						</p>
					</div>
				</div>
			</ul>
		</section>


		<section
			class="lists grid"
			data-spacing="800"
		>

			<!-- Recent activities -->
			<div class="dashboard-panel grid grid-cols-1 content-start gap-8 overflow-auto">
				<x-heading.component-big>Lista degli studenti</x-heading.component-big>

				<p class="md:hidden">Trascina verso sinistra per vedere di più</p>

				@if ($studentCount)
					<div
						class="dashboard-list min-w-[640px]"
						style="--columns: 3;"
					>
						<div class="dashboard-list__row dashboard-list__row--header">
							<p class="dashboard-field dashboard-field_head">Nome</p>
							<p class="dashboard-field dashboard-field_head">E-mail</p>
							<p class="dashboard-field dashboard-field_head">Registrato/a il</p>
						</div>

						@foreach ($students as $student)
							<div class="dashboard-list__row">
								<p class="dashboard-list__field">{{ $student->inverted_full_name }}</p>
								<p class="dashboard-list__field">{{ $student->user?->email ?: '-' }}</p>
								<p class="dashboard-list__field">{{ $student->created_at_date }}</p>
							</div>
						@endforeach

					</div>
				@else
					<p class="center-content mar-v-5">Ancora nessun studente registrato</p>
				@endif

			</div>

			<!-- Recent activities -->
			<div class="dashboard-panel grid grid-cols-1 content-start gap-8 overflow-auto">
				<x-heading.component-big>Attività recenti</x-heading.component-big>

				@if ($feedEntriesData)

					<div class="dashboard-list">

						@foreach ($feed as $feedEntry)
							<div class="dashboard-list__row">
								<div>
									<p class="font-bold">{{ $feedEntry['studentName'] }}</p>
									<p class="dashboard-list__field">{!! $feedEntry['text'] !!}</p>
								</div>
							</div>
						@endforeach

					</div>
				@else
					<p class="center-content mar-v-5">Nessuna attività recente</p>
				@endif

			</div>
		</section>
	</div>
</x-layouts.class-dashboard>
