@props(['class', 'title' => null, 'classLocation' => null])

@php
	/*
	 * Load configurations
	 * 	- requires a dashboard name, set in the router
	 * 	- requires a file in app/config named dashboard-*name* with all the configurations stored in a $dashboardConfig variable
	 */
	$dashboardName = \App\Legacy\LegacyView::get('dashboard-name');

	$dashboardNavigation = [];

	$dashboardNavigation[] = [
	    'title' => 'Tutte le classi',
	    'slug' => 'classes',
	    'url' => client_url('/'),
	];

	$dashboardNavigation[] = [
	    'title' => 'Riepilogo',
	    'slug' => 'home',
	    'url' => client_url('/class'),
	];

	$dashboardNavigation[] = [
	    'title' => 'Risultati di classe',
	    'slug' => 'class-progress',
	    'links' => [['title' => 'Grafici riassunitivi', 'slug' => 'graphs']],
	];

	if ($class->isMiddleSchool()) {
	    $dashboardNavigation[] = [
	        'title' => 'Risultati individuali',
	        'slug' => 'students',
	        'links' => [
	            ['title' => 'Progresso dello studente', 'slug' => 'progress/list'],
	            ['title' => 'P.O.I.', 'slug' => 'progress/poi'],
	            $class->grade == 3 ? ['title' => 'Consigli orientativi', 'slug' => 'suggestion'] : null,
	        ],
	    ];
	} else {
	    $dashboardNavigation[] = [
	        'title' => 'Studenti',
	        'slug' => 'students',
	        'links' => [['title' => 'Progresso degli studenti', 'slug' => 'progress/list']],
	    ];
	}

	$dashboardNavigation[] = [
	    'title' => 'Gestione',
	    'slug' => 'settings',
	    'links' => [
	        ['title' => 'Lista degli studenti', 'slug' => 'list'],
	        ['title' => 'Gestione docenti', 'slug' => 'teachers'],
	        ['title' => 'Impostazioni generali', 'slug' => 'general'],
	    ],
	];

	$dashboardConfig = [
	    'path' => 'class',
	    'logo' => false,
	    'return-link' => true,
	    'navigation' => $dashboardNavigation,
	];

	unset($dashboardNavigation);

	// load template parts
	\App\Legacy\StyleLoader::add('-expands-dashboard/list', 'template');

	// fetch current section
	$currentPath = false;

	if (strpos(\App\Legacy\LegacyView::getInstance()->name, '-')) {
	    $path = explode(
	        '/',
	        explode('section-', str_replace('add', 'list', \App\Legacy\LegacyView::getInstance()->name))[1],
	        2,
	    );
	    $currentPath = [
	        'category' => $path[0],
	        'link' => $path[1],
	    ];
	} else {
	    $currentPath = [
	        'category' => 'home',
	    ];
	}

	// fetch categories
	$dashboardNavigation = [];

	foreach ($dashboardConfig['navigation'] as $category) {
	    $dashboardCategory = [];
	    $dashboardCategory['title'] = $category['title'];
	    $dashboardCategory['slug'] = $category['slug'];
	    $dashboardCategory['url'] = $category['url'] ?? null;
	    $dashboardCategory['checked'] = $currentPath && $dashboardCategory['slug'] == $currentPath['category'];
	    $dashboardCategory['links'] = [];

	    if (!empty($category['links'])) {
	        foreach ($category['links'] as $link) {
	            if (!$link) {
	                continue;
	            }

	            $dashboardLink = [];
	            $dashboardLink['title'] = $link['title'];
	            $dashboardLink['slug'] = $link['slug'];
	            $dashboardLink['checked'] =
	                $dashboardCategory['checked'] && $dashboardLink['slug'] == $currentPath['link'];
	            $dashboardLink['url'] =
	                $link['url'] ??
	                client_url('/' . $dashboardConfig['path'] . '/' . $category['slug'] . '/' . $link['slug']);

	            $dashboardCategory['links'][] = $dashboardLink;
	        }
	    }

	    $dashboardNavigation[] = $dashboardCategory;
	}

	$dashboardName = $class->name;
@endphp

@pushOnce('styles')
	<style>
		.dashboard {
			--_background-h: 216;
			--_background-s: 70%;
			--_background-l: 12%;
			--_background: hsl(var(--_background-h), var(--_background-s), var(--_background-l));
			--_icon-size: 1rem;
			display: grid;
			grid-template-columns: max-content minmax(0, 1fr);
			width: 100%;
			min-height: 100dvh;
			overflow: unset;
			background-color: var(--_background);
		}

		.dashboard__body {
			width: 100%;
			height: 100%;
			padding: 3.5rem 3rem;
			background-color: #f2f2f2;
			box-shadow: -1rem 0 5rem rgb(0, 0, 0, 0.1);
			border-radius: 1.5rem 0 0 1.5rem;
			overflow: hidden;
		}

		@media (max-width: 480px) {
			.dashboard__body {
				padding: 2rem 2rem;
			}
		}

		.dashboard__navigation {
			--fc-700: #fff;
			--fc-400: hsl(calc(var(--_background-h) - 4), 25%, 60%);
			display: block;
			color: var(--fc-400);
			transition: width 0.4s;
		}

		.dashboard__navigation-wrapper {
			position: sticky;
			top: 0;
			max-height: 100dvh;
		}


		.dashboard__navigation-header {
			padding-block: 4rem 5rem;
			padding-inline: 0.5rem;
		}

		.dashboard__logo {
			--_padding: 0.6rem;
			display: flex;
			margin-inline: auto;
			width: clamp(4rem, 10vw, 7rem);
			max-width: 100%;
			padding: var(--_padding);
			background: conic-gradient(var(--color-primary-400), var(--color-transition-400), var(--color-secondary-400), var(--_background));
			border-radius: 50%;
		}

		.dashboard__logo::after {
			content: attr(data-content);
			display: flex;
			align-items: center;
			justify-content: center;
			width: 100%;
			aspect-ratio: 1;
			outline: calc(var(--_padding) - 1px) solid var(--_background);
			outline-offset: -1px;
			background-color: hsl(var(--_background-h), var(--_background-s), calc(var(--_background-l) * 0.75));
			border-radius: inherit;
			color: var(--fc-700);
			font-family: var(--ff-titles);
			font-size: calc(min(3rem, 4.5vw) * 2/var(--character-count));
			line-height: 1;
			text-shadow: 0.25rem 0.5rem 1rem black;
		}

		.dashboard__navigation-body {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 2rem;
		}

		.dashboard-category {
			--icon-size: 1rem;
			--_padding: min(4rem, 4vw);
			display: grid;
			grid-template-columns: var(--_padding) 0fr var(--_icon-size) 1fr var(--_padding);
			grid-template-rows: max-content 0fr;
			column-gap: 0.75rem;
			transition: grid-template-rows 0.3s, grid-template-columns 0.4s;
		}

		.dashboard-category input {
			display: none;
		}

		@media (max-width: 1024px) {
			.dashboard__navigation:not(.open) .dashboard-category {
				grid-template-columns: var(--_padding) 0fr var(--_icon-size) 0fr var(--_padding);
			}
		}

		.dashboard-category__header {
			grid-column: 1 / -1;
			display: grid;
			grid-template-columns: subgrid;
			align-items: center;
			font-size: var(--fs-450);
			cursor: pointer;
		}

		.dashboard-category__header a {
			display: contents;
		}

		.dashboard-category__header::before {
			content: '';
			opacity: 0;
			background-color: var(--color-primary-400);
			box-shadow: 3px 0 1rem 0 var(--color-primary-400), 3px 0 2rem 0 var(--color-primary-400);
			width: 3px;
			height: 100%;
			transition: opacity 0.2s;
		}

		.dashboard-category__label {
			font-size: 1em;
			font-family: var(--ff-titles);
			font-weight: var(--font-weight-medium);
			text-wrap: nowrap;
			transition: color 0.2s;
			cursor: pointer;
			overflow: hidden;
		}

		.dashboard-category__header .icon-embed {
			grid-column: 3;
			cursor: pointer;
		}

		.dashboard-category__dropdown-wrapper {
			grid-row: 2;
			grid-column: 4 / -1;
			overflow: hidden;
			opacity: 0;
			transition: opacity 0.3s;
		}

		.dashboard-category__dropdown {
			display: grid;
			gap: 1.5rem;
			grid-template-columns: minmax(0, 1fr);
			padding-top: 1.5rem;
		}

		.dashboard-category__dropdown input {
			display: none;
		}

		.dashboard-category__link {
			display: grid;
			grid-template-columns: 0.5rem auto;
			align-items: center;
			gap: 0.5rem;
			padding-right: 2rem;
			text-wrap: nowrap;
			line-height: 1.2;
			font-family: var(--ff-titles);
			font-size: var(--fs-450);
			font-weight: var(--fw-light);
			transition: 0.2s;
		}

		.dashboard-category__link:has([name='dashboard-link']:checked),
		.dashboard-category__link:hover {
			color: var(--fc-700);
		}

		.dashboard-category__link::before {
			content: '';
			width: 100%;
			aspect-ratio: 1;
			border-radius: 2px;
		}

		.dashboard-category__link:nth-child(1n)::before {
			background-color: #65add6;
		}

		.dashboard-category__link:nth-child(2n)::before {
			background-color: #e7d78f;
		}

		.dashboard-category__link:nth-child(3n)::before {
			background-color: #f05749;
		}

		.dashboard-category__link:nth-child(4n)::before {
			background-color: #93b3aa;
		}

		.dashboard-category__link:nth-child(5n)::before {
			background-color: #c99bd1;
		}

		.dashboard__navigation.open .dashboard-category:has([name='dashboard-category']:checked) {
			grid-template-rows: max-content 1fr;
		}

		@media (min-width: 1025px) {
			.dashboard-category:has([name='dashboard-category']:checked) {
				grid-template-rows: max-content 1fr;
			}
		}

		.dashboard-category:has([name='dashboard-category']:checked) .dashboard-category__dropdown-wrapper {
			opacity: 1;
		}

		.dashboard-category__header:has([name='dashboard-category']:checked),
		.dashboard-category__header:hover {
			color: var(--fc-700);
		}

		.dashboard-category__header:has([name='dashboard-category']:checked)::before {
			opacity: 1;
		}

		/*
																																																			* Body
																																																			*/
		.dashboard-panel {
			padding: 1.5rem;
			background-color: #fff;
			border-radius: var(--border-radius-700);
			box-shadow: var(--shadow-big);
		}

		@media (min-width: 769px) {
			.dashboard-panel {
				padding: 2.5rem;
			}
		}

		.dashboard-panel__title,
		.dashboard-panel__title--outer {
			padding-bottom: 2.5rem;
			margin-bottom: 2rem;
			font-weight: var(--fw-bold);
			font-size: min(var(--fs-700), 6vw);
			border-bottom: var(--border);
		}

		.dashboard-panel__title--outer {
			border-bottom: unset;
			padding-bottom: 0;
			margin-bottom: 1rem;
		}

		.dashboard-list {
			--icon-size: 1em;
			display: grid;
			grid-template-columns: repeat(var(--columns, 1), auto);
		}

		@media (max-width: 1024px) {
			.dashboard-list {
				overflow: auto;
			}
		}

		.dashboard-list__row {
			display: grid;
			grid-template-columns: subgrid;
			grid-column: 1 / -1;
			column-gap: 1rem;
			align-items: center;
			padding-block: 1rem;
			border-top: 1px solid var(--border-clr-200);
		}

		.dashboard-list__row:first-child {
			padding-top: 0;
			border-top: none;
		}

		.dashboard-list__row:last-child {
			padding-bottom: 0;
		}

		.dashboard-list__row .icon-embed {
			margin: unset;
		}

		@media (max-width: 1024px) {
			.dashboard-list__row {
				min-width: 768px;
			}
		}

		.dashboard-list__label {
			font-family: var(--ff-titles);
			font-weight: var(--fw-semibold);
			font-size: var(--fs-450);
		}

		.dashboard-list__row--header p {
			font-weight: var(--fw-bold);
		}

		.dashboard-list__field--buttons {
			display: flex;
			flex-wrap: wrap;
			gap: 0.5rem;
		}

		.dashboard-list__button {
			border: none;
			background-color: transparent;
			box-shadow: none;
			font-family: var(--ff-default);
			font-size: var(--fs-300);
			font-weight: var(--font-weight-medium);
			color: var(--color-tertiary-400);
			cursor: pointer;
		}

		.dashboard-list__button[data-color='red'] {
			color: var(--color-bad-400);
		}

		.dashboard-list__button[data-color='green'] {
			color: var(--color-good-400);
		}

		.dashboard-list__field {
			word-break: break-word;
		}

		/*
																																																			* Pages
																																																			*/
		.page__content {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 3rem;
		}

		.page__header {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 2rem;
			text-align: center;
		}

		@media print {
			.dashboard__navigation {
				display: none !important;
			}

			.dashboard {
				display: block !important;
			}

			.dashboard__body {
				border-radius: unset !important;
				padding: 0 !important;
				padding-top: 5rem !important;
			}

			html {
				font-size: 85%;
			}

			* {
				box-shadow: unset !important;
			}
		}
	</style>
@endpushOnce

<x-layouts.legacy-main :$title>
	<div class="dashboard span-full-width">
		<aside class="dashboard__navigation js-dashboard-navigation">
			<div class="dashboard__navigation-wrapper">

				<div class="dashboard__navigation-header">
					<!-- logo -->
					<div
						class="dashboard__logo"
						data-content="<?= $dashboardName ?>"
						style="--character-count: {{ mb_strlen($dashboardName) }}"
					></div>
				</div>

				<!-- Admin sections -->
				<nav class="dashboard__navigation-body">

					<!-- Navigation -->
					<?php foreach ($dashboardNavigation as $category) { ?>

					<!-- Menu category -->
					<ul class="dashboard-category">

						<!-- Title box -->
						<label class="dashboard-category__header">
							<a <?= !empty($category['url']) ? 'href="' . $category['url'] . '"' : '' ?>>
								<input
									type="radio"
									name="dashboard-category"
									<?= $category['checked'] ? 'checked' : null ?>
								>

								<?= embed_icon('dashboards/' . $category['slug']) ?>

								<p class="dashboard-category__label"><?= $category['title'] ?></p>
							</a>
						</label>

						<!-- Dropdown -->
						<?php if (!empty($category['links'])) { ?>

						<ul class="dashboard-category__dropdown-wrapper">
							<div class="dashboard-category__dropdown">

								<?php foreach ($category['links'] as $i => $link) { ?>

								<label class="dashboard-category__link">
									<input
										type="radio"
										name="dashboard-link"
										<?= $link['checked'] ? 'checked' : null ?>
									>

									<a href="<?= $link['url'] ?>">
										<?= $link['title'] ?>
									</a>
								</label>

								<?php } ?>
							</div>
						</ul>

						<?php } ?>

					</ul>

					<?php } ?>

				</nav>
			</div>
		</aside>

		<section class="dashboard__body js-dashboard-content">
			{{ $slot }}
		</section>
	</div>
</x-layouts.legacy-main>
