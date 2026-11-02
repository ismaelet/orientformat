{% block dashboard-body %}

<div class="page__content">
	<div class="page__header">
		<h1 class="section-title"><span class="font-bold">P</span>rofilo <span class="font-bold">O</span>rientativo <span class="font-bold">I</span>ndividualizzato</h1>
		<p class="section-subtitle">Alla fine del percorso ti consigliamo di attribuire i consigli orientativi a tutti i tuoi studenti. Ogni studente può ricevere fino a tre consigli.</p>
	</div>

	<!-- List -->
	<section class="dashboard-panel">
		<h3 class="dashboard-panel__title">Lista degli studenti</h3>

		<?php
use Legacy\UserSystem\Student;

if ($students->num_rows) { ?>

			<div class="dashboard-list" style="--columns: 3;">
				<div class="dashboard-list__row dashboard-list__row--header">
					<p class="dashboard-list__field">Studente\Studentessa</p>
					<p class="dashboard-list__field">Consigli orientativi</p>
					<div class="dashboard-list__field"></div>
				</div>

				<?php while ($student = $students->fetch_assoc()) {
				    $student = new Student($student['id']);
				    ?>

					<form class="dashboard-list__row" id="row<?= $student->id ?>" method="POST" action="#row<?= $student->id ?>">
						<p class="dashboard-list__field"><?= $student->InvertedfullName ?></p>
						<p class="dashboard-list__field"><?= $student->advicesString ?: '-' ?></p>
						<div class="dashboard-list__field dashboard-list__field--buttons">
							<a href="<?= 'recap?studentId='.$student->id ?>" class="dashboard-list__button">Scegli consiglio</a>
						</div>
					</form>

				<?php } ?>

			</div>

		<?php } else { ?>

			<p class="center-content mar-v-5">Non ci sono studenti registrati in questa classe.</p>

		<?php } ?>

	</section>

	<!-- Print -->
	<div class="grid center-content">
		<div class="button mar-t-3 js-print">
			<?= embed_icon('print') ?>
			Stampa
		</div>
	</div>
</div>

{% end dashboard-body %}