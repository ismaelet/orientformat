$(document).ready(function () {
	// on mouseover
	$('.responsive').hover(
		function () {
			const id = $(this).data('id')

			$('#section' + id).addClass('active')
			$('#result' + id).addClass('active')
		},
		function () {
			$('.section').removeClass('active')
			$('.result').removeClass('active')
		}
	)

	// lines
	const htmlStyle = getComputedStyle(document.documentElement)
	const color1 = htmlStyle.getPropertyValue('--color-1-of-5')
	const color2 = htmlStyle.getPropertyValue('--color-2-of-5')
	const color3 = htmlStyle.getPropertyValue('--color-3-of-5')
	const color4 = htmlStyle.getPropertyValue('--color-4-of-5')
	const color5 = htmlStyle.getPropertyValue('--color-5-of-5')

	const colors = [color1, color2, color3, color4, color5]

	generate_lines()

	$(window).resize(function () {
		$('.leader-line').remove()
		generate_lines()
	})

	function generate_lines() {
		for (let i = 1; i < 5; i++) {
			const dot1 = document.getElementById(
				$('#result' + i)
					.find('.score.active')
					.attr('id')
			)
			const dot2 = document.getElementById(
				$('#result' + (i + 1))
					.find('.score.active')
					.attr('id')
			)

			if (dot1 && dot2) {
				new LeaderLine(dot1, dot2, { dash: { animation: true }, endPlug: 'behind', size: 4, startPlugColor: colors[i - 1], endPlugColor: colors[i], gradient: true })
			}
		}

		$('.leader-line').appendTo('#img-box')

		reposition()
	}

	function reposition() {
		const box = $('#img-box')
		const offsetY = box.offset().top
		const offsetX = box.offset().left

		$('.leader-line').each(function () {
			const self = $(this)

			const top = parseInt(self.css('top'))
			const left = parseInt(self.css('left'))

			self.css('top', top - offsetY + 'px')
			self.css('left', left - offsetX + 'px')
		})
	}
})
