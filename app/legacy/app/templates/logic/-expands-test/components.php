<?php

use App\Models\Activities\Section;

function title(?string $title = null, ?string $description = null) {
	$legacyTest = test();
	$title = $title ?: $legacyTest->title;
	$description = $description ?: $legacyTest->description;

	ob_start();
?>

	<section class="test__title-block">
		<p class="test__counter colored-title"><?= __('misc.section-progress', ['step' => $legacyTest->step, 'total' => $legacyTest->section->testCount]) ?></p>
		<h1 class="section-title colored-title"><?= $title ?></h1>
		<p class="test__description subsection-subtitle"><?= nl2br($description) ?></p>
	</section>

<?php

	return ob_get_clean();
}

function test_description(): string {
	return test()->description;
}

function submit(bool $progressiveButton = false) {
	$legacyTest = test();
	$section = Section::find($legacyTest->sectionId);

	switch (true) {
		// supervisor view
		case isSupervisor():
			$label = __('Return to the list of results');
			$name = null;
			break;

		// completed test and section
		case $legacyTest->completed && $legacyTest->section->completed:
			$label = __('Return to the summary');
			$name = null;
			break;

		// test that requires review
		case $legacyTest->reviewResult && !$legacyTest->completed:
			$label = __('Check your answer');
			$name = 'review';
			break;

		// uncompleted test, completed section
		case $legacyTest->section->completed:
			$label = __('Save the new result');
			$name = 'submit';
			break;

		// default button
		default:
			$label = __('Proceed');
			$name = 'submit';
	}

	ob_start();
?>

	<?php switch (true) {

		// supervisor go back button
		case isSupervisor(): ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= route('class.students.results.show', ['class' => watchedStudent()->school_class, 'student' => watchedStudent()]) ?>"><?= $label ?></a>
			</div>

		<?php break;

		// go back button
		case $legacyTest->completed && $legacyTest->section->completed: ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= $section->url() ?>"><?= $label ?></a>
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
	$legacyTest = test();

	if (!$legacyTest->completed && !isSupervisor()) { ?>

		<button type="submit" name="skip" class="skip interactive" formnovalidate>
			<?= $legacyTest->everCompleted ? __('Continue at another time') : __('Skip this activity and resume it later') ?>
		</button>

	<?php }
}

function no_results() {
	$legacyTest = test();

	ob_start();

	if ((!$legacyTest->completed && !$legacyTest->hasRequiredTest && isSupervisor()) || ($legacyTest->hasRequiredTest && !$legacyTest->requiredTest->completed)) { ?>

		<div class="no-results mar-v-2">

			<?php if (isSupervisor()) { ?>

				<?php if ($legacyTest->hasRequiredTest) { ?>
					<p>Lo studente non ha ancora completato l'attività precedente, necessaria per mostrare i dati di questa pagina, oppure ha deciso di azzerare i propri risultati per ripeterla più tardi. Potrai tornare qui quando avrà completato l'attività per esaminare i risultati.</p>
				<?php  } else { ?>
					<p>Lo studente non ha ancora completato questa attività, oppure ha deciso di azzerare i propri risultati per ripetere l'attività più tardi. Potrai tornare qui quando l'avrà completata per esaminare i risultati.</p>
				<?php } ?>

			<?php } else { ?>

				<p><?= __('misc.required-test-warning', ['url' => $legacyTest->requiredTest->clientUrl]) ?></p>

			<?php } ?>

		</div>

	<?php

	}

	return ob_get_clean();
}

function renderRedoButton(bool $fullWith = true) {
	ob_start();

	if (test()->completed && test()->percentage != 100 && !isSupervisor()) { ?>

		<button type="submit" class="button button--secondary <?= $fullWith ? 'button--full-width' : '' ?>" name="redo" value="<?= testId() ?>"><?= __('Try again') ?></button>

	<?php }

	return ob_get_clean();
}

function renderSaveButton(bool $fullWith = false) {
	ob_start();

	if (test()->completed && !isSupervisor()) { ?>

		<button type="submit" class="button <?= $fullWith ? 'button--full-width' : '' ?>" name="submit"><?= __('Save changes') ?></button>

<?php }

	return ob_get_clean();
}
