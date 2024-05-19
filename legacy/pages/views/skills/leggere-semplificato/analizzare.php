{% block content %}

<div class="pad-t-5 main-wrap grid-flow" data-spacing="700">

	<?= title() ?>

	<div>
		<h2 id="text-title" class="fa-center txt-3rem mar-b-2 mar-t-5 fw-bold txt-upp">Testo</h2>

		<div id="content" class="<?= $legacyTest->completed ? 'completed' : '' ?>">

			<p id="text" class="txt-11rem">

				<?php

				$inputKey = 0;

				foreach ($text as $key => $part) {
					$value = null;
					$type = $part[1];
					$interactive = $type ? true : false;

					if ($interactive) {
						$value = $results[$inputKey] ?? 0;
						$inputKey++;
				?>

						<input type="hidden" class="inp-<?= $type ?> inactive js-field" name="field[]" value="<?= $value ?>">

					<?php } ?>

					<span class="part <?= $interactive ? 'selectable ' . $type : null ?> <?= test()->completed && $interactive ? ($value ? 'correct' : 'wrong') : null ?>" data-type="<?= $type ?>">
						<?= $part[0] ?>
					</span>

				<?php } ?>

			</p>


			<div id="selectors" class="grid4 col-gap2 gap-o-1-480w mar-t-5 mar-b-3">
				<div class="selector clickable cenY rel argomento" data-select="argomento" data-count="2">
					<p class="cenY rel fw-bold txt-2">Qual è l’argomento principale?</p>
				</div>
				<div class="selector clickable cenY rel causa" data-select="causa" data-count="3">
					<p class="cenY rel fw-bold txt-2">Perché? (causa)</p>
				</div>
				<div class="selector clickable cenY rel scopo" data-select="scopo" data-count="1">
					<p class="cenY rel fw-bold txt-2">Perché? (scopo)</p>
				</div>
				<div class="selector clickable cenY rel dove" data-select="dove" data-count="1">
					<p class="cenY rel fw-bold txt-2">Dove?</p>
				</div>
			</div>

		</div>
	</div>

	<div>
		<?= submit(true) ?>

		<?php if (!$legacyTest->completed) { ?>

			<label>
				<p class="txt-c3 clickable inlb">Non riesco ad associare una parte del testo ad ogni tipo di ragionamento e preferisco saltare l'attività.</p>

				<input type="checkbox" name="skip-cbx" class="hidden" onchange="$(this).next().click()">
				<button type="submit" name="review" class="hidden"></button>
			</label>

		<?php } ?>

	</div>

	<?= renderRedoButton(true) ?>

</div>

{% end content %}