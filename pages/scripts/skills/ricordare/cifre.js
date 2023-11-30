const numberInputSelector = '.js-number'

$(document).ready(function () {
	$('.resume').click(function () {
		$('#numbers-old').hide()
		$('#numbers-new').show()
	})

	$('#view').click(function () {
		document.querySelectorAll(numberInputSelector).forEach((element) => {
			element.value = ''
		})

		$('#numbers-new').hide()
		$('#view-pan').fadeIn()
	})

	$('#listen').click(function () {
		document.querySelectorAll(numberInputSelector).forEach((element) => {
			element.value = ''
		})

		$('#numbers-new').hide()
		$('#listen-pan').fadeIn()
	})

	$('.back').click(function () {
		$('#listen-pan').hide()
		$('#view-pan').hide()
		$('#audio')[0].pause()
		$('#audio')[0].currentTime = 0
		document.querySelector('.js-listen-button').classList.remove('active')
		$('#numbers-new').fadeIn()
	})

	$('#play').click(function () {
		$('#audio')[0].play()
	})

	$('#audio').on('playing', function () {
		document.querySelector('.js-listen-button').classList.add('active')
	})

	$('#audio').on('ended', function () {
		document.querySelector('.js-listen-button').classList.remove('active')
	})
})
