<?php

?>

{% block dashboard-body %}

<!-- Content -->
<section class="pad-b-2">

	<p class="maintenance-warning">Questa pagina al momento è in manutenzione e potrebbe non mostrare tutti i dati previsti. Il normale funzionamento verrà ripristinato al più presto.</p>

	<?php /*
	<!-- Title -->
	<!-- <div class="title-box mar-t-1">
		<h2 class="title txt-15rem txt-med">Sicurezza media nella scelta della scuola superiore: <span class="fw-bold"><?= $choicePercentage ?>%</span></h2>
		<p class="stitle txt-1rem mar-t-05">Calcolata in base alle risposte date nel questionario iniziale o (se presente) finale.</p>
	</div> -->
	*/ ?>

	<div class="areas mar-t-4">

		<?php foreach ($areas as $area) { ?>

			<div class="area" data-position="1" data-count="<?= count($area['sections']) ?>">
				<div class="area_header">
					<h2 class="area-title striked-title"><?= $area['name'] ?></h2>
					<div class="area_arrows">
						<div class="area_arrow icon-box js-arrow js-arrow-left">
							<?= embed_icon('navigation/arrow1-left') ?>
						</div>
						<div class="area_arrow icon-box js-arrow js-arrow-right">
							<?= embed_icon('navigation/arrow1-right') ?>
						</div>
					</div>
				</div>

				<div class="sections-containter">
					<div class="sections" style="--count: <?= count($area['sections']) ?>">

						<?php foreach ($area['sections'] as $key => $legacySection) { ?>

							<div class="section js-section js-section-waiting section-color section-color--area-<?= $area['id'] ?>" data-key="<?= $key ?>" data-section-id="<?= $legacySection->id ?>" data-grade-id="<?= schoolClassId() ?>">
								<div class="dashboard-panel load slide-bottom ld-<?= $key ?>" style="--i: <?= $key + 1 ?>">
									<div class="dashboard-panel-body">
										<h3 class="dashboard-panel-title"><?= $legacySection->title ?></h3>
										<div class="dashboard-panel-icon icon-box load slide-bottom ld-<?= $key + 2 ?>">
											<?= embed_icon(APP_ICONS_DIR . 'sections/section-' . $legacySection->id) ?>
										</div>
									</div>

									<div class="js-section-content js-load">

										<!-- Ajax generated content -->

										<section class="filters mar-b-1">
										</section>

										<div class="graph grid-flow center-content">
											<div class="load-icon">
												<?= embed_icon('loading') ?>
											</div>
										</div>

										<h3 class="dashboard-panel_result">
											<span class="inlb"><?= section_config($legacySection->id, 'recap-name-grade') ?: 'Risultato medio' ?>:</span><br>
											<span class="dashboard-panel_value inlb fw-bold">...</span>
										</h3>
									</div>
								</div>
							</div>

						<?php } ?>

					</div>
				</div>

				<div class="section-dots">

					<?php for ($i = 1; $i <= count($area['sections']); $i++) { ?>

						<div class="section-dot <?= $i == 1 ? 'active' : '' ?>" data-position="<?= $i ?>"></div>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>
</section>

{% end dashboard-body %}