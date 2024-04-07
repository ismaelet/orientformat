$(document).ready(function() {

	$('.shape-inp').keyup(function() {

		var full = true;

		$('.shape-inp').each(function() {
			if (!$(this).val()) {full = false;}
		});

		if (full) {
			$('.btn-box').removeClass('hide');
		} else {
			$('.btn-box').addClass('hide');
		}
	});
});