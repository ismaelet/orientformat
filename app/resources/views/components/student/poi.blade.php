@pushOnce('styles')
	<style>
		.bg-neutral-50 rounded shadow p-8 {
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

		/* background: linear-gradient(90deg, #f4c152, #c5545b, #531c54, #002d62, #006e7f, #24a852); */
		.result:nth-child(1) .result__icon {
			background-color: #f4c152;
		}

		.result:nth-child(2) .result__icon {
			background-color: #c5545b;
		}

		.result:nth-child(3) .result__icon {
			background-color: #531c54;
		}

		.result:nth-child(4) .result__icon {
			background-color: #002d62;
		}

		.result:nth-child(5) .result__icon {
			background-color: #006e7f;
		}

		.result:nth-child(6) .result__icon {
			background-color: #24a852;
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

<div class="page__content">
	<div class="page__header">
		<div class="grid grid-cols-1 justify-items-center">
			<p class="fw-light txt-2rem"><span class="text-secondary-400 font-semibold">P</span>rofilo <span
					class="text-secondary-400 font-semibold"
				>O</span>rientativo
				<span class="text-secondary-400 font-semibold">I</span>ndividualizzato
			</p>
			<p>di</p>
			<x-heading.main><?= $student->fullName ?></x-heading.main>
		</div>

		<div class="center-content">
			<a
				href="{{ route('class.students.results.index', ['class' => $class]) }}"
				class="button button--secondary"
			>Indietro</a>
		</div>

		<p class="max-w-220 mx-auto text-lg">{!! $description[$userType] !!}</p>
	</div>

	<div class="columns-30rem grid gap-8">
		<!-- Questionnaire -->
		<div class="grid rounded bg-neutral-50 p-8 shadow">
			<h2 class="panel-title">Scelta indicata nei questionari</h2>
			<p>Qui puoi trovare la scelta che è stata effettuata nei questionari iniziale e finale, e il grado di sicurezza.</p>

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

		<!-- Motivazionale -->
		<div class="grid rounded bg-neutral-50 p-8 shadow">
			<div>
				<h2 class="panel-title">Area Motivazionale</h2>
				<p class="text-lg">(Consapevolezza ed espressione culturali)</p>
			</div>
			<p>Qui puoi trovare i risultati relativi alle fonti di motivazione principali.</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-7 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span
								class="fy-italic fw-regular">"Motivazione e aree di interesse"</span>:</h3>
						<p class="answer mt-1"><span
								class="fw-semibold"><?= $results['motivazione'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Area principale:</span> ' . $results['motivazione'] ?></span>
						</p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-24 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span
								class="fy-italic fw-regular">"I miei interessi"</span>:</h3>
						<p class="answer mt-1"><span
								class="fw-semibold"><?= $results['interessi'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Area principale:</span> ' . $results['interessi'] ?></span>
						</p>
					</div>
				</div>
			</div>
		</div>

		{{-- Personale --}}
		<div class="grid rounded bg-neutral-50 p-8 shadow">
			<div class="">
				<h2 class="panel-title">Area Personale</h2>
				<p class="text-lg">(****)</p>
			</div>
			<p>******</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-27 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span class="fy-italic fw-regular">"La
								ruota delle emozioni"</span>:</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['ruota'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['ruota'] ?></span>
						</p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-1 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span class="fy-italic fw-regular">"Stili
								Cognitivi"</span>:
						</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['stili'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Stile principale:</span> ' . $results['stili'] ?></span>
						</p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-3 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
								class="fy-italic fw-regular">"Resilienza"</span>:
						</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['resilienza'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Tasso di resilienza:</span> ' . $results['resilienza'] ?></span>
						</p>
					</div>
				</div>

				{{-- Autostima --}}
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-4 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
								class="fy-italic fw-regular">"Autostima"</span>:
						</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['autostima'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Tasso di autostima:</span> ' . $results['autostima'] ?></span>
						</p>
					</div>
				</div>

				{{-- Attributivo --}}
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-6 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span class="fy-italic fw-regular">"Stile
								Attributivo"</span>:
						</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['attributivo'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Stile prevalente:</span> ' . $results['attributivo'] ?></span>
						</p>
					</div>
				</div>

				{{-- Temperamento --}}
				<div class="result">
					<div class="result__icon">
						<x-icon-sections.section-8 class="h-1/2 w-1/2" />
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultato dell'autovalutazione della sezione <span
								class="fy-italic fw-regular">"Temperamento"</span>:
						</h3>
						<p class="answer"><span
								class="fw-semibold"><?= $results['temperamento'] == null ? '<span class="fw-regular">non ancora completata</span>' : '<span class="fw-regular">Temperamento più pronunciato:</span> ' . $results['temperamento'] ?></span>
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Competenza alfabetica -->
		<div class="grid rounded bg-neutral-50 p-8 shadow">
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
								class="fw-semibold"><?= $results['ascoltare'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['ascoltare'] ?></span>
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
								class="fw-semibold"><?= $results['parlare'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['parlare'] ?></span>
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
								class="fw-semibold"><?= $results['leggere'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['leggere'] ?></span>
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
								class="fw-semibold"><?= $results['scrivere'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['scrivere'] ?></span>
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Imparare -->
		<div class="grid rounded bg-neutral-50 p-8 shadow">
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
								class="fw-semibold"><?= $results['attenzione'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['attenzione'] ?></span>
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
								class="fw-semibold"><?= $results['ricordare'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['ricordare'] ?></span>
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
								class="fw-semibold"><?= $results['problemi'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['problemi'] ?></span>
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
								class="fw-semibold"><?= $results['scrivere'] == null ? '<span class="fw-regular">non ancora completata</span>' : $results['scrivere'] ?></span>
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Imprenditoriale -->
		<div class="grid rounded bg-neutral-50 p-8 shadow">
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

						<?php if ($results['creatività'] == null) { ?>
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
	</div>

	@if ($userType == 'teacher' && $class->grade == 3)
		{{-- Consiglio Orientativo --}}
		<div class="">
			<h2 class="dashboard-panel__title text-center">Consiglio orientativo</h2>
			<form
				class="grid rounded bg-neutral-50 p-8 shadow"
				data-spacing="400"
				method="POST"
			>
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
	@endif
</div>
