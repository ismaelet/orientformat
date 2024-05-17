{% block main %}

<!-- Content -->
<div class="page-body">
	<div class="grid-flow">
		<div class="page__header pad-v-5">
			<div class="grid-flow center-content main-wrap" data-spacing="700">
				<div>
					<h1 class="title"><?= ucfirst($grade->adjective) ?> anno</h1>
					<p class="subtitle">Attività completate al <span><?= $gradeModel->completedPercentage() ?> %</span></p>
				</div>
				<a href="<?= client_url('/activities') ?>" class="button button--secondary">Cambia anno</a>
			</div>
		</div>

		<div class="areas">

			<?php foreach ($grade->areas as $area) { ?>

				<div class="area-wrapper">
					<section class="area grid-flow main-wrap full-width" data-spacing="700">
						<div class="area__header fa-center grid-flow" data-spacing="400">
							<h2 class="section-title"><?= $area->name ?></h2>
							<p class="section-subtitle"><?= $area->description ?></p>

							<!-- Read more -->
							<?php if ($area->id == 4) { ?>

								<a class="button button--secondary push-center" href="student-read?area=<?= $area->id ?>">
									<?= embed_icon('read') ?>
									Saperne di più
								</a>

							<?php } ?>

						</div>

						<div class="sections">

							<?php foreach ($area->getSections($grade->fullId) as $key => $section) { ?>

								<div class="section-wrapper js-load load--fade-in section-color section-color--area-<?= $section->areaId ?>" data-direction="bottom" data-delay="<?= $key % 3 ?>">
									<a class="section <?= $section->progressPercentage == 100 ? 'completed' : '' ?>" <?= 'href="' . $section->clientUrl . '&slug=' . $section->slug . '"' ?>>
										<div class="section-img gradient-overlay grid-flow stack-content center-content">
											<div class="section-img-over"></div>
											<div class="section__icon">
												<?= embed_icon($section->icon) ?>
											</div>
										</div>

										<div class="section__body">
											<div class="section__content grid-flow center-content" data-spacing="100">
												<h3 class="section__title fw-bold txt-12rem"><?= $section->name ?></h3>
												<p class="section-desc"><?= $section->description ?></p>

												<?php if ($section->isStandard) { ?>

													<p class="section__progress flex-group center-content fw-semibold">

														<?php if ($section->progressPercentage == 100) { ?>

															<?= embed_icon('correct') ?>
															Sezione completata

														<?php } else { ?>

															Attività completate: <span class="fw-bold"><?= $section->completedTestCount . '/' . ($section->testCount ?: '??') ?></span>

														<?php } ?>

													</p>

												<?php } ?>

											</div>

											<?php if (false) { ?>

												<p class="mar-t-1 pad-t-05 br-t-1 br-d txt-09rem">Durata stimata<br>dell'attività: <span class="fw-bold"><?= $section->time ?> minuti</span></p>

											<?php } ?>

											<div class="section__cta-wrapper">
												<div class="section__cta button button--secondary">esplora</div>
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