$(document).ready(function() {

	$('.petal .body').hover(function() {

		$('.petal').addClass('blur');
		$(this).parent().addClass('active').removeClass('blur');

	}, function() {

		$('.petal').removeClass('blur').removeClass('active');

	});

});