<?php

/*
use Activity\Result\Handler\SchoolClassSectionResult;
use Activity\Section;

$key = $_GET['key'];
$sectionId = $_GET['sectionId'];
$section = new Section($sectionId);
$result = null;
$time_start = microtime(true);
$graphData = generate_graph_data($sectionId, schoolClass());
$empty = !$graphData['count'];

if (!$empty) {
	$result = (new SchoolClassSectionResult($sectionId, schoolClassId()))->result;
}


if (!$empty) { ?>

	<?php /* 
	<section class="filters mar-b-1">
		<?php snippet_graph_filters($graphData, $sectionId, false, false, $key + 1) ?>
	</section>
	 ?>

	<div class="graph">
		<?php graph_columns($graphData) ?>
	</div>

	<h3 class="dashboard-panel_result">
		<span class="inlb"><?= section_config($sectionId, 'recap-name-grade') ?: 'Risultato medio' ?>:</span><br>
		<span class="dashboard-panel_value inlb txt-bold"><?= $result ?></span>
	</h3>

<?php } else { ?>

	<p class="empty">Ancora nessuno studente ha completato questa sezione</p>

<?php } ?>
*/