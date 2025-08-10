{% block dashboard-body %}

<div class="grid" data-spacing="800">
	<div class="center-content grid" data-spacing="700">
		<h1 class="section-title">Compara i consigli orientativi</h1>
		<p class="section-subtitle">Qui puoi comparare i consigli orientativi dati alle intenzioni indicate dagli studenti riguardo alla scelta della scuola superiore<br><br>In <span class="font-bold txt-green">verde</span> sono indicati i consigli orientativi che combaciano con le scelte dello studente.<br>In <span class="font-bold txt-orange">arancione</span> quelli che suggeriscono un indirizzo che non coincide con la scelta dello studente, ma che fa parte della stessa area.<br>In <span class="font-bold txt-red">rosso</span> quelli che non trovano corrispondenza tra le scelte dello studente.</p>
	</div>

	<!-- List -->
	<?php if ($students->num_rows) { ?>

		<div class="students grid gap-4">

			<?php while ($student = $students->fetch_assoc()) {
				$student = new \Legacy\UserSystem\Student($student['id']);
			?>

				<div class="student dashboard-panel">
					<h3 class="txt-13rem txt-c3 font-bold"><?= $student->invertedFullName ?></h3>

					<div class="student_body">
						<div class="student_choices">
							<h3 class="student_subtitle">Scelte dello studente</h3>

							<?php

							$hasChoices = false;

							foreach ($student->combinedChoices as $choicePlace => $choice) {
								if ($choice != 'Lo escludo') {
									$hasChoices = true;
							?>

									<p class="choice">
										<?= $choicePlace . ' - <strong>' . $parseAnswer[trim($choice)] . '</strong>' ?>
									</p>

								<?php } ?>
							<?php } ?>

							<?php if (!$hasChoices) { ?>

								<p class="choice choice--empty">Lo studente non ha espresso alcuna preferenza</p>

							<?php } ?>

						</div>

						<div class="student_advices">
							<h3 class="student_subtitle">Consigli orientativi</h3>

							<?php foreach ($student->advices as $advice) {
								$result = $hasChoices && _compare_advice($student, $advice) ? _compare_advice($student, $advice) : 0;
							?>

								<div class="advice-box advice--<?= $result ?>">
									<span class="advice_icon icon-box">
										<?= embed_icon($parseIcons[$result]) ?>
									</span>
									<p class="advice">
										<?= ucfirst(strtolower($advice->name)) ?>
									</p>
								</div>

							<?php } ?>

						</div>
					</div>
				</div>

			<?php } ?>

		</div>

	<?php } else { ?>

		<!-- Empty -->
		<div class="empty">
			<p class="pad-h-3 pad-v-5 fa-center font-bold txt-11rem">Non sono ancora stati attribuiti consigli orientativi in questa classe.</p>
		</div>

	<?php } ?>

</div>

{% end dashboard-body %}