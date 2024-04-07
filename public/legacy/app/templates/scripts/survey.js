$('document').ready(function () {
	const carousel = $('.questions-carousel')

	check_arrows()

	$('.answer-cbx').on('change', function () {
		const self = $(this)
		const pos = carousel.data('pos') + 1

		self.parents('.question').find('.answer-cbx').prop('checked', false)
		self.prop('checked', true)

		carousel_slide(pos)
	})

	$('.slide-arrow').click(function () {
		const direction = $(this).data('direction')

		let pos = carousel.data('pos')

		if (direction == 'right') {
			pos++
		} else {
			pos--
		}

		carousel_slide(pos)
	})

	function check_arrows() {
		const leftArrow = $('.slide-arrow[data-direction="left"]')
		const rightArrow = $('.slide-arrow[data-direction="right"]')
		const pos = carousel.data('pos')
		const count = $('.question').length
		const checked = $('.question:nth-child(' + pos + ') .answer-cbx:checked').length

		if (checked && pos < count) {
			rightArrow.removeClass('disabled')
		} else {
			rightArrow.addClass('disabled')
		}

		if (pos > 1) {
			leftArrow.removeClass('disabled')
		} else {
			leftArrow.addClass('disabled')
		}
	}

	function carousel_slide(pos) {
		const count = $('.question').length

		if (pos <= count) {
			$('.question').removeClass('active')
			$('.question:nth-child(' + pos + ')').addClass('active')

			carousel.data('pos', pos).css('--_pos', pos)
			check_arrows()
		} else {
			$('#body').submit()
		}
	}

	//timer
	var time = 0

	window.setInterval(function () {
		time++

		$('#time-passed').val(time)
	}, 1000)
})
