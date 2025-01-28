{% block dashboard-body %}

<div class="page__content" data-spacing="800">
	<div class="page__header">
		<h1 class="section-title">Progresso degli studenti</h1>
		<p class="section-subtitle">Seleziona dalla lista qui sotto lo studente/studentessa del/della quale vuoi esaminare i risultati.</p>
	</div>

	<!-- List -->
	<section class="dashboard-panel">
		<h3 class="dashboard-panel__title">Lista degli studenti</h3>

		<?php if (schoolClass()->studentCount) { ?>

			<div class="dashboard-list" style="--columns: 2;">
				<div class="dashboard-list__row dashboard-list__row--header">
					<p class="dashboard-list__field">Studente</p>
					<div class="dashboard-list__field"></div>
				</div>

				<?php foreach (schoolClass()->students as $student) { ?>

					<a class="dashboard-list__row js-show-loading-panel" href="<?= client_url('/class/students/progress/focus?studentId=' . $student->id) ?>">
						<p class="dashboard-list__field"><?= $student->invertedFullName ?></p>

						<div class="dashboard-list__field dashboard-list__field--buttons">
							<div class="dashboard-list__button">Vedi il progresso</div>
						</div>
					</a>

				<?php } ?>

			</div>

		<?php } else { ?>

			<!-- Empty -->
			<div class="empty">
				<p class="pad-h-3 pad-v-5 fa-center txt-sbold txt-11rem">Non ci sono studenti registrati in questa classe.</p>
			</div>

		<?php } ?>

	</section>
</div>

<div class="loading-panel js-loading-panel">
	<?= embed_icon(ICONS_DIR . 'loading') ?>
</div>

{% end dashboard-body %}