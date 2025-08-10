{% extends dashboard %}

{% block content %}

<?= snippet_breadcrumbs($breadcrumbs) ?>

<div class="grid center-content" data-spacing="400">
	<h1><?= $pageTitle ?></h1>

	<a href="<?= client_url('/class/class-progress/list') ?>" class="sbtn block push-center mb-4">Indietro</a>

	<?php if ($divideBy) { ?>
		<h2 class="text-center txt-15rem txt-sbold">Risultati divisi <?= $divideByNames[$divideBy] ?></h2>
	<?php } ?>

	<?php if ($filterBy) { ?>
		<h2 class="filter-title text-center txt-12rem">Mostrando solo gli alunni <?= $filterByNames[$filterBy][$filterRange] ?></h2>
	<?php } ?>
</div>

<?php snippet_graph_filters($graphData, $sectionId, $divideBy, $filterBy) ?>

<?php if ($graphData) { ?>
	<!-- Graph -->
	<section class="graph <?= $divideBy ? 'graph--divided' : '' ?> <?= 'graph--' . section_config($sectionId, 'type') ?> js-load" data-section-id="<?= $sectionId ?>">
		<?php graph_columns($graphData) ?>
	</section>
<?php } else { ?>
	<h3 class="txt-red txt-sbold text-center mar-v-10">
		Non c'è nessun alunno che rispetti questi filtri e che abbia completato l'attività.
	</h3>
<?php } ?>

<p class="text-center txt-1rem mar-t-2"><?= section_config($sectionId, 'desc') ?></p>

<div class="center-content grid">
	<a href="<?= client_url('/read?id=' . $sectionId) ?>" class="button button--auto-width mar-t-2">
		<?= embed_icon('read') ?>
		Saperne di più
	</a>
</div>

{% end content %}