{% block content %}

<div class="pad-t-5 main-wrap grid" data-spacing="700">

	<?= title() ?>

	<div>
		<h2 id="text-title" class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp"><?= __('Text') ?></h2>

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

					<?php } ?><span class="part <?= $interactive ? 'selectable js-selectable ' . $type : null ?> <?= legacy_test()->completed && $interactive ? ($value ? 'correct' : 'wrong') : null ?>" data-type="<?= $type ?>"><?= $part[0] ?></span><?php } ?>
			</p>


			<div id="selectors" class="grid mar-t-5 mar-b-3" data-columns="10rem" data-spacing="400">
				<div class="test-selector clickable js-test-selector" data-type="chi" data-count="<?= $parameterCount['chi'] ?>">
					<p class=""><?= __('tests.132-category-1') ?></p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="quando" data-count="<?= $parameterCount['quando'] ?>">
					<p class=""><?= __('tests.132-category-2') ?></p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="causa" data-count="<?= $parameterCount['causa'] ?>">
					<p class=""><?= __('tests.132-category-3') ?></p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="scopo" data-count="<?= $parameterCount['scopo'] ?>">
					<p class=""><?= __('tests.132-category-4') ?></p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="come" data-count="<?= $parameterCount['come'] ?>">
					<p class=""><?= __('tests.132-category-5') ?></p>
				</div>
				<div class="test-selector clickable js-test-selector" data-type="conseguenza" data-count="<?= $parameterCount['conseguenza'] ?>"><?= __('tests.132-category-6') ?></p>
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