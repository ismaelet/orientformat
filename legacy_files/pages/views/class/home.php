{% block dashboard-body %}

<div class="grid-flow" data-spacing="800">
	<section class="slider__header">
		<div class="slider__title-block grid-flow">
			<h1 class="title">Pannello della<br>classe <?= schoolClass()->name ?></h1>
			<p class="section-subtitle">Qui puoi controllare il progresso della classe e modificarne le impostazioni</p>
		</div>

		<ul class="recap-panel grid-flow" data-spacing="800">

			<a class="recap-item js-load load--fade-in" data-direction="bottom" data-delay="1" href="<?= client_url('/class/students/list') ?>" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.5">
				<?= embed_icon(APP_ICONS_DIR . 'dashboards/students') ?>
				<div>
					<p class="recap-item__label">Studenti registrati</p>
					<p class="recap-item__value"><?= schoolClass()->studentCount . (schoolClass()->studentCount <> 1 ? ' studenti' : ' studente') ?></p>
				</div>
			</a>

			<a class="recap-item js-load load--fade-in" data-direction="bottom" data-delay="2" href="<?= client_url('/class/students/progress/list') ?>" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.5">
				<?= embed_icon(APP_ICONS_DIR . 'dashboards/student-progress') ?>
				<div>
					<p class="recap-item__label">Attività completate</p>
					<p class="recap-item__value"><?= $progressPercent ?> %</p>
				</div>
			</a>

			<a class="recap-item js-load load--fade-in" data-direction="bottom" data-delay="3" data-tilt data-tilt-max="5" data-tilt-glare="true" data-tilt-max-glare="0.5">
				<?= embed_icon(APP_ICONS_DIR . 'dashboards/settings') ?>
				<div>
					<p class="recap-item__label">Codice della classe</p>
					<p class="recap-item__value"><?= schoolClass()->code ?></p>
				</div>
			</a>
		</ul>
	</section>


	<section class="lists grid-flow" data-spacing="800">

		<!-- Recent activities -->
		<div class="dashboard-panel js-load load--fade-in" data-direction="bottom" data-delay="0" data-load-type="always">
			<h3 class="dashboard-panel__title">Lista degli studenti</h3>

			<?php if ($schoolClass->studentCount) { ?>

				<div class="dashboard-list">
					<div class="dashboard-list__row  dashboard-list__row--header">
						<p class="dashboard-field dashboard-field_head">Nome</p>
						<p class="dashboard-field dashboard-field_head">Username</p>
						<p class="dashboard-field dashboard-field_head">Registrato il</p>
						<p class="dashboard-field dashboard-field_head">Attivo</p>
					</div>

					<?php foreach (schoolClass()->students as $student) { ?>

						<div class="dashboard-list__row">
							<p class="dashboard-list__field"><?= $student->user->invertedFullName ?></p>
							<p class="dashboard-list__field"><?= $student->user->username ?></p>
							<p class="dashboard-list__field"><?= $student->user->time ?></p>
							<div class="dashboard-list__field"><?= snippet_binary_icon($student->status) ?></div>
						</div>

					<?php } ?>

				</div>

			<?php } else { ?>

				<p class="center-content mar-v-5">Ancora nessun studente registrato</p>

			<?php } ?>

		</div>

		<!-- Recent activities -->
		<div class="dashboard-panel js-load load--fade-in" data-direction="bottom" data-delay="0" data-load-type="always">
			<h3 class="dashboard-panel__title">Attività recenti</h3>

			<?php if ($feedEntriesData) { ?>

				<div class="dashboard-list">

					<?php foreach ($feed as $feedEntry) { ?>

						<div class="dashboard-list__row">
							<div>
								<p class="dashboard-list__label"><?= $feedEntry['studentName'] ?></p>
								<p class="dashboard-list__field"><?= $feedEntry['text'] ?></p>
							</div>
						</div>

					<?php } ?>

				</div>

			<?php } else { ?>

				<p class="center-content mar-v-5">Nessuna attività recente</p>

			<?php } ?>

		</div>
	</section>
</div>

{% end dashboard-body %}