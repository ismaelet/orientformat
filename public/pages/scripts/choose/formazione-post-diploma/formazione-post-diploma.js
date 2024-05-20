document.addEventListener('DOMContentLoaded', function () {
	const schoolTypeSelector = '.school-type'
	const colorPrimary200 = getComputedStyle(document.documentElement).getPropertyValue('--clr-primary-200')
	const colorSecondary300 = getComputedStyle(document.documentElement).getPropertyValue('--color-secondary-300')
	const colorTertiary100 = getComputedStyle(document.documentElement).getPropertyValue('--color-tertiary-100')
	const colorTertiary400 = getComputedStyle(document.documentElement).getPropertyValue('--color-tertiary-400')

	// lines
	let parameters = { path: 'magnet', startSocket: 'bottom', endSocket: 'top', gradient: true, startPlugColor: colorTertiary400, endPlugColor: colorTertiary100, size: 3, dash: { animation: true } }
	let start = document.querySelector(schoolTypeSelector + ':nth-child(1)')
	let end = document.querySelector(schoolTypeSelector + ':nth-child(2)')

	// row 1
	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(5)')

	new LeaderLine(start, end, parameters)

	// row 2
	start = document.querySelector(schoolTypeSelector + ':nth-child(2)')
	end = document.querySelector(schoolTypeSelector + ':nth-child(6)')
	parameters.startPlugColor = colorTertiary100
	parameters.endPlugColor = colorSecondary300

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(3)')
	parameters.startSocket = screen.width > 768 ? 'right' : 'bottom'

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(4)')

	new LeaderLine(start, end, parameters)

	// row 4 - first item
	start = document.querySelector(schoolTypeSelector + ':nth-child(5)')
	end = document.querySelector(schoolTypeSelector + ':nth-child(7)')
	parameters.endPlugColor = colorPrimary200
	parameters.startSocket = 'bottom'

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(8)')

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(9)')

	new LeaderLine(start, end, parameters)

	// row 4 - second item
	start = document.querySelector(schoolTypeSelector + ':nth-child(6)')
	end = document.querySelector(schoolTypeSelector + ':nth-child(7)')
	parameters.startPlugColor = colorSecondary300
	parameters.startSocket = 'bottom'

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(8)')

	new LeaderLine(start, end, parameters)

	end = document.querySelector(schoolTypeSelector + ':nth-child(9)')

	new LeaderLine(start, end, parameters)
})
