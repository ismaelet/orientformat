<x-layouts.class-dashboard :$class>
	<div
		class="page__content"
		data-spacing="800"
	>
		<div class="page__header">
			<h1 class="section-title">Progresso degli studenti</h1>
			<p class="section-subtitle">Seleziona dalla lista qui sotto lo studente/studentessa del/della quale vuoi esaminare i
				risultati.</p>
		</div>

		<!-- List -->
		<section class="dashboard-panel">

			<?php if ($class->students) { ?>

			<div
				class="dashboard-list"
				style="--columns: 4;"
			>

				@foreach ($class->students as $student)
					<div class="dashboard-list__row js-show-loading-panel">
						<p class="dashboard-list__field"><?= $student->inverted_full_name ?></p>

						<a
							href="{{ route('class.students.results.show', ['class' => $class, 'student' => $student]) }}"
							class="dashboard-list__field dashboard-list__field--buttons"
						>
							<x-button
								size="xs"
								variant="secondary"
								color="secondary"
							>Vedi il progresso
								<x-icon-arrow-long-right class="w-4" /></x-button>
						</a>

						<a
							href="{{ route('class.students.poi.show', ['class' => $class, 'student' => $student]) }}"
							class="dashboard-list__field dashboard-list__field--buttons"
						>
							<x-button
								size="xs"
								variant="secondary"
								color="primary"
							>P.O.I.
								<x-icon-arrow-long-right class="w-4" />
							</x-button>
						</a>

						<a
							href="{{ route('class.students.self-evaluations.show', ['class' => $class, 'student' => $student]) }}"
							class="dashboard-list__field dashboard-list__field--buttons"
						>
							<x-button
								size="xs"
								variant="secondary"
								color="purple"
							>Autovalutazioni
								<x-icon-arrow-long-right class="w-4" />
							</x-button>
						</a>
					</div>
				@endforeach

			</div>

			<?php } else { ?>

			<!-- Empty -->
			<div class="empty">
				<p class="pad-h-3 pad-v-5 fa-center txt-sbold txt-11rem">Non ci sono studenti registrati in questa classe.</p>
			</div>

			<?php } ?>

		</section>
	</div>

	<div class="loading-panel js-loading-panel">
		<x-icon-loading />
	</div>

</x-layouts.class-dashboard>
