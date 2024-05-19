{% block content %}

<div class="grid-flow main-wrap" data-spacing="800">

	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div id="types" class="grid <?= $legacyTest->completed ? 'completed' : '' ?>">

		<?php foreach ($types as $key => $type) { ?>

			<div class="name-box grid row<?= $key % 2 ?>">
				<p class="name txt-12rem"><?= $type ?></p>
			</div>

			<div class="score-box row<?= $key % 2 ?> txt-rig">

				<?php for ($i = 0; $i < 6; $i++) { ?>

					<label class="score<?= $i ?> score clickable">
						<input type="checkbox" class="hidden filler-inp" name="field[]" value="<?= $i + 1 ?>" <?= isset($legacyTest->rawResults[$key]) && $i + 1 == $legacyTest->rawResults[$key] ? 'checked' : '' ?>>

						<div class="circle">
							<div class="dot cen"></div>
						</div>

						<p class="fa-center"><?= $i ?></p>
					</label>

				<?php } ?>

			</div>

		<?php } ?>

	</div>

	<?= submit(true) ?>

</div>

{% end content %}