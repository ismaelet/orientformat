const planetSelector = '.js-planet'
const planetFieldSelector = '.js-planet-field'
const planetTextSelector = '.js-planet-text'
const interestSelector = '.js-interest'
const addInterestSelector = '.js-add-interest'

document.addEventListener('DOMContentLoaded', function () {
	const interestInput = document.querySelector(interestSelector)
	const addInterest = document.querySelector(addInterestSelector)

	let planetId = 0

	document.querySelectorAll(planetSelector).forEach((element) => {
		element.addEventListener('click', () => {
			const interest = element.querySelector(planetFieldSelector).value

			planetId = element.dataset.planetId

			interestInput.value = interest
			interestInput.focus()
		})
	})

	addInterest.addEventListener('click', () => {
		const planet = document.querySelector(planetSelector + '[data-planet-id="' + planetId + '"]')
		const planetField = planet.querySelector(planetFieldSelector)
		const planetText = planet.querySelector(planetTextSelector)
		const interest = interestInput.value

		planetField.value = interest
		planetText.innerHTML = interest
	})

	document.addEventListener('keypress', function (e) {
		if (e.code === 'Enter') {
			e.preventDefault()
		}
	})

	interestInput.addEventListener('keypress', function (e) {
		if (e.code === 'Enter') {
			addInterest.click()
		}
	})
})
