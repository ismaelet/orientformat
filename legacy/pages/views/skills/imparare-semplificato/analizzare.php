{% block content %}

<div class="pad-t-5 main-wrap grid-flow" data-spacing="700">

	<?= title() ?>

	<div>
		<h2 id="text-title" class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Testo</h2>

		<div id="content" class="<?= $legacyTest->completed ? 'completed' : '' ?>">

			<p id="text" class="txt-11rem">

				<?php

				$inputKey = 0;

				foreach ($text as $key => $part) {
					$value = null;
					$type = $part[1] ?? null;
					$interactive = $type ? true : false;

					if ($interactive) {
						$value = $results[$inputKey] ?? 0;
						$inputKey++;

				?>
						<input type="hidden" class="inp-<?= $type ?> inactive js-field" name="field[]" value="<?= $value ?>">

					<?php } ?><span class="part <?= $interactive ? 'selectable js-selectable ' . $type : null ?> <?= test()->completed && $interactive ? ($value ? 'correct' : 'wrong') : null ?>" data-type="<?= $type ?>"><?= $part[0] ?></span><?php } ?>
			</p>


			<div id="selectors" class="grid-flow mar-t-5 mar-b-3" data-columns="10rem" data-spacing="400">
				<div class="test-selector clickable js-test-selector" data-type="chi" data-count="<?= $parameterCount['chi'] ?>">
					<p class=""><span class="font-bold">Di chi</span> si parla?</p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="quando" data-count="<?= $parameterCount['quando'] ?>">
					<p class=""><span class="font-bold">Quando?</span> In quante fasi?</p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="causa" data-count="<?= $parameterCount['causa'] ?>">
					<p class=""><span class="font-bold">Perché?</span> Per quale causa?</p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="scopo" data-count="<?= $parameterCount['scopo'] ?>">
					<p class=""><span class="font-bold">Perché?</span> Con quale scopo?</p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="come" data-count="<?= $parameterCount['come'] ?>">
					<p class=""><span class="font-bold">Come?</span> In quale modo?</p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="conseguenza" data-count="<?= $parameterCount['conseguenza'] ?>">
					<p class="">Qual è la <span class="font-bold">conseguenza</span>?</p>
				</div>
			</div>

		</div>
	</div>

	<div>
		<?= submit(true) ?>

		<?php if (!$legacyTest->completed) { ?>

			<label>
				<p class="txt-c3 clickable inlb">Non riesco ad associare tutti i tipo di ragionamento e voglio fermarmi qui.</p>

				<button type="submit" name="review" class="hidden"></button>
			</label>

		<?php } ?>
	</div>

	<?= renderRedoButton(true) ?>

</div>

{% end content %}