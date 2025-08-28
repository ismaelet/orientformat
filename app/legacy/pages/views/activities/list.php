{% block main %}

<!-- Content -->
<div class="page-body">
	<div class="grid">
		<div class="page__header pad-v-5">
			<div class="grid center-content main-wrap" data-spacing="700">
				<div>
					<h1 class="title"><?= ucfirst(__($grade->ordinal())) ?> <?= __('year') ?></h1>
					<p class="subtitle"><?= __('misc.grade-percentage') ?> <span><?= $student->percentageSectionsCompletedInGrade($grade) ?>%</span></p>
				</div>
				<a href="<?= route('activities.grades.index') ?>" class="button button--secondary"><?= __('misc.change-year') ?></a>
			</div>
		</div>

		<div class="areas">

			<?php foreach ($grade->areas as $area) { ?>

				<div class="area-wrapper">
					<section class="area main-wrap gap-8">
						<div class="area__header fa-center grid" data-spacing="400">
							<h2 class="section-title"><?= __('areas.' . $area->id) ?></h2>
							<p class="section-subtitle"><?= __('areas.' . $area->id . '-description') ?></p>

							<!-- Read more -->
							<?php if ($area->id == 4) { ?>

								<a class="button button--secondary push-center" href="<?= route('analysis.student.area', $area) ?>">
									<span class="w-5 block">
										<?= embed_icon('read') ?>
									</span>
									<?= __('Know More') ?>
								</a>

							<?php } ?>

						</div>

						<div class="sections mt-12">

							<?php foreach ($grade->sectionsInArea($area) as $key => $section) { ?>

								<div class="section-wrapper js-load load--fade-in section-color section-color--area-<?= $section->areaId ?>" data-direction="bottom" data-delay="<?= $key % 3 ?>">
									<a class="section grid-cols-1 <?= !$section->isCompletable() || $student->percentageTestsCompletedInSection($section) == 100 ? 'completed' : '' ?>" <?= 'href="' . $section->url() . '"' ?>>
										<div class="section-img gradient-overlay grid stack-content items-center justify-items-center">
											<div class="section-img-over"></div>
											<div class="section__icon w-20 flex justify-center">
												<?= embed_icon('sections/section-' . $section->id) ?>
											</div>
										</div>

										<div class="section__body grid-cols-1">
											<div class="section__content grid center-content" data-spacing="100">
												<h3 class="section__title font-bold txt-12rem"><?= __('sections.' . $section->slug) ?></h3>
												<p class="section-desc"><?= __('sections.description-' . $section->slug) ?></p>

												<?php if ($section->isCompletable()) { ?>

													<p class="section__progress flex center-content font-semibold">

														<?php if ($student->percentageTestsCompletedInSection($section) == 100) { ?>

															<span class="w-4">
																<?= embed_icon('correct') ?>
															</span>
															<?= __('Section completed') ?>

														<?php } else { ?>

															<?= __('Completed activities') ?>: <span class="font-bold"><?= $student->testsCompletedInSection($section) . '/' . ($section->testCount() ?: '??') ?></span>

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