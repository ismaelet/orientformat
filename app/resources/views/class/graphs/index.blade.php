<?php

use Legacy\SchoolSystem\Grade;

?>

@pushOnce('styles')
	<link
		rel="stylesheet"
		href="{{ asset('css/legacy/graphs.css') }}"
	>
@endpushOnce

@pushOnce('scripts')
	<script
		defer
		src="{{ asset('js/legacy/chartjs-plugin-annotation.min.js') }}"
	></script>
	<script
		defer
		src="{{ asset('js/legacy/graphs.js') }}"
	></script>
@endpushOnce

<x-layouts.class-dashboard :$class>
	<div class="page__header">
		<h1 class="section-title">Progresso della classe</h1>
		<p class="text-base">Qui sono illustrati i risultati medi della classe. Puoi usare le frecce a lato del nome di ogni
			area per vedere tutti i risultati.</p>
	</div>

	<div class="areas mar-t-3">

		<?php foreach ($areas as $area) { ?>

		<div
			class="area section-color--area-<?= $area['id'] ?>"
			data-position="1"
			data-count="<?= count($area['sections']) ?>"
		>
			<div class="area_header flex items-center">
				<h2 class="text-3xl font-semibold"><?= $area['name'] ?></h2>

				<?php if (count($area['sections']) > 1) { ?>

				<div class="area_arrows">
					<div
						class="area_arrow icon-box js-arrow js-arrow-left section-color section-color--area-<?= $area['id'] ?> grid place-items-center"
					>
						<x-icon-arrow-simple-left class="h-1/3 w-1/3" />
					</div>
					<div
						class="area_arrow icon-box js-arrow js-arrow-right section-color section-color--area-<?= $area['id'] ?> grid place-items-center"
					>
						<x-icon-arrow-simple-right class="h-1/3 w-1/3" />
					</div>
				</div>

				<?php } ?>

			</div>

			<div class="sections-containter pb-16">
				<div
					class="sections"
					style="--count: <?= count($area['sections']) ?>"
				>

					<?php foreach ($area['sections'] as $key => $legacySection) { ?>

					<div
						class="graph-item section js-section js-section-waiting section-color section-color--area-<?= $area['id'] ?>"
						data-key="<?= $key ?>"
						data-section-id="<?= $legacySection->id ?>"
						data-school-class-id="<?= $class->id ?>"
					>

						<div class="dashboard-panel">
							<!-- Header -->
							<h3 class="dashboard-panel__title flex items-center justify-between">
								<span class="block">
									<?= $legacySection->title ?>

									<span class="block text-base font-normal">
										Attività di
										<?php
										$grades = [];
										foreach (explode(',', $legacySection->legacy_grades) as $gradeId) {
										    if (($class->isMiddleSchool() && $gradeId <= 3) || ($class->isHighSchool() && !$class->isProfessional() && in_array($gradeId, [4, 5, 6, 7, 8])) || ($class->isHighSchool() && $class->isProfessional() && in_array($gradeId, [4, 5, 9, 10]))) {
										        $grade = new Grade($gradeId);
										        $grades[] = strtolower($grade->name);
										    }
										}
										echo implode(', ', $grades);
										?>
									</span>
								</span>

								<div
									class="gradient-overlady graph-item__icon text-background invisible flex aspect-square w-20 items-center justify-center rounded-full text-4xl md:visible"
								>
									<x-dynamic-component
										:component="'icon-sections.section-' . $legacySection->mainSectionId"
										class="h-1/2 w-1/2"
									/>
								</div>
							</h3>

							<!-- Content -->
							<div class="js-section-content stack-content grid grid-cols-1">
								<div>
									<!-- Body -->
									<div class="grah-item__body">
										<div class="graph-item__canvas-wrapper">
											<canvas class="js-canvas"></canvas>
										</div>
										<p class="js-empty-warning hidden pb-20 text-center text-lg">L'attività non è stata ancora completata</p>
									</div>

									<!-- Footer -->
									<div class="grah-item__footer js-condensed-result-container grid justify-items-center py-8 text-center">
										<p class="md:text-l"><?= section_config($legacySection->id, 'recap-name-grade') ?: 'Risultato medio' ?>:</p>
										<p class="js-condensed-result font-semibold md:text-xl">...</p>
									</div>
								</div>

								<!-- Loading -->
								<div
									class="load-panel bg-surface js-loading grid content-center justify-center data-[visible='false']:hidden"
									data-visible="true"
								>
									<x-icon-loading class="w-20" />
								</div>
							</div>
						</div>
					</div>

					<?php } ?>

				</div>
			</div>
		</div>

		<?php } ?>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-layouts.class-dashboard>
