<?php

use \Legacy\Activity\Result\Handler\StudentSectionResult;
use Review\Review;

?>

{% block dashboard-body %}

<section class="page__content">
	<!-- Title -->
	<div class="page__header">
		<h1 class="section-title"><span class="txt-2rem txt-light">progresso di</span><br><?= $watchedStudent->fullName ?></h1>
		<p class="section-subtitle">Qui puoi monitorare il progresso dello studente/studentessa diviso per attività.<br>Clicca sul punto informativo che puoi trovare alla fine di ogni riga per mostrare l'interpretazione del risultato relativo.</p>
	</div>

	<div class="grades">

		<div>
			<h2 class="dashboard-panel__title--outer">Questionari</h2>
			<div class="dashboard-panel grade">

				<div class="areas">
					<!-- Reviews -->
					<div class="area">
						<h3 class="area__title subsection-title">Lista dei questionari</h3>
						<div class="sections" style="--count: 2;">

							<?php
							$key = 0;

							while ($reviewRow = $reviews->fetch_assoc()) {
								$review = new Review($reviewRow['reviewId']);
								$key++;
							?>

								<a href="review?id=<?= $reviewRow['id'] ?>" class="section section-color section-color--area-reviews" style="--i: <?= $key + 1 ?>">
									<div class="dashboard-panel-icon js-load load--fade-in" data-delay="2" data-direction="bottom">
										<?= embed_icon(APP_ICONS_DIR . 'sections/review') ?>
									</div>

									<p class="dashboard-panel-title"><?= $review->title ?></p>

									<p class="dashboard-panel_result">
									</p>

									<p>
									</p>

									<div class="dashboard-panel-footer">
										<div>Vedi i risultati</div>
									</div>

								</a>

							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</div>


		<?php foreach ($grades as $grade) { ?>

			<div>
				<h2 class="dashboard-panel__title--outer"><?= $grade['title'] ?></h2>
				<div class="dashboard-panel grade">

					<div class="areas">

						<!-- Regular areas -->
						<?php foreach ($grade['areas'] as $areaI => $area) { ?>

							<div class="area">
								<h3 class="area__title subsection-title"><?= $area['name'] ?></h3>
								<div class="sections" style="--count: <?= count($area['sections']) ?>">

									<?php foreach ($area['sections'] as $key => $legacySection) {
										$legacySection->setStudentId($watchedStudentId);
										$legacySectionResult = new StudentSectionResult($legacySection->id, $watchedStudentId);
										$speed = $legacySectionResult->getSpeedString();
									?>

										<div class="section section-color section-color--area-<?= $area['id'] ?>" style="--i: <?= $key + 1 ?>">
											<div class="dashboard-panel-icon js-load load--fade-in" data-delay="2" data-direction="bottom">
												<?= embed_icon(APP_ICONS_DIR . 'sections/section-' . $legacySection->mainSectionId) ?>
											</div>

											<p class="dashboard-panel-title"><?= $legacySection->title ?? $legacySection['title'] ?></p>

											<p class="dashboard-panel_result">

												<?php if ($legacySectionResult->result) { ?>

													<span class="inlb"><?= section_config($legacySection->id ?? null, 'recap-name-student') ?: 'Risultato' ?>:</span><br>
													<span class="dashboard-panel_value inlb fw-bold"><?= $legacySectionResult->result ?></span>

												<?php } else { ?>

													Non ancora completato

												<?php } ?>

											</p>

											<p>

												<?php if ($legacySectionResult && $speed) { ?>
													Completato in <strong><?= $speed ?></strong><br>
												<?php } ?>

											</p>

											<div class="dashboard-panel-footer">

												<?php if (($legacySection->completed || $legacySectionResult->result) && isset($actions[$legacySection->id])) {
													foreach ($actions[$legacySection->id] as $action) {
												?>

														<p class="dashboard-home-more">
															<a href="<?= client_url('/' . $action[2] . $action[1]) ?>"><?= $action[0] ?></a>
														</p>

												<?php }
												} ?>

											</div>

											<div class="info-icon icon-box">
												<?= embed_icon('info') ?>
											</div>

											<div class="section-info">
												<p><?= $infos[$legacySection->mainSectionId] ?? "" ?></p>
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