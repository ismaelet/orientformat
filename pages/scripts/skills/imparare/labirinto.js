$(document).ready(function () {
	const count = $('.js-count').data('count')

	var pos = 1

	$('.answer').click(function () {
		const self = $(this)
		const question = self.parent()
		const answer = self.data('answer')
		const right = question.data('answer')

		$('.result').hide()

		if (answer == right) {
			pos++

			$('.result.right').fadeIn(250)

			question.find('.filler-inp').val(answer).change()
		} else {
			pos = 1

			$('.result.wrong').fadeIn(250)

			$('.filler-inp').val(0).change()
		}

		$('.question').removeClass('active')

		if (pos <= count) {
			$('#question' + pos).addClass('active')
		} else {
			$('.result').hide()
			$('#end').fadeIn()
		}
	})
})
