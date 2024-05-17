{% block dashboard-body %}

<div class="page__content">
	<div class="page__header">
		<h1 class="section-title"><span class="fw-light txt-2rem">consiglio orientativo di</span><br><?= $student->fullName ?></h1>

		<div class="center-content">
			<a href="<?= client_url('/class/students/suggestion/give') ?>" class="button button--secondary">Indietro</a>
		</div>
	</div>

	<div class="grid-flow page-content" data-columns="40rem" data-spacing="700">
		<div class="dashboard-panel grid-flow" data-spacing="400">
			<h2 class="dashboard-panel__title">Risultati in evidenza</h2>
			<p>Qui puoi trovare i dati più rilevanti relativi allo/a studente/studentessa al fine di attribuire il consiglio orientativo.</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon(APP_ICONS_DIR . 'questionnaires/start') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Scelta indicata nel questionario:</h3>

						<?php if ($choice) { ?>
							<p class="answer"></p><span class="fw-semibold"><?= $choice['primary_choice_area'] ?></span> (<?= trim($choice['primary_choice_intensity']) ?>)</p>
						<?php } else { ?>

							<p class="answer"><span class="fw-semibold">Non ancora compilato</span></p>

						<?php } ?>

					</div>
				</div>

				<div class="result">
					<div class="result__icon">
						<?= embed_icon(APP_ICONS_DIR . 'sections/section-7') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Area di interesse principale indicata nell'attività <span class="fy-italic fw-regular">Motivazione e aree di interesse</span>:</h3>
						<p class="answer"><span class="fw-semibold"><?= $motivationArea ?></span></p>
					</div>
				</div>

				<div class="result">
					<div class="result__icon">
						<?= embed_icon(APP_ICONS_DIR . 'sections/section-24') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Area di interesse principale indicata nell'attività <span class="fy-italic fw-regular">I miei interessi</span>:</h3>
						<p class="answer"><span class="fw-semibold"><?= $interestArea ?></span></p>
					</div>
				</div>
			</div>
		</div>

		<form class="dashboard-panel grid-flow" data-spacing="400" method="POST">
			<h2 class="dashboard-panel__title">Consiglio orientativo</h2>
			<p>È possibile selezionare qui sotto uno o più consigli orientativi. Si può indicare un'area generica (ad esempio "Liceo") oppure un indirizzo più specifico:</p>

			<div class="grid-flow mar-t-2" data-spacing="400">

				<?php for ($i = 0; $i < 3; $i++) { ?>

					<select name="advice[]" class="sel">
						<option value="0">- nessuno -</option>

						<?php foreach ($advices as $adviceId => $adviceTitle) { ?>

							<option value="<?= $adviceId ?>" <?= isset($student->advices[$i]) && $student->advices[$i]->id == $adviceId ? 'selected' : '' ?>>
								<?= $adviceTitle ?>
							</option>

						<?php } ?>

					</select>

				<?php } ?>

			</div>

			<button type="submit" name="submit" class="button push-right">Salva</button>
		</form>
	</div>
</div>

{% end dashboard-body %}