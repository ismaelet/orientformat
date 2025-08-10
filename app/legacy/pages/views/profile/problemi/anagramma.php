{% block content %}

<div class="main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="page-content">
		<div class="riddles">

			<?php foreach ($riddles as $key => $riddle) { ?>

				<div class="riddle">
					<p class="riddle__anagram"><?= $riddle[0] ?></p>
					<p class="riddle__definition"><?= $riddle[1] ?></p>
					<input type="text" class="js-field <?= test()->completed ? (strtoupper(test()->rawResults[$key]) == $riddle[2] ? 'test-input--correct' : 'test-input--wrong') : null ?>" name="field[]" value="<?= test()->completed ? strtoupper(test()->rawResults[$key]) : null ?>" placeholder="Parola" <?= test()->completed || isSupervisor() ? 'readonly' : null ?>>
				</div>

			<?php } ?>

		</div>
	</div>

	<div class="grid" data-spacing="700">
		<?= submit(true) ?>
	</div>
</div>

{% end content %}