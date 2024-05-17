{% block content %}

<div class="panels grid-flow" data-columns="40rem" data-spacing="700">
	<form class="panel" method="POST">
		<h2 class="panel_title">Studenti</h2>

		<div class="download-buttons">

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-active-students" value="<?= $i ?>">
					Scarica gli studenti attivi nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= embed_icon('download') ?>
				</button>

			<?php } ?>

		</div>

		<hr class="border-neutral-200">

		<div class="download-buttons">

			<button class="download-button download-button--fade" name="download-students" value="all">
				Scarica la lista di tutti gli studenti
				<?= embed_icon('download') ?>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button download-button--fade" name="download-students" value="<?= $i ?>">
					Scarica gli studenti registrati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= embed_icon('download') ?>
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
				<?= embed_icon('download') ?>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-teachers" value="<?= $i ?>">
					Scarica i docenti registrati nel <?= $i ?>
					<?= embed_icon('download') ?>
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
				<?= embed_icon('download') ?>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-school-classes" value="<?= $i ?>">
					Scarica le classi registrate dell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= embed_icon('download') ?>
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
					<?= embed_icon('download') ?>
				</div>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-results" value="<?= $i ?>">
					Scarica i risultati degli studenti dell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<div class="text-icon text-icon--small icon-box">
						<?= embed_icon('download') ?>
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
				<?= embed_icon('download') ?>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-reviews" value="<?= $i ?>">
					Scarica i risultati dei questionari compilati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= embed_icon('download') ?>
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
				<?= embed_icon('download') ?>
			</button>

			<?php for ($i = $currentYear; $i >= $startingYear; $i--) { ?>

				<button class="download-button" name="download-advices" value="<?= $i ?>">
					Scarica i consigli orientativi dati nell'anno scolastico <?= $i ?>/<?= $i + 1 ?>
					<?= embed_icon('download') ?>
				</button>

			<?php } ?>

		</div>
	</form> -->
</div>

{% end content %}