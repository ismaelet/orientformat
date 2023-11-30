<?php

use SchoolSystem\SchoolClass;
use UserSystem\Teacher;

?>

{% block main %}

<div class="page-content full-wrap_left">
	<div class="main-content pos-rel">
		<!-- Title -->
		<h1 class="txt-sbold">Funzionalità<br>per l'insegnante</h1>

		<!-- Classes -->
		<section class="elements mar-t-3">
			<h2 class="section-title">Le tue classi</h2>

			<?php while ($collaboration = $collaborations->fetch_assoc()) {
				$collaborationGrade = new SchoolClass($collaboration['gradeId']);
				$collaborationTeacher = new Teacher($collaboration['teacherId']);
			?>

				<form class="dashboard-warning" method="POST">
					<p><strong><?= $collaborationTeacher->fullName ?></strong> ha chiesto di poter collaborare alla gestione della classe <strong><?= $collaborationGrade->name . ' - ' . $collaborationGrade->yearRange ?></strong></p>

					<button name="accept-collaboration" value="<?= $collaboration['id'] ?>" class="button">Accetta</button>
					<button name="decline-collaboration" value="<?= $collaboration['id'] ?>" class="button button--secondary">Rifiuta</button>
				</form>

			<?php } ?>

			<div class="element-list element-list_classes mar-t-2">

				<?php if (teacher()->schoolClasses) {
					foreach (teacher()->schoolClasses as $key => $schoolClass) { ?>

						<div class="load--fade-in js-load grid-flow" data-direction="bottom" data-delay="<?= $key % 3 ?>">
							<a class="element element_class" href="<?= client_url('/class?class-id=' . $schoolClass->id) ?>">
								<div>
									<h3 class="class-name fw-bold"><?= substr($schoolClass->name, 0, 4) ?></h3>
									<h3 class="fa-center txt-sbold">(<?= $schoolClass->yearRangeString ?>)</h3>
								</div>

								<div>
									<p class="element-subtitle txt-sbold"><?= $schoolClass->school->name ?></p>
									<!-- <p class="mar-t-1">Codice classe:<br><strong><?= $schoolClass->code ?></strong></p> -->
								</div>
							</a>
						</div>

				<?php }
				} ?>

				<div class="load--fade-in js-load" data-direction="bottom" data-delay="<?= teacher()->schoolClassCount % 4 ?>">
					<a class="element element_functionality" href="<?= client_url('/teacher/add-class') ?>">
						<div class="element-icon icon-box">
							<?= icon_embed('add') ?>
						</div>

						<div>
							<p class="element-subtitle txt-sbold">Aggiungi una classe</p>
						</div>
					</a>
				</div>
			</div>
		</section>

		<!-- Functionalities -->
		<section class="elements mar-t-3">
			<h2 class="section-title">Strumenti</h2>
			<div class="element-list element-list_functionalities mar-t-2">

				<?php foreach ($functionalities as $key => $functionality) { ?>

					<div class="load--fade-in js-load" data-direction="bottom" data-delay="<?= ($key - 1) % 2 ?>">
						<a class="element element_functionality" href="<?= $functionality['url'] ?>">
							<div class="element-icon icon-box">
								<?= icon_embed('functionality-' . $functionality['slug']) ?>
							</div>
							<div>
								<h3 class="element-title txt-upp fw-bold"><?= $functionality['title'] ?></h3>
								<p class="element-subtitle mar-t-05"><?= $functionality['desc'] ?></p>
							</div>
						</a>
					</div>

				<?php } ?>

			</div>
		</section>
	</div>

	<aside class="feed-bar pos-rel">
		<div class="feed-bar_container">
			<h2 class="txt-15rem txt-sbold mar-b-2">Attività recenti</h2>
			<div class="grid gap1">

				<?php if ($feed) {
					foreach ($feed as $feedEntry) { ?>

						<div class="feed-entry">
							<p class="feed-text"><?= '<span>' . $feedEntry->date() . ':</span> ' . $feedEntry->text() ?></p>
						</div>

					<?php }
				} else { ?>

					<p class="empty-feed">Nessuna notificazione</p>

				<?php } ?>

			</div>
		</div>
	</aside>
</div>

{% end main %}