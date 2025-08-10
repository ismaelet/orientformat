{% block content %}

<div class="main-wrap grid" data-spacing="700">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?= submit(true) ?>
	<?= renderSaveButton(true) ?>

	<div class="selected-info js-selected-info <?= test()->completed ? 'active' : '' ?>">
		<div class="grid" data-spacing="200">
			<h3 class="subsection-title colored-title"><?= __('You have selected') ?>:</h3>
			<p class="selected-info__text js-selected-info-text"><?= test()->completed ? $characters[$selectedCharacterId] : '-' ?></p>
		</div>
	</div>
</div>

<div class="canvas">
	<div class="drawing-wrapper js-drawing-wrapper">
		<img class="drawing" src="<?= client_path('image') ?>">

		<?php foreach ($characters as $characterId => $character) { ?>

			<input type="hidden" class="js-info-text" value="<?= $character ?>" data-id="<?= $characterId ?>">
			<input type="radio" class="hidden js-field" name="field[]" id="field-<?= $characterId ?>" value="<?= $characterId ?>" <?= $selectedCharacterId == $characterId ? 'checked' : '' ?>>
			<img class="drawing__layer image-cover <?= !isSupervisor() ? 'js-layer' : '' ?>" data-id="<?= $characterId ?>" src="<?= client_path($characterId) ?>">

		<?php } ?>

		<div class="drawing__characters">

			<?php foreach ($characters as $characterId => $_looping) { ?>

				<label <?= !isSupervisor() ? 'for="field-' . $characterId . '"' : null ?> class="drawing__character <?= !isSupervisor() ? 'js-character' : '' ?>" data-id="<?= $characterId ?>"></label>

			<?php } ?>

		</div>

		<p class="drawing__info js-drawing-info">
		</p>
	</div>

	<div class="drawing__overlay"></div>
</div>

{% end content %}