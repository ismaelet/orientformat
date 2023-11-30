$(document).ready(function () {
	const count = $('.js-count').data('count')

	$('.answer').click(function () {
		const id = parseInt($(this).parents('.question-box').data('id')) + 1
		console.log(id)

		if ($('#question' + id).length) {
			$('html, body')
				.stop()
				.animate(
					{
						scrollTop: $('#question' + id).offset().top,
					},
					300
				)
		}
	})

	$('.answer').click(function () {
		$(this).parents('.question-box').find('.cbx-mirror').prop('checked', false)
		$(this).find('.cbx-mirror').prop('checked', true)
	})
})
