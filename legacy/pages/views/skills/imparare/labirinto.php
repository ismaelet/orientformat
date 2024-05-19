{% block content %}

<div class="">
	<div class="main-wrap <?= $legacyTest->completed ? 'completed' : '' ?>">
		<div class="title__wrapper">
			<?= title() ?>

			<?php if (!$legacyTest->completed || $legacyTest->percentage == 100) { ?>

				<p id="end" class="fa-center txt-c5 fw-bold txt-25rem">Hai risolto il labirinto!</p>

			<?php } else { ?>

				<p id="end" class="fa-center txt-red txt-sbold txt-25px">Puoi riprovare cliccando su "Riprova" qui sotto</p>

			<?php } ?>

			<div>
				<?= submit(true) ?>

				<?php if (!$legacyTest->completed) { ?>

					<label>
						<p class="txt-c3 clickable inlb">Non riesco ad uscire dal labirinto e preferisco saltare l'attività.</p>
						<input type="checkbox" name="skip-cbx" class="hidden" onchange="$(this).next().click();">
						<button type="submit" name="submit" class="hidden"></button>
					</label>

				<?php } ?>
			</div>

			<?= renderRedoButton(true) ?>
		</div>

		<div id="questions" class="">

			<?php foreach ($questions as $key => $question) { ?>

				<div id="question<?= $key + 1 ?>" class="question grid3 gap1 <?= $key ? '' : 'active' ?>" data-answer="<?= $question[1] ?>">

					<input type="hidden" class="filler-inp" value="0">

					<?php foreach ($question[0] as $key => $answer) { ?>

						<div class="answer fa-center pad-h-2 pad-v-3 clickable" data-answer="<?= $key + 1 ?>">
							<h1 class="txt-3rem txt-<?= $titles[$key][1] ?> fw-bold mar-b-3"><?= $titles[$key][0] ?></h1>
							<p class="answer-txt txt-c3 txt-15rem"><?= $answer ?></p>
						</div>

					<?php } ?>

				</div>

			<?php } ?>


			<p class="result right fa-center fw-bold txt-2rem">Corretto!</p>
			<p class="result wrong fa-center fw-bold txt-2rem">Sbagliato, sei tornato all'inizio</p>
		</div>
	</div>
</div>

{% end content %}