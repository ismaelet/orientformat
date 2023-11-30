$(document).ready(function() {

	$('.bar').hover(function() {

		const id = $(this).parent().data('id');

		$('.column').not('.column' + id).addClass('blur');
		$('.column' + id).addClass('active');
		$('#desc' + id).fadeIn();

	}, function() {

		$('.column').removeClass('blur').removeClass('active');
		$('.desc').stop(true).fadeOut();

	});
});