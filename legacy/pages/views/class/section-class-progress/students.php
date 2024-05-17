{% block content %}

<?php if ($students->num_rows) { ?>

	<!-- List -->
	<section class="dashboard-list">
		<div class="grid">
			<div class="dashboard-list-header">
				<h1 class="dashboard-list-title">Lista degli studenti</h1>
			</div>
		</div>

		<div class="dashboard-list-body" style="--_columns: 2fr 1fr;">
			<div class="list">

				<div class="head">
					<p class="dashboard-field dashboard-field_head">Studente</p>
					<p class="dashboard-field dashboard-field_head"></p>
				</div>

				<?php while ($studentData = $students->fetch_assoc()) {
					$student = new \Legacy\UserSystem\Student($studentData['id']);
				?>

					<form class="dashboard-row">
						<p class="dashboard-field"><?= $student->fullName ?></p>

						<div class="dashboard-field dashboard-field_btns">
							<a class="btn gre" href="<?= client_url('/class/student-progress/student?id=' . studentId()) ?>">Vedi il progresso</a>
						</div>
					</form>

				<?php } ?>

			</div>
		</div>
	</section>

<?php } else { ?>

	<!-- Empty -->
	<div class="empty">
		<p>Non ci sono studenti registrati in questa classe.</p>
	</div>

<?php } ?>

{% end content %}