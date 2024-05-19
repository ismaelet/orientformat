{% block content %}

<div class="main-wrap pad-t-5 pad-b-5 grid-flow" data-spacing="700" data-test-id="<?= testId() ?>">

	<?= title() ?>
	<?= no_results() ?>

	<?php if ($legacyTest->requiredTest->completed) { ?>

		<div class="graph-wrapper">

			<div id="circles" class="circles mar-t-10 mar-b-10" style="--group-count: <?= count($sortedResults) ?>">

				<p id="title-center" class="cen fa-center txt-c3 fw-bold"><?= $title ?></p>

				<?php for ($i = 1; $i < 5; $i++) { ?>

					<div id="border<?= $i ?>" class="border"></div>

				<?php } ?>

				<?php foreach ($sortedResults as $key => $result) { ?>

					<div class="group" style="--group-i: <?= $key ?>">
						<div class="group__circles">

							<?php for ($j = 1; $j < 5; $j++) { ?>

								<div class="circle js-load <?= $result['value'] == $j ? 'checked' : '' ?>">
									<div class="bgr"></div>
								</div>

							<?php } ?>

						</div>

						<div class="result__title-box txt-c3" data-group="<?= $result['name'] ?>">
							<p class="result__title txt-15rem js-load"><?= $result['name'] ?></p>
							<p class="stitle txt-c3 js-load"><?= $result['info'] ?></p>
						</div>

					</div>

				<?php } ?>

			</div>
		</div>

	<?php } ?>

	<?= submit() ?>

</div>

{% end content %}