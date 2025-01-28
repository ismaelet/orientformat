import VanillaTilt from 'vanilla-tilt'

export function initTilt() {
	const titlSelector = '[data-tilt]'

	// Attach the event listeners
	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll(titlSelector).forEach((element) => {
			const htmlElement = element

			VanillaTilt.init(htmlElement)
		})
	})
}
