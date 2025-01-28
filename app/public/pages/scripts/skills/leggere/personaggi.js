$(document).ready(function () {
	$('.answer').click(function () {
		const self = $(this)

		self.parents('.answers').find('input').prop('checked', false).change()
		self.prev().prop('checked', true).change()
	})

	$('.emotion').click(function () {
		const self = $(this)
		const box = self.parents('.emotions')

		var value = ''

		self.prev().click().change()

		box.find('input[type="checkbox"]').each(function () {
			const inp = $(this)

			if (inp.prop('checked')) {
				const val = $(this).data('val')

				value += '+' + val
			}
		})

		value = value.substring(1)

		box.find('.filler-inp').val(value).change()
	})
})
