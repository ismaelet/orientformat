{% block content %}

<script>
	document.addEventListener('DOMContentLoaded', () => {
		// Attach dragstart to all draggable divs
		document.querySelectorAll('.draggable').forEach(div => {
			div.addEventListener('dragstart', e => {
				e.dataTransfer.setData('text/plain', div.textContent.trim());
				e.dataTransfer.setData('id', div.id); // Save id so we can hide it
			});
		});

		// Enable inputs to accept drops
		document.querySelectorAll('input').forEach(input => {
			input.addEventListener('dragover', e => e.preventDefault());

			input.addEventListener('drop', e => {
				e.preventDefault();
				const text = e.dataTransfer.getData('text/plain');
				const id = e.dataTransfer.getData('id');
				const div = document.getElementById(id);

				// If input already has a linked div, show it again
				if (input.dataset.divId) {
					const oldDiv = document.getElementById(input.dataset.divId);
					oldDiv.style.display = 'inline-block';
				}

				// Hide the newly dropped div
				div.style.display = 'none';

				// Update input value and remember which div it holds
				input.value = text;
				input.dispatchEvent(new Event('change'));
				input.dataset.divId = id;
			});
		});
	});
</script>

<div class="pad-t-5 pad-b-5 main-wrap">

	<?= title() ?>

	<?php if ($legacyTest->completed || !isSupervisor()) { ?>

		<div id="text-box" class="section grid grid-cols-1 gap-8">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp"><?= __('Summary') ?></h1>

			<!-- Text -->
			<div class="summary-text"><?= $text ?></div>

			<!-- Draggable options -->
			<?php if (!test()->completed) { ?>
				<div class="flex gap-4 wrap justify-center <?= isSupervisor() ? 'pointer-events-none' : '' ?>">
					<?php foreach ($options as $key => $option) { ?>
						<p id="draggable-<?= $key ?>" class="border px-2 rounded-sm draggable-option draggable" draggable="true"><?= $option['text'] ?></p>
					<?php } ?>
				</div>
			<?php } ?>

			<!-- Read the full text -->
			<p class="clickable text-secondary-400 flex wrap items-center gap-2" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon text-c3"> <?= embed_icon('read') ?></span>
				<span class="btn-txt"><?= __('Click here to read the text again') ?></span>
			</p>
		</div>

		<div id="original-box" class="section hidden">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Testo</h1>

			<p id="original" class="mar-b-2 txt-1rem">
				<?= __('tests.39-full-text') ?>
			</p>

			<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon text-c3"><?= embed_icon('navigation/back') ?></span>
				<span class="btn-txt"><?= __('tests.39-back') ?></span>
			</p>
		</div>

	<?php } ?>

	<?= no_results() ?>
	<?= submit(true) ?>
	<?= skip() ?>

</div>

{% end content %}