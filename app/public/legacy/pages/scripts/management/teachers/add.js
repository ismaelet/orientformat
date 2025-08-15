$(document).ready(function () {
	var autocomplete = true

	if ($('.inp[name="username"]').val().length) {
		autocomplete = false
	}

	$('.inp[name="first_name"]').keyup(function () {
		generate_username()
	})
	$('.inp[name="last_name"]').keyup(function () {
		generate_username()
	})

	function generate_username() {
		const first_name = $('.inp[name="first_name"]').val().replace(' ', '').substring(0, 8).toLowerCase()
		const last_name = $('.inp[name="last_name"]').val().replace(' ', '').substring(0, 8).toLowerCase()
		const num = Math.floor(Math.random() * 8999) + 1000

		if (first_name.length && last_name.length && autocomplete) {
			$('.inp[name="username"]').val(last_name + '.' + first_name + num)
		}
	}
})
