{% block main %}

<!-- Slider -->
<section id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pad-b-5">

	<!-- Title -->
	<div class="title-box mar-t-4 fa-center">

		<h1 class="title txt-25rem txt-sbold"><?= $legacySection['name'] ?></h1>

		<p class="stitle txt-1rem mar-t-1">Qui puoi controllare e stampare i risultati della classe in questa attività.</p>

		<a href="<?= client_url('/teacher/sections') ?>" class="button button--secondary back">Tutte le attività</a><br>

	</div>

	<?php if (count($results)) { ?>

		<form method="POST" class="hidden">
			<input type="hidden" id="inp-studentId" name="studentId">
			<input type="hidden" id="inp-testId" name="testId">
			<button type="submit" class="hidden" id="btn-download" name="download"></button>
		</form>

		<!-- List -->
		<h1 class="mar-t-3 font-bold txt-12rem mar-b-05">Risultati della classe</h1>

		<div id="list" class="panel">

			<div class="list">

				<div class="head">

					<p class="field field-l">Studente</p>

					<?php foreach ($legacyTests as $legacyTest) { ?>
						<p class="field field-l"><?= $legacyTest['title'] ?></p>
					<?php } ?>

				</div>

				<?php foreach ($results as $key => $result) { ?>

					<div class="row">

						<?php foreach ($result['values'] as $key => $field) { ?>

							<p class="field" data-student-id="<?= $result['studentId'] ?>" data-test-id="<?= $legacyTests[$key - 1]['id'] ?? '' ?>" onclick="$('#inp-testId').val($(this).data('test-id')); $('#inp-studentId').val($(this).data('student-id')); $('#btn-download').click();">

								<?= $field ?>

							</p>

						<?php } ?>

					</div>

				<?php } ?>

			</div>
		</div>

		<?php if ($enableAverage) { ?>

			<!-- Average -->
			<h1 class="mar-t-3 font-bold txt-12rem mar-b-05">Valori medi di confronto</h1>

			<div id="average" class="panel">

				<div class="list">

					<div class="head">

						<p class="field field-l">Confronto</p>

						<?php foreach ($legacyTests as $legacyTest) { ?>
							<p class="field field-l"><?= $legacyTest['title'] ?></p>
						<?php } ?>

					</div>

					<form method="POST" class="row">

						<?php foreach ($average_class as $key => $field) { ?>

							<p class="field"><?= $field ?></p>

						<?php } ?>

					</form>

					<form method="POST" class="row">

						<?php foreach ($average_all as $key => $field) { ?>

							<p class="field"><?= $field ?></p>

						<?php } ?>

					</form>

				</div>

			</div>

		<?php } ?>

		<!-- Print -->
		<div class="fa-center">
			<div class="printbuttonmar-t-3">
				<span class="text-icon bgr-wht" <?= icon_svg('print') ?>></span>
				<span class="btn-text">Stampa</span>
			</div>
		</div>

	<?php } else { ?>

		<!-- Empty -->
		<div class="empty">
			<p>Non ci sono studenti registrati in questa classe.</p>
		</div>

	<?php } ?>

</section>

{% end main %}