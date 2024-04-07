{% block dashboard-body %}

<section class="page__content">
	<!-- Title -->
	<div class="page__header">
		<h1 class="section-title"><?= $reviewResult->review()->title ?></h1>
		<p class="section-subtitle">Qui puoi trovare le principali risposte che lo studente/studentessa ha segnato nel questionario</p>

		<div class="center-content">
			<a href="<?= client_url('/class/students/progress/focus?studentId=' . $student->id) ?>" class="button button--secondary">Indietro</a>
		</div>
	</div>

	<div class="results grid ">
		<div class="result__row bg-surface">
			<p class="text-xl font-semibold">Domanda</p>
			<p class="text-xl font-semibold">Risposta/e</p>
		</div>

		<?php foreach ($parsedResults as $question => $answers) { ?>

			<div class="result__row result__row--body">
				<div class="grid items-center">
					<p>
						<?= $question ?>
					</p>
				</div>

				<div class="grid items-center">
					<?php if (is_array($answers)) {
						foreach ($answers as $answerField => $answerValue) { ?>

							<p><?= $answerField ?> <?= !empty($answerValue) ? ': <span class="font-semibold">' . $answerValue . '</span></p>' : '' ?>

							<?php }
					} else { ?>
							<p class=""><?= $answers ?></p>
						<?php } ?>
				</div>
			</div>

		<?php } ?>

	</div>

	<!-- Print -->
	<div class="grid-flow center-content">
		<div class="button js-print">
			<?= icon_embed('print') ?>
			Stampa
		</div>
	</div>
</section>

{% end dashboard-body %}