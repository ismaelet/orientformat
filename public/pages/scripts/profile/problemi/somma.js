$(document).ready(function () {
	$('.page-graph-box input').focus(function () {
		const group = $(this).data('group')

		$('.line-g' + group).addClass('active')
	})

	$('.page-graph-box input').blur(function () {
		const group = $(this).data('group')

		$('.line-g' + group).removeClass('active')
	})
})
