<?php

use Activity\Result\Handler\StudentSectionResult;

?>

{% block dashboard-body %}

<section class="page__content">
	<!-- Title -->
	<div class="page__header">
		<h1 class="section-title"><span class="txt-2rem txt-light">progresso di</span><br><?= $watchedStudent->fullName ?></h1>
		<p class="section-subtitle">Qui puoi monitorare il progresso dello studente/studentessa diviso per attività.<br>Clicca sul punto informativo che puoi trovare alla fine di ogni riga per mostrare l'interpretazione del risultato relativo.</p>
	</div>

	<div class="grades">

		<?php foreach ($grades as $grade) { ?>

			<div>
				<h2 class="dashboard-panel__title--outer"><?= $grade['title'] ?></h2>
				<div class="dashboard-panel grade">


					<div class="areas">

						<?php foreach ($grade['areas'] as $areaI => $area) { ?>

							<div class="area">
								<h3 class="area__title subsection-title"><?= $area['name'] ?></h3>
								<div class="sections" style="--count: <?= count($area['sections']) ?>">

									<?php foreach ($area['sections'] as $key => $section) {
										$section->setStudentId($watchedStudentId);
										$sectionResult = new StudentSectionResult($section->id, $watchedStudentId);
										$speed = $sectionResult->getSpeedString();
									?>

										<div class="section section-color section-color--area-<?= $area['id'] ?>" style="--i: <?= $key + 1 ?>">
											<div class="dashboard-panel-icon js-load load--fade-in" data-delay="2" data-direction="bottom">
												<?= icon_embed(APP_ICONS_DIR . 'sections/section-' . $section->mainSectionId) ?>
											</div>

											<p class="dashboard-panel-title"><?= $section->title ?? $section['title'] ?></p>

											<p class="dashboard-panel_result">

												<?php if ($sectionResult->result) { ?>

													<span class="inlb"><?= section_config($section->id ?? null, 'recap-name-student') ?: 'Risultato' ?>:</span><br>
													<span class="dashboard-panel_value inlb fw-bold"><?= $sectionResult->result ?></span>

												<?php } else { ?>

													Non ancora completato

												<?php } ?>

											</p>

											<p>

												<?php if ($sectionResult && $speed) { ?>
													Completato in <strong><?= $speed ?></strong><br>
												<?php } ?>

											</p>

											<div class="dashboard-panel-footer">

												<?php if (($section->completed || $sectionResult->result) && isset($actions[$section->id])) {
													foreach ($actions[$section->id] as $action) {
												?>

														<p class="dashboard-home-more">
															<a href="<?= client_url('/' . $action[2] . $action[1]) ?>"><?= $action[0] ?></a>
														</p>

												<?php }
												} ?>

											</div>

											<div class="info-icon icon-box">
												<?= icon_embed('info') ?>
											</div>

											<div class="section-info">
												<p><?= $infos[$section->mainSectionId] ?? "" ?></p>
											</div>

										</div>

									<?php } ?>

								</div>
							</div>

						<?php } ?>

					</div>
				</div>
			</div>

		<?php } ?>

	</div>
</section>

{% end dashboard-body %}