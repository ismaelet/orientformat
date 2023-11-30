{% block main %}

<!-- Content -->
<section class="main-wrap pad-b-5">

	<!-- Title -->
	<div class="title-box mar-t-4 fa-center">
		<h1 class="page-title">Saperne di più</h1>
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary back mar-t-1">Indietro</a>
		<p class="stitle txt-1rem mar-t-1">Qui potrai accedere ad agili schede di approfondimento, arricchite da un <strong>Glossario ipertestuale</strong>.</p>
	</div>

	<div class="areas mar-t-6">

		<?php foreach ($areas as $area) { ?>

			<div class="area">
				<h2 class="area_title txt-sbold brb2 br-c<?= $area->id ?> pad-b-1 fa-center txt-25px mar-b-1"><?= $area->name ?></h2>

				<div class="sections">

					<?php if ($area->id == 4) { ?>

						<a href="<?= client_url('/read?area-id=' . $area->id) ?>" class="section fa-center section-color section-color--area-<?= $area->id ?>">
							<?= icon_embed($area->icon) ?>
							<p class="section__title"><?= $area->name ?></p>
						</a>

						<?php } else {
						foreach ($area->getAplhabeticalDoableSections() as $section) {
							if ($section->isMainSection) { ?>

								<a href="<?= client_url('/read?id=' . $section->id) ?>" id="section<?= $section->id ?>" class="section fa-center section-color section-color--area-<?= $area->id ?>">
									<?= icon_embed($section->icon) ?>
									<p class="section__title"><?= $section->name ?></p>
								</a>

					<?php }
						}
					} ?>

				</div>

			</div>

		<?php } ?>

	</div>

</section>

{% end main %}