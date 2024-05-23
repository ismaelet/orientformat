$(document).ready(function () {
	$('.js-generate-password').click(function () {
		$('[name="new-password"]').val(Math.random().toString(36).slice(2))
	})
})
