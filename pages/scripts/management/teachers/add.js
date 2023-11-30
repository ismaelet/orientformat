$(document).ready(function() {

	var autocomplete = true;

	if ($('.inp[name="username"]').val().length) { autocomplete = false; }

	$('.inp[name="firstname"]').keyup(function() { generate_username(); });
	$('.inp[name="lastname"]').keyup(function() { generate_username(); });

	function generate_username() {

		const firstname = $('.inp[name="firstname"]').val().replace(' ', '').substring(0, 8).toLowerCase();
		const lastname = $('.inp[name="lastname"]').val().replace(' ', '').substring(0, 8).toLowerCase();
		const num = Math.floor(Math.random() * 8999) + 1000;

		if (firstname.length && lastname.length && autocomplete) {

			$('.inp[name="username"]').val(lastname + '.' + firstname + num);

		}

	}

});