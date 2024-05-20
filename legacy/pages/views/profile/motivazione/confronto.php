{% block content %}

<div class="main-wrap pad-t-4 pad-b-5 grid-flow" data-spacing="700">

	<?= title() ?>

	<div id="content">

		<?php $key = -1;
		foreach ($groups as $group) { ?>

			<div class="group pad-b-2">

				<h3 class="subsection-title font-bold txt-15rem mb-4"><?= $group ?></h3>

				<div class="grid gap-4">
					<?php for ($i = 0; $i < 5; $i++) {
						$key++; ?>

						<div class="answer">
							<h1 class="number font-bold"><?= $i + 1 ?></h1>
							<input type="text" name="field_other[]" class="inp filler-inp" value="<?= $results[$key] ?? '' ?>" placeholder="Attività n&#176;<?= $i + 1 ?>" maxlength="50" <?= test()->completed || isSupervisor() ? 'readonly' : '' ?>>
						</div>

					<?php } ?>
				</div>
			</div>

		<?php } ?>

	</div>

	<div>
		<?= submit() ?>
		<?= skip() ?>
	</div>

</div>

{% end content %}