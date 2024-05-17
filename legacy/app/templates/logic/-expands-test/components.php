<?php

function title(string $title = null, string $description = null) {
	$test = test();
	$title = $title ?: $test->title;
	$description = $description ?: $test->description;

	ob_start();

?>

	<section class="test__title-block">
		<p class="test__counter colored-title">attività <?= $test->step ?> di <?= $test->section->testCount ?></p>
		<h1 class="section-title colored-title"><?= $title ?></h1>
		<p class="test__description subsection-subtitle"><?= nl2br($description) ?></p>
	</section>

<?php

	return ob_get_clean();
}

function submit(bool $progressiveButton = false) {
	$test = test();

	switch (true) {
			// supervisor view
		case isSupervisor():
			$label = 'Torna alla lista dei risultati';
			$name = null;
			break;

			// completed test and section
		case $test->completed && $test->section->completed:
			$label = 'Torna al riepilogo';
			$name = null;
			break;

			// test that requires review
		case $test->reviewResult && !$test->completed:
			$label = 'Verifica';
			$name = 'review';
			break;

			// uncompleted test, completed section
		case $test->section->completed:
			$label = 'Salva il nuovo risultato';
			$name = 'submit';
			break;

			// default button
		default:
			$label = 'Procedi';
			$name = 'submit';
	}

	ob_start();
?>

	<?php switch (true) {

			// supervisor go back button
		case isSupervisor(): ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= client_url('/class/students/progress/focus?studentId=' . watchedStudentId()) ?>"><?= $label ?></a>
			</div>

		<?php break;

			// go back button
		case $test->completed && $test->section->completed: ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="?id=<?= $test->section->id ?>"><?= $label ?></a>
			</div>

		<?php break;

			// progressive button
		case $progressiveButton && !test()->completed: ?>

			<button type="submit" class="button button--filling button--full-width js-submit-button js-progressive-submit-button" name="<?= $name ?>" disabled><?= $label ?></button>

		<?php break;

			// normal button
		default: ?>

			<button type="submit" class="button button--full-width js-submit-button" name="<?= $name ?>"><?= $label ?></button>

		<?php break;
	}

	return ob_get_clean();
}

function skip() {
	$test = test();

	if (!$test->completed && !isSupervisor()) { ?>

		<button type="submit" name="skip" class="skip interactive" formnovalidate>
			<?= $test->everCompleted ? 'Continua in un\'altro momento' : 'Salta questa attività e riprendila più tardi' ?>
		</button>

	<?php }
}

function no_results() {
	$test = test();

	ob_start();

	if ((!$test->completed && !$test->hasRequiredTest && isSupervisor()) || ($test->hasRequiredTest && !$test->requiredTest->completed)) { ?>

		<div class="no-results mar-v-2">

			<?php if (isSupervisor()) { ?>

				<?php if ($test->hasRequiredTest) { ?>
					<p>Lo studente non ha ancora completato l'attività precedente, necessaria per mostrare i dati di questa pagina, oppure ha deciso di azzerare i propri risultati per ripeterla più tardi. Potrai tornare qui quando avrà completato l'attività per esaminare i risultati.</p>
				<?php  } else { ?>
					<p>Lo studente non ha ancora completato questa attività, oppure ha deciso di azzerare i propri risultati per ripetere l'attività più tardi. Potrai tornare qui quando l'avrà completata per esaminare i risultati.</p>
				<?php } ?>

			<?php } else { ?>

				<p>Per poter vedere i risultati devi completare l'attività precedente, <a class="text-link" href="<?= $test->requiredTest->clientUrl ?>">clicca qui</a> per svolgerla</p>

			<?php } ?>

		</div>

	<?php

	}

	return ob_get_clean();
}

function renderRedoButton(bool $fullWith = true) {
	ob_start();

	if (test()->completed && test()->percentage != 100 && !isSupervisor()) { ?>

		<button type="submit" class="button button--secondary <?= $fullWith ? 'button--full-width' : '' ?>" name="redo" value="<?= testId() ?>">Riprova</button>

	<?php }

	return ob_get_clean();
}

function renderSaveButton(bool $fullWith = false) {
	ob_start();

	if (test()->completed && !isSupervisor()) { ?>

		<button type="submit" class="button <?= $fullWith ? 'button--full-width' : '' ?>" name="submit">Salva le modifiche</button>

<?php }

	return ob_get_clean();
}
