{% block dashboard-body %}

<div class="page__content">
	<div class="page__header">
		<h1 class="section-title"><span class="fw-light txt-2rem">profilo di</span><br><?= $student->fullName ?></h1>

		<div class="center-content">
			<a href="<?= client_url('/class/students/suggestion/give') ?>" class="button button--secondary">Indietro</a>
		</div>
	</div>

	<!-- Row 1 -->
	<div class="grid page-content" data-columns="25rem" data-spacing="700">

		<!-- Questionnaire -->
		<div class="dashboard-panel grid">
			<h2 class="panel-title">Scelta indicata nei questionari</h2>
			<p>Qui puoi trovare quale scelta è stata effettuata nei questionari iniziale e finale, e il grado di sicurezza</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('questionnaires/start') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Scelta indicata nel questionario iniziale:</h3>

						<?php if ($beginnerChoice) { ?>
							<p class="answer"></p><span class="font-semibold"><?= $beginnerChoice['primary_choice_area'] ?></span> (<?= trim($beginnerChoice['primary_choice_intensity']) ?>)</p>
						<?php } else { ?>

							<p class="answer"><span class="font-semibold">Non ancora compilato</span></p>

						<?php } ?>

					</div>
				</div>

				<div class="result">
					<div class="result__icon">
						<?= embed_icon('questionnaires/end') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Scelta indicata nel questionario finale:</h3>

						<?php if ($endChoice) { ?>
							<p class="answer"></p><span class="font-semibold"><?= $endChoice['primary_choice_area'] ?></span> (<?= trim($endChoice['primary_choice_intensity']) ?>)</p>
						<?php } else { ?>

							<p class="answer"><span class="font-semibold">Non ancora compilato</span></p>

						<?php } ?>

					</div>
				</div>
			</div>
		</div>

		<!-- Competenza alfabetica -->
		<div class="dashboard-panel grid">
			<div class="">
				<h2 class="panel-title">Area Competenza Alfabetica Funzionale</h2>
				<p class="text-lg">(Comunicazione nella lingua italiana)</p>
			</div>
			<p>Qui puoi trovare i risultati conseguiti nelle sezioni relative alle competenze alfabetiche funzionali</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-11') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Ascoltare"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['ascoltare'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['ascoltare'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-12') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Parlare"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['parlare'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['parlare'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-39') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Leggere"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['leggere'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['leggere'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-14') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Scrivere"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['scrivere'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['scrivere'] ?></span></p>
					</div>
				</div>
			</div>
		</div>

		<!-- Imparare -->
		<div class="dashboard-panel grid">
			<h2 class="panel-title">Area Imparare a imparare</h2>
			<p>Qui puoi trovare i risultati conseguiti nelle sezioni relative alle abilità e strumenti inerenti alle competenze di apprendimento</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-9') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Stare attenti"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['attenzione'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['attenzione'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-10') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Ricordare"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['ricordare'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['ricordare'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-5') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Risolvere problemi"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['problemi'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['problemi'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-40') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Media dei risultati della sezione <span class="italic font-normal">"Imparare"</span>:</h3>
						<p class="answer"><span class="font-semibold"><?= $results['scrivere'] === null ? '<span class="font-normal">non ancora completata</span>' : $results['scrivere'] ?></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 2 -->
	<div class="grid page-content" data-columns="30rem" data-spacing="700">
		<!-- Imparare -->
		<div class="dashboard-panel grid">
			<div>
				<h2 class="panel-title">Area Competenza Imprenditoriale</h2>
				<p class="text-lg">(Spirito di iniziativa e imprenditorialità)</p>
			</div>
			<p>Qui puoi trovare i risultati relativi ai tipi di pensiero e alle capacità autoimprenditoriali</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-17') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Risultati della sezione <span class="italic font-normal">"Creatività e autoimprenditorialità"</span>:</h3>

						<?php if ($results['creatività'] === null) { ?>
							<span class="font-normal">non ancora completata</span>
						<?php } else { ?>
							<div class="mt-2">
								<?php foreach ($results['creatività'] as $key => $result) { ?>

									<p class="answer"><?= $result['name'] ?>: <span class="font-semibold"><?= $result['percentage'] ?>%</span></p>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Motivazione e interessi -->
		<div class="dashboard-panel grid">
			<div>
				<h2 class="panel-title">Area Motivazionale</h2>
				<p class="text-lg">(Consapevolezza ed espressione culturali)</p>
			</div>
			<p>Qui puoi trovare i risultati relativi a ciò che motiva ed interessa di più lo studente/la studentessa</p>

			<div class="results mar-t-2">
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-7') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span class="italic font-normal">"Motivazione e aree di interesse"</span>:</h3>
						<p class="answer mt-1"><span class="font-semibold"><?= $results['motivazione'] === null ? '<span class="font-normal">non ancora completata</span>' : '<span class="font-normal">Area principale:</span> ' . $results['motivazione'] ?></span></p>
					</div>
				</div>
				<div class="result">
					<div class="result__icon">
						<?= embed_icon('sections/section-24') ?>
					</div>

					<div class="result__content">
						<h3 class="result__title">Area d'interesse principale, indicata nella sezione <span class="italic font-normal">"I miei interessi"</span>:</h3>
						<p class="answer mt-1"><span class="font-semibold"><?= $results['interessi'] === null ? '<span class="font-normal">non ancora completata</span>' : '<span class="font-normal">Area principale:</span> ' . $results['interessi'] ?></span></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Row 3 -->
	<div class="">
		<!-- Consiglio Orientativo -->
		<form class="dashboard-panel grid" data-spacing="400" method="POST">
			<h2 class="dashboard-panel__title">Consiglio orientativo</h2>
			<p>È possibile selezionare qui sotto uno o più consigli orientativi. Si può indicare un'area generica (ad esempio "Liceo") oppure un indirizzo più specifico:</p>

			<div class="grid mar-t-2" data-spacing="400">

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