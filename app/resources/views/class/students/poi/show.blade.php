@pushOnce('styles')
	<style>
		.dashboard-panel {
			grid-template-rows: max-content max-content auto;
			gap: 1rem;
		}

		.result {
			display: grid;
			grid-template-columns: 3rem minmax(0, 1fr);
			gap: 1rem;
			padding-block: 1.5rem;
			border-top: 1px solid var(--border-color);
		}

		.result:first-child {
			border-top: none;
			padding-top: unset;
		}

		.result:last-child {
			padding-bottom: unset;
		}

		.result__icon {
			--icon-size: 50%;
			position: relative;
			isolation: isolate;
			width: 100%;
			aspect-ratio: 1;
			overflow: hidden;
			border-radius: 50%;
			color: #fff;
		}

		.result__icon::after {
			content: '';
			position: absolute;
			z-index: -1;
			inset: 0;
			opacity: 0.4;
			mix-blend-mode: overlay;
			background: linear-gradient(135deg, hsl(0, 0%, 100%), hsl(0, 0%, 0%));
		}

		.result:nth-child(1) .result__icon {
			background-color: var(--color-primary-400);
		}

		.result:nth-child(2) .result__icon {
			background-color: var(--color-secondary-400);
		}

		.result:nth-child(3) .result__icon {
			background-color: var(--color-4);
		}

		.result:nth-child(4) .result__icon {
			background-color: var(--color-transition-400);
		}

		.result__title {
			font-size: var(--fs-400);
			font-weight: var(--fw-semibold);
		}

		.answer {
			font-size: var(--fs-400);
		}

		.panel-title {
			font-size: 1.75rem;
			font-weight: 600;
		}

		.page__content *:has(> svg) {
			display: grid;
			place-items: center;
		}
	</style>
@endpushOnce

<x-layouts.class-dashboard :$class>

	<div class="page__content">
		<div class="page__header">
			<h1 class="section-title"><span class="fw-light txt-2rem">profilo di</span><br><?= $student->fullName ?></h1>

			<div class="center-content">
				<a
					href="{{ route('class.students.results.index', ['class' => $class]) }}"
					class="button button--secondary"
				>Indietro</a>
			</div>
		</div>

		<!-- Row 1 -->
		<div
			class="page-content grid"
			data-columns="25rem"
			data-spacing="700"
		>

			<!-- Questionnaire -->
			<div class="dashboard-panel grid">
				<h2 class="panel-title">Scelta indicata nei questionari</h2>
				<p>Qui puoi trovare quale scelta è stata effettuata nei questionari iniziale e finale, e il grado di sicurezza</p>

				<div class="results mar-t-2">
					<div class="result">
						<div class="result__icon">
							<x-icon-questionnaires.start class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Scelta indicata nel questionario iniziale:</h3>

							<?php if ($beginnerChoice) { ?>
							<p class="answer"></p><span class="fw-semibold"><?= $beginnerChoice['primary_choice_area'] ?></span>
							(<?= trim($beginnerChoice['primary_choice_intensity']) ?>)</p>
							<?php } else { ?>

							<p class="answer"><span class="fw-semibold">Non ancora compilato</span></p>

							<?php } ?>

						</div>
					</div>

					<div class="result">
						<div class="result__icon">
							<x-icon-questionnaires.end class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Scelta indicata nel questionario finale:</h3>

							<?php if ($endChoice) { ?>
							<p class="answer"></p><span class="fw-semibold"><?= $endChoice['primary_choice_area'] ?></span>
							(<?= trim($endChoice['primary_choice_intensity']) ?>)</p>
							<?php } else { ?>

							<p class="answer"><span class="fw-semibold">Non ancora compilato</span></p>

							<?php } ?>

						</div>
					</div>
				</div>
			</div>

			<!-- Competenza alfabetica -->
			<div class="dashboard-panel grid">
				<div class="">
					<h2 class="panel-title">Area Competenza Alfabetica Funzionale</h2>
					<p class="text-lg">(Comunicazione nella lingua italiana)</p>
				</div>
				<p>Qui puoi trovare i risultati conseguiti nelle sezioni relative alle competenze alfabetiche funzionali</p>

				<div class="results mar-t-2">
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-11 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Ascoltare"</span>:</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['ascoltare'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['ascoltare'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-12 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Parlare"</span>:
							</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['parlare'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['parlare'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-39 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Leggere"</span>:
							</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['leggere'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['leggere'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-14 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Scrivere"</span>:
							</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['scrivere'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['scrivere'] ?></span>
							</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Imparare -->
			<div class="dashboard-panel grid">
				<h2 class="panel-title">Area Imparare a imparare</h2>
				<p>Qui puoi trovare i risultati conseguiti nelle sezioni relative alle abilità e strumenti inerenti alle competenze
					di apprendimento</p>

				<div class="results mar-t-2">
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-9 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span class="fy-italic fw-regular">"Stare
									attenti"</span>:</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['attenzione'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['attenzione'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-10 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Ricordare"</span>:</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['ricordare'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['ricordare'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-5 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Risolvere
									problemi"</span>:</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['problemi'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['problemi'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-40 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
									class="fy-italic fw-regular">"Imparare"</span>:
							</h3>
							<p class="answer"><span
									class="fw-semibold"><?= $results['scrivere'] === null ? '<span class="fw-regular">non ancora completata</span>' : $results['scrivere'] ?></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Row 2 -->
		<div
			class="page-content grid"
			data-columns="30rem"
			data-spacing="700"
		>
			<!-- Imparare -->
			<div class="dashboard-panel grid">
				<div>
					<h2 class="panel-title">Area Competenza Imprenditoriale</h2>
					<p class="text-lg">(Spirito di iniziativa e imprenditorialità)</p>
				</div>
				<p>Qui puoi trovare i risultati relativi ai tipi di pensiero e alle capacità autoimprenditoriali</p>

				<div class="results mar-t-2">
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-17 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Risultati della sezione <span class="fy-italic fw-regular">"Creatività e
									autoimprenditorialità"</span>:</h3>

							<?php if ($results['creatività'] === null) { ?>
							<span class="fw-regular">non ancora completata</span>
							<?php } else { ?>
							<div class="mt-2">
								<?php foreach ($results['creatività'] as $key => $result) { ?>

								<p class="answer"><?= $result['name'] ?>: <span class="fw-semibold"><?= $result['percentage'] ?>%</span></p>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

			<!-- Motivazione e interessi -->
			<div class="dashboard-panel grid">
				<div>
					<h2 class="panel-title">Area Motivazionale</h2>
					<p class="text-lg">(Consapevolezza ed espressione culturali)</p>
				</div>
				<p>Qui puoi trovare i risultati relativi a ciò che motiva ed interessa di più lo studente/la studentessa</p>

				<div class="results mar-t-2">
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-7 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span
									class="fy-italic fw-regular"
								>"Motivazione e aree di interesse"</span>:</h3>
							<p class="answer mt-1"><span
									class="fw-semibold"><?= $results['motivazione'] === null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Area principale:</span> ' . $results['motivazione'] ?></span>
							</p>
						</div>
					</div>
					<div class="result">
						<div class="result__icon">
							<x-icon-sections.section-24 class="h-1/2 w-1/2" />
						</div>

						<div class="result__content">
							<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span
									class="fy-italic fw-regular"
								>"I miei interessi"</span>:</h3>
							<p class="answer mt-1"><span
									class="fw-semibold"><?= $results['interessi'] === null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Area principale:</span> ' . $results['interessi'] ?></span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Row 3 -->
		<div class="">
			<!-- Consiglio Orientativo -->
			<form
				class="dashboard-panel grid"
				data-spacing="400"
				method="POST"
			>
				<h2 class="dashboard-panel__title">Consiglio orientativo</h2>
				<p>È possibile selezionare qui sotto uno o più consigli orientativi. Si può indicare un'area generica (ad esempio
					"Liceo") oppure un indirizzo più specifico:</p>

				<div
					class="mar-t-2 grid"
					data-spacing="400"
				>

					<?php for ($i = 0; $i < 3; $i++) { ?>

					<select
						name="advice[]"
						class="sel"
					>
						<option value="0">- nessuno -</option>

						<?php foreach ($advices as $adviceId => $adviceTitle) { ?>

						<option
							value="<?= $adviceId ?>"
							<?= isset($student->advices[$i]) && $student->advices[$i]->id == $adviceId ? 'selected' : '' ?>
						>
							<?= $adviceTitle ?>
						</option>

						<?php } ?>

					</select>

					<?php } ?>
				</div>

				<button
					type="submit"
					name="submit"
					class="button push-right"
				>Salva</button>
			</form>
		</div>
	</div>

</x-layouts.class-dashboard>
