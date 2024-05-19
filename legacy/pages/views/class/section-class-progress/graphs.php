<?php

use \Legacy\SchoolSystem\Grade;

?>

{% block dashboard-body %}

<div class="page__header">
	<h1 class="section-title">Progresso della classe</h1>
	<p class="text-base">Qui sono illustrati i risultati medi della classe. Puoi usare le frecce a lato del nome di ogni area per vedere tutti i risultati.</p>
</div>

<div class="areas mar-t-3">

	<?php foreach ($areas as $area) { ?>

		<div class="area section-color--area-<?= $area['id'] ?>" data-position="1" data-count="<?= count($area['sections']) ?>">
			<div class="area_header flex items-center">
				<h2 class="text-3xl font-semibold"><?= $area['name'] ?></h2>

				<?php if (count($area['sections']) > 1) { ?>

					<div class="area_arrows">
						<div class="area_arrow icon-box js-arrow js-arrow-left section-color section-color--area-<?= $area['id'] ?>">
							<?= embed_icon('navigation/arrow1-left') ?>
						</div>
						<div class="area_arrow icon-box js-arrow js-arrow-right section-color section-color--area-<?= $area['id'] ?>">
							<?= embed_icon('navigation/arrow1-right') ?>
						</div>
					</div>

				<?php } ?>

			</div>

			<div class="sections-containter pb-16">
				<div class="sections" style="--count: <?= count($area['sections']) ?>">

					<?php foreach ($area['sections'] as $key => $legacySection) { ?>

						<div class="graph-item section js-section js-section-waiting section-color section-color--area-<?= $area['id'] ?>" data-key="<?= $key ?>" data-section-id="<?= $legacySection->id ?>" data-school-class-id="<?= schoolClassId() ?>">

							<div class="dashboard-panel">
								<!-- Header -->
								<h3 class="dashboard-panel__title flex justify-between items-center">
									<span class="block">
										<?= $legacySection->title ?>

										<span class="block text-base font-normal">
											Attività di
											<?php
											$grades = [];
											foreach (explode(',', $legacySection->grades) as $gradeId) {
												if ((schoolClass()->isMiddleSchool && $gradeId <= 3) || (schoolClass()->isHighSchool && !schoolClass()->isProfessional && in_array($gradeId, [4, 5, 6, 7, 8])) || (schoolClass()->isHighSchool && schoolClass()->isProfessional && in_array($gradeId, [4, 5, 9, 10]))) {
													$grade = new Grade($gradeId);
													$grades[] = strtolower($grade->name);
												}
											}
											echo implode(', ', $grades);
											?>
										</span>
									</span>

									<div class="w-20 text-4xl justify-center aspect-square rounded-full gradient-overlady graph-item__icon flex invisible md:visible text-background ">
										<?= embed_icon('sections/section-' . $legacySection->mainSectionId) ?>
									</div>
								</h3>

								<!-- Content -->
								<div class="js-section-content grid grid-cols-1 stack-content">
									<div>
										<!-- Body -->
										<div class="grah-item__body">
											<div class="graph-item__canvas-wrapper">
												<canvas class="js-canvas"></canvas>
											</div>
											<p class="hidden text-lg text-center js-empty-warning pb-20">L'attività non è stata ancora completata</p>
										</div>

										<!-- Footer -->
										<div class="grah-item__footer js-condensed-result-container py-8 grid justify-items-center text-center">
											<p class="md:text-l "><?= section_config($legacySection->id, 'recap-name-grade') ?: 'Risultato medio' ?>:</p>
											<p class="md:text-xl font-semibold js-condensed-result">...</p>
										</div>
									</div>

									<!-- Loading -->
									<div class="load-panel grid content-center justify-center bg-surface js-loading">
										<div class="load-icon">
											<?= embed_icon('loading') ?>
										</div>
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
<script src="/pages/scripts/class/section-class-progress/chartjs-plugin-annotation.min.js"></script>

{% end dashboard-body %}