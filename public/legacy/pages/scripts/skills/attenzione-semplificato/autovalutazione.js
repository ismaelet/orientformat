$(document).ready(function () {
	$('.number').hover(
		function () {
			const id = $(this).data('question')

			$('.question')
				.not('#question' + id)
				.addClass('blur')
		},
		function () {
			$('.question').removeClass('blur')
		}
	)

	$('.number').click(function () {
		const self = $(this)
		const id = $(this).data('question')
		const val = $(this).data('val')

		self.addClass('active')

		$('.number[data-question=' + id + ']')
			.not(self)
			.removeClass('active')
		$('#field' + id)
			.val(val)
			.change()
	})
})
