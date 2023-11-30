$(document).ready(function () {
	$('.js-start').click(function () {
		$('#example').hide()
		$('#slider').show()

		setTimeout(function () {
			cycle(1)
		}, 1000)
	})

	function cycle(pos) {
		$('#image' + (pos - 1)).hide()
		$('#image' + pos).fadeIn(400)

		setTimeout(function () {
			if (pos < 6) {
				cycle(pos + 1)
			} else {
				$('#slider').hide()
				$('#solutions').fadeIn(400)
			}
		}, 8000)
	}

	$('.solution').click(function () {
		const self = $(this)
		const val = self.data('val')

		$('.solution').removeClass('active')
		self.addClass('active')

		$('.filler-inp').val(val).change()
	})
})
