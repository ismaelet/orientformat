@props(['class', 'title' => null])

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
			background-color: var(--color-tertiary-800);
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
			padding-block: 0.75rem;
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

<x-layouts.legacy-main :title="'Gestione Classe ' . $class->name">
	<div class="dashboard span-full-width">
		<x-class-dashboard.navigation :$class />

		<section class="dashboard__body js-dashboard-content">
			{{ $slot }}
		</section>
	</div>
</x-layouts.legacy-main>
