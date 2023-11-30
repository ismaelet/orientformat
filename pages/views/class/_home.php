{% block content %}

<h1 class="txt-15rem txt-med mar-b-4 hidden">Pannello di controllo<br><span style="font-size: 1.7em;">della classe <strong><?= $grade->name ?></strong></span></h1>

<section class="dashboard-home-section dashboard-home-section_small pad-t-3">
	<div class="dashboard-panel load slide-bottom ld-0">
		<div class="dashboard-panel-body">
			<div class="dashboard-panel-icon icon-box load slide-bottom ld-2">
				<?= icon_embed(__APP_ICONS__ . 'dashboards/students') ?>
			</div>
			<h3 class="dashboard-panel-title">Studenti registrati</h3>
			<h3 class="dashboard-panel-subtitle"><?= $grade->studentCount . ($grade->studentCount <> 1 ? ' studenti' : ' studente') ?> </h3>
		</div>
		<div class="dashboard-panel-footer">
			<p class="dashboard-home-more">
				<a href="<?= client_url('/class/students/list') ?>">Visualizza tutti</a>
			</p>
		</div>
	</div>

	<div class="dashboard-panel load slide-bottom ld-1">
		<div class="dashboard-panel-body">
			<div class="dashboard-panel-icon icon-box load slide-bottom ld-3">
				<?= icon_embed(__APP_ICONS__ . 'dashboards/student-progress') ?>
			</div>
			<h3 class="dashboard-panel-title">Attività completate</h3>
			<h3 class="dashboard-panel-subtitle"><?= $testCount ?> </h3>
		</div>
		<div class="dashboard-panel-footer">
			<p class="dashboard-home-more">
				<a href="<?= client_url('/class/class-progress/list') ?>">Controlla il progresso</a>
			</p>
		</div>
	</div>

	<div class="dashboard-panel load slide-bottom ld-2">
		<div class="dashboard-panel-body">
			<div class="dashboard-panel-icon icon-box load slide-bottom ld-4">
				<?= icon_embed(__APP_ICONS__ . 'dashboards/results') ?>
			</div>
			<h3 class="dashboard-panel-title">Consigli orientativi dati</h3>
			<h3 class="dashboard-panel-subtitle"><?= $advicesPercentage ?> %</h3>
		</div>
		<div class="dashboard-panel-footer">
			<p class="dashboard-home-more">
				<a href="<?= client_url('/class/students/list') ?>">Consigli orientativi</a>
			</p>
		</div>
	</div>

	<div class="dashboard-panel load slide-bottom ld-3">
		<div class="dashboard-panel-body">
			<div class="dashboard-panel-icon icon-box load slide-bottom ld-5">
				<?= icon_embed(__APP_ICONS__ . 'dashboards/settings') ?>
			</div>
			<h3 class="dashboard-panel-title">Codice della classe</h3>
			<h3 class="dashboard-panel-subtitle"><?= $grade->code ?></h3>
		</div>
		<div class="dashboard-panel-footer">
			<p class="dashboard-home-more">
				<a href="<?= client_url('/class/settings/general') ?>">Impostazioni</a>
			</p>
		</div>
	</div>
</section>

<section class="grid2 gap2 mar-t-3 mar-b-4">

	<!-- Recent activities -->
	<section class="dashboard-list load slide-bottom ld-0">
		<div class="grid">
			<div class="dashboard-list-header load slide-bottom ld-2">
				<h1 class="dashboard-list-title">Attività recenti</h1>
			</div>


			<div class="pad-2">

				<?php foreach ($feed as $feedEntry) { ?>
					<div class="feed-entry">
						<h3 class="feed-name txt-med txt-09rem txt-c3"><?= $feedEntry['studentName'] ?></h3>
						<p class="feed-text"><?= $feedEntry['text'] ?></p>
					</div>
				<?php } ?>

			</div>
		</div>
	</section>

	<!-- Student list -->
	<section class="dashboard-list load slide-bottom ld-1">
		<div class="grid">
			<div class="dashboard-list-header load slide-bottom ld-3">
				<h1 class="dashboard-list-title">Lista degli studenti</h1>
			</div>
		</div>

		<div class="dashboard-list-body" style="--_columns: repeat(5, auto);">
			<div class="list">

				<div class="head">
					<p class="dashboard-field dashboard-field_head">Cognome</p>
					<p class="dashboard-field dashboard-field_head">Nome</p>
					<p class="dashboard-field dashboard-field_head">Username</p>
					<p class="dashboard-field dashboard-field_head">Registrato il</p>
					<p class="dashboard-field dashboard-field_head">Attivo</p>
				</div>

				<?php while ($student = $students->fetch_assoc()) { ?>

					<form class="dashboard-row" id="row<?= $student['id'] ?>" method="POST" action="#row<?= $student['id'] ?>">

						<p class="dashboard-field"><?= ucfirst($student['lastname']) ?></p>
						<p class="dashboard-field"><?= ucfirst($student['firstname']) ?></p>
						<p class="dashboard-field"><?= $student['username'] ?></p>
						<p class="dashboard-field"><?= $student['time'] ?></p>
						<div class="dashboard-field dashboard-field_min-width"><?= snippet_binary_icon($student['status']) ?></div>
						<input type="hidden" name="id" value="<?= $student['id'] ?>">

					</form>

				<?php } ?>

			</div>
		</div>

		<div class="dashboard-list-footer">
			<p class="dashboard-home-more">
				<a href="<?= client_url('/class/students/list') ?>">Visualizza tutti</a>
			</p>
		</div>
	</section>

</section>

{% end content %}