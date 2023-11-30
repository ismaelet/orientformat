// branches
const branchSelector = '.js-branch'
const branchHighlightSelector = '.js-branch-highlight'
const branchLeavesSelector = '.js-branch-leaves'
const branchInteractionSelector = '.js-branch-interaction'
const branchValueSelector = '.js-branch-value'
const branchNameSelector = '.js-branch-name'

// fruits
const fruitSelector = '.js-fruit'
const fruitValueSelector = '.js-fruit-value'
const fruitNameSelector = '.js-fruit-name'
const fruitInteractionSelector = '.js-fruit-interaction'

// modals
const branchNameInputSelector = '.js-branch-name-input'
const fruitNameInputSelector = '.js-fruit-name-input'
const addBranchSelector = '.js-add-branch'
const addFruitSelector = '.js-add-fruit'

document.addEventListener('DOMContentLoaded', function () {
	const branchNameInput = document.querySelector(branchNameInputSelector)
	const fruitNameInput = document.querySelector(fruitNameInputSelector)
	const addBranch = document.querySelector(addBranchSelector)
	const addFruit = document.querySelector(addFruitSelector)

	let activeBranchId
	let activeFruitId

	document.addEventListener('keypress', function (e) {
		if (e.code === 'Enter') {
			e.preventDefault()
		}
	})

	// branch interactions
	document.querySelectorAll(branchInteractionSelector).forEach((element) => {
		const branch = element.closest(branchSelector)

		element.addEventListener('click', () => {
			activeBranchId = branch.dataset.id
			branchName = branch.querySelector(branchValueSelector).value
			branchNameInput.value = branchName
			branchNameInput.focus()
		})

		element.addEventListener('mouseenter', () => {
			branch.querySelector(branchHighlightSelector).classList.add('active')
		})

		element.addEventListener('mouseleave', () => {
			branch.querySelector(branchHighlightSelector).classList.remove('active')
		})
	})

	// branch modal interaction
	addBranch.addEventListener('click', () => {
		const branchName = branchNameInput.value
		const branch = document.querySelector(branchSelector + '[data-id="' + activeBranchId + '"]')
		const branchValueElement = branch.querySelector(branchValueSelector)
		const branchNameElement = branch.querySelector(branchNameSelector)

		branchValueElement.value = branchName
		branchNameElement.innerHTML = branchName

		if (branchName) {
			branch.classList.add('active')
		} else {
			branch.classList.remove('active')

			branch.querySelectorAll(fruitSelector).forEach((element) => {
				element.classList.remove('active')
			})

			branch.querySelectorAll(fruitValueSelector).forEach((element) => {
				element.value = ''
			})

			branch.querySelectorAll(fruitNameSelector).forEach((element) => {
				element.innerHTML = ''
			})
		}
	})

	branchNameInput.addEventListener('keypress', function (e) {
		if (e.code === 'Enter') {
			addBranch.click()
		}
	})

	// fruit interaction
	document.querySelectorAll(fruitInteractionSelector).forEach((element) => {
		element.addEventListener('click', () => {
			fruit = element.closest(fruitSelector)
			activeFruitId = fruit.dataset.fruitId
			fruitValueElement = fruit.querySelector(fruitValueSelector)
			fruitName = fruitValueElement.value
			fruitNameInput.value = fruitName
			fruitNameInput.focus()
		})
	})

	// fruit modal interaction
	addFruit.addEventListener('click', () => {
		const fruitName = fruitNameInput.value
		const fruit = document.querySelector(fruitSelector + '[data-fruit-id="' + activeFruitId + '"]')
		const fruitValueElement = fruit.querySelector(fruitValueSelector)
		const fruitNameElement = fruit.querySelector(fruitNameSelector)

		fruitValueElement.value = fruitName

		if (fruitName) {
			fruitNameElement.innerHTML = fruitName
			fruit.classList.add('active')
		} else {
			fruit.classList.remove('active')
		}
	})

	fruitNameInput.addEventListener('keypress', function (e) {
		if (e.code === 'Enter') {
			addFruit.click()
		}
	})
})
