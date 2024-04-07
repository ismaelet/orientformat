document.addEventListener('DOMContentLoaded', function () {
	const navigationPanel = document.querySelector('.js-dashboard-navigation')
	const dashboardContent = document.querySelector('.js-dashboard-content')

	navigationPanel.addEventListener('pointerenter', () => {
		navigationPanel.classList.add('open')
	})

	dashboardContent.addEventListener('pointerenter', () => {
		navigationPanel.classList.remove('open')
	})
})
