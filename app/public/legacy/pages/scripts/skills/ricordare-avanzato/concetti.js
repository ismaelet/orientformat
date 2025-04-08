$(document).ready(function () {
	var startTime, endTime

	$('#start').click(function () {
		startTime = new Date()

		$(this).hide()
		$('#concepts').addClass('active')

		setTimeout(function () {
			$('.concept').removeClass('loadA')
		}, 100)
	})

	$('#stop').click(function () {
		endTime = new Date()

		var time = endTime - startTime

		time /= 1000

		var seconds = Math.round(time)

		$('#record-time').val(seconds)

		$('html, body').animate({ scrollTop: 0 }, 200)

		$('#concepts').removeClass('active')
		$('#answers').addClass('active')
		$('.page-footer').addClass('active')
	})
})
