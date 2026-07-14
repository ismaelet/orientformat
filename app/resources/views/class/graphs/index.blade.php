<?php

use Legacy\SchoolSystem\Grade;

?>

@pushOnce('styles')
	<style>
		.areas {
			display: grid;
			grid-template-columns: minmax(0, 1fr);
			gap: 5rem;
		}

		.area-title {
			padding-inline: 1rem;
			margin-left: 2rem;
			font-size: min(2.5rem, 8vw);
			word-break: break-word;
			font-weight: 600;
		}

		.area:nth-child(1) .area-title::before {
			background-color: hsl(25, 100%, 60%);
		}

		.area:nth-child(2) .area-title::before {
			background-color: hsl(185, 100%, 40%);
		}

		.area:nth-child(3) .area-title::before {
			background-color: hsl(90, 100%, 35%);
		}

		.area:nth-child(4) .area-title::before {
			background-color: hsl(290, 100%, 35%);
		}

		.area_header {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 2rem;
		}

		.area_arrows {
			display: flex;
			gap: 1rem;
		}

		.area_arrow {
			width: 3rem;
			aspect-ratio: 1;
			background-color: #ddd;
			border-radius: 50%;
			cursor: pointer;
			transition: background 0.3s;
		}

		.area_arrow:hover {
			background-color: var(--_color);
			--_fill: #fff;
		}

		.area_arrow svg {
			width: 50%;
		}

		.section {
			padding: 2rem;
		}

		.graph-item__icon {
			color: #fff;
			background-color: var(--_color);
		}

		.grah-item__body {
			overflow: auto;
		}

		.graph-item__canvas-wrapper {
			width: 100%;
			min-width: 500px;
			aspect-ratio: 3;

			.section-color--area-4 & {
				aspect-ratio: 2.4;
			}
		}

		.dashboard-panel {
			padding-bottom: 0;
		}

		.dashboard-panel-body {
			display: grid;
			grid-template-columns: minmax(0, 1fr) min(6rem, 15vw);
			align-content: flex-start;
			gap: 0.5rem 1rem;
			margin-bottom: -2rem;
		}

		.dashboard-panel-icon {
			margin-top: -2rem;
			border-radius: 50%;
		}

		.dashboard-panel-title {
			font-size: min(1.75rem, 6vw);
			font-weight: 600;
			letter-spacing: unset;
		}

		.dashboard-panel_result {
			padding-block: 1rem;
			border-top: 1px solid var(--border-color);
			text-align: center;
			font-weight: 300;
		}

		.dashboard-panel_value {
			font-size: 1.5em;
		}

		.dashboard-panel-footer {
			padding-block: 0.75rem 1rem;
			border-top: 1px solid var(--border-color);
		}

		.dashboard-home-more {
			text-align: center;
			margin: unset;
		}

		.dashboard-home-more a {
			border-bottom: 1px dashed;
			color: var(--color-tertiary-400);
			transition: color 0.2s;
		}

		.dashboard-home-more a:hover {
			color: var(--color-primary-400);
		}

		.dashboard-panel-icon {
			background-color: var(--_color);
		}

		.graph {
			margin-bottom: 2rem;
		}

		.column-graph {
			overflow: auto;
			padding-bottom: 2rem;
			grid-template-columns: minmax(0, 1fr);
		}

		.graph-box {
			min-width: 500px;
			height: 18rem;
		}

		.column-graph--has-legend .graph-box {
			height: 14rem;
		}

		.graph-labels {
			min-width: 500px;
			max-height: 5rem;
		}

		.column-graph {
			margin-top: 1rem;
		}

		.area:nth-child(1) .column-graph {
			--_h-base: 25;
			--_s-base: 100%;
			--_l-base: 60%;
		}

		.area:nth-child(2) .column-graph {
			--_h-base: 185;
			--_s-base: 80%;
			--_l-base: 40%;
		}

		.area:nth-child(3) .column-graph {
			--_h-base: 70;
			--_s-base: 70%;
			--_l-base: 35%;
		}

		.area:nth-child(4) .column-graph {
			--_h-base: 290;
			--_s-base: 70%;
			--_l-base: 35%;
		}

		.graph-info-title {
			background-color: var(--color-tertiary-400);
			color: #fff;
		}

		.graph-column_single,
		.graph-column_single .graph-info-icon {
			--_h: calc(var(--_h-base) + (var(--_count) - 1) * 8);
			--_s: calc(var(--_s-base) + (var(--_count) - 1) * 0%);
			--_l: calc(var(--_l-base) + (var(--_count) - 1) * 1%);
			background: linear-gradient(to bottom, hsl(var(--_h), var(--_s), var(--_l)), hsl(var(--_h), var(--_s), calc(var(--_l) - 15%)));
		}

		.graph-subcolumn,
		.graph-column_multiple .graph-info-icon {
			--_h: calc(var(--_h-base) + (var(--_count) - 1) * 5);
			--_s: calc(var(--_s-base) + (var(--_subcount) - 1) * 0%);
			--_l: calc(var(--_l-base) + (var(--_subcount) - 1) * 30%);
			background: linear-gradient(to bottom, hsl(var(--_h), var(--_s), var(--_l)), hsl(var(--_h), var(--_s), calc(var(--_l) - 15%)));
		}

		.graph-box-average::before,
		.graph-legend-icon {
			border-bottom-style: dashed;
		}

		.graph-legend-row:nth-child(1) .graph-legend-icon,
		.graph-box-average:nth-last-child(2)::before {
			border-color: rgb(255, 123, 0);
		}

		.graph-legend-row:nth-child(2) .graph-legend-icon,
		.graph-box-average:nth-last-child(1)::before {
			border-color: rgb(90, 161, 255);
		}

		.search-filter-title {
			line-height: 2.5rem;
		}

		.graph-info_average {
			display: none;
		}

		.section-dots {
			display: flex;
			justify-content: center;
			gap: 1rem;
			margin-top: 2rem;
		}

		.section-dot {
			display: flex;
			width: 1.5rem;
			cursor: pointer;
		}

		.section-dot::after {
			content: '';
			width: 50%;
			aspect-ratio: 1;
			margin: auto;
			background-color: var(--border-color-strong);
			border-radius: 50%;
			transition: background 0.3s;
		}

		.section-dot.active::after {
			background-color: var(--text-color);
		}

		.empty {
			padding-block: 18rem;
			text-align: center;
			font-size: 1rem;
			font-weight: 500;
		}

		@media (max-width: 480px) {
			.area-title {
				padding-inline: 0.5em;
				margin-left: 0;
			}

			.dashboard-panel-body {
				align-items: center;
			}

			.dashboard-panel-icon {
				margin-top: 0;
			}

			.dashboard-panel-title {
				word-break: break-word;
			}

			.graph-legend {
				display: none;
			}
		}
	</style>
@endpushOnce

@pushOnce('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		document.addEventListener('DOMContentLoaded', () => {
			initializeSectionCharts()

			const chartObserver = new MutationObserver((mutations) => {
				for (const mutation of mutations) {
					for (const node of mutation.addedNodes) {
						if (!(node instanceof Element)) {
							continue
						}

						initializeSectionCharts(node)
					}
				}
			})

			const graphsRoot = document.querySelector('.areas')

			if (graphsRoot) {
				const chartObserver = new MutationObserver((mutations) => {
					for (const mutation of mutations) {
						for (const node of mutation.addedNodes) {
							if (!(node instanceof Element)) {
								continue
							}

							initializeSectionCharts(node)
						}
					}
				})

				chartObserver.observe(graphsRoot, {
					childList: true,
					subtree: true,
				})
			}
		})

		function generateDataset(
			data,
			section,
			specific = true,
			tooltipData = null,
			customLabel = null
		) {
			const colorIncrement = 10
			const colorS = 120
			const colorL = 80

			const colorBaseH =
				parseInt(
					getComputedStyle(section)
					.getPropertyValue('--_h-start')
				) + 39

			const colors = []
			const borderColors = []

			const resultCount = data.length

			for (
				let index = 0; index < resultCount; index++
			) {
				const hue =
					colorBaseH +
					colorIncrement *
					(index - resultCount / 2)
				colors.push(
					`lch(${colorL} ${colorS} ${hue} / ${
						specific ? 1 : 0.3
					})`
				)

				borderColors.push(
					`lch(${colorL} ${colorS} ${hue} / ${
						specific ? 1 : 0.4
					})`
				)
			}

			return {
				label: customLabel ??
					(
						specific ?
						'Risultato della classe' :
						'Risultato della piattaforma'
					),

				datasetKey: specific ?
					'school_class' : 'platform',

				data,

				tooltipData,

				backgroundColor: colors,
				borderColor: borderColors,
				borderWidth: 3,
				borderRadius: 16,
			}
		}

		function generateAnnotations(
			condensedResult,
			schoolClassData
		) {
			if (
				isNaN(parseInt(condensedResult)) ||
				!parseInt(condensedResult)
			) {
				return null
			}

			if (!schoolClassData.length) {
				return null
			}

			const average =
				schoolClassData.reduce(
					(sum, value) => sum + value,
					0
				) / schoolClassData.length

			return {
				annotation: {
					type: 'line',
					borderColor: 'hsl(0 0% 0% / 0.5)',
					borderDash: [6, 6],
					borderWidth: 2,

					label: {
						display: true,
						content: 'Average: ' +
							average.toFixed(2),
						position: 'end',
					},

					scaleID: 'y',
					value: average,
				},
			}
		}

		function initializeSectionChart(canvas) {
			if (!canvas) {
				return
			}

			if (Chart.getChart(canvas)) {
				return
			}

			const section = canvas.closest('.section')

			if (!section) {
				return
			}

			let graph

			try {
				graph = JSON.parse(canvas.dataset.chart)
			} catch (error) {
				console.error(
					'Invalid section graph data:',
					error
				)

				return
			}

			if (
				!graph?.labels?.length ||
				!graph?.datasets
			) {
				return
			}

			const schoolClassData =
				graph.datasets.school_class ?? []

			const platformData =
				graph.datasets.platform ?? []

			const schoolClassTooltipData =
				Array.isArray(
					graph.tooltip_values?.school_class
				) &&
				graph.tooltip_values.school_class.length > 0 ?
				graph.tooltip_values.school_class :
				null

			const schoolClassLabel =
				graph.dataset_labels?.school_class ??
				'Risultato della classe'

			const platformLabel =
				graph.dataset_labels?.platform ??
				'Risultato della piattaforma'

			const datasets = [
				generateDataset(
					schoolClassData,
					section,
					true,
					schoolClassTooltipData,
					schoolClassLabel
				),

				generateDataset(
					platformData,
					section,
					false,
					null,
					platformLabel
				),
			]

			const annotations =
				generateAnnotations(
					graph.condensed,
					schoolClassData
				)

			new Chart(canvas, {
				type: 'bar',

				data: {
					labels: graph.labels,
					datasets,
				},

				options: {
					maintainAspectRatio: false,

					plugins: {
						legend: {
							display: true,
						},

						tooltip: {
							callbacks: {
								label(context) {
									const tooltipData =
										context.dataset.tooltipData

									if (Array.isArray(tooltipData)) {
										const studentCount =
											tooltipData[context.dataIndex] ?? 0

										return (
											context.dataset.label +
											': ' +
											studentCount
										)
									}

									return (
										context.dataset.label +
										': ' +
										context.parsed.y +
										'%'
									)
								},
							},
						},

						annotation: {
							annotations,
						},
					},

					scales: {
						x: {
							ticks: {
								color: '#202020',

								font: {
									size: 16,
								},
							},
						},

						y: {
							ticks: {
								color: '#202020',

								font: {
									size: 16,
								},
							},
						},
					},
				},
			})
		}

		function initializeSectionCharts(
			root = document
		) {
			if (
				root instanceof Element &&
				root.matches('[data-section-chart]')
			) {
				initializeSectionChart(root)
			}

			root
				.querySelectorAll?.(
					'[data-section-chart]'
				)
				.forEach(initializeSectionChart)
		}
	</script>
@endpushOnce

<x-layouts.class-dashboard :$class>
	<div class="page__header">
		<h1 class="section-title">Progresso della classe</h1>
		<p class="text-base">Qui sono illustrati i risultati medi della classe. Puoi usare le frecce a lato del nome di ogni
			area per vedere tutti i risultati.</p>
	</div>

	<div class="areas mar-t-3">
		@foreach ($areas as $area)
			<div class="area section-color--area-{{ $area['id'] }}">
				<livewire:class-graphs.area
					:area-id="$area['id']"
					:area-name="$area['name']"
					:school-class-id="$class->id"
					:section-ids="$area['sections']->pluck('id')->all()"
					:key="'class-graph-area-' . $class->id . '-' . $area['id']"
				/>
			</div>
		@endforeach
	</div>
</x-layouts.class-dashboard>
