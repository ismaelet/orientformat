$(window).ready(function () {
	$('.js-switch-form').click(function () {
		$('.js-page-content').toggleClass('register-page')
		$('.js-page-content').toggleClass('login-page')
	})
})
