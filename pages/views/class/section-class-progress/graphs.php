<?php

use SchoolSystem\Grade;

?>

{% block dashboard-body %}

<div class="page__header">
	<h1 class="section-title">Progresso della classe</h1>
	<p class="section-subtitle">Qui sono illustrati i risultati medi della classe. Puoi usare le frecce a lato del nome di ogni area per vedere tutti i risultati.</p>
</div>


<p class="maintenance-warning my-8">Questa pagina sta venendo aggiornata e compariranno progressivamente più risultati fino alla fine del 2023.</p>

<?php /*
	<!-- Title -->
	<!-- <div class="title-box mar-t-1">
		<h2 class="title txt-15rem txt-med">Sicurezza media nella scelta della scuola superiore: <span class="fw-bold"><?= $choicePercentage ?>%</span></h2>
		<p class="stitle txt-1rem mar-t-05">Calcolata in base alle risposte date nel questionario iniziale o (se presente) finale.</p>
	</div> -->
	*/ ?>

<div class="areas">

	<?php foreach ($areas as $area) { ?>

		<div class="area section-color--area-<?= $area['id'] ?>" data-position="1" data-count="<?= count($area['sections']) ?>">
			<div class="area_header flex items-center">
				<h2 class="text-3xl font-semibold"><?= $area['name'] ?></h2>

				<?php if (count($area['sections']) > 1) { ?>

					<div class="area_arrows">
						<div class="area_arrow icon-box js-arrow js-arrow-left section-color section-color--area-<?= $area['id'] ?>">
							<?= icon_embed('navigation/arrow1-left') ?>
						</div>
						<div class="area_arrow icon-box js-arrow js-arrow-right section-color section-color--area-<?= $area['id'] ?>">
							<?= icon_embed('navigation/arrow1-right') ?>
						</div>
					</div>

				<?php } ?>

			</div>

			<div class="sections-containter pb-16">
				<div class="sections" style="--count: <?= count($area['sections']) ?>">

					<?php foreach ($area['sections'] as $key => $section) { ?>

						<div class="graph-item section js-section js-section-waiting section-color section-color--area-<?= $area['id'] ?>" data-key="<?= $key ?>" data-section-id="<?= $section->id ?>" data-school-class-id="<?= schoolClassId() ?>">

							<div class="dashboard-panel">
								<!-- Header -->
								<h3 class="dashboard-panel__title flex justify-between items-center">
									<span class="block">
										<?= $section->title ?>

										<span class="block text-base font-normal">
											Attività di
											<?php
											$grades = [];
											foreach (explode(',', $section->grades) as $gradeId) {
												if ((schoolClass()->isMiddleSchool && $gradeId <= 3) || (schoolClass()->isHighSchool && !schoolClass()->isProfessional && in_array($gradeId, [4, 5, 6, 7, 8])) || (schoolClass()->isHighSchool && schoolClass()->isProfessional && in_array($gradeId, [4, 5, 9, 10]))) {
													$grade = new Grade($gradeId);
													$grades[] = strtolower($grade->name);
												}
											}
											echo implode(', ', $grades);
											?>
										</span>
									</span>

									<div class="w-20 text-4xl justify-center aspect-square rounded-full text-surface gradient-overlady graph-item__icon flex invisible md:visible">
										<?= icon_embed(APP_ICONS_DIR . 'sections/section-' . $section->mainSectionId) ?>
									</div>
								</h3>

								<!-- Content -->
								<div class="js-section-content grid grid-cols-1 stack-content">
									<div>
										<!-- Body -->
										<div class="grah-item__body">
											<div class="graph-item__canvas-wrapper">
												<canvas class="js-canvas graph-item__canvas"></canvas>
											</div>
											<p class="hidden text-lg text-center js-empty-warning">Ancora nessuno studente ha completato l'attività</p>
										</div>

										<!-- Footer -->
										<div class="grah-item__footer js-condensed-result-container py-8 grid justify-items-center text-center">
											<p class="md:text-l "><?= section_config($section->id, 'recap-name-grade') ?: 'Risultato medio' ?>:</p>
											<p class="md:text-xl font-semibold js-condensed-result">...</p>
										</div>
									</div>

									<!-- Loading -->
									<div class="load-panel grid content-center justify-center bg-surface js-loading">
										<div class="load-icon"></div>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>

				</div>
			</div>
			<!-- 
				<div class="section-dots">

					<?php for ($i = 1; $i <= count($area['sections']); $i++) { ?>

						<div class="section-dot <?= $i == 1 ? 'active' : '' ?>" data-position="<?= $i ?>"></div>

					<?php } ?>

				</div> -->
		</div>

	<?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="<?= client_path('/app/scripts/modules/graphs.js') ?>"></script>

{% end dashboard-body %}