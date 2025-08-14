{% block content %}

<div class="test__body main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="sentences grid" data-spacing="700">

		<?php foreach ($sentences as $sentenceKey => $sentence) { ?>

			<div class="sentence surface grid <?= test()->completed ? (strtolower(test()->rawResults[$sentenceKey]) == strtolower($correctAnswers[$sentenceKey]) ? 'correct' : 'wrong') : 0 ?>" data-spacing="700">
				<div class="grid" data-spacing="400">
					<h3 class="subsection-title">Discorso indiretto</h3>
					<p class=""><?= $sentence[0] ?></p>
				</div>

				<div class="grid" data-spacing="400">
					<h3 class="subsection-title">Discorso diretto</h3>
					<div class="flex">
						<p class="test-text"><?= $sentence[1] ?>: "</p>
						<input type="text" class="js-field test-input" name="field[]" value="<?= test()->rawResults[$sentenceKey] ?? null ?>" placeholder="Discroso diretto">
						<p class="test-text">"</p>
					</div>
				</div>
			</div>

		<?php } ?>

	</div>

	<div class="grid" data-spacing="400">
		<?= submit(true) ?>
		<?= renderRedoButton() ?>
	</div>
</div>

{% end content %}