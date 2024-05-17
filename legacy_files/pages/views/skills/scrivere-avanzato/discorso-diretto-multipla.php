{% block content %}

<div class="test__body main-wrap grid-flow" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="sentences grid-flow" data-spacing="700">

		<?php foreach ($sentences as $sentenceKey => $sentence) { ?>

			<div class="sentence grid-flow <?= test()->completed ? (test()->rawResults[$sentenceKey] == $correctAnswers[$sentenceKey] ? 'correct' : 'wrong') : null ?>" data-spacing="400">
				<p class="original-sentence"><?= $sentence['original'] ?></p>

				<div class="choices grid-flow" data-spacing="200">

					<?php foreach ($sentence['choices'] as $choiceKey => $choice) { ?>

						<label class="checkbox choice">
							<input type="radio" class="js-field" name="field-<?= $sentenceKey ?>" value="<?= $choiceKey + 1 ?>" <?= test()->completed && test()->rawResults[$sentenceKey] == $choiceKey + 1 ? 'checked' : null ?> <?= test()->completed ? 'disabled' : null ?>>
							<span></span>
							<p><?= $choice ?></p>
						</label>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>

	<div class="grid-flow" data-spacing="700">
		<?= submit(true) ?>
		<?= renderRedoButton() ?>
	</div>
</div>

{% end content %}