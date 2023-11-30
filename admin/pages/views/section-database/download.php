{% block content %}

<div class="panels grid-flow" data-columns="40rem" data-spacing="700">
	<form class="panel" method="POST">
		<h2 class="panel_title">Studenti</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-students" value="all">
				Scarica la lista di tutti gli studenti
				<?= icon_embed('download') ?>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-students" value="<?= $i ?>">
					Scarica gli studenti registrati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= icon_embed('download') ?>
				</button>

			<?php } ?>

		</div>
	</form>

	<!-- Teachers -->
	<form class="panel" method="POST">
		<h2 class="panel_title">Docenti</h2>

		<div class="download-buttons">
			<button class="download-button" name="download-teachers" value="all">
				Scarica la lista di tutti i docenti
				<?= icon_embed('download') ?>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-teachers" value="<?= $i ?>">
					Scarica i docenti registrati nel <?= $i ?>
					<?= icon_embed('download') ?>
				</button>

			<?php } ?>

		</div>
	</form>

	<!-- Classes -->
	<form class="panel" method="POST">
		<h2 class="panel_title">Classi</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-school-classes" value="all">
				Scarica la lista di tutte le classi
				<?= icon_embed('download') ?>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-school-classes" value="<?= $i ?>">
					Scarica le classi registrate dell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= icon_embed('download') ?>
				</button>

			<?php } ?>

		</div>
	</form>

	<!-- Results -->
	<!-- <form class="panel" method="POST">
		<h2 class="panel_title">Risultati</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-results" value="all">
				Scarica la lista di tutti i risultati
				<div class="text-icon text-icon--small icon-box">
					<?= icon_embed('download') ?>
				</div>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-results" value="<?= $i ?>">
					Scarica i risultati degli studenti dell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<div class="text-icon text-icon--small icon-box">
						<?= icon_embed('download') ?>
					</div>
				</button>

			<?php } ?>

		</div>
	</form> -->

	<!-- Reviews -->
	<!-- <form class="panel" method="POST">
		<h2 class="panel_title">Questionari</h2>

		<div class="download-buttons">
			<button class="download-button" name="download-reviews" value="all">
				Scarica la lista di tutti i risultati dei questionari iniziali e finali
				<?= icon_embed('download') ?>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-reviews" value="<?= $i ?>">
					Scarica i risultati dei questionari compilati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= icon_embed('download') ?>
				</button>

			<?php } ?>

		</div>
	</form> -->

	<!-- Advices -->
	<!-- <form class="panel" method="POST">
		<h2 class="panel_title">Consigli orientativi</h2>

		<div class="download-buttons">

			<button class="download-button" name="download-advices" value="all">
				Scarica la lista di tutti i consigli orientativi
				<?= icon_embed('download') ?>
			</button>

			<?php for ($i = $startingYear; $i <= $currentYear; $i++) { ?>

				<button class="download-button" name="download-advices" value="<?= $i ?>">
					Scarica i consigli orientativi dati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= icon_embed('download') ?>
				</button>

			<?php } ?>

		</div>
	</form> -->
</div>

{% end content %}