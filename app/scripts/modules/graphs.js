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

		// colors
		// const colorS = parseInt(getComputedStyle(section).getPropertyValue('--_s')) * 1.5
		// const colorL = getComputedStyle(section).getPropertyValue('--_l')
		// const colorIncrement = parseInt(getComputedStyle(section).getPropertyValue('--_h-range'))
		const colorIncrement = 10
		const colorS = 120
		const colorL = 80
		const colorBaseH = parseInt(getComputedStyle(section).getPropertyValue('--_h-start')) + 39
		// const colorBaseH = 80

		let colors = []
		let borderColors = []
		if (section.classList.contains('js-section-waiting')) {
			axios
				.post('/api/call-class-method/Activity\\Result\\Graphs\\SectionGraph', {
					scope: 'generate',
					arguments: [sectionId, schoolClassId],
				})
				.then(function (response) {
					console.log(response.data)
					const resultCount = response.data.labels.length

					if (resultCount) {
						for (let index = 0; index < resultCount; index++) {
							colors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)} / .7`)
							borderColors.push(`lch(${colorL} ${colorS} ${colorBaseH + colorIncrement * (index - resultCount / 2)}`)
						}

						condensedResult.innerHTML = response.data.condensed

						new Chart(canvas, {
							type: 'bar',
							data: {
								labels: response.data.labels,
								datasets: [
									{
										label: 'Risultato medio per la classe',
										data: response.data.data,
										backgroundColor: colors,
										borderWidth: 3,
										borderColor: borderColors,
										borderRadius: 16,
									},
								],
							},
							scales: {},
							options: {
								plugins: {
									legend: {
										display: false,
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
					} else {
						emptyWarning.classList.remove('hidden')
						condensedResultContainer.classList.add('hidden')
					}

					loading.classList.add('hidden')
					section.classList.remove('js-section-waiting')
				})
				.catch(function (error) {
					console.error(error)
				})
		}
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
