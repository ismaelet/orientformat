<?php

function snippet_graph_filters($graphData, $sectionId, $divideBy = false, $filterBy = false) { ?>
	<!-- Filters -->
	<form class="search-filters <?= $divideBy || !section_config($sectionId, 'average') ? 'search-filters--default-position' : '' ?>" method="GET" action="results">

		<input type="hidden" name="sectionId" value="<?= $sectionId ?>">

		<?php foreach (sysDashboardGraphsConfig('search-filters') as $filter) { ?>

			<div class="search-filter <?= empty($_GET[$filter['slug']]) ? '' : 'active' ?>">
				<input type="checkbox" class="search-filter-cbx" id="search-filter-<?= $filter['slug'] . $sectionId ?>">
				<label class="search-filter-header" for="search-filter-<?= $filter['slug'] . $sectionId ?>">
					<p class="search-filter-title"><?= $filter['title'] ?></p>
					<div class="search-filter-icon icon-box">
						<?= icon_embed('navigation/arrow1-down') ?>
					</div>
				</label>

				<div class="search-filter-ddown">

					<?php foreach ($filter['list'] as $filterElement) {

						if (isset($filterElement['list'])) { ?>
							<label class="search-filter_filter pos-rel">
								<input type="checkbox" class="search-filter-field-cbx js-search-overcbx" name="<?= $filter['slug'] ?>" value="<?= $filterElement['slug'] ?>" <?= isset($_GET[$filter['slug']]) && $_GET[$filter['slug']] == $filterElement['slug'] ? 'checked' : '' ?>>
								<p class="search-filter-field"><?= $filterElement['title'] ?></p>

								<div class="search-filter_sublist">

									<?php foreach ($filterElement['list'] as $filterSubelement) { ?>
										<label class="search-filter_subfilter">
											<input type="checkbox" class="search-filter-field-cbx js-search-subcbx" name="range" value="<?= $filterSubelement[1] ?>" <?= isset($_GET['range']) && $_GET['range'] == $filterSubelement[1] ? 'checked' : '' ?>>
											<p class="search-filter-field"><?= $filterSubelement[0] ?></p>
										</label>
									<?php } ?>

								</div>
							</label>
						<?php } else { ?>
							<label>
								<input type="checkbox" class="search-filter-field-cbx js-search-cbx" name="<?= $filter['slug'] ?>" value="<?= $filterElement['slug'] ?>" <?= isset($_GET[$filter['slug']]) && $_GET[$filter['slug']] == $filterElement['slug'] ? 'checked' : '' ?>>
								<p class="search-filter-field"><?= $filterElement['title'] ?></p>
							</label>
					<?php }
					} ?>

				</div>
			</div>

			<h3>oppure</h3>

		<?php } ?>

		<div>
			<?php if (!$graphData) $graphData['count'] = 0; ?>
			<p class="results-count">dati di <?= $graphData['count'] ?> <?= $graphData['count'] == 1 ? 'studente' : 'studenti' ?></p>

			<?php if ($divideBy || $filterBy) { ?>
				<p class="remove-filter inlb clickable">
					<strong>x</strong>
					rimuovi i filtri
				</p>
			<?php } ?>
		</div>
	</form>
<?php }
