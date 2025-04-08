const characterSelector = '.js-character'
const weaponSelector = '.js-weapon'

document.addEventListener('DOMContentLoaded', function () {
	$(weaponSelector).draggable({
		revert: function (event, ui) {
			if (!event) {
				$(this).animate({ top: '0px', left: '0px' }, 100)
			}
		},
	})

	$(characterSelector).droppable({
		accept: weaponSelector,

		drop: function (event, ui) {
			const character = $(this)[0]
			const weapon = ui.draggable[0]
			const resultInput = character.querySelector(fieldInput)
			const oldId = parseInt(resultInput.value)
			const id = weapon.dataset.id

			weapon.style.top = 0
			weapon.style.left = 0
			weapon.classList.add('hidden')

			if (oldId) {
				document.querySelector('[data-id="' + oldId + '"]').classList.remove('hidden')
			}

			character.querySelector('.js-weapon-image-wrapper').classList.add('active')
			character.querySelector('.js-weapon-image').src = weapon.querySelector('img').src

			resultInput.value = id

			resultInput.dispatchEvent(new Event('change'))
		},
	})
})
