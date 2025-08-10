{% block main %}

<!-- Content -->
<div class="page-body">
	<div class="grid">
		<div class="page__header pad-v-5">
			<div class="grid center-content main-wrap" data-spacing="700">
				<div>
					<h1 class="title"><?= ucfirst(__($legacyGrade->adjective)) ?> <?= __('year') ?></h1>
					<p class="subtitle"><?= __('misc.grade-percentage') ?> <span><?= $legacyGradeModel->completedPercentage() ?>%</span></p>
				</div>
				<a href="<?= route('activities.grades.index') ?>" class="button button--secondary"><?= __('misc.change-year') ?></a>
			</div>
		</div>

		<div class="areas">

			<?php

			use App\Models\Activities\Area;

			foreach ($legacyGrade->areas as $legacyArea) {
				$area = Area::find($legacyArea->id);
			?>

				<div class="area-wrapper">
					<section class="area main-wrap full-width gap-8">
						<div class="area__header fa-center grid" data-spacing="400">
							<h2 class="section-title"><?= __('areas.' . $legacyArea->id) ?></h2>
							<p class="section-subtitle"><?= __('areas.' . $legacyArea->id . '-description') ?></p>

							<!-- Read more -->
							<?php if ($legacyArea->id == 4) { ?>

								<a class="button button--secondary push-center" href="<?= route('analysis.student.area', $area) ?>">
									<?= embed_icon('read') ?>
									<?= __('Know More') ?>
								</a>

							<?php } ?>

						</div>

						<div class="sections">

							<?php foreach ($legacyArea->getSections($legacyGrade->fullId) as $key => $legacySection) { ?>

								<div class="section-wrapper js-load load--fade-in section-color section-color--area-<?= $legacySection->areaId ?>" data-direction="bottom" data-delay="<?= $key % 3 ?>">
									<a class="section <?= $legacySection->progressPercentage == 100 ? 'completed' : '' ?>" <?= 'href="' . $legacySection->clientUrl . '&slug=' . $legacySection->slug . '"' ?>>
										<div class="section-img gradient-overlay grid stack-content center-content">
											<div class="section-img-over"></div>
											<div class="section__icon">
												<?= embed_icon($legacySection->icon) ?>
											</div>
										</div>

										<div class="section__body">
											<div class="section__content grid center-content" data-spacing="100">
												<h3 class="section__title font-bold txt-12rem"><?= __('sections.' . $legacySection->id) ?></h3>
												<p class="section-desc"><?= __('sections.description-' . $legacySection->id) ?></p>

												<?php if ($legacySection->isStandard) { ?>

													<p class="section__progress flex-group center-content fw-semibold">

														<?php if ($legacySection->progressPercentage == 100) { ?>

															<?= embed_icon('correct') ?>
															<?= __('Section completed') ?>

														<?php } else { ?>

															<?= __('Completed activities') ?>: <span class="font-bold"><?= $legacySection->completedTestCount . '/' . ($legacySection->testCount ?: '??') ?></span>

														<?php } ?>

													</p>

												<?php } ?>

											</div>

											<div class="section__cta-wrapper">
												<div class="section__cta button button--secondary"><?= __('explore') ?></div>
											</div>
										</div>
									</a>
								</div>

							<?php } ?>

						</div>
					</section>
				</div>

			<?php } ?>

		</div>
	</div>
</div>

{% end main %}