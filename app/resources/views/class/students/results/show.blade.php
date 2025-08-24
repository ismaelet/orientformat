@pushOnce('styles')
	<style>
		.grades {
			display: grid;
			gap: 5rem;
		}

		.grade {
			display: grid;
			gap: 2rem;
		}

		.areas {
			display: grid;
			gap: 3rem;
		}

		.area {
			display: grid;
			gap: 1rem;
		}

		.area-title {
			margin-bottom: 1rem;
			font-size: 2rem;
			font-weight: 600;
		}

		.dashboard-panel-body {
			display: grid;
			grid-template-columns: 6rem 1fr;
			align-content: flex-start;
			gap: 0.5rem 2rem;
			margin-bottom: 1rem;
		}

		.dashboard-panel-icon {
			grid-row: span 2;
			border-radius: 50%;
		}

		.dashboard-panel-title {
			font-size: 1.2rem;
			font-weight: 500;
			letter-spacing: unset;
		}

		.dashboard-panel_result {
			font-size: 0.9rem;
		}

		.dashboard-panel_value {
			font-size: 1.2em;
			line-height: 1.2;
		}

		.dashboard-home-more {
			text-align: right;
			margin: unset;
		}

		.dashboard-home-more a {
			border-bottom: 1px dashed;
			color: var(--color-tertiary-400);
			transition: color 0.2s;
		}

		.dashboard-home-more a:hover {
			color: var(--color-primary-400);
		}

		.grade {
			overflow: auto;
			grid-template-columns: minmax(0, 1fr);
		}

		.areas {
			display: grid;
			grid-template-columns: 3rem auto auto auto auto 2rem;
			min-width: 1024px;
		}

		.area {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
		}

		.area__title {
			grid-column: 1 / -1;
		}

		.sections {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
			padding-inline: 1rem;
			border-radius: var(--border-radius-400);
			border: var(--border);
		}

		.section {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
			align-items: center;
			column-gap: 2rem;
			padding-block: 1rem;
			border-bottom: 1px solid var(--border-color);
		}

		.section:last-child {
			border-bottom: unset;
		}

		.dashboard-panel-icon {
			display: grid;
			place-items: center;
			aspect-ratio: 1;
			background-color: var(--_color);
			grid-row: unset;
			margin: unset;
		}

		.info-icon {
			--_fill: var(--color-tertiary-400);
			width: 1.5rem;
			justify-self: flex-end;
			cursor: pointer;
		}

		.dashboard-panel-icon svg {
			width: 60%;
			color: #fff;
		}

		.section-info {
			opacity: 0;
			padding-block: 0;
			line-height: 0;
			grid-column: 2 / -1;
			visibility: hidden;
			transition: opacity 0.3s, line-height 0.3s, padding 0.3s;
		}

		.section:has(input:checked) .section-info {
			opacity: 1;
			visibility: visible;
			line-height: 2;
			padding-block: 2rem;
			font-size: 0.95rem;
		}

		@media (max-width: 1024px) {
			.section_content {
				grid-template-columns: minmax(0, 1fr);
				gap: 0;
			}

			.dashboard-panel-icon {
				width: 5rem;
				margin-inline: auto;
				margin-bottom: 1rem;
			}

			.dashboard-panel_result br {
				display: none;
			}

			.dashboard-panel-footer {
				margin-top: 1rem;
				margin-bottom: 1rem;
			}

			.dashboard-home-more {
				text-align: left;
			}

			.section-info p {
				padding-inline: 0;
				font-size: 0.9rem;
			}

			.dashboard-panel_value {
				font-size: unset;
			}

			.dashboard-panel-title {
				font-weight: 600;
			}
		}
	</style>
@endpushOnce

<x-layouts.class-dashboard :$class>
	<section class="page__content">
		<!-- Title -->
		<div class="page__header">
			<h1 class="section-title"><span class="txt-2rem txt-light">progresso di</span><br><?= $student->inverted_full_name ?>
			</h1>
			<p class="section-subtitle">Qui puoi monitorare il progresso dello studente/studentessa diviso per attività.<br>Clicca
				sul punto informativo che puoi trovare alla fine di ogni riga per mostrare l'interpretazione del risultato relativo.
			</p>
		</div>

		<div class="grades">

			<div>
				<h2 class="dashboard-panel__title--outer">Questionari</h2>
				<div class="dashboard-panel grade">

					<div class="areas">
						<!-- Reviews -->
						<div class="area">
							<h3 class="area__title subsection-title">Lista dei questionari</h3>
							<div
								class="sections"
								style="--count: 2;"
							>

								@foreach ($reviewResults as $key => $reviewResult)
									<a
										href="review?id={{ $reviewResult->id }}"
										class="section section-color section-color--area-reviews"
										style="--i: {{ $key + 1 }}"
									>
										<div
											class="dashboard-panel-icon js-load load--fade-in"
											data-delay="2"
											data-direction="bottom"
										>
											<x-icon-review />
										</div>

										<p class="dashboard-panel-title">{{ $reviewResult->review->title }}</p>

										<span>
										</span>

										<span>
										</span>

										<div class="dashboard-panel-footer">
											<div>Vedi i risultati</div>
										</div>

									</a>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</div>


			@foreach ($grades as $grade)
				<x-class-dashboard.student-result.grade
					:grade="$grade"
					:student="$student"
				/>
			@endforeach

		</div>
	</section>
</x-layouts.class-dashboard>
