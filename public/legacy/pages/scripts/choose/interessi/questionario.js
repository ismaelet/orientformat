document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll(fieldInput).forEach((element) => {
		element.addEventListener('change', () => {
			const question = element.closest('.js-question')

			question.querySelectorAll(fieldInput).forEach((field) => {
				field.checked = false
			})

			element.checked = true
		})
	})
})
