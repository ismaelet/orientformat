<x-layouts.class-dashboard :$class>
	@pushOnce('styles')
		<style>
			.review-results {
				display: grid;
				gap: 2rem;
				color: var(--color-neutral-text);
			}

			.review-results__header,
			.review-results__questions {
				display: grid;
				gap: 1.5rem;
			}

			.review-results__context {
				color: var(--color-neutral-400);
			}

			.review-results__question {
				overflow-wrap: anywhere;
				border: 1px solid var(--color-neutral-border);
				border-radius: var(--radius-lg);
				background: var(--color-background-400);
			}

			.review-results__question h3 {
				padding: 1.25rem 1.5rem;
				border-bottom: 1px solid var(--color-neutral-border);
				font-weight: 600;
				font-size: 1.125rem;
				line-height: 1.6;
				color: var(--color-neutral-heading);
			}

			.review-results__answer {
				display: grid;
				gap: 0.5rem;
				padding: 1rem 1.5rem;
				line-height: 1.6;
			}

			.review-results__answer + .review-results__answer {
				border-top: 1px solid var(--color-neutral-border);
			}

			.review-results__answer dd {
				font-weight: 600;
				color: var(--color-tertiary-400);
			}

			@media (min-width: 640px) {
				.review-results__answer {
					grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
					gap: 1.5rem;
				}
			}

			@media print {
				.review-results__actions {
					display: none;
				}

				.review-results__question {
					break-inside: avoid;
				}
			}
		</style>
	@endPushOnce

	<section class="review-results" aria-labelledby="review-title">
		<header class="review-results__header">
			<div class="review-results__actions flex flex-wrap gap-3 justify-center" x-data>
				<x-button
					href="{{ route('class.students.results.show', ['class' => $class, 'student' => $student]) }}"
					variant="secondary"
				>
					Torna ai risultati
				</x-button>
				<x-button @click="window.print()">Stampa risposte</x-button>
			</div>

			<div class="grid gap-3">
				<p class="review-results__context text-sm">Risposte al questionario</p>
				<x-heading.main id="review-title">{{ $reviewResult->review->title }}</x-heading.main>
				<p class="text-lg font-semibold">{{ $student->full_name }}</p>
			</div>
		</header>

		<div class="grid gap-4" aria-labelledby="review-answers-title">
			<div class="flex flex-wrap items-baseline justify-between gap-2">
				<h2 id="review-answers-title" class="text-xl font-semibold">Le risposte dello studente</h2>
				<p class="review-results__context text-sm">
					{{ count($answers) }} {{ count($answers) === 1 ? 'domanda' : 'domande' }}
				</p>
			</div>
			<p class="review-results__context">Sono riportate le risposte alle domande condivise con i docenti.</p>

			<div class="review-results__questions">
				@forelse ($answers as $question)
					<article class="review-results__question" aria-labelledby="review-question-{{ $loop->iteration }}">
						<h3 id="review-question-{{ $loop->iteration }}">{{ $question['question'] }}</h3>
						<dl>
							@foreach ($question['answers'] as $answer)
								<div class="review-results__answer">
									<dt>{{ $answer['label'] !== '' ? $answer['label'] : 'Risposta' }}</dt>
									<dd>{{ $answer['value'] !== '' ? $answer['value'] : 'Non indicata' }}</dd>
								</div>
							@endforeach
						</dl>
					</article>
				@empty
					<div class="review-results__question p-6">
						<h3>Non ci sono risposte da mostrare</h3>
						<p class="mt-4">Questo questionario non contiene risposte condivise con i docenti. Puoi tornare ai risultati per consultare le altre attività dello studente.</p>
					</div>
				@endforelse
			</div>
		</div>
	</section>
</x-layouts.class-dashboard>
