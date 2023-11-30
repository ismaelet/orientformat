document.addEventListener('DOMContentLoaded', function () {
	/**
	 * Fetch graph data
	 */
	async function generate_section(sectionId) {
		const section = document.querySelector('.js-section[data-section-id="' + sectionId + '"]')
		const canvas = section.querySelector('.js-canvas')
		const schoolClassId = section.dataset.schoolClassId

		const graphData = await call_class_method('Activity\\Result\\Graphs\\SectionGraph', 'generate', [sectionId, schoolClassId])

		new Chart(canvas, {
			type: 'bar',
			data: {
				labels: graphData.labels,
				datasets: [
					{
						label: 'Risultato medio per la classe',
						data: graphData.data,
					},
				],
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
