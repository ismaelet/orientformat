document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.js-school-type-selector').forEach((element) => {
		element.addEventListener('click', () => {
			const schoolType = element.dataset.schoolType

			document.querySelector('.js-school-type-selectors').classList.remove('active')

			document.querySelector('.js-school-type[data-school-type="' + schoolType + '"]').classList.add('active')
		})
	})
})
