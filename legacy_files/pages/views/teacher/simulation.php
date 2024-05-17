<?php

use \Legacy\Activity\Area;

use \Legacy\SchoolSystem\Grade;

?>

{% block main %}

<div class="main-wrap">
	<div class="grid-flow center-content" data-spacing="700">
		<h1 class="page-title">Simulazione studente</h1>
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary">Indietro</a>
		<p class="txt-1rem">
			Cliccando qui sotto è possibile visualizzare le attività proposte agli studenti e testarne il funzionamento.<br>
			Ogni anno le attività sono suddivise per aree, che possono variare da due a quattro e possono essere svolte in qualsiasi ordine,<br>anche se consigliamo di cominciare con il <strong>Profilo personale</strong> e finire con <strong>Scegliere</strong>, quando presente.
		</p>
	</div>

	<div class="page-content mar-t-5">
		<div class="school-types grid-flow js-school-type-selectors <?= $selectedSchoolType ? '' : 'active' ?>" data-columns="20rem" data-spacing="700">

			<?php foreach ($schoolTypes as $schoolTypeSlug => $schoolType) { ?>

				<div class="school-type-selector js-school-type-selector element element--school element_functionality" data-school-type="<?= $schoolTypeSlug ?>">
					<div class="element-icon icon-box">
						<?= embed_icon('schools') ?>
					</div>

					<div>
						<h3 class="element-title"><?= $schoolType['name'] ?></h3>
					</div>
				</div>

			<?php } ?>

		</div>

		<?php foreach ($schoolTypes as $schoolTypeSlug => $schoolType) { ?>

			<div class="school-type js-school-type <?= $selectedSchoolType && $selectedSchoolType == $schoolTypeSlug ? 'active' : '' ?>" data-school-type="<?= $schoolTypeSlug ?>">
				<div class="grades">

					<?php for ($gradeId = $schoolType['grades'][0]; $gradeId <= $schoolType['grades'][1]; $gradeId++) {
						$grade = (new Grade($gradeId))->setIsProfessional($schoolType['is-professional']);
					?>

						<div class="grade">
							<h3 class="grade__title">Attività del <?= $grade->adjective ?> anno</h3>

							<div class="areas">

								<?php for ($areaId = 1; $areaId <= 4; $areaId++) {
									$area = new Area($areaId);
									$sections = $area->getSections($grade->fullId);

									if ($sections) {
								?>

										<div class="area">
											<h3 class="area__title"><?= $area->name ?></h3>

											<div class="activities grid-flow" data-columns='20rem' data-spacing="400">

												<?php foreach ($sections as $sectionKey => $section) { ?>

													<div class="load--fade-in js-load" data-direction="bottom" data-delay="<?= $sectionKey % 3 ?>">
														<a class="activity element element_functionality" href="<?= $section->clientUrl ?>">
															<div class="element-icon icon-box">
																<?= embed_icon($section->icon) ?>
															</div>

															<div>
																<h3 class="element-title"><?= $section->name ?></h3>
																<p class="element-subtitle"><?= $section->description ?></p>
															</div>
														</a>
													</div>

												<?php } ?>

											</div>
										</div>

								<?php }
								} ?>

							</div>
						</div>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>
</div>

{% end main %}