document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.js-text-error').forEach((element) => {
		element.addEventListener('click', () => {
			element.classList.add('active')
			element.querySelector('.js-field').value = 1
		})
	})
})
