document.addEventListener('DOMContentLoaded', function () {
	/**
	 * Fetch graph data
	 */
	async function generate_section(sectionId) {
		const section = document.querySelector('.js-section[data-section-id="' + sectionId + '"]')
		const canvas = section.querySelector('.js-canvas')
		const emptyWarning = section.querySelector('.js-empty-warning')
		const condensedResultContainer = section.querySelector('.js-condensed-result-container')
		const condensedResult = section.querySelector('.js-condensed-result')
		const loading = section.querySelector('.js-loading')
		const schoolClassId = section.dataset.schoolClassId

		if (section.classList.contains('js-section-waiting')) {
			requested = true

			// Fetch the data
			get_graph_data(sectionId, schoolClassId).then(async function (schoolClassResponse) {
				// Fetch the platform data
				platformResponse = await get_graph_data(sectionId).then(function (response) {
					return response
				})

				// Generate the graph
				if (schoolClassResponse.labels && schoolClassResponse.labels.length) {
					// Show the condensed result
					condensedResult.innerHTML = schoolClassResponse.condensed

					// Generate the datasets
					let datasets = []
					datasets.push(generate_dataset(schoolClassResponse.data, section))
					datasets.push(generate_dataset(platformResponse.data, section, false))

					// Average
					const average = generate_annotations(schoolClassResponse.condensed)

					// Render the graph
					render_graph(canvas, schoolClassResponse.labels, datasets, average)
				} else {
					emptyWarning.classList.remove('hidden')
					condensedResultContainer.classList.add('hidden')
				}
			})

			loading.classList.add('hidden')
			section.classList.remove('js-section-waiting')
		}
	}

	/**
	 * Generate a dataset
	 */
	function generate_dataset(data, section, specific = true) {
		// colors
		const colorIncrement = 10
		const colorS = 120
		const colorL = 80
		const colorBaseH = parseInt(getComputedStyle(section).getPropertyValue('--_h-start')) + 39

		let colors = []
		let borderColors = []

		const resultCount = data.length

		// Dataset colors
		if (specific) {
			for (let index = 0; index < resultCount; index++) {
				colors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)} / 1`)
				borderColors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)} / 1`)
			}
		} else {
			for (let index = 0; index < resultCount; index++) {
				colors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)} / .3`)
				borderColors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)} / .4`)
			}
		}

		// Class dataset
		const dataset = {
			label: specific ? 'Risultato classe' : 'Risultato piattaforma',
			data: data,
			backgroundColor: colors,
			borderWidth: 3,
			borderColor: borderColors,
			borderRadius: 16,
		}

		return dataset
	}

	/**
	 * Generate the annotations
	 */
	function generate_annotations(condensedResult) {
		if (isNaN(parseInt(condensedResult)) || !parseInt(condensedResult)) {
			return null
		}

		function average(ctx) {
			const values = ctx.chart.data.datasets[0].data
			return values.reduce((a, b) => a + b, 0) / values.length
		}

		annotations = {
			annotation: {
				type: 'line',
				borderColor: 'hsl(0 0% 0% / 0.5)',
				borderDash: [6, 6],
				borderDashOffset: 0,
				borderWidth: 2,
				label: {
					enabled: true,
					content: (ctx) => 'Average: ' + average(ctx).toFixed(2),
					position: 'end',
				},
				scaleID: 'y',
				value: (ctx) => average(ctx),
			},
		}

		return annotations
	}

	/**
	 * Render the graph
	 */
	function render_graph(canvas, labels, datasets, annotations = null) {
		new Chart(canvas, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: datasets,
			},
			scales: {},
			options: {
				maintainAspectRatio: false,
				plugins: {
					legend: {
						display: true,
					},
					tooltip: {
						callbacks: {
							label: function (context) {
								return context.dataset.label + ': ' + context.parsed.y + '%'
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
								family: 'Open Sans',
								size: 16,
							},
						},
					},
					y: {
						ticks: {
							color: '#202020',
							font: {
								family: 'Open Sans',
								size: 16,
							},
						},
					},
				},
			},
		})
	}

	/**
	 * OLD
	 */
	// ajax generate section
	$('.js-section:first-child()').each(function () {
		const sectionId = $(this).data('section-id')
		generate_section(sectionId)
	})

	$('.section-dot').click(function () {
		const self = $(this)

		const area = self.parents('.area')

		const position = self.data('position')

		slide_area(area, position)
	})

	$('.js-arrow').click(function () {
		const self = $(this)

		const area = self.parents('.area')

		const count = area.data('count')

		let position = area.data('position')

		if ($(this).hasClass('js-arrow-right')) {
			position++
		} else {
			position--
		}

		if (position < 1) {
			position = count
		}

		if (position > count) {
			position = 1
		}

		slide_area(area, position)
	})

	function slide_area(area, position) {
		const section = area.find('.section:nth-child(' + position + ')')
		const sectionId = section.data('section-id')
		const translation = (position - 1) * 100

		area.data('position', position)

		area.find('.section-dot').removeClass('active')

		area.find('.section-dot[data-position="' + position + '"]').addClass('active')

		area.find('.sections').css('transform', 'translateX(-' + translation + '%)')

		if (section.hasClass('js-section-waiting')) {
			generate_section(sectionId)
		}
	}
})

function get_graph_data(sectionId, schoolClassId = null) {
	return axios({
		method: 'get',
		url: schoolClassId ? `/orientamento/api/section-graphs/${sectionId}?school_class_id=${schoolClassId}` : `/orientamento/api/section-graphs/${sectionId}`,
		retry: 3,
		retryDelay: 1000,
	})
		.then(function (response) {
			return response.data
		})
		.catch(function (error) {
			console.error(error.response.data.message)
			return error
		})
}
