{% block main %}

<div class="main-wrap pt-20 pad-b-7">
	<h1 class="page-title">Come utilizzare la piattaforma</h1>

	<a href="<?= $returnUrl === 'add' ? route('classes.create') : (isset($_SESSION['dashboard-schoolClassId']) ? route('class.settings', ['class' => $_SESSION['dashboard-schoolClassId']]) : route('teacher.dashboard')) ?>" class="button button--secondary back mar-t-1">Indietro</a>

	<p class="page_text mar-t-2 txt-1rem txt-jus">
		Orient-Format si presta a modalità di impiego che possono variare in base alle classi, al tempo disponibile, a particolari interessi del docente-orientatore, a bisogni formativi specifici all’interno della classe e alla disponibilità di collaborazione da parte dei colleghi. Elenchiamo sinteticamente alcuni possibili percorsi. Altri percorsi ci potranno essere suggeriti dagli stessi docenti. Quando il docente orientatore sceglie un percorso, nell’ambiente studente compariranno solo le relative aree e sezioni. Tuttavia l’orientatore potrà decidere in seguito di intraprendere un nuovo e più ampio percorso.
	</p>

	<section class="paths">

		<?php foreach ($paths as $key => $path) { ?>

			<div class="path">
				<h2 class="path_title"><?= $path['name'] ?></h2>
				<p class="path_text"><?= $path['info'] ?></p>

				<div class="areas">

					<?php foreach ($areas as $areaSlug => $area) { ?>

						<div class="area">
							<h3 class="area_title"><?= $area ?></h3>
							<p class="area_text mt-2"><?= implode('<br>', (array) $path['sections'][$areaSlug]) ?></p>
						</div>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</section>
</div>

{% end main %}